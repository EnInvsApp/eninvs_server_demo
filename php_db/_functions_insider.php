<?php

function get_insiders_us($ticker, $mysqli, $enable_echo = false, $small = false)
{
	$result = false;
	
	$___time_gap_company = 20 * 60;
	if (isset($_GET['cache']) && $_GET['cache'] == 'no' || $small)
	{
		$___time_gap_company = 0;
	}
	$___obj = array();
	$___cashe_file = '/html/cashe/cache_get_insiders_us_'.$ticker.'.inc';
	$___bool_cashe = false;
	$___cashe_s = '';

	if (file_exists($___cashe_file))
	{
		$___unix_time = filemtime($___cashe_file);
		$___ftm = date('Y-m-d H:i:s', $___unix_time + $___time_gap_company);
		if ($___ftm > date('Y-m-d H:i:s'))
		{
			$___cashe_s = file_get_contents($___cashe_file);
			if (strlen($___cashe_s) <= 2) $___bool_cashe = false;
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

		$comp_name = get_emitent_name_any_table_EN($ticker);
		$comp_name_1 = get_emitent_name_US_2($ticker);
		
		// --------
		
		$comp_name_str = $comp_name;
		$comp_name_1_str = $comp_name_1;
		
		$comp_name_str = SEC_name_special_trim($comp_name_str);
		$comp_name_1_str = SEC_name_special_trim($comp_name_1_str);
		
		$comp_name_str = strtolower($comp_name_str);
		$comp_name_1_str = strtolower($comp_name_1_str);
		
		if ($comp_name_1 == '---' || !$comp_name_1)
		{
			$comp_name_1 = false;
		}
		
		$qu = 
		'
			SELECT 
				D, 
				Person_Name, 
				Person_Status,
				Share_After, 
				Buy_Sell, 
				Is_Option, 
				Diff, 
				Share_Price ,
				Issuer
			FROM _SEC_insiders 
			WHERE 
				Ticker = ? AND 
				D >= SUBDATE(CURDATE(), 91) AND 
				(Is_Option = 0 OR Is_Option is null)
			ORDER BY 
				D DESC, 
				Diff DESC 
		';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('s', $ticker);
		$stmt->execute();
		$s = $stmt->get_result();

		$insiders = [];
		while ($row = $s->fetch_array(MYSQLI_BOTH))
		{
			$Name = $comp_name_1;
			$Person_Name = $row['Person_Name'];
			$Issuer = $row['Issuer'];
			
			$Name = SEC_name_special_trim($Name);
			$Person_Name = SEC_name_special_trim($Person_Name);
			$Issuer = SEC_name_special_trim($Issuer);
			
			$Name = strtolower($Name);
			$Person_Name = strtolower($Person_Name);
			$Issuer = strtolower($Issuer);
			
			// ------------
			
			$p_1 = false;
			$p_1_alt = false;
			$p_2 = false;
			$p_2_alt = false;
			
			// ------------
			
			if (strlen($Name) > 0)
			{
				if (strlen($Person_Name) > 0)
				{
					$p_1 = strpos($Person_Name, $Name);
					$p_1_alt = strpos($Name, $Person_Name);
				}
				
				if (strlen($Issuer))
				{
					$p_2 = strpos($Issuer, $Name);
					$p_2_alt = strpos($Name, $Issuer);
				}
			}
			if (!($p_1 === false && $p_1_alt === false && 
				($p_2 !== false || $p_2_alt !== false)))
			{
				continue;
			}

			$dt = $row['D'];
			$person = $row['Person_Name'];
			$comp_name_pattern = preg_quote($comp_name, "/");
			if (preg_match('/'.strtolower($comp_name_pattern).'/', ($person)))
			{
				continue;
			}
			$position = $row['Person_Status'];
			$share_after = $row['Share_After'];
			$buy_sell = $row['Buy_Sell'];
			$is_option = $row['Is_Option'];
			$diff = $row['Diff'];
			$share_price = $row['Share_Price'];

			$cl_price = get_emitent_close_price_by_date_US2($ticker, $dt);
			$day_ago = date('Y-m-d', strtotime('-1 day', strtotime($dt)));
			$cl_price_day_ago = get_emitent_close_price_by_date_US2($ticker, $day_ago);
			if ($cl_price != 0)
			{

				$cl_price_change_0 = $share_price / $cl_price - 1;
				$cl_price_change_1 = $share_price / $cl_price_day_ago - 1;
				
				// if (abs($cl_price_change_0) > 0.65 && abs($cl_price_change_1) > 0.65) // turned off 2022-08-14
				// {
					// continue;
				// }
			}

			if (!isset($insiders[$dt]))
			{
				$insiders[$dt] = [];
			}
			
			if (!isset($insiders[$dt][$person]))
			{
				$insiders[$dt][$person] = [];
			}

			$insiders[$dt][$person][] = 
			[
				'share_after' => $share_after,
				'buy_sell' => $buy_sell,
				'is_option' => $is_option,
				'diff' => $diff,
				'share_price' => $share_price,
				'position' => $position,
			];
		}

		nice_print_forecast('insiders', $insiders, $enable_echo);


		$res = [];
		$month_stat = [];
		$avg_diff = 0;
		$avg_diff_pct = 0;
		$avg_diff_count = 0;
		$lst_month_dt = date('Y-m-d', strtotime("-3 month"));
		foreach ($insiders as $dt => $person_deals)
		{
			// nice_print_forecast('dt', $dt, true);
			foreach ($person_deals as $person => $deals)
			{
				nice_print_forecast('person', $person, $enable_echo);
				$sum_diff = 0;
				$lst_share_price = 0;
				$lst_share_after = 0;
				$max_share_after = null;
				$min_share_after = null;
				$diff_price = 0;
				foreach ($deals as $deal)
				{
					if ($deal['buy_sell'] == 'BUY')
					{
						$sum_diff += $deal['diff'];
						$diff_price += $deal['diff'] * $deal['share_price'];
					} 
					else 
					{
						$sum_diff -= $deal['diff'];
						$diff_price -= $deal['diff'] * $deal['share_price'];

					}
					if ($lst_share_price == 0)
					{
						$lst_share_price = $deal['share_price'];
					}

					if ($min_share_after == null || $deal['share_after'] < $min_share_after)
						$min_share_after = $deal['share_after'];

					if ($max_share_after == null || $deal['share_after'] > $max_share_after)
						$max_share_after = $deal['share_after'];
				}
				
				nice_print_forecast('sum_diff', $sum_diff, $enable_echo);
				nice_print_forecast('lst_share_price', $lst_share_price, $enable_echo);
				$bs = 'BUY';
				
				//если в сумме 0 акций, то не выводим. Или если он просто получил опцион и ничего с ним не делал
				if ($diff_price == 0)
				{
					continue;
				}
				else if ($diff_price > 0)
				{
					$lst_share_after = $max_share_after;
				} 
				else 
				{
					$bs = 'SELL';
					$lst_share_after = $min_share_after;
				}
				nice_print_forecast('lst_share_after', $lst_share_after, $enable_echo);
				nice_print_forecast('diff_price', $diff_price, $enable_echo);
				nice_print_forecast('bs', $bs, $enable_echo);

				$emitent_shares = get_shares_count_by_ticker($ticker, $mysqli);
				$share_diff_pct = $sum_diff / $emitent_shares;
				$share_after_pct = $lst_share_after / $emitent_shares;
				
				$price_0 = $lst_share_price;
				$price_1 = get_emitent_price_ANY($ticker, $mysqli);
				$price_ch = $price_1 / $price_0 - 1;

				
				// nice_print_forecast('price_0', $deal['share_price'], true);
				// nice_print_forecast('cl_price_change_0', $cl_price_change_0, true);
				// nice_print_forecast('cl_price_change_1', $cl_price_change_1, true);
				
				// echo $diff_price,'<br>';
				// echo $share_diff_pct,'<br>';
				// echo '<br>';
				
				if (abs($diff_price) >= 50000 || (abs($diff_price) >= 5000 && abs($share_diff_pct) >= 0.00005) || $small)
				{
					
						$res[] = 
						[
							'dt' => $dt,
							'person' => $person,
							'buy_sell' => $bs,
							'share_price' => $lst_share_price,
							'diff_price' => $diff_price,
							'share_num' => $share_diff_pct,
							'share_after' => $share_after_pct, 
							'position' => $deal['position'],
							'price_ch' => $price_ch,
						];
					
				}

				if ($dt >= $lst_month_dt)
				{
					$avg_diff_pct += $share_diff_pct;
					$avg_diff += $diff_price;
					$avg_diff_count++;
				}
				
			}
		}
		
		if ($avg_diff_count > 0)
		{
			//$avg_diff = $avg_diff / $avg_diff_count;
			//$avg_diff_pct = $avg_diff_pct / $avg_diff_count;
			$month_stat['avg_deal_price'] = $avg_diff;
			$month_stat['avg_deal_price_pct'] = $avg_diff_pct;
			$month_stat['buy_sell'] = 'BUY';
			if ($avg_diff < 0)
			{
				$month_stat['buy_sell'] = 'SELL';
			}
		}



		if (count($res) > 0)
		{
			$result = ['objects_insider' => $res, 'month_stat' => $month_stat];
		}
		
		if (!$small)
		{
			$___cashe_s = serialize($result);
			file_put_contents($___cashe_file, $___cashe_s);
		}
	}
	else
	{
		$result = unserialize($___cashe_s);
	}
	
    return $result;
}

function get_all_insiders_us($mysqli, $mode = 'all', $today = false, $period, $spb, $enable_echo = false)
{
	$result = false;
	
	$___time_gap_company = 20 * 60;
	if (isset($_GET['cache']) && $_GET['cache'] == 'no')
	{
		$___time_gap_company = 0;
	}
				
	$___obj = array();
	$___cashe_file = '/html/cashe/cache_get_all_insiders_us_'.$mode.'_'.$today.'_'.$period.'_'.$spb.'.inc';
	$___bool_cashe = false;
	$___cashe_s = '';

	if (file_exists($___cashe_file))
	{
		$___unix_time = filemtime($___cashe_file);
		$___ftm = date('Y-m-d H:i:s', $___unix_time + $___time_gap_company);
		if ($___ftm > date('Y-m-d H:i:s'))
		{
			$___cashe_s = file_get_contents($___cashe_file);
			if (strlen($___cashe_s) <= 2) $___bool_cashe = false;
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

		$period_dt = date('Y-m-d', strtotime('-7 days'));
		if ($period == 'month')
		{
			$period_dt = date('Y-m-d', strtotime('-1 months'));
		}
		if ($period == '3month')
		{
			$period_dt = date('Y-m-d', strtotime('-3 Months'));
		}

		
		
		$qu = 
			'
				SELECT 
					Ticker,
					Issuer,
					D, 
					Person_Name, 
					Person_Status, 
					Share_After, 
					Buy_Sell, 
					Is_Option, 
					Diff, 
					Share_Price 
				FROM _SEC_insiders 
				WHERE 
					D >= ? AND 
					D <= ? AND
					(
						Ticker IN (SELECT Ticker FROM US2_Emitents WHERE Active = 1) OR 
						Ticker IN (SELECT Ticker FROM US_Emitents WHERE Active = 1) OR 
						Ticker IN (SELECT Ticker FROM Wd_Emitents WHERE Active = 1) 
					) AND 
					(Is_Option = 0 OR Is_Option is null) 
				ORDER BY 
					D DESC, 
					Diff DESC
			';
		
		$stmt = $mysqli->prepare($qu);
		$stmt->bind_param('ss', $period_dt, $today);
		$stmt->execute();
		$s = $stmt->get_result();

		$insiders = [];
		$comps_patterns = 
		[
			'inc.',
			'trust',
			'foundation',
			'L.L.C',
			' LP ',
			'holding',
			'company',
			'corporation',
			'activecorp',
			'gmbh',
			'LLC',
			'L.P.'
		];

		while ($row = $s->fetch_array(MYSQLI_BOTH))
		{
			$ticker = $row['Ticker'];
			$Name = get_emitent_name_any_table_EN($ticker);
			$Person_Name = $row['Person_Name'];
			$Issuer = $row['Issuer'];
			
			$Name = SEC_name_special_trim($Name);
			$Person_Name = SEC_name_special_trim($Person_Name);
			$Issuer = SEC_name_special_trim($Issuer);
			
			$Name = strtolower($Name);
			$Person_Name = strtolower($Person_Name);
			$Issuer = strtolower($Issuer);
			
			// ------------
			
			$p_1 = false;
			$p_1_alt = false;
			$p_2 = false;
			$p_2_alt = false;
			
			// ------------
			
			if (strlen($Name) > 0)
			{
				if (strlen($Person_Name) > 0)
				{
					$p_1 = strpos($Person_Name, $Name);
					$p_1_alt = strpos($Name, $Person_Name);
				}
				
				if (strlen($Issuer))
				{
					$p_2 = strpos($Issuer, $Name);
					$p_2_alt = strpos($Name, $Issuer);
				}
			}
			if (!($p_1 === false && $p_1_alt === false && 
				($p_2 !== false || $p_2_alt !== false)))
			{
				continue;
			}


			$person = $row['Person_Name'];
			
			$comp_name = get_emitent_name_any_table_EN($ticker);
			//фильтр
			if ($mode == 'no_comps')
			{
				if (stripos($person, 'LP ') === 0 )
				{
					continue;
				}
				if (stripos($person, ' LP') === strlen($person) - 3)
				{
					continue;
				}
				if (stripos($person, ' INC') === strlen($person) - 4)
				{
					continue;
				}
				foreach ($comps_patterns as $p)
				{
					if ($p == 'corporation')
					{

					}
					if (stripos($person, $p) !== false)
					{
						continue 2;
					}
				}
			}
			
			//filter
			if ($spb == 'spb')
			{
				//echo $ticker.':'.US2_is_ISIN_SPB_available(US2_get_ISIN_by_ticker($ticker), $mysqli).'<br>';
				if (!US2_is_ISIN_SPB_available(US2_get_ISIN_by_ticker($ticker), $mysqli))
				{
					continue;
				}
			}


			$dt = $row['D'];
			$position = $row['Person_Status'];
			$share_after = $row['Share_After'];
			$buy_sell = $row['Buy_Sell'];
			$is_option = $row['Is_Option'];
			$diff = $row['Diff'];
			$share_price = $row['Share_Price'];

			$cl_price = get_emitent_close_price_by_date_US2($ticker, $dt);
			$day_ago = date('Y-m-d', strtotime('-1 day', strtotime($dt)));
			$cl_price_day_ago = get_emitent_close_price_by_date_US2($ticker, $day_ago);
			
			$cl_price_change_0 = $share_price / $cl_price - 1;
			$cl_price_change_1 = $share_price / $cl_price_day_ago - 1;

			// if (abs($cl_price_change_0) > 0.65 && abs($cl_price_change_1) > 0.65) // turned off 2022-08-14
			// {
				// continue;
			// }
			
			if (!isset($insiders[$ticker]))
			{
				$insiders[$ticker] = [];
			}

			if (!isset($insiders[$ticker][$dt]))
			{
				$insiders[$ticker][$dt] = [];
			}
			
			if (!isset($insiders[$ticker][$dt][$person]))
			{
				$insiders[$ticker][$dt][$person] = [];
			}

			$insiders[$ticker][$dt][$person][] = 
			[
				'share_after' => $share_after,
				'buy_sell' => $buy_sell,
				'is_option' => $is_option,
				'diff' => $diff,
				'share_price' => $share_price,
				'position' => $position,
				'comp_name' => $comp_name,
			];
		}

		nice_print_forecast('insiders', $insiders, $enable_echo);
		$res = [];
		$net_ticker_res = [];
		$month_stat = [];
		
		//$lst_month_dt = date('Y-m-d', strtotime("-1 week"));
		//echo $lst_month_dt.'<br>';

		foreach ($insiders as $ticker => $ticker_insiders)
		{
			$avg_ticker_buy_diff = 0;
			$avg_ticker_sell_diff = 0;
			$avg_ticker_buy_pct = 0;
			$avg_ticker_sell_pct = 0;
			$avg_diff = 0;
			$avg_diff_pct = 0;
			$avg_diff_count = 0;
			foreach ($ticker_insiders as $dt => $person_deals)
			{
				nice_print_forecast('dt', $dt, $enable_echo);
				foreach ($person_deals as $person => $deals)
				{
					nice_print_forecast('person', $person, $enable_echo);
					$sum_diff = 0;
					$lst_share_price = 0;
					$lst_share_after = 0;
					$max_share_after = null;
					$min_share_after = null;
					$diff_price = 0;
					foreach ($deals as $deal)
					{
						if ($deal['buy_sell'] == 'BUY')
						{
							$sum_diff += $deal['diff'];
							$diff_price += $deal['diff'] * $deal['share_price'];
						} 
						else 
						{
							$sum_diff -= $deal['diff'];
							$diff_price -= $deal['diff'] * $deal['share_price'];
	
						}
						if ($lst_share_price == 0)
						{
							$lst_share_price = $deal['share_price'];
						}
	
						if ($min_share_after == null || $deal['share_after'] < $min_share_after)
							$min_share_after = $deal['share_after'];
	
						if ($max_share_after == null || $deal['share_after'] > $max_share_after)
							$max_share_after = $deal['share_after'];
					}
					
					nice_print_forecast('sum_diff', $sum_diff, $enable_echo);
					nice_print_forecast('lst_share_price', $lst_share_price, $enable_echo);
					$bs = 'BUY';
					
					//если в сумме 0 акций, то не выводим. Или если он просто получил опцион и ничего с ним не делал
					if ($diff_price == 0)
					{
						continue;
					}
					else if ($diff_price > 0)
					{
						$lst_share_after = $max_share_after;
					} 
					else 
					{
						$bs = 'SELL';
						$lst_share_after = $min_share_after;
					}
					nice_print_forecast('lst_share_after', $lst_share_after, $enable_echo);
					nice_print_forecast('diff_price', $diff_price, $enable_echo);
					nice_print_forecast('bs', $bs, $enable_echo);
	
					$emitent_shares = get_shares_count_by_ticker($ticker, $mysqli);
					$share_diff_pct = $sum_diff / $emitent_shares;
					$share_after_pct = $lst_share_after / $emitent_shares;
					
					
					$avg_diff += $diff_price;
					$avg_diff_pct += $share_diff_pct;
					
					if ($share_diff_pct > 0)
					{
						$avg_ticker_buy_diff += $diff_price;
						$avg_ticker_buy_pct += $share_diff_pct;
					}
					else 
					{
						$avg_ticker_sell_diff += $diff_price;
						$avg_ticker_sell_pct += $share_diff_pct;
					}


					$avg_diff_count++;
					
					$price_0 = $lst_share_price;
					$price_1 = get_emitent_price_ANY($ticker, $mysqli);
					$price_ch = $price_1 / $price_0 - 1;

					$cl_price = get_emitent_close_price_by_date_US2($ticker, $dt);
					$day_ago = date('Y-m-d', strtotime('-1 day', strtotime($dt)));
					$cl_price_day_ago = get_emitent_close_price_by_date_US2($ticker, $day_ago);
					$cl_price_change_0 = $lst_share_price / $cl_price - 1;
					$cl_price_change_1 = $lst_share_price / $cl_price_day_ago - 1;

					
					if (abs($diff_price) >= 50000)
					{
							$res[] = 
							[
								'ticker' => $ticker,
								'dt' => $dt,
								'person' => $person,
								'buy_sell' => $bs,
								'share_price' => $lst_share_price,
								'diff_price' => $diff_price,
								'share_num' => $share_diff_pct,
								'share_after' => $share_after_pct, 
								'position' => $deal['position'],
								'comp_name' => $comp_name,
								'price_ch' => $price_ch,
							];
					}
				}
			}

			if ($avg_diff > 0)
			{
				$net_ticker_res['buy'][$ticker] = 
				[
					'ticker' => $ticker,
					'net_diff' => $avg_diff,
					'net_diff_pct' => $avg_diff_pct,
					'comp_name' => $deal['comp_name'],
				];
			}
			if ($avg_diff < 0)
			{
				$net_ticker_res['sell'][$ticker] = 
				[
					'ticker' => $ticker,
					'net_diff' => $avg_diff,
					'net_diff_pct' => $avg_diff_pct,
					'comp_name' => $deal['comp_name'],
				];
			}
		}
		
		// if ($avg_diff_count > 0)
		// {
		// 	//$avg_diff = $avg_diff / $avg_diff_count;
		// 	//$avg_diff_pct = $avg_diff_pct / $avg_diff_count;
		// 	//нетто покупок\продаж (все покупки минус все продажи)
		// 	$month_stat['avg_deal_price'] = $avg_diff;
		// 	$month_stat['avg_deal_price_pct'] = $avg_diff_pct;
		// 	$month_stat['buy_sell'] = 'BUY';
		// 	if ($avg_diff < 0)
		// 	{
		// 		$month_stat['buy_sell'] = 'SELL';
		// 	}
		// }

		usort($res, function ($item1, $item2) {
			if (abs($item1['diff_price']) == abs($item2['diff_price'])) return 0;
			return abs($item1['diff_price']) > abs($item2['diff_price']) ? -1 : 1;
		});

		usort($net_ticker_res['buy'], function ($item1, $item2) {
			if (abs($item1['net_diff']) == abs($item2['net_diff'])) return 0;
			return abs($item1['net_diff']) > abs($item2['net_diff']) ? -1 : 1;
		});
		usort($net_ticker_res['sell'], function ($item1, $item2) {
			if (abs($item1['net_diff']) == abs($item2['net_diff'])) return 0;
			return abs($item1['net_diff']) > abs($item2['net_diff']) ? -1 : 1;
		});
		
		if (count($res) > 0)
		{
			$result = ['objects_insider' => $res, 'month_stat' => $month_stat, 'net_tickers' => $net_ticker_res];
		}
		
		$___cashe_s = serialize($result);
		file_put_contents($___cashe_file, $___cashe_s);
	}
	else
	{
		$result = unserialize($___cashe_s);
	}
	
    return $result;
}

function SEC_name_special_trim($name)
{
	$name = trim($name);
	
	$ss = [
		' NEW',
		' New',
		' new',
		
		' DE',
		' De',
		' de',
		
		' CN',
		' Cn',
		' cn',
		
		' INTERNATIONAL',
		' International',
		' international',
		
		' & CO',
		' & Co',
		' & co',
		' &CO',
		' &Co',
		' &co',
		' CO',
		' Co',
		' co',
		' COMPANY',
		' Company',
		' company',
		
		' GR',
		' Gr',
		' gr',
		' GROUP',
		' Group',
		' group',
		
		' CORP',
		' Corp',
		' corp',
		' CORPORATION',
		' Corporation',
		' corporation',
		
		' INC',
		' Inc',
		' inc',
		' INCORPORATED',
		' Incorporated',
		' incorporated',
		' INCORPORATE',
		' Incorporate',
		' incorporate',
		
		' LP',
		' Lp',
		' lp',
		' PARTNERSHIP',
		' Partnership',
		' partnership',
		
		' LTD',
		' Ltd',
		' ltd',
		' LIMITED',
		' Limited',
		' limited',
		
		' TRUST',
		' Trust',
		' trust',
		
		' LLC',
		' Llc',
		' llc',
		
		' LLP',
		' Llp',
		' llp',
		
		' PLC',
		' Plc',
		' plc',
		
		' LA',
		' La',
		' la',
		
		' GMBH',
		' Gmbh',
		' gmbh',
		
		' SA',
		' Sa',
		' sa',
		
		' (The)'
	];
	
	$name = str_replace('.', '', $name);
	$name = str_replace(',', '', $name);
	$name = str_replace("'", '', $name);
	$name = str_replace('"', '', $name);
	
	for ($z = 0; $z < 3; $z++)
	{
		for ($y = 0; $y < sizeOf($ss); $y++) 
		{ 
			$s = $ss[$y]; 
			if ((strlen($name) > strlen($s)) && (substr($name, strlen($name) - strlen($s)) == $s)) 
			{
				$name = substr($name, 0, strlen($name) - strlen($s)); 
			}
		}
	}
	
	$name = str_replace('  ', ' ', $name);
	$name = trim($name);
	
	// ------------
	
	// 2022-11-28
	
	if (true)
	{
		$temp_1 = 'Liberty Energy';
		$temp_2 = 'Liberty Oilfield';
		
		$p = strpos($name, $temp_1);
		
		if ($p !== false)
		{
			$name = str_replace($temp_1, $temp_2, $name);
		}
	}
	
	// ------------
	
	return $name;
}

function nice_percent_span_insider_NO_COLOR($ch)
{
	return '<span>'.number_format($ch * 100,3, '.', ' ').'%</span>';
}

function nice_percent_span_insider_color_by_other_value($ch, $value)
{
	$st = '';
	if ($value > 0) $st = ' style="color:#31c421;" ';
	else if ($value < 0) $st = ' style="color:#E51717;" ';
	return '<span '.$st.'>'.number_format($ch * 100,3, '.', ' ').'%</span>';
}

function nice_percent_span_insider($ch, $d = 3)
{
	$st = '';
	if ($ch > 0) $st = ' style="color:#31c421;" ';
	else if ($ch < 0) $st = ' style="color:#E51717;" ';
	return '<span '.$st.'>'.number_format($ch * 100,$d, '.', ' ').'%</span>';
}

?>