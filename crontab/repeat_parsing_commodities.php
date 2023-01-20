<?php

ini_set('display_errors', '1');
date_default_timezone_set('Europe/Moscow');
include '/html/engine/connect.php';
include_once '/html/php_db/single_functions.php';

// -----------------------------------------------------

if (false)
{
	$dt = '2004-12-31';
	
	while ($dt < date('Y-m-d'))
	{
		update_car_manufacturers_index_cost($mysqli, $dt);
		
		$dt = date('Y-m-d', strtotime('+1 day', strtotime($dt)));
	}
	
	exit;
}

// -----------------------------------------------------

// файл с описаниями
include '/html/crontab/repeat_parsing_commodities_description.php';

for ($i = 0; $i < sizeOf($comm_links); $i++) // if ($comm_links[$i]['commID'] == 118)
{
	$sources_no_proxy = ['fmp'];
	
	if (!in_array($comm_links[$i]['source'], $sources_no_proxy))
	{
		$url = base64_encode($comm_links[$i]['link']);
		$content = file_get_contents('https://eninvs.com/_use_proxy.php?link='.$url);
	}
	else
	{
		$content = file_get_contents($comm_links[$i]['link']);
	}
	
	// -----------------------------------------------------
	
	$content = str_replace(' ', '', $content);
	switch ($comm_links[$i]['source'])
	{
		case 'fmp': $content = commodities_parsing_fmp($content, $comm_links[$i]['commID']); break;
		case 'sun': $content = commodities_parsing_sun($content); break;
		case 'trc': $content = commodities_parsing_trc($content); break;
		case 'inv': $content = commodities_parsing_inv($content, $comm_links[$i]['commID']); break;
		case 'frd': $content = commodities_parsing_frd($content); break;
		case 'mbi': $content = commodities_parsing_mbi($content); break;
		case 'est': $content = commodities_parsing_est($content, $comm_links[$i]['commID']); break;
		case 'sab': $content = commodities_parsing_sab($content); break;
		
		case '181': $content = commodities_parsing_181($content); break;
		case '182': $content = commodities_parsing_182($content); break;
		case '186': $content = commodities_parsing_186($content); break;
		
		case 'ppf': $content = commodities_parsing_ppf($content); break;
		case 'pps': $content = commodities_parsing_pps($content); break;
		case 'ulc': $content = commodities_parsing_ulc($content); break;
		case 'cme': $content = commodities_parsing_cme($content); break;
		case 'dat': $content = commodities_parsing_dat($content); break;
		case 'ice': $content = commodities_parsing_ice($content, $mysqli); break;
		case 'sag': $content = commodities_parsing_sag($content); break;
		case 'fnm': $content = commodities_parsing_fnm($content); break;
		case 'ech': $content = commodities_parsing_ech($content); break;
		case 'fzp': $content = commodities_parsing_fzp($content); break;
		case 'dia': $content = commodities_parsing_dia($content); break;
		case 'cgr': $content = commodities_parsing_cgr($content); break;
		
		default: $content = 0; break;
	}
	
	$LastPrice = $content + 0;
	
	if (true)
	{
		$clr = '';
		
		if ($LastPrice == 0)
		{
			$clr = 'background-color:#F4FFB9;';
		}
		
		echo 
			'<br>',
			'<span style="display:inline-block; width:150px;" >',
				$comm_links[$i]['commID'],':',
			'</span>',
			'<span style="display:inline-block; width:150px; ',$clr,'" >',
				$LastPrice,
			'</span>',
			'<br>',
			PHP_EOL;
	}
	
	if ($LastPrice > 0)
	{
		// некоторые цены преобразуем через фиксированные множители или валюты
		
		$USDCNY = get_cross_course_last(3, $mysqli);
		
		if ($comm_links[$i]['commID'] == 22) $LastPrice = $LastPrice * 1071.341;
		
		if ($comm_links[$i]['commID'] == 41) $LastPrice = ($LastPrice / $USDCNY) * 2.09233;
		if ($comm_links[$i]['commID'] == 43) $LastPrice = ($LastPrice / $USDCNY) * 1.06181;
		
		if ($comm_links[$i]['commID'] == 47) $LastPrice = ($LastPrice / $USDCNY) * 0.99217;
		if ($comm_links[$i]['commID'] == 48) $LastPrice = ($LastPrice / $USDCNY) * 1.5;
		if ($comm_links[$i]['commID'] == 88) $LastPrice = $LastPrice + 5;
		
		if ($comm_links[$i]['commID'] == 90) $LastPrice = $LastPrice - 0.026;
		if ($comm_links[$i]['commID'] == 107) $LastPrice = ($LastPrice / $USDCNY) * 1.07913;
		if ($comm_links[$i]['commID'] == 146) $LastPrice = ($LastPrice / $USDCNY) * 1.09261;
		
		// ---------------------------
		
		$qu = 'SELECT COUNT(*) as ct FROM Commodities_D_Values WHERE commID = ? AND D = CURDATE() ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('d', $comm_links[$i]['commID']);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		
		if ($data['ct'] == 0)
		{
			$qu = 'INSERT INTO Commodities_D_Values (Value, D, commID) VALUES (?, CURDATE(), ?) ';
		}
		else
		{
			$qu = 'UPDATE Commodities_D_Values SET Value = ? WHERE commID = ? AND D = CURDATE() ';
		}
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('dd', $LastPrice, $comm_links[$i]['commID']);
		$stmt->execute();
		
		// ---------------------------
		
		// гибридный ряд нефти с учетом скидок после санкций
		if ($comm_links[$i]['commID'] == 15)
		{
			$disc_RF_oil_id = 178;
			$disc_RF_oil_price = $LastPrice - 24.5;
			
			$qu = 'SELECT COUNT(*) as ct FROM Commodities_D_Values WHERE commID = ? AND D = CURDATE() ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('d', $disc_RF_oil_id);
			$stmt->execute();
			$s = $stmt->get_result();
			$data = $s->fetch_array(MYSQLI_BOTH);
			
			if ($data['ct'] == 0)
			{
				$qu = 'INSERT INTO Commodities_D_Values (Value, D, commID) VALUES (?, CURDATE(), ?) ';
			}
			else
			{
				$qu = 'UPDATE Commodities_D_Values SET Value = ? WHERE commID = ? AND D = CURDATE() ';
			}
			
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('dd', $disc_RF_oil_price, $disc_RF_oil_id);
			$stmt->execute();
		}
		
		// гибридный ряд золота с учетом скидок после санкций
		if ($comm_links[$i]['commID'] == 173)
		{
			$ounce_const = 31.1;
			
			$commID_175 = 175;
			$commID_12_price = get_comm_NOW_by_commID(12);
			$commID_173_price = get_comm_NOW_by_commID(173);
			$USDRUB_now = get_cross_course_last(1, $mysqli);
			
			$commID_175_price = 
				min
				(
					$commID_12_price, 
					($commID_173_price / $USDRUB_now * $ounce_const) 
				) 
				* (1 - 0.05); // 2022-12-27 // раньше стояло -3.5%, дисконт расширился до 5% (Кирилл)
			
			if ($commID_175_price > 100)
			{
				$qu = 'SELECT COUNT(*) as ct FROM Commodities_D_Values WHERE commID = ? AND D = CURDATE() ';
				$stmt = $mysqli->prepare($qu);
				$stmt->bind_param('d', $commID_175);
				$stmt->execute();
				$s = $stmt->get_result();
				$data = $s->fetch_array(MYSQLI_BOTH);
				
				if ($data['ct'] == 0)
				{
					$qu = 'INSERT INTO Commodities_D_Values (Value, D, commID) VALUES (?, CURDATE(), ?) ';
				}
				else
				{
					$qu = 'UPDATE Commodities_D_Values SET Value = ? WHERE commID = ? AND D = CURDATE() ';
				}
				
				$stmt = $mysqli->prepare($qu);
				$stmt->bind_param('dd', $commID_175_price, $commID_175);
				$stmt->execute();
			}
		}
	}
}

// aero indexes
update_aero_revenue_index_on_date($mysqli);
update_aero_cost_index_on_date($mysqli);

// ammonia gas margin
update_ammonia_gas_margin_index_on_date($mysqli);

// dark spread & spark spread
update_dark_spread_on_date($mysqli);
update_spark_spread_on_date($mysqli);

// car manufacturers revenue and cost indexes
update_car_manufacturers_index_revenue($mysqli);
update_car_manufacturers_index_cost($mysqli);

// -----------------------------------------------------

$tm_now = date('Hi') + 0;
if ($tm_now > 1840 && $tm_now < 1920)
{
	// commodities
	for ($i = 0; $i < sizeOf($comm_links); $i++)
	{
		$qu = 'SELECT Count(*) FROM _18_45_Commodity WHERE commID=? AND D=CURDATE()';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('d', $comm_links[$i]['commID']);
		$stmt->execute();
		$s = $stmt->get_result();
		$cnt = $s->fetch_array(MYSQLI_BOTH);
		
		if ($cnt[0] + 0 == 0)
		{
			$qu = 'SELECT Value FROM Commodities_D_Values WHERE commID=? ORDER BY D DESC LIMIT 1';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('d', $comm_links[$i]['commID']);
			$stmt->execute();
			$s = $stmt->get_result();
			$data = $s->fetch_array(MYSQLI_BOTH);
			$val = $data['Value'];
			
			$qu = 'INSERT INTO _18_45_Commodity (commID, D, Value) VALUES (?, CURDATE(), ?) ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('dd', $comm_links[$i]['commID'], $val);
			$stmt->execute();
		}
	}
	
	// potentials
	
	$qu = 'SELECT Ticker, Potential FROM Company_Forecast WHERE Potential is not NULL AND Date=CURDATE() ';
	$stmt = $mysqli->prepare($qu);
	$stmt->execute();
	$s = $stmt->get_result();
	
	while ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$ticker = $data['Ticker'];
		$potential = $data['Potential'];
		
		$qu = 'SELECT Count(*) FROM _18_45_Potential WHERE Ticker=? AND D=CURDATE()';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $ticker);
		$stmt->execute();
		$s_ = $stmt->get_result();
		$cnt = $s_->fetch_array(MYSQLI_BOTH);
		
		if ($cnt[0] + 0 == 0)
		{
			$qu = 'INSERT INTO _18_45_Potential (Ticker, D, Value) VALUES (?, CURDATE(), ?) ';
			$stmt = $mysqli->prepare($qu);
			$stmt->bind_param('sd', $ticker, $potential);
			$stmt->execute();
		}
	}
	
	// other ( S&P500 )
	
	$qu = 'SELECT Count(*) FROM _18_45_Other WHERE Name="SP500" AND D=CURDATE()';
	$stmt = $mysqli->prepare($qu);
	$stmt->execute();
	$s = $stmt->get_result();
	
	$cnt = $s->fetch_array(MYSQLI_BOTH);
	if ($cnt[0] + 0 == 0)
	{
		$qu = 'SELECT SP500 FROM Profitability ORDER BY D DESC LIMIT 1';
		$stmt = $mysqli->prepare($qu);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$val = $data['SP500'] + 0;
		
		$qu = 'INSERT INTO _18_45_Other (Name, D, Value) VALUES ("SP500", CURDATE(), ?)';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('d', $val);
		$stmt->execute();
	}
	
	// other ( USDRUB )
	
	$qu = 'SELECT Count(*) FROM _18_45_Other WHERE Name = "USDRUB" AND D = CURDATE()';
	$stmt = $mysqli->prepare($qu);
	$stmt->execute();
	$s = $stmt->get_result();
	
	$cnt = $s->fetch_array(MYSQLI_BOTH);
	if ($cnt[0] + 0 == 0)
	{
		$qu = 'SELECT Value FROM Currencies_D_Values WHERE currID = 1 ORDER BY D DESC LIMIT 1';
		$stmt = $mysqli->prepare($qu);
		$stmt->execute();
		$s = $stmt->get_result();
		$data = $s->fetch_array(MYSQLI_BOTH);
		$val = $data['Value'] + 0;
	
		$qu = 'INSERT INTO _18_45_Other (Name, D, Value) VALUES ("USDRUB", CURDATE(), ?)';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('d', $val);
		$stmt->execute();
	}
}

// -----------------------------------------------------

function update_aero_revenue_index_on_date($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// ticket price
	
	$qu = 
		'
			SELECT Value 
			FROM Commodities_D_Values 
			WHERE 
				commID = 184 AND 
				D <= ? 
			ORDER BY D DESC 
			LIMIT 1 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$ticket_price = $data['Value'];
		
		// checkpoint traffic
		
		$qu = 
			'
				SELECT AVG(Value) as avg_value 
                FROM 
				(
					SELECT Value 
					FROM Commodities_D_Values 
					WHERE 
						commID = 116 AND 
						D <= ? 
					ORDER BY D DESC 
					LIMIT 7 
				) t1
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$daily_traffic = $data['avg_value'];
			$res = $daily_traffic * $ticket_price / 1000000;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (189, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_aero_cost_index_on_date($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// fuel price
	
	$qu = 
		'
			SELECT Value 
			FROM Commodities_D_Values 
			WHERE 
				commID = 186 AND 
				D <= ? 
			ORDER BY D DESC 
			LIMIT 1 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$fuel_price = $data['Value'];
		
		// checkpoint traffic
		
		$qu = 
			'
				SELECT AVG(Value) as avg_value 
                FROM 
				(
					SELECT Value 
					FROM Commodities_D_Values 
					WHERE 
						commID = 116 AND 
						D <= ? 
					ORDER BY D DESC 
					LIMIT 7 
				) t1
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$daily_traffic = $data['avg_value'];
			$res = $daily_traffic * $fuel_price / 1000000;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (194, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_ammonia_gas_margin_index_on_date($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// ammonia
	
	$qu = 
		'
			SELECT Value 
			FROM Commodities_D_Values 
			WHERE 
				commID = 41 AND 
				D <= ? 
			ORDER BY D DESC 
			LIMIT 1 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$ammonia_price = $data['Value'];
		
		// henry hub
		
		$qu = 
			'
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 94 AND 
					D <= ? 
				ORDER BY D DESC 
				LIMIT 1 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$henry_hub_price = $data['Value'];
			$res = $ammonia_price - $henry_hub_price * 35.8;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (196, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_dark_spread_on_date($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// electricity
	
	$qu = 
		'
			SELECT AVG(Value) as avg_value 
			FROM 
			(
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 100 AND 
					D <= ? 
				ORDER BY D DESC 
				LIMIT 7 
			) t1 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$electricity_price = $data['avg_value'];
		
		// steam coal US
		
		$qu = 
			'
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 211 AND 
					D <= ? 
				ORDER BY D DESC 
				LIMIT 1 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$steam_coal_US = $data['Value'];
			$res = $electricity_price - $steam_coal_US * 1000 / (2204.6 * 1.027);
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (212, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_spark_spread_on_date($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// electricity
	
	$qu = 
		'
			SELECT AVG(Value) as avg_value 
			FROM 
			(
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 100 AND 
					D <= ? 
				ORDER BY D DESC 
				LIMIT 7 
			) t1 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$electricity_price = $data['avg_value'];
		
		// natural_gas
		
		$qu = 
			'
				SELECT AVG(Value) as avg_value 
				FROM 
				(
					SELECT Value 
					FROM Commodities_D_Values 
					WHERE 
						commID = 94 AND 
						D <= ? 
					ORDER BY D DESC 
					LIMIT 7 
				) t1 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $dt);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$natural_gas = $data['avg_value'];
			$res = $electricity_price - $natural_gas * 7.4;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (213, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_car_manufacturers_index_revenue($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// new_vehicles_price
	
	$qu = 
		'
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 180 AND 
					D <= ? 
				ORDER BY D DESC 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$new_vehicles_price = $data['Value'];
		
		// new_vehicles_volume
		
		$m = date('m', strtotime($dt));
		if (strlen($m) == 1)
		{
			$m = '0'.$m;
		}
		$month = date('Y', strtotime($dt)).' '.$m;
		
		$qu = 
			'
				SELECT Value 
				FROM Macro_goods_M_values 
				WHERE 
					SourceID = 23 AND 
					M < ? 
				ORDER BY M DESC 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $month);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$new_vehicles_volume = $data['Value'];
			$res = $new_vehicles_price * $new_vehicles_volume;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (216, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

function update_car_manufacturers_index_cost($mysqli, $dt = null)
{
	$res = null;
	
	if ($dt == null)
	{
		$dt = date('Y-m-d');
	}
	
	// new_vehicles_cost
	
	$qu = 
		'
				SELECT Value 
				FROM Commodities_D_Values 
				WHERE 
					commID = 215 AND 
					D <= ? 
				ORDER BY D DESC 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $dt);
	$stmt->execute();
	$s = $stmt->get_result();
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$new_vehicles_cost = $data['Value'];
		
		// new_vehicles_volume
		
		$m = date('m', strtotime($dt));
		if (strlen($m) == 1)
		{
			$m = '0'.$m;
		}
		$month = date('Y', strtotime($dt)).' '.$m;
		
		$qu = 
			'
				SELECT Value 
				FROM Macro_goods_M_values 
				WHERE 
					SourceID = 23 AND 
					M < ? 
				ORDER BY M DESC 
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $month);
		$stmt->execute();
		$s = $stmt->get_result();
		
		if ($data = $s->fetch_array(MYSQLI_BOTH))
		{
			$new_vehicles_volume = $data['Value'];
			$res = $new_vehicles_cost * $new_vehicles_volume;
		}
	}
	
	if ($res > 0)
	{
		$qu = 'INSERT INTO Commodities_D_Values (commID, D, Value) VALUES (217, ?, ?) ON DUPLICATE KEY UPDATE Value = ? ';
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('sdd', $dt, $res, $res);
		$stmt->execute();
	}
}

// -----------------------------------------------------

function commodities_parsing_186($s)
{
	$res = null;
	
	$s = str_replace("'", "", $s);
	$s = str_replace(" ", "", $s);
	$s = strtolower($s);
	
	$s0 = '<tablesummary';
	$p = strpos($s, $s0);
	if ($p !== false)
	{
		$s = substr($s, $p);
		$s0 = '</table>';
		$p = strpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, 0, $p);
			
			$s0 = '<tr';
			$p = strrpos($s, $s0);
			if ($p !== false)
			{
				$s = substr($s, $p);
				
				$s0 = '.';
				$p = strrpos($s, $s0);
				if ($p !== false)
				{
					$p = strrpos(substr($s, 0, $p), '>');
					if ($p !== false)
					{
						$s = substr($s, $p + 1);
						
						$p = strrpos($s, '<');
						if ($p > 0)
						{
							$s = substr($s, 0, $p);
							$res = $s;
						}
					}
				}
			}
		}
	}
	
	return $res;
}

function commodities_parsing_182($s)
{
	$res = null;
	
	$s = str_replace("'", "", $s);
	$s = str_replace(" ", "", $s);
	$s = strtolower($s);
	
	$s0 = 'renderto:container_gasoline';
	$p = strpos($s, $s0);
	if ($p !== false)
	{
		$s = substr($s, $p);
		
		$s0 = 'data:[[date.utc';
		$p = strpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, $p);
			
			$s0 = ']]},';
			$p = strpos($s, $s0);
			if ($p !== false)
			{
				$s = substr($s, 0, $p);
				
				$s0 = '),';
				$p = strrpos($s, $s0);
				if ($p !== false)
				{
					$s = substr($s, $p + strlen($s0));
					$res = $s + 0;
				}
			}
		}
	}
	
	return $res;
}

function commodities_parsing_181($s)
{
	$res = null;
	
	$s = str_replace("'", "", $s);
	$s = str_replace(" ", "", $s);
	$s = strtolower($s);
	
	$s0 = 'renderto:container_diesel';
	$p = strpos($s, $s0);
	if ($p !== false)
	{
		$s = substr($s, $p);
		
		$s0 = 'data:[[date.utc';
		$p = strpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, $p);
			
			$s0 = '),';
			$p = strpos($s, $s0);
			if ($p !== false)
			{
				$s = substr($s, $p + strlen($s0));
				
				$s0 = ']';
				$p = strpos($s, $s0);
				if ($p !== false)
				{
					$s = substr($s, 0, $p);
					$res = $s + 0;
				}
			}
		}
	}
	
	return $res;
}

function commodities_parsing_fzp($s)
{
	$res = null;
	
	$s0 = ']]}]';
	$p = strpos($s, $s0);
	if ($p !== false)
	{
		$s = substr($s, 0, $p);
		
		$s0 = ',';
		$p = strrpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, $p + strlen($s0));
			$res = trim($s);
		}
	}
	
	return $res;
}

function commodities_parsing_ech($s)
{
	$res = null;
	
	$s0 = 'id="priceTrendPriceArray1"';
	$p = strpos($s, $s0);
	if ($p !== false)
	{
		$s = substr($s, $p, 200);
		
		$s0 = '"]';
		$p = strpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, 0, $p);
			
			$s0 = '"';
			$p = strrpos($s, $s0);
			if ($p !== false)
			{
				$s = trim(substr($s, $p + 1));
				$s = str_replace(',', '', $s);
				$s = $s + 0;
				
				$res = $s;
			}
		}
	}
	
	return $res;
}

function commodities_parsing_fnm($content)
{
	$str1 = '"last":{"currency":"RUB","value":';
	$pos = strpos($content, $str1);
	$content = substr($content, $pos + strlen($str1));
	$pos = strpos($content, ',');
	$content = substr($content, 0, $pos);
	
	return $content;
}

function commodities_parsing_fmp($content, $commID)
{
	$content = trim($content);
	$str1 = '"price":';
	$pos = strpos($content, $str1);
	$content = substr($content, $pos + strlen($str1));
	$pos = strpos($content, ',');
	$content = substr($content, 0, $pos);
	
	if ($commID == 10)
	{
		$content = $content * 2213;
	}
	
	return $content;
}

function commodities_parsing_sun($content)
{
	$res = '';
	
	$s0 = 'class="xnn-topbba">';
	$p = strpos($content, $s0);
	
	if ($p > 0)
	{
		$content = substr($content, $p + strlen($s0), 100);
		
		$s0 = '</span>';
		$p = strpos($content, $s0);
		
		if ($p > 0)
		{
			$res = trim(substr($content, 0, $p));
		}
	}
	
	return $res;
}

function commodities_parsing_trc($content)
{
	$content = trim($content);
	$content = str_replace(' ', '', $content);
	$str1 = 'TEChartsMeta=[{"value":';
	$pos = strpos($content, $str1);
	if ($pos > 0)
	{
		$content = substr($content, $pos + strlen($str1));
		$pos = strpos($content, ',');
		$content = substr($content, 0, $pos);
	}
	else
	{
		$content = 0;
	}
	
	return $content;
}

function commodities_parsing_inv($content, $commID)
{
	$res = '';
	
	$str1 = '"lastClose":"';
	$pos = strpos($content, $str1);
	
	if ($pos > 0)
	{
		$content = substr($content, $pos + strlen($str1), 30);
		$str2 = '","';
		$pos = strpos($content, $str2);
		$content = trim(substr($content, 0, $pos));
		
		$p1 = strpos($content, ',');
		$p2 = strpos($content, '.');
		
		if ($p1 > 0 && $p2 > 0)
		{
			$p_min = min($p1, $p2);
			$content = substr($content, 0, $p_min).substr($content, $p_min + 1);
		}
		
		$content = str_replace(',', '.', $content);
		
		$res = $content;
	}
	
	if ($commID == 77)
	{
		$res = max(0, $res - 5.5); // 2022-12-09
	}
	
	return $res;
}

function commodities_parsing_frd($content)
{
	$res = '';
	
	$s0 = 'series-meta-observation-value">';
	$p = strpos($content, $s0);
	
	if ($p > 0)
	{
		$content = substr($content, $p + strlen($s0), 100);
		
		$s0 = '</span>';
		$p = strpos($content, $s0);
		
		if ($p > 0)
		{
			$res = trim(substr($content, 0, $p));
			
			if (strpos($res, ',') > 0 && strpos($res, '.') > 0)
			{
				$res = str_replace(',', '', $res);
			}
		}
	}
	
	return $res;
}

function commodities_parsing_mbi($content)
{
	$str1 = '"currentValue":';
	$pos = strrpos($content, $str1);
	$content = substr($content, $pos + strlen($str1), 30);
	$str2 = ',"previousClose":';
	$pos = strpos($content, $str2);
	$content = substr($content, 0, $pos);
	$content = str_replace(',', '', $content);
	$content = str_replace('$', '', $content);
	$content = trim($content);
	
	return $content;
}

function commodities_parsing_est($s, $commID)
{
	$res = null;
	
	$s0 = ']]';
	$p = strrpos($s, $s0);
	if ($p !== false && strlen($s) > 100)
	{
		$s = substr($s, $p - 100, 100);
		
		$s0 = '",';
		$p = strrpos($s, $s0);
		if ($p !== false)
		{
			$s = substr($s, $p + strlen($s0));
			
			$arr = explode(',', $s);
			if (sizeOf($arr) == 2)
			{
				if ($commID == 197 || $commID == 199)
				{
					$res = $arr[0];
				}
				else
				{
					$res = $arr[1];
				}
			}
		}
	}
	
	return $res;
}

function commodities_parsing_sab($content)
{
	$res = '';
	
	$content = str_replace(' ', '', $content);
	$content = mb_strtolower($content);
	
	$s0 = '<tdheaders="price-vlsfo">';
	
	$p = strpos($content, $s0);
	if ($p > 0)
	{
		$content = substr($content, $p + strlen($s0), 30);
		$p = strpos($content, '<');
		
		if ($p > 0)
		{
			$content = substr($content, 0, $p);
			$res = $content + 0;
		}
	}
	
	return $res;
}

function commodities_parsing_ppf($content)
{
	$res = '';
	
	$content = str_replace(' ', '', $content);
	$content = mb_strtolower($content);
	
	$s0 = 'дизельноетопливо</td><td>';
	
	$p = mb_strpos($content, $s0);
	if ($p > 0)
	{
		$content = mb_substr($content, $p + mb_strlen($s0), 200);
		$p = mb_strpos($content, '<');
		
		if ($p > 0)
		{
			$content = mb_substr($content, 0, $p);
			$res = $content + 0;
		}
	}
	
	return $res;
}

function commodities_parsing_pps($content)
{
	$res = '';
	
	$content = str_replace(' ', '', $content);
	$content = mb_strtolower($content);
	
	$s0 = 'аи-92</td><td>';
	
	$p = mb_strpos($content, $s0);
	if ($p > 0)
	{
		$content = mb_substr($content, $p + mb_strlen($s0), 200);
		$p = mb_strpos($content, '<');
		
		if ($p > 0)
		{
			$content = mb_substr($content, 0, $p);
			$res = $content + 0;
		}
	}
	
	return $res;
}

function commodities_parsing_dia($content)
{
	$res = '';
	
	$content = str_replace(' ', '', $content);
	$content = mb_strtolower($content);
	
	$s0 = 'change<spanstyle=color:';
	
	$p = strpos($content, $s0);
	if ($p > 0)
	{
		$content = substr($content, $p + strlen($s0), 200);
		$p = strpos($content, '>');
		
		if ($p > 0)
		{
			$content = substr($content, $p + 1);
			$p = strpos($content, '<');
			
			if ($p > 0)
			{
				$content = substr($content, 0, $p);
				$res = $content + 0;
			}
		}
	}
	
	return $res;
}

function commodities_parsing_ulc($content)
{
	$res = '';
	
	$s01 = 'title="DownloadFile"';
	$s02 = 'href="';
	
	$p = strpos($content, $s01);
	if ($p > 0)
	{
		$content = substr($content, $p + strlen($s01), 200);
		$p = strpos($content, $s02);
		
		if ($p > 0)
		{
			$content = substr($content, $p + strlen($s02));
			$p = strpos($content, '"');
			
			if ($p > 0)
			{
				$content = substr($content, 0, $p);
				
				$path_0 = '/html/_test/temp.pdf';
				$path_1 = '/html/_test/temp.txt';
				
				if (file_exists($path_0)) unlink($path_0);
				if (file_exists($path_1)) unlink($path_1);
				
				$command = 'wget '.$content.' -O '.$path_0;
				exec($command);
				
				$command = '/usr/bin/pdftotext -layout '.$path_0.' '.$path_1;
				exec($command);
				
				$content = html_entity_decode(file_get_contents($path_1));
				
				$content = str_replace('    ', ' ', $content);
				$content = str_replace('   ', ' ', $content);
				$content = str_replace('  ', ' ', $content);
				$content = str_replace('  ', ' ', $content);
				
				$s01 = 'Weekly Average';
				$s02 = 'Change From';
				
				$p = strpos($content, $s01);
				if ($p > 0)
				{
					$content = substr($content, $p + strlen($s01), 100);
					$p = strpos($content, $s02);
					
					if ($p > 0)
					{
						$content = trim(substr($content, 0, $p));
						
						$p = strpos($content, ' ');
						
						if ($p > 0)
						{
							$res = trim(substr($content, $p + 1));
						}
					}
				}
			}
		}
	}
	
	return $res;
}

function commodities_parsing_cgr($content)
{
	$res = '';
	
	$content = str_replace(' ', '', $content);
	$content = strtolower($content);
	
	$s0 = ']],';
	
	$p = strrpos($content, $s0);
	if ($p > 0)
	{
		$content = substr($content, 0, $p);
		$p = strrpos($content, ',');
		
		if ($p > 0)
		{
			$content = substr($content, $p + 1);
			$res = $content + 0;
		}
	}
	
	return $res;
}

function commodities_parsing_cme($content)
{
	$content_0 = $content;
	
	if (true)
	{
		$str1 = '"last":"';
		$pos = strpos($content, $str1);
		if ($pos > 0)
		{
			$content = substr($content, $pos + strlen($str1), 30);
			$str2 = '","';
			$pos = strpos($content, $str2);
			$content = trim(substr($content, 0, $pos));
		}
		else
		{
			$content = '';
		}
	}
	
	// ---------------------------------------------------------
	
	if ($content == '')
	{
		$content = $content_0;
		
		$str1 = '"priorSettle":"';
		$pos = strpos($content, $str1);
		if ($pos > 0)
		{
			$content = substr($content, $pos + strlen($str1), 30);
			$str2 = '","';
			$pos = strpos($content, $str2);
			$content = trim(substr($content, 0, $pos));
		}
		else
		{
			$content = '';
		}
	}
	
	// ---------------------------------------------------------
	
	$content = str_replace("`", '.', $content);
	$content = str_replace("'", '.', $content);
	
	return $content;
}

function commodities_parsing_dat($content)
{
	$res = '';
	
	$s0 = '&ds_2=Contract';
	$pos = strpos($content, $s0);
	
	if ($pos > 0)
	{
		$content = substr($content, 0, $pos);
		
		$s0 = ',';
		$pos = strrpos($content, $s0);
		
		if ($pos > 0)
		{
			$content = substr($content, $pos + strlen($s0));
			
			$res = trim(str_replace(' ', '', $content));
		}
	}
	
	return $res;
}

function commodities_parsing_ice($content, $mysqli)
{
	$str1 = '"lastPrice":';
	$pos = strpos($content, $str1);
	$content = substr($content, $pos + strlen($str1), 30);
	$str2 = '},';
	$pos = strpos($content, $str2);
	
	$content = substr($content, 0, $pos);
	$content = str_replace(',', '', $content);
	$content = str_replace('$', '', $content);
	$content = trim($content);
	$content = $content + 0;
	
	if ($content > 0)
	{
		$content = ($content * 10.5) / get_cross_course_last(2, $mysqli);
	}
	
	return $content;
}

function commodities_parsing_sag($content)
{
	$res = '';
	
	$s0 = 'price_retailer\u0022:';
	$pos = strpos($content, $s0);
	
	if ($pos > 0)
	{
		$content = substr($content, $pos + strlen($s0));
		
		$s0 = '},{';
		$pos = strpos($content, $s0);
		
		if ($pos > 0)
		{
			$content = substr($content, 0, $pos);
			
			$res = trim(str_replace(' ', '', $content));
		}
	}
	
	return $res;
}

?>