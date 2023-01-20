<?php

ini_set('display_errors', '1');
date_default_timezone_set('Europe/Moscow');
include '/html/engine/connect.php';
include_once '/html/php_db/single_functions.php';

include_once '/html/php_db/_functions_reporting.php';

include '/html/head_foot/head_1.php';

// ------------ ------------ ------------ ------------ ------------ ------------ ------------ ------------

$apiToken = '*****************************';
$chatId = '************';

// ------------ ------------ ------------ ------------ ------------ ------------ ------------ ------------

$dts = [];
$qu = 'SELECT DISTINCT D as DD FROM ___YAHOO_report_moments WHERE D > CURDATE() ORDER BY DD ASC ';
$stmt = $mysqli->prepare($qu);
$stmt->execute();
$s = $stmt->get_result();
while ($data = $s->fetch_array(MYSQLI_BOTH)) $dts[] = $data['DD'];

if (sizeOf($dts) >= 2)
{
	$messages = [];
	
	$dt = $dts[1];
	$qu = 
		'
			SELECT 
				t1.Ticker, 
				t2.Name, 
				t1.Moment 
			FROM ___YAHOO_report_moments t1 
				LEFT JOIN US2_Emitents t2 
				ON t1.Ticker = t2.Ticker 
			WHERE 
				t1.D = ? AND 
				t2.Active = 1 
			ORDER BY 
				t1.Ticker ASC 
		';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	while ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$ticker = $data['Ticker'];
		$name = $data['Name'];
		$moment = strtolower($data['Moment']);
		
		$eps_confirmation_stat = get_eps_confirmation_stat($ticker, $mysqli);
		$eps_beats_hist = $eps_confirmation_stat[1]; // beats estimates in % of quarters
		$eps_beats_avg = $eps_confirmation_stat[2]; // beats estimates by $ in average
		$EPS_A_arr = $eps_confirmation_stat[4]; // array of eps values (actual)
		$EPS_E_arr = $eps_confirmation_stat[5]; // array of eps values (estimated)
		
		if (sizeOf($EPS_A_arr) > 1 && $eps_beats_hist !== null)
		{
			$temp_s_1 = '';
			if (strpos($moment, 'open' ) > 1) $temp_s_1 = $lang_tr['ltr_00819a'];
			if (strpos($moment, 'close') > 1) $temp_s_1 = $lang_tr['ltr_00819b'];
			
			$temp_s_2 = $lang_tr['ltr_00820b'];
			if (sizeOf($EPS_A_arr) > 4) $temp_s_2 = $lang_tr['ltr_00820c'];
			
			$message  = '';
			$message .= '#'.$ticker.'<br><br>';
			$message .= $name.' '.$lang_tr['ltr_00818'].' '.$lang_tr['ltr_00819'].' ('.$dt.') '.$temp_s_1.'<br><br>';
			$message .= $lang_tr['ltr_00820a'].' '.sizeOf($EPS_A_arr).' '.$temp_s_2.' '.$lang_tr['ltr_00821'].' ';
			
			$message .= number_format($eps_beats_hist*100,0,'.','').'% '.$lang_tr['ltr_00779'].' ('.$lang_tr['ltr_00780'].nice_EPS($eps_beats_avg).' '.$lang_tr['ltr_00781'].')';
			
			
			$messages[] = $message;
		}
	}
}

// ------------ ------------ ------------ ------------ ------------ ------------ ------------ ------------

if (sizeOf($messages) > 0)
{
	echo '<div class="border1 float1" style="width:550px; font-size:14px;" > ';
		
		for ($i = 0; $i < sizeOf($messages); $i++)
		{
			echo '<div style="margin:50px 30px;" >',$messages[$i],'</div>';
			echo '<hr style="margin:10px; height:0px; color:#F0F0F0;" />';
		}
		
	echo '</div>';
}

?>