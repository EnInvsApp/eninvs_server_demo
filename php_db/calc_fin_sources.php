<?php

ini_set('memory_limit', -1);

if (isset($siteUserLogin___) && $siteUserLogin___ == 'Admin') ini_set('display_errors', '1');
date_default_timezone_set('Europe/Moscow');
include '/html/engine/connect.php';
include '/html/php_db/single_functions.php';

// ------------

$prefix_array = 
[
	'US' => 'US', 
	'Wd' => 'Wd', 
	'US2' => 'US2', 
];

if (isset($_GET['update_q']))
{
	$update_q = $_GET['update_q'];
	
	$source = null;
	if (isset($_GET['source']))
	{
		$source = strtolower($_GET['source']);
	}
	
	NASDAQ_SEC_fin_data_base_update($ticker, $update_q, $prefix_array, $mysqli, $source, $sec_form);
	
	file_get_contents('https://eninvs.com/crontab/_FCF_count.php?ticker='.$ticker);
	
	echo '<script>window.location.replace("https://eninvs.com/fin_sources.php?ticker=',$ticker,'&sec_form=',$sec_form,'");</script>';
	
	exit;
}

// ------------

$quarter_data = [];

foreach ($prefix_array as $prefix)
{
	$qu = 
		'
			SELECT 
				Q, 
				Revenue, 
				Ebitda, 
				NetDebt 
			FROM '.$prefix.'_EmitentFinancialData 
			WHERE Ticker = ? 
			ORDER BY Q ASC 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	
	$found = false;
	
	while ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$found = true;
		
		$q = $data['Q'];
		
		if (!isset($quarter_data[$q]))
		{
			$quarter_data[$q] = [];
		}
		
		$result = 
		[
			'Revenue' => $data['Revenue'], 
			'EBITDA' => $data['Ebitda'], 
			'NetDebt' => $data['NetDebt'], 
		];
		
		$quarter_data[$q][$prefix] = $result;
	}
	
	if (!$found)
	{
		unset($prefix_array[$prefix]);
	}
}

// ------------

$NASDAQ_press_prefix = 'NASDAQ_press';

if ($sec_form == 10)
{
	$prefix_array[$NASDAQ_press_prefix] = $NASDAQ_press_prefix;

	foreach ($quarter_data as $q => $data)
	{
		$quarter_data[$q][$NASDAQ_press_prefix] = NASDAQ_fin_data_base_get($ticker, $q, $mysqli);
	}
}

// ------------

$SEC_press_prefix = 'SEC_press';

$prefix_array[$SEC_press_prefix] = $SEC_press_prefix;

foreach ($quarter_data as $q => $data)
{
	$quarter_data[$q][$SEC_press_prefix] = SEC_fin_data_base_get($ticker, $q, $mysqli, $sec_form);
}

$quarter_data = array_reverse($quarter_data);

?>