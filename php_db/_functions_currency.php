<?php

function get_USDRUB_by_month($ym, $mysqli)
{
	$y = substr($ym,0,strpos($ym,' ')) + 0;
	$m = substr($ym,strpos($ym,' ')) + 0;
	
	$qu = 'SELECT AVG(Value) as amv FROM Currencies_D_Values WHERE currID=1 AND YEAR(D)+0=? AND MONTH(D)+0=? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('dd', $y, $m);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	return $data['amv'];
}

function get_currency_US2($mysqli, $ticker)
{
	$res = null;
	
	$qu = 'SELECT Currency FROM US2_Emitents WHERE Ticker = ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	if ($data = $s->fetch_assoc()) $res = $data['Currency'];
	
	return $res;
}

function get_curr_infl_rate($currID, $last_Q, $mysqli)
{
	$res = get_US_Producer_price_index_yoy($mysqli) + 1;
	
	if ($currID > 0)
	{
		$qu = 'SELECT PPI_yoy FROM Currencies WHERE ID = ? AND PPI_yoy > 0 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('d', $currID);
		$stmt->execute();
		$s = $stmt->get_result();
		if ($data = $s->fetch_assoc())
		{
			$res = $data['PPI_yoy'];
			$res = min(max($res, 0.6), 2.0);
		}
	}
	
	return $res;
}

function get_inflation_Wd_x_by_date($currID, $last_Q, $mysqli)
{
	$Y = substr($last_Q, 0, 4) + 0;
	$Y = max($Y, 2015);
	
	$qu = 'SELECT Value FROM Currency_Y_Inflation WHERE currID=? AND Y<=? ORDER BY Y DESC LIMIT 1 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('dd', $currID, $Y);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_assoc();
	$res = $data['Value'] + 1;
	return $res;
}

function get_emitent_curr($ticker)
{
	$res = '';
	include '/html'.'/engine/connect.php';
	$qu = "SELECT ShortName FROM Emitents LEFT JOIN Currencies ON `Share_currID` = Currencies.ID WHERE Ticker = ? ";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	if ($data = $s->fetch_array(MYSQLI_BOTH)) $res = $data['ShortName'];
	if (strlen($res) > 3) $res = substr($res, 3, 3);
	if (strlen($res) < 3) $res = 'USD';
	include '/html/engine/'.'connect_close.php';
	return $res;
}

function get_emitent_curr_Wd($ticker)
{
	$res = '';
	include '/html'.'/engine/connect.php';
	$qu = "SELECT ShortName FROM Wd_Emitents LEFT JOIN Currencies ON `Share_currID` = Currencies.ID WHERE Ticker = ? ";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	if ($data = $s->fetch_array(MYSQLI_BOTH)) $res = $data['ShortName'];
	if (strlen($res) > 3) $res = substr($res, 3, 3);
	if (strlen($res) < 3) $res = 'USD';
	include '/html/engine/'.'connect_close.php';
	return $res;
}

function get_emitent_currID($ticker, $mysqli)
{
	$res = '';
	$qu = 'SELECT Share_currID FROM Emitents WHERE Ticker = ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$res = $data['Share_currID'];
	return $res;
}

function get_emitent_currID_Wd($ticker, $mysqli)
{
	$res = "";
	$qu = "SELECT Share_currID FROM Wd_Emitents WHERE Ticker = ? ";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$res = $data['Share_currID'];
	return $res;
}

function get_PrCurrX_by_ticker($ticker, $mysqli)
{
	$PrCurrX = 1;
	$qu = "SELECT Share_currID FROM Emitents WHERE Ticker=? ";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$PrCurrID = $data['Share_currID'];
	if ($PrCurrID != 1) // if not RUB
	{
		$qu = "SELECT Value FROM Currencies_D_Values WHERE currID = 1 ORDER BY D DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$PrCurrX = $data['Value'];
	}
	if ($PrCurrID > 1) // if also not USD
	{
		$qu = "SELECT Value FROM Currencies_D_Values WHERE currID = ? ORDER BY D DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('i', $PrCurrID);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$PrCurrX = $PrCurrX / $data['Value'];
	}
	return $PrCurrX;
}

function get_PrCurrX_by_ticker_on_date($ticker, $dt, $mysqli)
{
	$PrCurrX = 1;
	$qu = "SELECT Share_currID FROM Emitents WHERE Ticker=? ";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$PrCurrID = $data['Share_currID'];
	if ($PrCurrID != 1) // if not RUB
	{
		$qu = "SELECT Value FROM Currencies_D_Values WHERE currID = 1 AND D <= ? ORDER BY D DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$PrCurrX = $data['Value'];
	}
	if ($PrCurrID > 1) // if also not USD
	{
		$qu = "SELECT Value FROM Currencies_D_Values WHERE currID = ? AND D <= ? ORDER BY D DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('is', $PrCurrID, $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$PrCurrX = $PrCurrX / $data['Value'];
	}
	return $PrCurrX;
}

function get_PrCurrX_by_ticker_on_date_Wd($ticker, $dt, $mysqli)
{
	$PrCurrX = 1;
	$qu = 'SELECT Share_currID FROM Wd_Emitents WHERE Ticker=? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	$data = $s->fetch_array(MYSQLI_BOTH);
	$PrCurrID = $data['Share_currID'];
	if ($PrCurrID > 0) // if not USD
	{
		$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID = ? AND D <= ? ORDER BY D DESC LIMIT 1 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('is', $PrCurrID, $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$PrCurrX = $PrCurrX / $data['Value'];
	}
	
	return $PrCurrX;
}

function get_currID($ShortName, $mysqli)
{
	$res = null;
	
	$ShortName = strtoupper($ShortName);
	
	if (strlen($ShortName) == 3)
	{
		$ShortName = 'USD'.$ShortName;
	}
	
	if ($ShortName == 'USDRMB') $ShortName = 'USDCNY';
	if ($ShortName == 'USDRUR') $ShortName = 'USDRUB';
	
	$qu = 'SELECT ID FROM Currencies WHERE ShortName = ? ';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ShortName);
	$stmt->execute();
	$s = $stmt->get_result();
	
    if ($row = $s->fetch_assoc())
	{
		$res = $row['ID'];
	}
	
	return $res;
}

function get_cross_course_LTM($currID, $mysqli)
{
	$qu = 'SELECT avg(Value) as Value FROM (SELECT currID, Value FROM Currencies_Q_Values WHERE currID=? ORDER BY Q DESC LIMIT 4) as t1 GROUP BY currID ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	return $row['Value'];
}

function get_cross_course_LTM_q($currID, $max_q, $mysqli)
{
	$qu = 'SELECT avg(Value) as Value FROM (SELECT currID, Value FROM Currencies_Q_Values WHERE currID=? AND Q<=? ORDER BY Q DESC LIMIT 4) as t1 GROUP BY currID ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('is', $currID, $max_q);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	return $row['Value'];
}

function get_cross_course_by_two_currencies($curr_1, $curr_2, $dt, $mysqli)
{
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	$x1 = 1;
	$x2 = 1;
	
	if ($curr_1 != 'USD')
	{
		$x1 = get_cross_course_on_date(get_currID('USD'.$curr_1, $mysqli), $dt, $mysqli);
	}
	
	if ($curr_2 != 'USD')
	{
		$x2 = get_cross_course_on_date(get_currID('USD'.$curr_2, $mysqli), $dt, $mysqli);
	}
	
	$x = $x2 / $x1;
	
	return $x;
}

function get_cross_course_on_date($currID, $dt, $mysqli)
{
	$res = null;
	
	$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? AND D<=? ORDER BY D DESC LIMIT 1 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('is', $currID, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
    if ($row = $s->fetch_assoc()) $res = $row['Value'] + 0;
	
	if ($res == null || $res <= 0)
	{
		$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D ASC LIMIT 1 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('i', $currID);
		$stmt->execute();
		$s = $stmt->get_result();
		if ($row = $s->fetch_assoc()) $res = $row['Value'] + 0;
	}
	
	if ($res == null || $res <= 0) $res = 1;
	
	return $res;
}

function get_cross_course_last($currID, $mysqli)
{
	if ($currID == 0) return 1;
	$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D DESC LIMIT 1 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	return $row['Value'];
}

function get_cross_course_prev($currID, $mysqli)
{
	$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? AND D<CURDATE() ORDER BY D DESC LIMIT 1 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	return $row['Value'];
	
	/*
	$qu = "SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D DESC LIMIT 2";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
    $row = $s->fetch_assoc();
	return $row['Value'];
	*/
}

function get_curr_ShortName_by_currID($currID)
{
    include '/html/engine/connect.php';
    $qu = 'SELECT ShortName FROM Currencies where ID = ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	include '/html/engine/connect_close.php';
    return $row['ShortName'];
}

function get_curr_Description_by_currID($currID)
{
    include '/html/engine/connect.php';
    $qu = 'SELECT Description FROM Currencies where ID = ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    $row = $s->fetch_assoc();
	include '/html/engine/connect_close.php';
    return $row['Description'];
}

function get_curr_Description_by_currID_lang($currID, $lang)
{
	$result = null;
	
    include '/html/engine/connect.php';
	
	if ($lang == '' || strtoupper($lang) == 'RU') $qu = 'SELECT Description   as DS FROM Currencies where ID = ? ';
    else                                          $qu = 'SELECT DescriptionEN as DS FROM Currencies where ID = ? ';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $currID);
	$stmt->execute();
	$s = $stmt->get_result();
    
	if ($row = $s->fetch_assoc())
	{
		$result = $row['DS'];
	}
	
	include '/html/engine/connect_close.php';
	
    return $result;
}

function get_comm_Currency_by_commID($commID)
{
    include '/html/engine/connect.php';
    $qu = 'SELECT Currencies.ShortName as sn FROM Commodities LEFT JOIN Currencies ON Currencies.ID=Commodities.Measure_currencyID where Commodities.ID=? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $commID);
	$stmt->execute();
	$s = $stmt->get_result();
	include '/html/engine/connect_close.php';
    if ($row = $s->fetch_assoc())
	{
        $res = $row['sn'];
        if ($res != null && $res != '') return str_replace('USD', '', $res);
        else return 'USD'; 
    }
    return '';
}

function get_comm_CurrencyID_by_commID($commID, $mysqli)
{
    $qu = 'SELECT Measure_currencyID FROM Commodities where Commodities.ID=? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('i', $commID);
	$stmt->execute();
	$s = $stmt->get_result();
    if ($row = $s->fetch_assoc())
	{
        $res = $row['Measure_currencyID'];
        return $res;
    }
    return "";
}

function get_currency_value_3m($curr_ID, $q, $mysqli, $allow_least = true)
{
	$res = null;
	
	$qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID = ? AND Q = ? ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('is', $curr_ID, $q);
	$stmt->execute();
	$s = $stmt->get_result();
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$res = $data['Value'];
	}
	else
	{
		if ($allow_least)
		{
			$qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID = ? ORDER BY Q ASC LIMIT 1 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('i', $curr_ID);
			$stmt->execute();
			$s = $stmt->get_result();
			if ($data = $s->fetch_array(MYSQLI_BOTH))
			{
				$res = $data['Value'];
			}
		}
	}
	
	return $res;
}

function get_curr_LTM_by_currID ($currID, $last_q, $mysqli)
{
	$qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID=? AND Q<=? ORDER BY Q DESC LIMIT 4 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('is', $currID, $last_q);
	$stmt->execute();
	$s = $stmt->get_result();
	$values = array();
	while ($data = $s->fetch_array(MYSQLI_BOTH)) $values[] = $data['Value'];
	
	if (count($values) == 0) return '---';
	$res = array_sum($values)/count($values);
	
	return $res;
}

function get_course_USD_NOW ($currID)
{
    if ($currID == 0) return 1;
    else 
    {
        include '/html'.'/engine/connect.php';
        $qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D DESC LIMIT 1 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('i', $currID);
		$stmt->execute();
		$s = $stmt->get_result();
        $row = $s->fetch_assoc();
		include '/html/engine/'.'connect_close.php';
        return 1 / $row['Value'];
    }
}

function get_course_USD_LTM ($currID, $last_q, $mysqli)
{
	$last_q = str_replace(' H1', ' q2', $last_q);
	$last_q = str_replace(' H2', ' q4', $last_q);
    if ($currID == 0) return 1;
    else
    {
		$qu = "SELECT Value FROM Currencies_Q_Values WHERE currID=? AND Q<=? ORDER BY Q DESC LIMIT 4";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('is', $currID, $last_q);
		$stmt->execute();
		$s = $stmt->get_result();
		$values = array();
		while ($data = $s->fetch_array(MYSQLI_BOTH)) $values[] = $data['Value'];
		return (count($values) / array_sum($values));
    }
}

function get_course_RUB_NOW ($currID)
{
    if ($currID == 1) return 1;
    else 
    {
        $res = '';
        include '/html'.'/engine/connect.php';
        $s = $mysqli->query("SELECT Value FROM Currencies_D_Values WHERE currID=1 ORDER BY D DESC LIMIT 1");
        if ($row = $s->fetch_assoc()) {
            $res = $row['Value'];
        }
        if ($currID == 0)
        {
			include '/html/engine/'.'connect_close.php';
            return $res;
        }
        else 
        {
            $res2 = '';
            $qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D DESC LIMIT 1 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('i', $currID);
			$stmt->execute();
			$s = $stmt->get_result();
            if ($row = $s->fetch_assoc()) $res2 = $row['Value'];
			
			include '/html/engine/'.'connect_close.php';
            return ($res / $res2);
        }
    }
}

function get_course_RUB_LTM($currID, $last_q, $mysqli, $use_cache = true)
{
	$last_q = str_replace(' H1', ' q2', $last_q);
	$last_q = str_replace(' H2', ' q4', $last_q);
	
    if ($currID == 1)
	{
		return 1;
	}
    else
    {
		$res = 0;
		
		if ($use_cache)
		{
			$qu = 'SELECT Value_LTM FROM Currencies_Q_Values WHERE currID = 1 AND Q=  ? AND Value_LTM is NOT NULL ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('s', $last_q);
			$stmt->execute();
			$s = $stmt->get_result();
			
			if ($data = $s->fetch_array(MYSQLI_BOTH))
			{
				$res = $data['Value_LTM'] + 0;
			}
		}
		
		// ------------
		
		if ($res == 0)
		{
			$qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID = 1 AND Q <= ? ORDER BY Q DESC LIMIT 4 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('s', $last_q);
			$stmt->execute();
			$s = $stmt->get_result();
			
			$values = [];
			while ($data = $s->fetch_array(MYSQLI_BOTH))
			{
				$values[] = $data['Value'];
			}
			
			$res = array_sum($values)/count($values);
			
			if ($use_cache)
			{
				$qu = 'UPDATE Currencies_Q_Values SET Value_LTM = ? WHERE currID = 1 AND Q = ? ';
				$stmt = $mysqli->prepare($qu);
				$stmt->bind_param('ss', $res, $last_q);
				$stmt->execute();
			}
		}
		
		// ------------
		
        if ($currID == 0)
        {
            return $res;
        }
        else
        {
            $res2 = 0;
			
			if ($use_cache)
			{
				$qu = 'SELECT Value_LTM FROM Currencies_Q_Values WHERE currID = ? AND Q = ? AND Value_LTM is NOT NULL ';
				$stmt = $mysqli->prepare($qu);
				$stmt->bind_param('is', $currID, $last_q);
				$stmt->execute();
				$s = $stmt->get_result();
				
				if ($data = $s->fetch_array(MYSQLI_BOTH))
				{
					$res2 = $data['Value_LTM'] + 0;
				}
			}
			
			// ------------
			
			if ($res2 == 0)
			{
				$qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID = ? AND Q <= ? ORDER BY Q DESC LIMIT 4 ';
				$stmt = $mysqli->prepare($qu);
				$stmt->bind_param('is', $currID, $last_q);
				$stmt->execute();
				$s = $stmt->get_result();
				$values = array();
				while ($data = $s->fetch_array(MYSQLI_BOTH))
				{
					$values[] = $data['Value'];
				}
				$res2 = array_sum($values)/count($values);
				
				if ($use_cache)
				{
					$qu = 'UPDATE Currencies_Q_Values SET Value_LTM = ? WHERE currID = ? AND Q = ? ';
					$stmt = $mysqli->prepare($qu);
					$stmt->bind_param('sis', $res2, $currID, $last_q);
					$stmt->execute();
				}
			}
			
            return ($res / $res2);
        }
    }
}

function get_USDRUB_on_date($dt, $mysqli)
{
	$qu = "SELECT Value FROM Currencies_D_Values WHERE currID=1 AND D<=? ORDER BY D DESC LIMIT 1";
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
    if ($data = $s->fetch_array(MYSQLI_BOTH)) return ($data['Value'] + 0);
	else
	{
		$qu = "SELECT Value FROM Currencies_D_Values WHERE currID=1 ORDER BY D ASC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		return ($data['Value'] + 0);
	}
}

function get_USD_on_date($currID, $dt, $mysqli)
{
	if ($currID == 0) return 1;
	$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? AND D<=? ORDER BY D DESC LIMIT 1 ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('ds', $currID, $dt);
	$stmt->execute();
	$s = $stmt->get_result();
    $data = $s->fetch_array(MYSQLI_BOTH);
	return 1 / $data['Value'];
}

function get_USDRUB_LTM($dt, $mysqli)
{
	$qu = 'SELECT avg(Value) as Value FROM (SELECT currID, Value FROM Currencies_Q_Values WHERE currID=1 ORDER BY Q DESC LIMIT 4) as t1 GROUP BY currID ';
	$stmt = $mysqli->prepare($qu);
	$stmt->execute();
	$s = $stmt->get_result();
    $data = $s->fetch_array(MYSQLI_BOTH);
	return ($data['Value'] + 0);
}

function get_USDRUB_LTM_q($max_q, $mysqli)
{
	$qu = 'SELECT avg(Value) as Value FROM (SELECT currID, Value FROM Currencies_Q_Values WHERE currID=1 AND Q<=? ORDER BY Q DESC LIMIT 4) as t1 GROUP BY currID ';
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $max_q);
	$stmt->execute();
	$s = $stmt->get_result();
    $data = $s->fetch_array(MYSQLI_BOTH);
	return ($data['Value'] + 0);
}

function get_course_RUB_prev ($currID, $mysqli)
{
	if ($currID == 1) return 1;
    else 
    {
        $s = $mysqli->query('SELECT Value FROM Currencies_D_Values WHERE currID=1 ORDER BY D DESC LIMIT 2 ');
        $row = $s->fetch_assoc();
        $row = $s->fetch_assoc();
        $res = $row['Value'];
        if ($currID == 0)
		{
			return $res;
		}
        else 
        {
            $qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? ORDER BY D DESC LIMIT 2 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('i', $currID);
			$stmt->execute();
			$s = $stmt->get_result();
            $row = $s->fetch_assoc();
            $row = $s->fetch_assoc();
            $res2 = $row['Value'];
            return ($res / $res2);
        }
    }
}

function get_course_RUB_on_date($currID, $dt, $mysqli)
{
    if ($currID == 1) return 1;
    else 
    {
        $res = "";
        $qu = "SELECT Value FROM Currencies_D_Values WHERE currID=1 AND D<=? ORDER BY D DESC LIMIT 1";
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
        if ($row = $s->fetch_assoc()) {
            $res = $row['Value'];
        }
        if ($currID == 0)
        {
            return $res;
        }
        else 
        {
            $res2 = "";
            $qu = "SELECT Value FROM Currencies_D_Values WHERE currID=? AND D<=? ORDER BY D DESC LIMIT 1";
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('is', $currID, $dt);
			$stmt->execute();
			$s = $stmt->get_result();
            if ($row = $s->fetch_assoc()) {
                $res2 = $row['Value'];
            }
            return ($res / $res2);
        }
    }
}

function get_course_RUB_L_W ($currID)
{
    if ($currID == 1) return 1;
    else
    {
        $res = '';
		$dt1  = new DateTime('-7 days');
		$dt1_ = $dt1->format('Y-m-d');
        include '/html'.'/engine/connect.php';
        $qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=1 AND D<=? ORDER BY D DESC LIMIT 1 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt1_);
		$stmt->execute();
		$s = $stmt->get_result();
        $data = $s->fetch_array(MYSQLI_BOTH);
        $res = $data['Value'];
        if ($currID == 0)
        {
			include '/html/engine/'.'connect_close.php';
            return $res;
        }
        else
        {
            $res2 = '';
            $qu = 'SELECT Value FROM Currencies_D_Values WHERE currID=? AND D<=? ORDER BY D DESC LIMIT 1 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('is', $currID, $dt1_);
			$stmt->execute();
			$s = $stmt->get_result();
            $values = array();
            $data = $s->fetch_array(MYSQLI_BOTH);
            $res2 = $data['Value'];
			include '/html/engine/'.'connect_close.php';
            return ($res / $res2);
        }
    }
}

function get_course_RUB_L_Q ($currID, $last_q)
{
	$last_q = str_replace(' H1', ' q2', $last_q);
	$last_q = str_replace(' H2', ' q4', $last_q);

    if ($currID == 1) return 1;
    else
    {
        $res = '';
        include '/html'.'/engine/connect.php';
        $qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID=1 AND Q=? LIMIT 1 ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $last_q);
		$stmt->execute();
		$s = $stmt->get_result();
        $data = $s->fetch_array(MYSQLI_BOTH);
        $res = $data['Value'];
        if ($currID == 0)
        {
			include '/html/engine/'.'connect_close.php';
            return $res;
        }
        else
        {
            $res2 = '';
            $qu = 'SELECT Value FROM Currencies_Q_Values WHERE currID=? AND Q=? LIMIT 1 ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('is', $currID, $last_q);
			$stmt->execute();
			$s = $stmt->get_result();
            $values = array();
            $data = $s->fetch_array(MYSQLI_BOTH);
            $res2 = $data['Value'];
			include '/html/engine/'.'connect_close.php';
            return ($res / $res2);
        }
    }
}

?>