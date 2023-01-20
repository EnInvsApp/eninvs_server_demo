<?php

ini_set('display_errors', '1');
ini_set('memory_limit', '-1');
date_default_timezone_set('Europe/Moscow');
include '/html/engine/connect.php';
include_once '/html/php_db/single_functions.php';

flog('option_start');
$no_db = false;

$ticker_num = false;
if (isset($argv) && isset($argv[1]) && is_numeric(strtolower($argv[1])))
{
    $ticker_num = $argv[1];
}

$test_ticker = false;
if (isset($_GET['ticker']))
{
    $test_ticker = $_GET['ticker'];
}

$today = date('Y-m-d');
$day_of_week = date('w', strtotime($today));
$dt = false;
$dt_next = false;

switch ($day_of_week) {
    case 1:
        $dt = date('Y-m-d', strtotime($today. ' + 4 days'));
        $dt_next = date('Y-m-d', strtotime($today. ' + 11 days'));
        break;
    case 2:
        $dt = date('Y-m-d', strtotime($today. ' + 3 days'));
        $dt_next = date('Y-m-d', strtotime($today. ' + 10 days'));
        break;
    case 3:
        $dt = date('Y-m-d', strtotime($today. ' + 2 days'));
        $dt_next = date('Y-m-d', strtotime($today. ' + 9 days'));
        break;
    case 4:
        $dt = date('Y-m-d', strtotime($today. ' + 1 days'));
        $dt_next = date('Y-m-d', strtotime($today. ' + 8 days'));
        break;
    case 5:
        $dt = date('Y-m-d', strtotime($today. ' + 0 days'));
        $dt_next = date('Y-m-d', strtotime($today. ' + 7 days'));
        break;
}

if ($dt === false)
{
    return false;
}

$dt_arr = [$dt, $dt_next];

$D = date('Y-m-d');
$DT = date('Y-m-d H:i:s');

foreach ($dt_arr as $dt)
{

$timestamp = strtotime($dt) + 3 * 60 * 60;
nice_print_forecast('today', $today, true);
nice_print_forecast('day_of_week', $day_of_week, true);
nice_print_forecast('dt', $dt, true);
nice_print_forecast('timestamp', $timestamp, true);

$tickers = [];

$lst_ticker = false;
$qu = 
	'   SELECT Ticker
        FROM 
        (
            (SELECT Ticker FROM US2_Emitents WHERE Active = 1) 
            UNION 
            (SELECT Ticker FROM US_Emitents WHERE Active = 1) 
            UNION 
            (SELECT Ticker FROM Wd_Emitents WHERE Active = 1) 
        ) as t1
        WHERE 
            Ticker NOT LIKE "%.%" AND
            Ticker >= "A"
        ORDER BY 
            Ticker ASC
	';

$stmt = $mysqli->prepare($qu);
echo $mysqli->error;
$stmt->execute();
echo $stmt->error;
$s = $stmt->get_result();

$t_count = 0;
while ($row = $s->fetch_array(MYSQLI_BOTH))
{
    if ($ticker_num !== false)
    {
        if ($t_count % 4 != $ticker_num)
        {
            $t_count++;
            continue;
        }
    }
    $tickers[] = $row['Ticker'];
    $t_count++;
}

if ($test_ticker !== false)
{
    $tickers = [$test_ticker];
}

$link_pattern = 'https://finance.yahoo.com/quote/{ticker}/options?p={ticker}&date='.$timestamp;
nice_print_forecast('link_pattern', $link_pattern, true);



$t_count = 0;
foreach ($tickers as $ticker)
{
    flog($ticker_num.': option_ticker:'.$t_count.'/'.count($tickers).' '.$ticker);
    $t_count++;

    $price = get_emitent_last_price_US_2($ticker);
    

    $link = str_replace('{ticker}', $ticker, $link_pattern);
    nice_print_forecast('ticker', $ticker, true);
    nice_print_forecast('link', $link, true);

    $proxy_link = 'https://eninvs.com/_use_proxy.php?key=123&path='.base64_encode($link).'&sweb=1';
	$content = file_get_contents($proxy_link);
    if ($content === false || strlen($content) < 10000)
    {
        flog('file_get_contents ERROR');
    }

    flog('length: '.strlen($content));
    $call_content = substr($content, strpos($content, '<table class="calls'));
    $call_content = substr($call_content, 0,  strpos($call_content, '</table>'));
    // echo htmlspecialchars($call_content);

    
    $put_content = substr($content, strpos($content, '<table class="puts'));
    $put_content = substr($put_content, 0,  strpos($put_content, '</table>'));
    // echo htmlspecialchars($put_content);

    $res = parse_options_yahoo_table($call_content, 'call', $D, $DT, $price, $mysqli, $ticker, $dt, $no_db);
    $res = parse_options_yahoo_table($put_content, 'put', $D, $DT, $price, $mysqli, $ticker, $dt, $no_db);


}
}
flog('option_end');

function parse_options_yahoo_table($table, $call_put, $D, $DT, $price, $mysqli, $ticker, $dt, $no_db = false)
{
    $pattern = '/<tr class="data-row(?<row>\d+).*?data-col0.*?href="(?<link>.*?)".*?>(?<name>.*?)<\/a>.*?data-col1.*?>(?<dt>\d\d\d\d-\d\d-\d\d.*?)<.*?data-col2.*?">(?<strike>[\-\d\.,]+)<\/a>.*?data-col3.*?>(?<last_price>[\-\d\.,]+)<.*?data-col4.*?>(?<bid>[\-\d\.,]+)<.*?data-col5.*?>(?<ask>[\-\d\.,]+)<.*?data-col6.*?>(?<change>[\-\d\.,]+)<.*?data-col7.*?>(?<pct_change>[\-\d\.,]+)%?<.*?data-col8.*?>(?<volume>[\-\d\.,]+)<.*?data-col9.*?>(?<interest>[\-\d\.,]+)<.*?data-col10.*?>(?<volatility>[\-\d\.,]+)%?</';
    $matches = [];
    if (preg_match_all($pattern, $table, $matches, PREG_SET_ORDER))
    {
        foreach ($matches as $match)
        {
            $in_money = 0;
            echo 'match[0]: ', htmlspecialchars($match[0]), '<br>';
            if (strpos($match[0], ' in-the-money ') !== false)
            {
                $in_money = 1;
            }
            $obj = 
            [
                'name' => $match['name'],
                'dt' => $match['dt'],
                'strike' => $match['strike'],
                'last_price' => $match['last_price'],
                'bid' => $match['bid'],
                'ask' => $match['ask'],
                'change' => $match['change'],
                'pct_change' => $match['pct_change'] / 100,
                'volume' => $match['volume'],
                'interest' => $match['interest'],
                'volatility' => $match['volatility'] / 100,
                'in_money' => $in_money,
                'ex_d' => $dt,
            ];

            nice_print_forecast('obj', $obj, true);
            foreach ($obj as $name => $value)
            {
                if ($value === '-')
                {
                    $obj[$name] = null;
                }
                else if (preg_match('/[\-\d\.,]+/', $value))
                {
                    $value = str_replace(',', '', $value);
                    $obj[$name] = $value;
                }
            }

            if (!$no_db)
            {
                $qu = 
                '	INSERT INTO YAHOO_option_price_data 
                        (Ex_D, Ticker, D, DT, Call_Put, In_Money, Price, Name, Last_Trade_Date, Strike, Last_Price, Bid, Ask, Price_Change, Price_Change_Pct, Volume, Open_Interest, Implied_Volatility)
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                        ID=ID
                ';
                $stmt = $mysqli->prepare($qu);
                echo $mysqli->error;
                $stmt->bind_param('ssssssssssssssssss', $dt, $ticker, $D, $DT, $call_put, $obj['in_money'], $price, $obj['name'], 
                    $obj['dt'], $obj['strike'], $obj['last_price'], $obj['bid'], $obj['ask'],
                    $obj['change'], $obj['pct_change'], $obj['volume'], $obj['interest'] , $obj['volatility']);
                $stmt->execute();
                echo $stmt->error;
            }
        }
    }
}


//update price in/out
option_trades_RR_strategy_out($mysqli, $today);

option_trades_RR_strategy_in($mysqli, $today);










?>