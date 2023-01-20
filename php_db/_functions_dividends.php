<?php

function get_emitent_div_per_share_after_LTM($ticker, $LTM_ending_date, $mysqli)
{
	$dt = date('Y-m-d');
	return get_emitent_div_per_share_after_LTM_on_date($ticker, $LTM_ending_date, $dt, $mysqli);
}

function get_emitent_div_per_share_after_LTM_on_date($ticker, $LTM_ending_date, $dt, $mysqli)
{
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM Company_Dividend WHERE Ticker = ? AND Dividend_Last_Buy > ? AND Dividend_Last_Buy < ?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	return $sum * get_PrCurrX_by_ticker($ticker, $mysqli);
}

function get_emitent_div_per_share_after_LTM_on_date_US($ticker, $LTM_ending_date, $dt, $mysqli)
{
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM US_Company_Dividend WHERE Ticker = ? AND Dividend_Last_Buy > ? AND Dividend_Last_Buy < ?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	return $sum;
}

function get_emitent_div_per_share_after_LTM_on_date_US_2($ticker, $LTM_ending_date, $dt, $mysqli)
{
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM US2_Company_Dividend WHERE Ticker = ? AND Dividend_Last_Buy > ? AND Dividend_Last_Buy < ?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	return $sum;
}

function get_emitent_div_per_share_after_LTM_OwnCurr($ticker, $LTM_ending_date)
{
	$dt = date('Y-m-d');
	return get_emitent_div_per_share_after_LTM_OwnCurr_on_date($ticker, $LTM_ending_date, $dt);
}

function get_emitent_div_per_share_after_LTM_OwnCurr_on_date($ticker, $LTM_ending_date, $dt)
{
	include '/html'.'/engine/connect.php';
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM Company_Dividend WHERE Ticker = ? AND Dividend_Last_Buy > ? AND Dividend_Last_Buy < ?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	include '/html/engine/'.'connect_close.php';
	return $sum;
}

function get_emitent_div_per_share_after_LTM_Wd($ticker, $LTM_ending_date)
{
	$dt = date('Y-m-d');
	return get_emitent_div_per_share_after_LTM_Wd_on_date($ticker, $LTM_ending_date, $dt);
}

function get_emitent_div_per_share_after_LTM_Wd_on_date($ticker, $LTM_ending_date, $dt)
{
	include '/html'.'/engine/connect.php';
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM Wd_Company_Dividend WHERE Ticker=? AND Dividend_Last_Buy>? AND Dividend_Last_Buy<?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	include '/html/engine/'.'connect_close.php';
	return $sum;
}

function get_emitent_div_per_share_after_LTM_US($ticker, $LTM_ending_date)
{
	$dt = date('Y-m-d');
	return get_emitent_div_per_share_after_LTM_US_on_date($ticker, $LTM_ending_date, $dt);
}

function get_emitent_div_per_share_after_LTM_US_on_date($ticker, $LTM_ending_date, $dt)
{
	include '/html/engine/connect.php';
	$qu = "SELECT Sum(Dividend_Per_Share_Declared) as sm FROM US_Company_Dividend WHERE Ticker=? AND Dividend_Last_Buy>? AND Dividend_Last_Buy<?";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	include '/html/engine/connect_close.php';
	return $sum;
}

function get_emitent_div_per_share_after_LTM_US_2($ticker, $LTM_ending_date)
{
	$dt = date('Y-m-d');
	return get_emitent_div_per_share_after_LTM_US_2_on_date($ticker, $LTM_ending_date, $dt);
}

function get_emitent_div_per_share_after_LTM_US_2_on_date($ticker, $LTM_ending_date, $dt)
{
	include '/html/engine/connect.php';
	$qu = 'SELECT Sum(Dividend_Per_Share_Declared) as sm FROM US2_Company_Dividend WHERE Ticker = ? AND Dividend_Last_Buy > ? AND Dividend_Last_Buy < ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('sss', $ticker, $LTM_ending_date, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	$sum = 0;
	if ($row = $s->fetch_assoc()) $sum = $row['sm'];
	if ($sum == null) $sum = 0;
	include '/html/engine/connect_close.php';
	return $sum;
}

function get_emitent_dividend_rate($ticker)
{
    include '/html/engine/connect.php';
	$q = get_emitent_last_Q($ticker);
	$limit = 2;
	if (strpos($q, 'q') != false) $limit = 4;
	$divSum = 0;
		
	$qu = 'SELECT Dividend_Per_Share_Declared, Dividend_Last_Buy, Q FROM Company_Dividend WHERE Ticker=? AND Dividend_Per_Share_Declared IS NOT NULL ORDER BY Q DESC LIMIT ? ';
	$stmt = $mysqli->prepare($qu);
	$limit4 = 4;
	$stmt->bind_param('si', $ticker, $limit4);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days'))));
		
		if ($data['Q'] > $bottom_Q) $divSum += $data['Dividend_Per_Share_Declared'];
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
				$divSum += $data['Dividend_Per_Share_Declared'];
		
		$price_l = get_emitent_last_price($ticker);
		
		if ($divSum >= $price_l)
		{
			$avg_price = get_avg_stock_price_RF($ticker, 365, $mysqli);
			
			if ($divSum >= $avg_price)
			{
				return '0.0%';
			}
			else
			{
				return number_format($divSum / $avg_price * 100, 1, '.', ' ').'%';
			}
		}
		else
		{
			return number_format($divSum / $price_l * 100, 1, '.', ' ').'%';
		}
	}
	else
	{
		// second way (if NO data per share)
		$cap_full = get_emitent_cap_FULL($ticker);
		$qu = 'SELECT Dividend FROM EmitentFinancialData WHERE Ticker=? ORDER BY Q DESC LIMIT ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('si', $ticker, $limit);
		$stmt->execute();
		$s = $stmt->get_result();
		while ($data = $s->fetch_array(MYSQLI_BOTH)) $divSum -= $data['Dividend'];
		
		include '/html/engine/connect_close.php';
		
		if ($divSum >= $cap_full) return '0.0%';
		return number_format($divSum / $cap_full * 100, 1, '.', ' ').'%';
	}
}

function get_emitent_dividend_rate_Wd($ticker)
{
    include '/html/engine/connect.php';
	$divSum = 0;
		
	$qu = 
		'
			SELECT 
				Dividend_Per_Share_Declared, 
				Dividend_Last_Buy, 
				Q 
			FROM Wd_Company_Dividend 
			WHERE 
				Ticker = ? AND 
				Dividend_Per_Share_Declared IS NOT NULL 
			ORDER BY Q DESC 
			LIMIT 4 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days'))));
		
		if ($data['Q'] > $bottom_Q)
		{
			$divSum += $data['Dividend_Per_Share_Declared'];
		}
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
			{
				$divSum += $data['Dividend_Per_Share_Declared'];
			}
		}
		
		$price_l = get_emitent_last_price_Wd($ticker);
		
		if ($divSum >= $price_l)
		{
			$avg_price = get_avg_stock_price_GC($ticker, 365, $mysqli);
			
			if ($divSum >= $avg_price)
			{
				return '0.0%';
			}
			else
			{
				return number_format($divSum / $avg_price * 100, 1, '.', ' ').'%';
			}
		}
		else
		{
			return number_format($divSum / $price_l * 100, 1, '.', ' ').'%';
		}
	}
	else
	{
		$q = get_emitent_last_Q_Wd($ticker);
		$limit = 2;
		if (strpos($q, 'q') != false) $limit = 4;
		
		// second way (if NO data per share)
		$cap_full = get_emitent_cap_FULL_Wd($ticker, false);
		
		$qu = 
			'
				SELECT Dividend 
				FROM Wd_EmitentFinancialData 
				WHERE Ticker = ? 
				ORDER BY Q DESC 
				LIMIT ? 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('si', $ticker, $limit);
		$stmt->execute();
		$s = $stmt->get_result();
		while ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$divSum -= $data['Dividend'];
		}
		
		include '/html/engine/connect_close.php';
		
		if ($divSum >= $cap_full) return '0.0%';
		return number_format($divSum / $cap_full * 100, 1, '.', ' ').'%';
	}
}

function get_emitent_dividend_rate_US($ticker)
{
    include '/html/engine/connect.php';
	$divSum = 0;
		
	$qu = 'SELECT Dividend_Per_Share_Declared, Dividend_Last_Buy, Q FROM US_Company_Dividend WHERE Ticker=? AND Dividend_Per_Share_Declared IS NOT NULL ORDER BY Q DESC LIMIT 4 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days'))));
		
		if ($data['Q'] > $bottom_Q) $divSum += $data['Dividend_Per_Share_Declared'];
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
				$divSum += $data['Dividend_Per_Share_Declared'];
		
		$price_l = get_emitent_last_price_US($ticker);
		
		if ($divSum >= $price_l)
		{
			$avg_price = get_avg_stock_price_US($ticker, 365, $mysqli);
			
			if ($divSum >= $avg_price)
			{
				return '0.0%';
			}
			else
			{
				return number_format($divSum / $avg_price * 100, 1, '.', ' ').'%';
			}
		}
		else
		{
			return number_format($divSum / $price_l * 100, 1, '.', ' ').'%';
		}
	}
	else
	{
		// second way (if NO data per share)
		$cap_full = get_emitent_cap_FULL_US($ticker);
		$qu = 'SELECT Dividend FROM US_EmitentFinancialData WHERE Ticker=? ORDER BY Q DESC LIMIT 4 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $ticker);
		$stmt->execute();
		$s = $stmt->get_result();
		while ($data = $s->fetch_array(MYSQLI_BOTH)) $divSum -= $data['Dividend'];
		
		include '/html/engine/'.'connect_close.php';
		
		if ($divSum >= $cap_full) return '0.0%';
		return number_format($divSum / $cap_full * 100, 1, '.', ' ').'%';
	}
}

function get_emitent_dividend_rate_US_2($ticker)
{
    include '/html/engine/connect.php';
	$divSum = 0;
		
	$qu = 'SELECT Dividend_Per_Share_Declared, Dividend_Last_Buy, Q FROM US2_Company_Dividend WHERE Ticker=? AND Dividend_Per_Share_Declared IS NOT NULL ORDER BY Q DESC LIMIT 4 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days'))));
		
		if ($data['Q'] > $bottom_Q) $divSum += $data['Dividend_Per_Share_Declared'];
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
				$divSum += $data['Dividend_Per_Share_Declared'];
		
		$price_l = get_emitent_last_price_US_2($ticker);
		
		if ($divSum >= $price_l)
		{
			$avg_price = get_avg_stock_price_US2($ticker, 365, $mysqli);
			
			if ($divSum >= $avg_price)
			{
				return '0.0%';
			}
			else
			{
				return number_format($divSum / $avg_price * 100, 1, '.', ' ').'%';
			}
		}
		else
		{
			return number_format($divSum / $price_l * 100, 1, '.', ' ').'%';
		}
	}
	else
	{
		include '/html/engine/connect_close.php';
		return '0.0%';
	}
}

function get_emitent_dividend_rate_US_2_on_date($ticker, $dt, $mysqli)
{
	$result = 0;
	
	$divSum = 0;
		
	$qu = 
		'
			SELECT 
				Dividend_Per_Share_Declared, 
				Dividend_Last_Buy, 
				Q 
			FROM US2_Company_Dividend 
			WHERE 
				Ticker = ? AND 
				Dividend_Last_Buy < ? AND 
				Dividend_Per_Share_Declared IS NOT NULL 
			ORDER BY Q DESC 
			LIMIT 4 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('ss', $ticker, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days', strtotime($dt)))));
		
		if ($data['Q'] > $bottom_Q)
		{
			$divSum += $data['Dividend_Per_Share_Declared'];
		}
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
			{
				$divSum += $data['Dividend_Per_Share_Declared'];
			}
		}
		
		$price_l = get_emitent_last_price_US_2($ticker);
		
		if ($divSum < $price_l)
		{
			$result = $divSum / $price_l;
		}
	}
	
	return $result;
}

function get_emitent_dividend_rate_GC_on_date($ticker, $dt, $mysqli)
{
	$result = 0;
	
	$divSum = 0;
		
	$qu = 
		'
			SELECT 
				Dividend_Per_Share_Declared, 
				Dividend_Last_Buy, 
				Q 
			FROM Wd_Company_Dividend 
			WHERE 
				Ticker = ? AND 
				Dividend_Last_Buy < ? AND 
				Dividend_Per_Share_Declared IS NOT NULL 
			ORDER BY Q DESC 
			LIMIT 4 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('ss', $ticker, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$last_date = $data['Dividend_Last_Buy'];
		$last_date = date('Y-m-d', strtotime('-330 days', strtotime($last_date)));
		
		$bottom_Q = (substr($data['Q'], 0, 4) - 1).substr($data['Q'], 4);
		$bottom_Q =  max($bottom_Q, get_q(date('Y-m-d', strtotime('-570 days', strtotime($dt)))));
		
		if ($data['Q'] > $bottom_Q)
		{
			$divSum += $data['Dividend_Per_Share_Declared'];
		}
		
		while ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			if ($data['Q'] > $bottom_Q && $data['Dividend_Last_Buy'] > $last_date)
			{
				$divSum += $data['Dividend_Per_Share_Declared'];
			}
		}
		
		$price_l = get_emitent_last_price_Wd($ticker);
		
		if ($divSum < $price_l)
		{
			$result = $divSum / $price_l;
		}
	}
	
	return $result;
}

?>