<?php

$___time_gap_company = 60 * 60;
if (isset($repeat_forecast_php_starter) && $repeat_forecast_php_starter == true) $___time_gap_company = 0;
if (isset($_GET['cache']) && $_GET['cache'] == 'no') $___time_gap_company = 0;

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$calc_prefix = 'US';

$___obj = array();
$___cashe_file = '/html/cashe/cashe__BIG_company_page_'.$calc_prefix.'_'.$ticker.'.inc';
$___bool_cashe = false;
$___cashe_s = '';

if (file_exists($___cashe_file))
{
	$___unix_time = filemtime($___cashe_file);
	$___ftm = date('Y-m-d H:i:s', $___unix_time + $___time_gap_company);
	if ($___ftm > date('Y-m-d H:i:s'))
	{
		$___cashe_s = file_get_contents($___cashe_file);
		if (strlen($___cashe_s) <= 5) $___bool_cashe = false;
		else $___bool_cashe = true;
	}
	else {
		$___bool_cashe = false;
		unlink($___cashe_file);
	}
}
else $___bool_cashe = false;

if (!$___bool_cashe)
{
	
	$ticker = str_replace("'", "", $ticker);
	$ticker = str_replace('"', '', $ticker);
	
	$year_created_value = -1000;
	$mult_common_grow = 10.0;
	$X__rel = 4;
	
	$category = get_emitent_category_US($ticker);
	$last_Q = get_emitent_last_Q_US($ticker);
	
	// ------------------------------------------------------------------------------------------
	
	$years_add = 0;
	if ($last_Q < '2022 q2')
	{
		if ($last_Q < '2022 q1') $years_add = 1;
		else                     $years_add = 2;
	}
	
	// ------------------------------------------------------------------------------------------
	
	//$category = get_emitent_category_US($ticker);
	$is_grow = emitent_Is_Growing_US($ticker);

	$banking = false;

	$qu = 
		'
			SELECT * FROM (SELECT ID, Q, Revenue, Ebitda, NetDebt, NextReportingDate, NextOperatingDate FROM 
			US_EmitentFinancialData WHERE Ticker=? ORDER BY Q DESC LIMIT 6) as A ORDER BY Q ASC
		';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$countData = count($data);
	if ($countData > 0)
	{
		$NetDebtLast = '';
		$FinActuality = '';
		$NextReportingDate = '';
		$NextOperatingDate = '';
		
		$EbitdaLTM = 0;
		$EbitdaLTMq1 = 0;
		$EbitdaLTMq2 = 0;
		$EbitdaLTMq3 = 0;
		$EbitdaLTMq4 = 0;
		
		$RevenueLTM = 0;
		$RevenueLTMq1 = 0;
		$RevenueLTMq2 = 0;
		$RevenueLTMq3 = 0;
		$RevenueLTMq4 = 0;
		
		if ($data['NetDebt'] != 0 && $data['NetDebt'] != null) $NetDebtLast = $data['NetDebt'];
		$EbitdaLTMq4 = $data['Ebitda'];
		$RevenueLTMq4 = $data['Revenue'];
					
		// further iterrations
		while($data = $s->fetch_array(MYSQLI_BOTH))
		{
			if ($data['NetDebt'] != 0 && $data['NetDebt'] != null) $NetDebtLast = $data['NetDebt'];
			
			$EbitdaLTMq1 = $EbitdaLTMq2;
			$EbitdaLTMq2 = $EbitdaLTMq3;
			$EbitdaLTMq3 = $EbitdaLTMq4;
			$EbitdaLTMq4 = $data['Ebitda'];
			$RevenueLTMq1 = $RevenueLTMq2;
			$RevenueLTMq2 = $RevenueLTMq3;
			$RevenueLTMq3 = $RevenueLTMq4;
			$RevenueLTMq4 = $data['Revenue'];
			
			$FinActuality = $data['Q'];
			$nrd = $data['NextReportingDate'];
			if ($nrd != null && strlen($nrd) > 9) $NextReportingDate = substr($nrd, 8).".".substr($nrd, 5, 2).".".substr($nrd, 0, 4);
			else $NextReportingDate = "---";
			$nrd = $data['NextOperatingDate'];
			if ($nrd != null && strlen($nrd) > 9) $NextOperatingDate = substr($nrd, 8).".".substr($nrd, 5, 2).".".substr($nrd, 0, 4);
			else $NextOperatingDate = "---";						
		}
		
		if (strpos($FinActuality, 'H') == false)
		{
			$EbitdaLTM = $EbitdaLTMq1 + $EbitdaLTMq2 + $EbitdaLTMq3 + $EbitdaLTMq4;
			$RevenueLTM = $RevenueLTMq1 + $RevenueLTMq2 + $RevenueLTMq3 + $RevenueLTMq4;
		}
		else 
		{
			$EbitdaLTM = $EbitdaLTMq3 + $EbitdaLTMq4;
			$RevenueLTM = $RevenueLTMq3 + $RevenueLTMq4;
		}
		
		// обычная акция
		$price = get_emitent_last_price_US($ticker);
		
		$qu = "SELECT Count FROM US_ClosePriceCap WHERE Ticker=? AND Count > 0 ORDER BY Date DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $ticker);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$shares_count = $data['Count'] + 0;
		$cap = $shares_count * $price;
		
		$price =  (float) $price;
		$cap   = ((float) $cap) / 1000000;
		$NetDebtLast = (float) $NetDebtLast;
		
		$dtY = date('Y-m-d', time() - 60 * 60 * 24);
		$dtT = date('Y-m-d');
		$hist_mult_00 = get_emitent_LTM_mult_hist_p75_US             ($ticker, 4)+0;
		$hist_mult    = get_emitent_LTM_mult_hist_p75_on_date_FCF_US ($ticker, 4, $dtT)+0;
		
		$EV_ = $cap;
		if (!$banking) $EV_ += $NetDebtLast;
		$mult_LTM = $EV_ / $EbitdaLTM;
		$EBITDA_rent_LTM = $EbitdaLTM / $RevenueLTM;
		
		$growth_Revenue_hist = get_growth_Revenue_hist_US($ticker);
		$growth_Ebitda_hist = get_growth_Ebitda_hist_US($ticker);
		
		$growth_Revenue = get_growth_Revenue_US($ticker);
		$growth_Ebitda = get_growth_Ebitda_US($ticker);
	}
	
	$Q_pre_LTM = $last_Q;
	$temp = substr($Q_pre_LTM, 0, 4) - 1 - $years_add;
	$Q_pre_LTM = $temp.substr($Q_pre_LTM, 4);
	
	$LTM_ending_date = str_replace('H1', 'q2', $last_Q);
	$LTM_ending_date = str_replace('H2', 'q4', $LTM_ending_date);
	$LTM_ending_date = str_replace(' q1', '-03-31', $LTM_ending_date);
	$LTM_ending_date = str_replace(' q2', '-06-30', $LTM_ending_date);
	$LTM_ending_date = str_replace(' q3', '-09-30', $LTM_ending_date);
	$LTM_ending_date = str_replace(' q4', '-12-31', $LTM_ending_date);
	$days = (strtotime(date('Y-m-d')) - strtotime($LTM_ending_date)) / (60 * 60 * 24);

	$s = $mysqli->query('SELECT Revenue, Ebitda FROM US_EmitentFinancialData WHERE Ticker="'.$ticker.'" AND Q="'.$last_Q.'" ');
	$row = $s->fetch_assoc();
	$fin_revenue_last = $row['Revenue'];
	$fin_ebitda_last = $row['Ebitda'];

	$s = $mysqli->query('SELECT Revenue, Ebitda FROM US_EmitentFinancialData WHERE Ticker="'.$ticker.'" AND Q="'.$Q_pre_LTM.'" ');
	if ($row = $s->fetch_assoc())
	{
		$fin_revenue_prev = $row['Revenue'];
		$fin_ebitda_prev = $row['Ebitda'];

		$gr_revenue = (pow($fin_revenue_last / $fin_revenue_prev, 1 / (1 + $years_add))) - 1;
		$gr_ebitda = (pow($fin_ebitda_last / $fin_ebitda_prev, 1 / (1 + $years_add))) - 1;
		
		if ($fin_revenue_last >= 0 && $fin_revenue_prev <= 0) $gr_revenue = 0;
		if ($fin_ebitda_last  >= 0 && $fin_ebitda_prev  <= 0) $gr_ebitda = 0;
		
		$gr_avg = ($gr_revenue + $gr_ebitda) / 2;

		$gr_revenue_hist = get_growth_Revenue_hist_US($ticker);
		$gr_ebitda_hist = get_growth_Ebitda_hist_US($ticker);
		$gr_avg_hist = ($gr_revenue_hist + $gr_ebitda_hist) / 2;
		
		$dt = date('Y-m-d');
		$paid = get_emitent_div_per_share_after_LTM_on_date_US($ticker, $LTM_ending_date, $dt, $mysqli) / $price * $cap;
		
		$FCF_LTM = get_emitent_FCF_LTM_US($ticker);

		$mult_aim = get_emitent_LTM_mult_hist_p75_US($ticker, 4);
		$mult_aim = str_replace('x', '', $mult_aim);
		$FCF_new = $FCF_LTM * ($days / 365);
		$NetDebtCurr = $NetDebtLast + $paid - $FCF_new;
		
		$s = $mysqli->query('SELECT Ebitda FROM US_EmitentFinancialData WHERE Ticker="'.$ticker.'" AND Q>"'.$Q_pre_LTM.'" ORDER BY Q ASC LIMIT 1 ');
		$row = $s->fetch_assoc();
		$fin_ebitda_LTM_begin = $row['Ebitda'];
		$period_length = 91;
		if (strpos($last_Q, 'H') != false) $period_length = 182;
		$EBITDA_curr = $EbitdaLTM + $fin_ebitda_LTM_begin * ($days / $period_length) * (pow($gr_ebitda + 1, (1 + $years_add)) - 1);
		
		$mult_E = ($cap + $NetDebtCurr) / $EBITDA_curr;
		$EV_E = $EBITDA_curr * $mult_aim;
		$cap_E = $EV_E - $NetDebtCurr;
		$potential = ($cap_E / $cap) - 1;
		
		if ($gr_avg <= ($gr_avg_hist / 100) || $gr_avg <= 0)
		{
			$potential = null;
		}
		
		$mysqli->query('START TRANSACTION;');
		
		$dtN = date('Y-m-d');
		$qu = 'SELECT Count(*) as Count FROM Company_Forecast WHERE Ticker=? AND Date=? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('ss', $ticker, $dtN);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		
		if ($data['Count'] == 0)
		{
			$qu = 'INSERT INTO Company_Forecast (Date, Ticker, EBITDA_E, Mult_E, Potential) VALUES (?, ?, ?, ?, ?) ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('ssidd', $dtN, $ticker, $EBITDA_curr, $mult_E, $potential);
			$stmt->execute();
		}
		else
		{
			$qu = 'UPDATE Company_Forecast SET Potential=? WHERE Date=? AND Ticker=? ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('dss', $potential, $dtN, $ticker);
			$stmt->execute();
		}
		
		$mysqli->query('COMMIT;');
		
		// ----------------------- Year Created Value ------------------------
		// (EBITDA 4Q – EBITDA 0Q) * (EBITDA LTM / EBITDA 4Q) * (EV/EBITDA LTM + ОБЩИЙ_x) /2 + FCF_LTM) / MCAP
		
		$year_created_value = -1000;
		
		if 
			(
				$fin_ebitda_last > 0 && 
				$EbitdaLTM > 0 && 
				$fin_ebitda_prev > 0
			)
		{
			if (!($fin_ebitda_last < 0))
			{
				$X__rel = ($EbitdaLTM / $fin_ebitda_last);
			}
			
			$year_created_value = 
				(
					($fin_ebitda_last - $fin_ebitda_prev) / (1 + $years_add) * 
					$X__rel * 
					(($cap + $NetDebtLast + $paid) / $EbitdaLTM + $mult_common_grow) / 2 + 
					$FCF_LTM
				) / 
				$cap;
		}
		
		$qu = 'SELECT Count(*) as ct FROM US_CreatedValue_Log WHERE Ticker=? AND Date=CURDATE() ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $ticker);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		if ($data['ct'] == 0)
		{
			$qu = 'INSERT INTO US_CreatedValue_Log (Ticker, Date, CreatedValue_percent) VALUES (?, CURDATE(), ?) ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('sd', $ticker, $year_created_value);
			$stmt->execute();
		}
		else
		{
			$qu = 'UPDATE US_CreatedValue_Log SET CreatedValue_percent=? WHERE Ticker=? AND Date=CURDATE() ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('ds', $year_created_value, $ticker);
			$stmt->execute();
		}
	}

	// --------------------------------------------------------

	$div_rate_Y = get_emitent_dividend_rate_US($ticker);

	if (!$banking)
	{
		if (!isset($FCF_LTM) || $FCF_LTM == null) $FCF_LTM = get_emitent_FCF_LTM_US($ticker);
		$FCF_rate_Y = number_format($FCF_LTM/$cap*100, 1, '.', ' ')."%";
	}

	$emitClosePrice = get_emitent_last_DayClose_price_SPECIAL_US($ticker);
	$emitDayPriceChange = $price / $emitClosePrice - 1;
	if(abs($emitDayPriceChange) < 0.0005) $emitDayPriceChange = 0;

	$min3y_price = get_emitent_min3y_close_price_US($ticker);
	$max3y_price = get_emitent_max3y_close_price_US($ticker);
	
	$shin = null;

	$shin = get_short_interest($ticker, $mysqli);

	$price_to_book = get_price_to_book($ticker, $mysqli);
	
	$EV_EBITDA_annualized = get_EV_EBITDA_annualized_any($ticker, $mysqli, 'US');
	
	$___obj = 
	[
		'is_grow' => $is_grow,
		'category' => $category,

		'NetDebtLast' => $NetDebtLast,
		'FinActuality' => $FinActuality,
		'NextReportingDate' => $NextReportingDate,
		'NextOperatingDate' => $NextOperatingDate,

		'EbitdaLTM' => $EbitdaLTM,
		'EbitdaLTMq1' => $EbitdaLTMq1,
		'EbitdaLTMq2' => $EbitdaLTMq2,
		'EbitdaLTMq3' => $EbitdaLTMq3,
		'EbitdaLTMq4' => $EbitdaLTMq4,

		'RevenueLTM' => $RevenueLTM,
		'RevenueLTMq1' => $RevenueLTMq1,
		'RevenueLTMq2' => $RevenueLTMq2,
		'RevenueLTMq3' => $RevenueLTMq3,
		'RevenueLTMq4' => $RevenueLTMq4,

		'price' => $price,
		'cap' => $cap,

		'dtY' => $dtY,
		'dtT' => $dtT,
		'hist_mult_00' => $hist_mult_00,
		'hist_mult' => $hist_mult,
		'EV_' => $EV_,

		'mult_LTM' => $mult_LTM,
		'EBITDA_rent_LTM' => $EBITDA_rent_LTM,
		'growth_Revenue' => $growth_Revenue,
		'growth_Revenue_hist' => $growth_Revenue_hist,
		'growth_Ebitda' => $growth_Ebitda,
		'growth_Ebitda_hist' => $growth_Ebitda_hist,

		'year_created_value' => $year_created_value,

		'last_Q' => $last_Q,
		'Q_pre_LTM' => $Q_pre_LTM,
		'temp' => $temp,
		'Q_pre_LTM' => $Q_pre_LTM,

		'LTM_ending_date' => $LTM_ending_date,
		'days' => $days,

		'fin_revenue_last' => $fin_revenue_last,
		'fin_ebitda_last' => $fin_ebitda_last,

		'fin_revenue_prev' => $fin_revenue_prev,
		'fin_ebitda_prev' => $fin_ebitda_prev,
		'gr_revenue' => $gr_revenue,
		'gr_ebitda' => $gr_ebitda,

		'gr_avg' => $gr_avg,

		'gr_revenue_hist' => $gr_revenue_hist,
		'gr_ebitda_hist' => $gr_ebitda_hist,
		'gr_avg_hist' => $gr_avg_hist,

		'dt' => $dt,
		'paid' => $paid,
		'FCF_LTM' => $FCF_LTM,

		'mult_aim' => $mult_aim,
		'FCF_new' => $FCF_new,
		'NetDebtCurr' => $NetDebtCurr,

		'fin_ebitda_LTM_begin' => $fin_ebitda_LTM_begin,
		'period_length' => $period_length,
		'EBITDA_curr' => $EBITDA_curr,
		'mult_E' => $mult_E,
		'EV_E' => $EV_E,
		'cap_E' => $cap_E,
		'potential' => $potential,

		'div_rate_Y' => $div_rate_Y,
		'FCF_rate_Y' => $FCF_rate_Y,

		'emitClosePrice' => $emitClosePrice,
		'emitDayPriceChange' => $emitDayPriceChange,
		'min3y_price' => $min3y_price,
		'max3y_price' => $max3y_price,

		'shares_count' => $shares_count,
		'countData' => $countData,

		'mult_common_grow' => $mult_common_grow,
		'X__rel' => $X__rel,

		'shin' => $shin,
		
		'price_to_book' => (isset($price_to_book) ? $price_to_book : null),
			
		'EV_EBITDA_annualized' => (isset($EV_EBITDA_annualized) ? $EV_EBITDA_annualized : null),
	];

	$___cashe_s = serialize($___obj);
	file_put_contents($___cashe_file, $___cashe_s);
}
else
{
	$___obj = unserialize($___cashe_s);
	$is_grow = $___obj['is_grow'];
	$category = $___obj['category'];

	$NetDebtLast = $___obj['NetDebtLast'];
	$FinActuality = $___obj['FinActuality'];
	$NextReportingDate = $___obj['NextReportingDate'];
	$NextOperatingDate = $___obj['NextOperatingDate'];

	$EbitdaLTM = $___obj['EbitdaLTM'];
	$EbitdaLTMq1 = $___obj['EbitdaLTMq1'];
	$EbitdaLTMq2 = $___obj['EbitdaLTMq2'];
	$EbitdaLTMq3 = $___obj['EbitdaLTMq3'];
	$EbitdaLTMq4 = $___obj['EbitdaLTMq4'];

	$RevenueLTM = $___obj['RevenueLTM'];
	$RevenueLTMq1 = $___obj['RevenueLTMq1'];
	$RevenueLTMq2 = $___obj['RevenueLTMq2'];
	$RevenueLTMq3 = $___obj['RevenueLTMq3'];
	$RevenueLTMq4 = $___obj['RevenueLTMq4'];

	$price = $___obj['price'];
	$cap = $___obj['cap'];

	$dtY = $___obj['dtY'];
	$dtT = $___obj['dtT'];
	$hist_mult_00 = $___obj['hist_mult_00'];
	$hist_mult = $___obj['hist_mult'];
	$EV_ = $___obj['EV_'];

	$mult_LTM = $___obj['mult_LTM'];
	$EBITDA_rent_LTM = $___obj['EBITDA_rent_LTM'];
	$growth_Revenue = $___obj['growth_Revenue'];
	$growth_Revenue_hist = $___obj['growth_Revenue_hist'];
	$growth_Ebitda = $___obj['growth_Ebitda'];
	$growth_Ebitda_hist = $___obj['growth_Ebitda_hist'];

	$year_created_value = $___obj['year_created_value'];

	$last_Q = $___obj['last_Q'];
	$Q_pre_LTM = $___obj['Q_pre_LTM'];
	$temp = $___obj['temp'];
	$Q_pre_LTM = $___obj['Q_pre_LTM'];

	$LTM_ending_date = $___obj['LTM_ending_date'];
	$days = $___obj['days'];

	$fin_revenue_last = $___obj['fin_revenue_last'];
	$fin_ebitda_last = $___obj['fin_ebitda_last'];

	$fin_revenue_prev = $___obj['fin_revenue_prev'];
	$fin_ebitda_prev = $___obj['fin_ebitda_prev'];
	$gr_revenue = $___obj['gr_revenue'];
	$gr_ebitda = $___obj['gr_ebitda'];

	$gr_avg = $___obj['gr_avg'];

	$gr_revenue_hist = $___obj['gr_revenue_hist'];
	$gr_ebitda_hist = $___obj['gr_ebitda_hist'];
	$gr_avg_hist = $___obj['gr_avg_hist'];

	$dt = $___obj['dt'];
	$paid = $___obj['paid'];
	$FCF_LTM = $___obj['FCF_LTM'];

	$mult_aim = $___obj['mult_aim'];
	$FCF_new = $___obj['FCF_new'];
	$NetDebtCurr = $___obj['NetDebtCurr'];

	$fin_ebitda_LTM_begin = $___obj['fin_ebitda_LTM_begin'];
	$period_length = $___obj['period_length'];
	$EBITDA_curr = $___obj['EBITDA_curr'];
	$mult_E = $___obj['mult_E'];
	$EV_E = $___obj['EV_E'];
	$cap_E = $___obj['cap_E'];
	$potential = $___obj['potential'];

	$div_rate_Y = $___obj['div_rate_Y'];
	$FCF_rate_Y = $___obj['FCF_rate_Y'];

	$emitClosePrice = $___obj['emitClosePrice'];
	$emitDayPriceChange = $___obj['emitDayPriceChange'];
	$min3y_price = $___obj['min3y_price'];
	$max3y_price = $___obj['max3y_price'];

	$shares_count = $___obj['shares_count'];
	$countData = $___obj['countData'];

	$mult_common_grow = $___obj['mult_common_grow'];
	$X__rel = $___obj['X__rel'];

	$shin =  $___obj['shin'];
	
	$price_to_book = (isset($___obj['price_to_book']) ? $___obj['price_to_book'] : null);
	
	$EV_EBITDA_annualized = (isset($___obj['EV_EBITDA_annualized']) ? $___obj['EV_EBITDA_annualized'] : null);
}

include '/html/api/api_view/data_page_universal.php';

include '/html/php_db/company_E_calculation_alpha_beta.php';

?>