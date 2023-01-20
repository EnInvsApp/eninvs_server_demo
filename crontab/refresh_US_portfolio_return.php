<?php

ini_set('display_errors', '1');
date_default_timezone_set('Europe/Moscow');
include '/html/'.'engine/connect.php';
include_once '/html/php_db/single_functions.php';

// ----------------------------------------------------------------------------------------------------------------

$dt_minus_2 = date('Y-m-d', strtotime('-40 hour'));
$dt_minus_1 = date('Y-m-d', strtotime('-16 hour'));

$names = array();
$tickers = array();
$shares = array();
$prices_P = array();
$prices_N = array();
$qu = 
	'SELECT Name, Ticker, Share, Price '.
	'FROM Aim_Portfolio_Structure '.
	'WHERE Market="US" AND '.
	'DT = (SELECT MAX(DT) FROM Aim_Portfolio_Structure WHERE Market="US" AND DATE_FORMAT(DT,"%Y-%m-%d")="'.$dt_minus_2.'" ) ';
$stmt = $mysqli->prepare($qu);
$stmt->execute();
$s = $stmt->get_result();

// ----------------------------------------------------------------------------------------------------------------

$i = 0;
$sum_P = 0;
$sum_N = 0;
while ($data = $s->fetch_array(MYSQLI_BOTH))
{
	$shares[] = $data['Share'];
	$prices_P[] = $data['Price'];
	$prices_N[] = get_emitent_last_price_US($data['Ticker']);
	
	$div = 0;
	
	$qu = 'SELECT Dividend_Per_Share_Declared FROM US_Company_Dividend WHERE Ticker="'.$data['Ticker'].'" AND Dividend_Last_Buy="'.$dt_minus_2.'" ';
	$stmt = $mysqli->prepare($qu);
	$stmt->execute();
	$s__ = $stmt->get_result();
	if ($data__ = $s__->fetch_array(MYSQLI_BOTH)) $div = $data__['Dividend_Per_Share_Declared'];
	
	$sum_P += $shares[$i];
	$sum_N += $shares[$i] * (($prices_N[$i] + $div) / $prices_P[$i]);
	
	$i++;
}

// ----------------------------------------------------------------------------------------------------------------

$day_X = $sum_N / $sum_P;

$qu = 'SELECT US_Value FROM Profitability WHERE D="'.$dt_minus_2.'" ';
$stmt = $mysqli->prepare($qu);
$stmt->execute();
$s = $stmt->get_result();
$data = $s->fetch_array(MYSQLI_BOTH);
$RS_SPB_Value_P = $data['US_Value'];

$RS_SPB_Value_N = $RS_SPB_Value_P * $day_X; 
$qu = 'UPDATE Profitability SET US_Value_day=?, US_Value=? WHERE D=? ';
$stmt = $mysqli->prepare($qu);
$stmt->bind_param('dds', $day_X, $RS_SPB_Value_N, $dt_minus_1);
$stmt->execute();

include '/html/'.'engine/connect_close.php';

?>