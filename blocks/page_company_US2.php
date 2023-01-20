<?php

$banking = false;
$root = $_SERVER['DOCUMENT_ROOT'];
include_once '/html/php_db/single_functions.php';

$nm = ' ';
if (!empty($_GET['name'])) $nm = $_GET['name'];

echo "<span id='hidden_ticker_container' style='display:none;'>",$nm,'</span>',PHP_EOL;
echo "<div id='topDiv' style='height:15px;'> </div>",PHP_EOL;

$EnNI = 'EBITDA';
$EV_P = 'EV';

$url_with_get_param = $_SERVER['REQUEST_URI'];

$alt_classic_and_rising = 
	'
		``Classic investment`` logic assumes valuation of companies based on their profits (we use EV/EBITDA multiple for that). 
		It can usually be applied for the profitable/stable companies. 
		In particular our approach assumes returning to historical EV/EBITDA multiple 
		(on 75% percentile level) for the company 
		if its last financial growth rates are not worse than historical levels
	';

include '/html/php_db/get_emitent_list_active_US_2.php';
echo '<select id="select_emitent_1" class="select-css" style="width:250px;">',PHP_EOL;
	$correct_ticker = false;
	for ($i = 0; $i < count($names); $i++)
	{
		if ($tickers[$i] == $nm) { $correct_ticker = true; echo PHP_EOL,'<script>$("title").html("',$names[$i],$lang_tr['ltr_00610'],'");</script>',PHP_EOL; }
		echo "<option value='".$tickers[$i]."'>".$names[$i]."</option>".PHP_EOL;
	}
	if ($correct_ticker == false) exit;
echo '</select>',PHP_EOL;

echo '<div style="height:30px; padding-left:25px;">',PHP_EOL;
	echo '<p><a class="a_blogs" href="',str_replace("company_US_wide","company_US_wide_classic",$url_with_get_param),'">',$lang_tr['ltr_00570'],'</a>&nbsp;&nbsp;',
		 '<b>&nbsp;&nbsp;<span style="color:#232362; text-decoration:underline;" alt="',$alt_classic_and_rising,'" title="',$alt_classic_and_rising,'">*</span></b></p>',PHP_EOL;
echo '</div>',PHP_EOL;

// -------------------------------------------------------------------------------------------------------------

echo '<div >',PHP_EOL;

	if (true)
	{
		echo '<div class="float1 border1" id="company_descriptions_and_fin_data" >',PHP_EOL;
			if (!empty($_GET['name'])) 
			{
				$ticker = $_GET['name'];
				
				include '/html/php_db/company_E_calculation_traffic.php';
				
				$category = get_emitent_category_US_2($ticker);
				if (US2_is_ticker_financial($mysqli, $ticker)) $banking = true;
				
				include $root.'/php_db/company_E_calculation_growing_US_2.php';
				
				// ------------
				
				$temp = $url_with_get_param;
				
				$url_part_1 = '/company_US_wide.';
				$url_part_2 = '/company%5fUS%5fwide.';
				$url_part_3 = '/all.';
				// $url_part_3 = '/companyGLOBAL.';
				
				if 
				(
					strpos($temp, $url_part_1) !== false || 
					strpos($temp, $url_part_2) !== false || 
					strpos($temp, $url_part_3) !== false 
				)
				{
					if (!isset($_GET['fix']) || empty($_GET['fix']) || $_GET['fix'] != '1')
					{
						if (!isset($gr_revenue) || !isset($gr_revenue_hist) || $gr_revenue < 0.2 || $gr_revenue_hist < 0.2)
						{
							$temp = str_replace($url_part_1, '/company_US_wide_classic.', $temp);
							$temp = str_replace($url_part_2, '/company_US_wide_classic.', $temp);
							$temp = str_replace($url_part_3, '/company_US_wide_classic.', $temp);
							
							echo '<script>window.location="',$temp,'"</script>',PHP_EOL;
						}
					}
				}
				
				// ------------
				
				include '/html/php_db/company_E_calculation_growing_US_2_not_classic.php';
				
				$admin_load_speed_timer['growing_US_2.php (14)'] = microtime(true);
				
				include '/html/php_db/get_emitent_summary_US_2.php';
				
				if ($banking) { $EnNI = 'Net Income'; $EV_P = 'P'; }
				$FCF_rate_Y_color_1 = '';
				$FCF_rate_Y_color_E = '';
				$FCF_rate_Y_E = -1;
				
				$color_div = '';
				
				echo '<div id="summaryContainerOuter" >',PHP_EOL;
					if (true) // ??? (strlen($emitentSummary) > 0)
					{
						echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr['ltr_00271'],'</span></h3>'.PHP_EOL;
						echo '<div style="height:5px;"></div>'.PHP_EOL;
						
						include '/html/blocks/page_company_US2_info_country_sector.php';
						
						if (strlen($emitentSummary) > 5)
						{
							echo '<div style="height:10px;"></div>',PHP_EOL;
							echo "<div class='summaryContainerInner'>",PHP_EOL;
								echo $emitentSummary,PHP_EOL;
							echo "</div>",PHP_EOL;
							
							echo '<div style="height:5px;"></div>',PHP_EOL;
						}
					}
					
					$website = get_url_by_ticker($ticker, $mysqli);
					if ($website !== null)
					{
						echo '<div style="height:10px;"></div>',PHP_EOL;
						echo '<div>Website: <a href="https://',$website,'" target="_blank" style="text-decoration:underline; color:#175996;" >',$website,'</a></div>',PHP_EOL;
					}
					
					echo '<br><hr class="hr_E" >',PHP_EOL;
					
					if (true)
					{
						echo "<div class='summaryContainerInner'>",PHP_EOL;
							
							// 1. Growth
							
							if (isset($gr_revenue) && isset($gr_revenue_hist))
							{
								echo '<br><span style="color:#093E58;" ><b>',$lang_tr['ltr_00762'],': </b></span>'.PHP_EOL;
								
								$green_count = 0;
								$red_count = 0;
								
								$gr_avg = $gr_revenue;
								$gr_avg_hist = $gr_revenue_hist;
								
								$gr_temp_1 = "";
								if ($gr_avg >= 0.1) { $gr_temp_1 = "<span style='color:#31c421;'>".$lang_tr["ltr_00100"]."</span>"; $green_count++; }
								else if ($gr_avg > 0) $gr_temp_1 = "<span>".$lang_tr["ltr_00101"]."</span>";
								else { $gr_temp_1 = "<span style='color:#E51717;'>".$lang_tr["ltr_00102"]."</span>"; $red_count++; }
								$gr_temp_2 = $gr_avg;
								
								$avg_hist_temp_color = '';
								$gr_temp_3 = "";
								if ($gr_avg > $gr_avg_hist/100 + 0.001)
								{
									if ($gr_avg_hist/100 < 0) $avg_hist_temp_color = ' style="color:#E51717;" ';
									$gr_temp_3 = $lang_tr['ltr_00103'].' <span style="color:#31c421;" >'.$lang_tr['ltr_00104'].'</span> '.$lang_tr['ltr_00106'].' '; 
									$green_count++;
								}
								else if ($gr_avg < $gr_avg_hist/100 - 0.001) $gr_temp_3 = $lang_tr['ltr_00103'].' <span style="color:#E51717;" >'.$lang_tr['ltr_00105'].'</span> '.$lang_tr['ltr_00106'].' ';
								else
								{
									$gr_temp_3 = $lang_tr['ltr_00107'].' ';
									$red_count++;
								}
								
								// --------------------
								
								$stab_text = '';
								
								if (isset($gr_rev_stab) && $gr_rev_stab !== null)
								{
									$green_color_ = 'color:#31c421;';
									$red_color_ = 'color:#E51717;';
									if ($red_count == 2) $green_color_ = '';
									if ($green_count == 2) $red_color_ = '';
									
									$stab_text .= '. '.$lang_tr['ltr_00758'];
									if      ($gr_rev_stab  < 0.9) $stab_text .= '<span style="'.$red_color_.'">'.$lang_tr['ltr_00761'].'</span>'; // unstable
									else if ($gr_rev_stab >= 0.9 && $gr_rev_stab <= 2.7) $stab_text .= '<span >'.$lang_tr['ltr_00760'].'</span>'; // mixed
									else $stab_text .= '<span style="'.$green_color_.'">'.$lang_tr['ltr_00759'].'</span>'; // stable
								}
								
								// --------------------
								
								$gr_temp_4 = $gr_avg_hist / 100;
								
								$gr_temp_2_text = number_format($gr_temp_2 * 100, 1, '.', ' ');
								$gr_temp_4_text = number_format($gr_temp_4 * 100, 1, '.', ' ');
								
								if ($gr_temp_2 > 2)
								{
									$gr_temp_2_text = '>200';
								}
								
								if ($gr_temp_4 > 2)
								{
									$gr_temp_4_text = '>200';
								}
								
								echo 
									'<span>',
										$gr_temp_1,' ',$lang_tr['ltr_00108a'],' ',$gr_temp_2_text,'%, ',
										$gr_temp_3,
										'<span ',$avg_hist_temp_color,'>',$gr_temp_4_text,'%</span>',
										$stab_text,
									'</span>',
									PHP_EOL;
								
								// --------------------
								
								// traffic
								
								if (isset($TRAFFIC_ch_3m) && $TRAFFIC_ch_3m !== null)
								{
									echo ' <span>',$lang_tr['ltr_00782'],nice_percent_span($TRAFFIC_ch_3m),'</span>',PHP_EOL;
								}
							}
							
							// 2. Profitability
							
							if (true)
							{
								echo '<br><br><span style="color:#093E58;" ><b>',$lang_tr['ltr_00763'],': </b></span>'.PHP_EOL;
								$str = '<span style="color:#31c421;" >'.$lang_tr['ltr_00766a'].',</span>';
								if ($rent <= 0) $str = '<span style="color:#E51717;" >'.$lang_tr['ltr_00766b'].',</span>';
								
								if (!$banking) echo '<span>',$lang_tr['ltr_00765'],' ',$str,' ',nice_percent_span($rent),'.','</span> ',PHP_EOL;
								else           echo '<span>',$lang_tr['ltr_00765a'],' ',$str,' ',nice_percent_span($rent),'.','</span> ',PHP_EOL;
								
								if 
								(
									isset($rent_Q_EBITDA_Y_ch) && 
									isset($rent_Q_EBITDA_avg) && 
									$rent_Q_EBITDA_Y_ch !== null && 
									$rent_Q_EBITDA_avg !== null
								)
								{
									$stab_lim = 0.02;
									
									if
									(
										$rent_Q_EBITDA_Y_ch > 0 && 
										$rent_Q_EBITDA_avg < $stab_lim
									)
									{
										$str1 = '<span style="color:#31c421;" >'.$lang_tr['ltr_00771'].'</span>';
										$str2 = '<span style="color:#31c421;" >'.$lang_tr['ltr_00773'].'</span>';
									}
									
									if
									(
										$rent_Q_EBITDA_Y_ch > 0 && 
										$rent_Q_EBITDA_avg >= $stab_lim
									)
									{
										$str1 = '<span style="color:#31c421;" >'.$lang_tr['ltr_00771'].'</span>';
										$str2 = '<span >'.$lang_tr['ltr_00774'].'</span>';
									}
									
									if
									(
										$rent_Q_EBITDA_Y_ch <= 0 && 
										$rent_Q_EBITDA_avg < $stab_lim
									)
									{
										$str1 = '<span style="color:#E51717;" >'.$lang_tr['ltr_00772'].'</span>';
										$str2 = '<span style="color:#E51717;" >'.$lang_tr['ltr_00773'].'</span>';
									}
									
									if
									(
										$rent_Q_EBITDA_Y_ch <= 0 && 
										$rent_Q_EBITDA_avg >= $stab_lim
									)
									{
										$str1 = '<span style="color:#E51717;" >'.$lang_tr['ltr_00772'].'</span>';
										$str2 = '<span style="color:#E51717;" >'.$lang_tr['ltr_00774'].'</span>';
									}
									
									echo '<span>',$lang_tr['ltr_00770'],' ',$str1,' ',$str2,'.</span> ',PHP_EOL;
								}
								
								if (isset($gross_margin) && $gross_margin !== null)
								{
									$gm_top_lim = 0.4;
									$gm_low_lim = 0.2;
									if ($gross_margin > $gm_top_lim)
									{
										$str1 = '<span style="color:#31c421;" >'.$lang_tr['ltr_00786'];
									}
									else if ($gross_margin < $gm_low_lim)
									{
										$str1 = '<span style="color:#E51717;" >'.$lang_tr['ltr_00788'];
									}
									else
									{
										$str1 = '<span >'.$lang_tr['ltr_00787'];
									}
									echo '<span>',$lang_tr['ltr_00785'],' ',$str1,', ',nice_percent_span_NO_COLOR($gross_margin),'</span>.</span> ',PHP_EOL;
								}
								
								if (isset($eps_beats_last) && $eps_beats_last !== null)
								{
									$str = '<span style="color:#31c421;" >'.$lang_tr['ltr_00776'];
									if ($eps_beats_last == 0) $str = '<span style="color:#E51717;" >'.$lang_tr['ltr_00777'];
									if (isset($eps_beats_last_percent) && $eps_beats_last_percent !== null) $str .= ', '.nice_percent_span($eps_beats_last_percent);
									echo '<span>',$lang_tr['ltr_00775'],' ',$str,'</span></span>. ',PHP_EOL;
								}
								
								if (isset($eps_beats_hist) && $eps_beats_hist !== null)
								{
									echo '<span>',$lang_tr['ltr_00778'],' ',number_format($eps_beats_hist*100,0,'.',''),'% ',$lang_tr['ltr_00779'],PHP_EOL;
									if (isset($eps_beats_avg) && $eps_beats_avg !== null) echo ' (',$lang_tr['ltr_00780'],nice_EPS($eps_beats_avg),' ',$lang_tr['ltr_00781'],')',PHP_EOL;
									echo '</span>',PHP_EOL;
								}
							}
							
							// 3. Cash Flow Generation
							
							if (true)
							{
								echo '<br><br><span style="color:#093E58;" ><b>',$lang_tr['ltr_00764'],': </b></span>'.PHP_EOL;
								
								if      ($div_rate_Y >= 5) $color_div = " color:#31c421;";
								else if ($div_rate_Y <= 2) $color_div = " color:#E51717;";
								echo '<span>',$lang_tr['ltr_00110'],' <span style="',$color_div,'">',$div_rate_Y,'</span>. ',PHP_EOL;
								if (!$banking)
								{
									if ($FCF_rate_Y + 0 < -0.05) $FCF_rate_Y_color_1 = " style='color:#E51717;'"; // red
										else if ($FCF_rate_Y + 0 >= 14.95) $FCF_rate_Y_color_1 = " style='color:#31c421;'"; // green
									$FCF_rate_E_str = '';
									if (isset($EbitdaE)) 
									{
										$FCF_rate_Y_E = ($FCF_LTM + 0.8*($EbitdaE - $EbitdaLTM))/$cap*100;
										if ($FCF_rate_Y_E + 0 < -0.05) $FCF_rate_Y_color_E = " style='color:#E51717;'"; // red
										else if ($FCF_rate_Y_E + 0 >= 14.95) $FCF_rate_Y_color_E = " style='color:#31c421;'"; // green
										$FCF_rate_E_str = ', '.$lang_tr['ltr_00111'].' <span'.$FCF_rate_Y_color_E.'>'.number_format($FCF_rate_Y_E, 1, '.', ' ').'%</span>';
									}
									echo $lang_tr['ltr_00112'],' <span',$FCF_rate_Y_color_1,'>',$FCF_rate_Y,'</span> (LTM)',$FCF_rate_E_str,PHP_EOL;
								}
								echo '</span>',PHP_EOL;
							}
							
							// 4. Undervaluation
							
							// Year Created Value
							if (isset($year_created_value) && $year_created_value !== null && $year_created_value !== 0 && $year_created_value != -1000)
							{
								echo '<br><br><span style="color:#093E58;" ><b>',$lang_tr['ltr_00768'],': </b></span>'.PHP_EOL;
								
								$stl_ycv = '';
								if ($year_created_value < 0.00) $stl_ycv = " style='color:#E51717;' ";
								if ($year_created_value > 0.05) $stl_ycv = " style='color:#31c421;' ";
								if ($FREE_LIMITED_ACCESS_MODE)
								{
									echo '<span>',$lang_tr["ltr_00272"],' <span',$stl_ycv,'>',PHP_EOL;
									
										echo '<div class="in_row_1 first_col_no report_out_cell q_col" style="cursor:pointer;" onclick="goFreeTrialPage()" >',
											 '<div class="lock_yellow_1" style="float:right;" ></div>',
											 '</div>',PHP_EOL;
									
									echo '</span></span>',PHP_EOL;
								}
								else
								{
									echo '<span>',$lang_tr['ltr_00272'],' ',nice_percent_FCF_rate($year_created_value),'</span>',PHP_EOL;
								}
							}
							
							// 5. Entry Point
							
							if (true)
							{
								echo '<br><br><span style="color:#093E58;" ><b>',$lang_tr['ltr_00769'],': </b></span>'.PHP_EOL;
								
								if (isset($USD_Revenue_share))
								{
									$curr_share_color_1 = "";
									if ($USD_Revenue_share < 0.4995) $curr_share_color_1 = " style='color:#E51717;'"; // red
										else $curr_share_color_1 = " style='color:#31c421;'"; // green
										
									$just_about_sign = "";
									if ($USD_Revenue_share+0 > 0.99 || $USD_Revenue_share+0 < 0.01) $just_about_sign = "≈ ";
									echo "<span>",$lang_tr["ltr_00113"]," <span".$curr_share_color_1.">".$just_about_sign.
										number_format($USD_Revenue_share*100,1,'.',' ')."%</span></span>".PHP_EOL;
								}
								
								$min3y_price = get_emitent_min3y_close_price_US_2($ticker);
								$max3y_price = get_emitent_max3y_close_price_US_2($ticker);
								echo "<span>",$lang_tr["ltr_00114"]," ".number_format(($price/$min3y_price-1)*100, 1, '.', ' ')."% ",$lang_tr["ltr_00115"]," ".
														  number_format((1-$price/$max3y_price)*100, 1, '.', ' ')."% ",$lang_tr["ltr_00116"],"</span>".PHP_EOL;
								
								/*
								if ($h_tickers_pos > 0)
								{
									$color_span_growth_place = '';
									if ($h_tickers_pos < 50) $color_span_growth_place = 'style="color:#31c421;" ';
									else if ($h_tickers_pos > 300) $color_span_growth_place = 'style="color:#E51717;" ';
									echo '<li><span>',$lang_tr["ltr_00571"],
										 ' <span ',$color_span_growth_place,'>',$h_tickers_pos,'</span> ',
										 $lang_tr["ltr_00572"],' ',sizeOf($h_tickers),' ',$lang_tr["ltr_00573"],' ',$lang_tr["ltr_00574"],'</span></li>';
								}
								
								if ($evs_tickers_pos > 0)
								{
									$color_span_EVsales_place = '';
									if ($evs_tickers_pos < 50) $color_span_EVsales_place = 'style="color:#31c421;" ';
									else if ($evs_tickers_pos > 300) $color_span_EVsales_place = 'style="color:#E51717;" ';
									echo '<li><span>',$lang_tr["ltr_00571"],
										 ' <span ',$color_span_EVsales_place,'>',$evs_tickers_pos,'</span> ',
										 $lang_tr["ltr_00572"],' ',sizeOf($EVs_tickers),' ',$lang_tr["ltr_00573"],' ',$lang_tr['ltr_00575a'],$EV_P,'&nbsp;/&nbsp;Sales',$lang_tr['ltr_00575b'],'</span></li>';
								}
								
								if ($rentE_tickers_pos > 0)
								{
									$color_span_rentE_place = '';
									if ($rentE_tickers_pos < 50) $color_span_rentE_place = 'style="color:#31c421;" ';
									else if ($rentE_tickers_pos > 300) $color_span_rentE_place = 'style="color:#E51717;" ';
									echo '<li><span>',$lang_tr["ltr_00571"],
										 ' <span ',$color_span_rentE_place,'>',$rentE_tickers_pos,'</span> ',
										 $lang_tr["ltr_00572"],' ',sizeOf($rentE_tickers),' ',$lang_tr["ltr_00573"],' ',$lang_tr['ltr_00576a'],$EnNI,$lang_tr['ltr_00576b'],'</span></li>';
								}
								
								if ($rentF_tickers_pos > 0)
								{
									$color_span_rentF_place = '';
									if ($rentF_tickers_pos < 50) $color_span_rentF_place = 'style="color:#31c421;" ';
									else if ($rentF_tickers_pos > 300) $color_span_rentF_place = 'style="color:#E51717;" ';
									echo '<li><span>',$lang_tr["ltr_00571"],
										 ' <span ',$color_span_rentF_place,'>',$rentF_tickers_pos,'</span> ',
										 $lang_tr["ltr_00572"],' ',sizeOf($rentF_tickers),' ',$lang_tr["ltr_00573"],' ',$lang_tr["ltr_00577"],'</span></li>';
								}
								*/
								
							}
							
							

							// AI
							
							if (
									isset($gr_revenue_hist) && 
									isset($gr_revenue) && 
									isset($rent) && 
									isset($country) && 
									isset($category) && 
									
									$gr_revenue_hist !== null && 
									$gr_revenue !== null && 
									$rent !== null && 
									$country !== null && 
									$category !== null
								)
							{
								$var_0_const    = 1.31;
								$var_1_grow_H   = 3.68;
								$var_2_grow_L   = 1.48;
								$var_3_margin   = 4.87;
								$var_4_country  = 1.60 * 0.11;
								$var_5_industry = 4.33 * 0.11;
								
								$AI_lim = 0.01;
								
								$cat_bonus = 0;
								if (
										$ticker   == 'AMZN' || 
										$ticker   == 'JD' || 
										$ticker   == 'PDD'
									) $cat_bonus = 1;
								
								$country_bonus = 0;
								if ($country == 'UNITED STATES') $country_bonus = 1;
								
								$AI_usual_mult = 
									$var_0_const + 
									$var_1_grow_H * $gr_revenue_hist / 100 + 
									$var_2_grow_L * $gr_revenue + 
									$var_3_margin * $rent + 
									$var_4_country * $country_bonus + 
									$var_5_industry * $cat_bonus
								;
								
								$AI_usual_mult_text = number_format($AI_usual_mult, 1,'.','');
								
								if ($AI_usual_mult > 100)
								{
									$AI_usual_mult_text = '>100';
								}
								
								echo '<br><br>';
								echo '<span><span style="color:#093E58;">',
										'<b>AI Insight</b></span>: the companies with similar growth trajectories, ',$EnNI,' margin, industries and geography ',
										'on average are valued <b>',$AI_usual_mult_text,'x</b> by ',$EV_P,'&nbsp;/&nbsp;Sales multiple',PHP_EOL;
								
								if (isset($EV_Sales) && $EV_Sales !== null && $EV_Sales > 0 && $AI_usual_mult > 0)
								{
									$AI_percent = ($AI_usual_mult / $EV_Sales) - 1;
									$AI_percent_style = '';
									$AI_percent_word = '';
									if ($AI_percent >  $AI_lim) { $AI_percent_style = ' style="color:#31c421;"'; $AI_percent_word = 'undervalued'; }
									if ($AI_percent < -$AI_lim) { $AI_percent_style = ' style="color:#E51717;"'; $AI_percent_word = 'overvalued'; }
									
									if (abs($AI_percent) > $AI_lim)
									{
										$AI_percent_text = number_format(abs($AI_percent) * 100, 1,'.','');
										
										if ($AI_percent > 1)
										{
											$AI_percent_text = '>100';
										}
										
										echo ', the company can be <b><span ',$AI_percent_style,'>',$AI_percent_text,'% ',$AI_percent_word,'</b></span>',PHP_EOL;
									}
								}
								
								echo '</span>',PHP_EOL;
								
							}


							//insiders
							$arr = get_insiders_us($ticker, $mysqli);
							if ($arr && isset($arr['month_stat']) && isset($arr['month_stat']['avg_deal_price']))
							{
								$month_stat = $arr['month_stat'];
								$b_s_word = green_colour_insiders($lang_tr['insiders_buy']);
								if ($month_stat['buy_sell'] == 'SELL')
								{
									$b_s_word = red_colour_insiders($lang_tr['insiders_sell']);
								}
								echo '<br><br>';
								echo '<span><span style="color:#093E58;"><b>Insiders: </b></span>',sprintf($lang_tr['ltr_insiders_last_month'], $b_s_word, number_format(abs($month_stat['avg_deal_price'] / 1000000), 1, '.', ' '), nice_percent_span_insider_color_by_other_value($month_stat['avg_deal_price_pct'], $month_stat['avg_deal_price'])),'</span>',PHP_EOL;
							}
							
						echo '</div>',PHP_EOL;
					}
					
				echo '</div>',PHP_EOL;
			}
		echo '</div>',PHP_EOL;

		$back_img = '';
		if (false)
		{
			$img_back_path = $root.'/img/logo_back/'.$ticker.'_back.jpg';
			
			if (!file_exists($img_back_path))
			{
				$img_back_path = $root.'/img/logo_back/'.$ticker.'_back.png';
			}
			
			if ( file_exists($img_back_path))
			{
				$back_img = ' background-image:url("'.str_replace($root, '', $img_back_path).'"); padding-top:120px; background-size:100% 120px; background-repeat:no-repeat; ';
			}
		}

		echo '<div id="fin_Counting_Block" class="float1 border1"  style="',$back_img,'" >',PHP_EOL;
			
			echo '<div id="main_fin_data" class="border_0_style">',PHP_EOL;
				if (isset($_GET["name"]))
				{
					$title_1 = $lang_tr["ltr_00028"];
					$title_2 = $lang_tr["ltr_00029"];
					$title_3 = $lang_tr["ltr_00030"];
					
					$title_4 = $lang_tr["ltr_00031a"];
					$title_5 = $lang_tr["ltr_00032a"];
					
					$title_6 = $lang_tr["ltr_00033"];
					$title_7 = $lang_tr["ltr_00034"];
					$title_8 = $lang_tr["ltr_00035"];
					
					$title_10 = $lang_tr["ltr_00037"];
					$title_11 = $lang_tr["ltr_00038"];
					
					// --------------------------------------------------------------------------------
					
					
					$sgnTXT = '';
					$clrTXT = '#A7A7A7';
					if ($emitDayPriceChange > 0) { $clrTXT = '#A8DE92'; $sgnTXT = '+'; }
					if ($emitDayPriceChange < 0) { $clrTXT = '#DEA892'; }
					$emitChangeTXT = '<span style="color:'.$clrTXT.'; width:55px; display:inline-block; float:right; text-align:right;">&nbsp;('.$sgnTXT.number_format($emitDayPriceChange*100, 1, '.', '').'%)</span>';
					
					include '/html/blocks/page_company_block_pre_post_market_price.php';
					
					echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr["ltr_00124"],'</span><a class="a_company_page_load_fin" style="color:#74A1D5" href="export_csv.php?key=',$key_param_date_export,'&tableName=Key financial indicators&Ticker='.$ticker.'&Prefix=US2"> (Download financials) </a></h3>'.PHP_EOL;
					echo "<div style='height:15px;'> </div>".PHP_EOL;
					echo '<div title="',$lang_tr["ltr_00256"],': ',$FinActuality,'">','<span>',$lang_tr["ltr_00067"],': ',$ticker,'</span>',$post_pre_element,'</div>'.PHP_EOL;
					
					echo '<div style="margin-top:10px;" title="',$title_1,'">',$lang_tr["ltr_00125"],', USD: ',$emitChangeTXT,'<span class="company_price_widget_frame" style="float:right;">',$price;
						$prefix  = 'RS';
						include '/html/blocks/page_company_price_widget.php';
					echo '</span></div>'.PHP_EOL;
					echo '<div>',$lang_tr["ltr_00126"],': <span style="float:right;">'.number_format($shares_count, 0, '.', ' ').'</span></div>'.PHP_EOL;
					echo "<hr class='hr_E'>".PHP_EOL;
					
					if ($countData > 0)
					{
						// дивидендная доходность
						echo '<div title="'.$title_2.'">'.$lang_tr["ltr_00127"].':&nbsp;&nbsp;<span style="float:right;'.$color_div.'">'.$div_rate_Y.'</span></div>'.PHP_EOL;
						
						// доходность FCF
						if (!($mult_LTM > 0 && $EbitdaLTM <= 0))
						{
							if (!$banking)
							{
								if ($FCF_LTM == null || $FCF_LTM == 0) $FCF_LTM = '---';
								if ($FCF_LTM != '---') 
								{
									$FCF_str_add_1 = '';
									$FCF_str_add_2 = '';
									if ($FCF_rate_Y_E != -1)
									{
										$FCF_str_add_1 = ' / expected';
										$FCF_str_add_2 = ' / <span'.$FCF_rate_Y_color_E.'>'.number_format($FCF_rate_Y_E, 1, '.', ' ').'%</span>';
									}
									echo '<div title="'.$title_3.'">'.'FCF Yield LTM'.$FCF_str_add_1.': <span style="float:right;"><span'.$FCF_rate_Y_color_1.'>'.$FCF_rate_Y.'</span>'.$FCF_str_add_2.'</span></div>'.PHP_EOL;
								}
							}
							
							// мульт отчетный
							if (!$banking)
							{
								echo '<div title="'.$title_6.'">'.'EV / LTM EBITDA: <span style="float:right;">'.number_format($mult_LTM, 1, '.', ' ').'x</span></div>'.PHP_EOL;
							}
							else 
							{
								echo '<div>'.'P / E LTM: <span style="float:right;">'.number_format($mult_LTM, 1, '.', ' ').'x</span></div>'.PHP_EOL;
							}
							
							if ($EV_EBITDA_annualized !== null)
							{
								if (!$banking)
								{
									echo '<div>EV / EBITDA annualized: <span style="float:right;">',number_format($EV_EBITDA_annualized, 1, '.', ''),'x</span></div>',PHP_EOL;
								}
								else
								{
									echo '<div>P / E annualized: <span style="float:right;">',number_format($EV_EBITDA_annualized, 1, '.', ''),'x</span></div>',PHP_EOL;
								}
							}
						}
						
						echo "<div style='height:10px;'> </div>".PHP_EOL;
						// темпы роста либо изменение цен
						if (isset($growth_Revenue) && isset($growth_Ebitda))
						{
							$growth_color_1 = "";
							if ($growth_Revenue + 0 < 0) $growth_color_1 = " color:#E51717;";
							else if ($growth_Revenue + 0 >= 10) $growth_color_1 = " color:#31c421;";
							$growth_color_2 = "";
							if ($growth_Ebitda + 0 < 0) $growth_color_2 = " color:#E51717;";
							else if ($growth_Ebitda + 0 >= 10) $growth_color_2 = " color:#31c421;";
							
							if ($growth_Revenue + 0 == 200) $sgn = '> '; else $sgn = '';
							echo '<div title="',$title_4,'">',$lang_tr["ltr_00128"],':&nbsp;&nbsp;<span style="float:right;',$growth_color_1,'">',$sgn,$growth_Revenue,'</span></div>',PHP_EOL;
							
							if ($growth_Ebitda + 0 == 200) $sgn = '> '; else $sgn = '';
							echo '<div title="',$title_4,'">'.$lang_tr["ltr_00129"],' ',$EnNI,' (',$lang_tr['ltr_00132'],'):&nbsp;&nbsp;<span style="float:right;',$growth_color_2,'">',$sgn,$growth_Ebitda,'</span></div>',PHP_EOL;
							
							if ($growth_Revenue_hist + 0 == 200) $sgn = '> '; else $sgn = '';
							echo '<div title="',$title_5,'">'.$lang_tr["ltr_00130"],':&nbsp;&nbsp;<span style="float:right;">',$sgn,$growth_Revenue_hist,'</span></div>',PHP_EOL;
							
							if ($growth_Ebitda_hist + 0 == 200) $sgn = '> '; else $sgn = '';
							echo '<div title="',$title_5,'">'.$lang_tr["ltr_00131"],' ',$EnNI,':&nbsp;&nbsp;<span style="float:right;">',$sgn,$growth_Ebitda_hist,'</span></div>',PHP_EOL;
						}
						echo "<div style='height:10px;'> </div>".PHP_EOL;
						
						echo '<div>',$EV_P,' / Sales: <span style="float:right;">',number_format($EV_Sales, 1, '.', ' '),'x</span></div>',PHP_EOL;
						echo '<div>',$lang_tr["ltr_00196a"],' (',$EnNI,' LTM / Revenue): <span style="float:right;">',number_format($rent * 100, 1, '.', ' '),'%</span></div>',PHP_EOL;
						
							if (isset($year_created_value))
							{
								$stl_ycv = "";
								if ($year_created_value < 0.00) $stl_ycv = " style='color:#E51717;' ";
								if ($year_created_value > 0.05) $stl_ycv = " style='color:#31c421;' ";
								if ($FREE_LIMITED_ACCESS_MODE)
								{
									echo '<div'.$stl_ycv.'><b>'.$lang_tr["ltr_00138"].': <span style="float:right;">',PHP_EOL;
									
										echo '<div class="in_row_1 first_col_no report_out_cell q_col" style="cursor:pointer;" onclick="goFreeTrialPage()" >',
											 '<div class="lock_yellow_1" style="float:right;" ></div>',
											 '</div>',PHP_EOL;
									
									echo '</span></b></div>'.PHP_EOL;
								}
								else
								{
									echo '<div'.$stl_ycv.'><b>'.$lang_tr['ltr_00138'].': <span style="float:right;">'.nice_percent_FCF_rate($year_created_value).'</span></b></div>'.PHP_EOL;
								}
							}
					}
					else echo '<span> -- '.$lang_tr["ltr_00259"].' -- </span>'.PHP_EOL;
				}
			echo '</div>'.PHP_EOL;

			$admin_load_speed_timer['growing_US_2.php (15)'] = microtime(true);

			echo "<div style='height:15px;'> </div>".PHP_EOL;
			
			echo '<div id="fin_Counting_Block_inner">'.PHP_EOL;
					if (!$banking)
					{
						echo '<div>'.$lang_tr["ltr_00140b"].': <span style="float:right;">'.number_format($cap, 0, '.', ' ').'</span></div>'.PHP_EOL;
						echo '<div>'.$lang_tr["ltr_00141b"].': <span style="float:right;">'.number_format($NetDebtLast, 0, '.', ' ').'</span></div>'.PHP_EOL;
						echo '<div>'.'EV (Enterprise Value): <span style="float:right;">'.number_format($EV_, 0, '.', ' ').'</span></div>'.PHP_EOL;
						
						if 
						(
							isset($price_to_book) && 
							$price_to_book != null 
							
							/*
							
							&& 
							(
								strpos(strtolower($category), 'shipping') !== false || 
								strpos(strtolower($category), 'biotech') !== false
							)
							
							*/
						) 
						{
							echo '<div>Price to Book: <span style="float:right;">',number_format($price_to_book, 1, '.', ' '),'x</span></div>',PHP_EOL;
						}
					}
					else
					{
						echo '<div>'.$lang_tr["ltr_00140b"].': <span style="float:right;">'.number_format($cap, 0, '.', ' ').'</span></div>'.PHP_EOL;
						
						if (isset($price_to_book) && $price_to_book !== null)
						{
							echo '<div>Price to Book: <span style="float:right;">',number_format($price_to_book, 1, '.', ' '),'x</span></div>',PHP_EOL;
						}
					}
					
					include '/html/blocks/block_company_review_link_universal.php';
					
					echo '<br>';
					
					if ($shin !== null)
					{
						echo '<span><Short interest: ',number_format($shin * 100, 1, '.', ''),'%</span>',PHP_EOL;
					}

					//buy and sell button
					include '/html/blocks/block_BCS_brokstock_ref_links.php';
					
			echo '</div>'.PHP_EOL;
			
		echo '</div>'.PHP_EOL;
	}

echo '</div>'.PHP_EOL;

// -------------------------------------------------------------------------------------------------------------

$admin_load_speed_timer['growing_US_2.php (16)'] = microtime(true);

if (!empty($_GET['name']))
{
	// charts
	if (true)
	{
		echo '<div style="float:left; min-width:97%;" >',PHP_EOL;
			
			$prefix = 'US2';
			include '/html/blocks/COMPANY_CARD_GRAPHS/company_graph_revenue.php';
			
			$admin_load_speed_timer['growing_US_2.php (17)'] = microtime(true);
			
			if (!$banking) include '/html/blocks/COMPANY_CARD_GRAPHS/company_graph_debt.php';
			
			$admin_load_speed_timer['growing_US_2.php (18)'] = microtime(true);
			
			include '/html/blocks/COMPANY_CARD_GRAPHS/company_graph_price_dividend.php';
			
			$admin_load_speed_timer['growing_US_2.php (19)'] = microtime(true);
			
			$strategy_prefix = 'RS';
			include '/html/blocks/COMPANY_CARD_GRAPHS/company_graph_mult.php';
			
		echo '</div>',PHP_EOL;
	}
	
	include '/html/blocks/page_company_block_TRAFFIC.php';
	
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	
	$admin_load_speed_timer['growing_US_2.php (20)'] = microtime(true);
	
	$limit = 10;
	include '/html/php_db/get_emitent_news.php';
	if (sizeOf($obj) > 0)
	{
		echo '<div class="float1" style="width:95%;" >',PHP_EOL;
			for ($i = 0; $i < sizeOf($obj); $i++) include '/html/blocks/block_company_news_item.php';
		echo '</div>',PHP_EOL;
	}
	
	$admin_load_speed_timer['growing_US_2.php (21)'] = microtime(true);
	
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	
	if ($FREE_LIMITED_ACCESS_MODE)
	{
		echo '<div class="in_row_1 first_col_no q_col" style="width:400px; min-width:400px; max-width:400px; cursor:pointer; padding:80px 5px; " onclick="goFreeTrialPage()" >',
			 '<div class="lock_yellow_1" style="float:left;"></div><div style="float:left; font-size:18px; width:340px; text-align:left; margin-left:15px;" >',
			 'More information for subscribed users:<br>',
			 'detailed calculation of<br>',
			 'Fundamental value created in LTM</div>',
			 '</div>',PHP_EOL;
	}
	else
	{
		echo '<div class="mobile-show-use-full-version">',$lang_tr["ltr_00658"],'</div>',PHP_EOL;
		
		echo '<div>',PHP_EOL;
			
			$admin_load_speed_timer['growing_US_2.php (22)'] = microtime(true);
			
			include '/html/blocks/block_table_estimates.php';
			include '/html/blocks/block_table_options.php';
			// -----------------------------------------------------------
			
			echo '<div >',PHP_EOL;
			
				echo '<div>',PHP_EOL;
					
					if (isset($year_created_value) && $year_created_value !== null && $year_created_value != 0 && $year_created_value != -1000)
					{
						$gp_4 = '&nbsp;&nbsp;&nbsp;&nbsp;';
						
						echo '<div id="YearCreatedValueContainer" class="float1 border1" >',PHP_EOL;
							
							echo "<div style='height:8px;'> </div>".PHP_EOL;
							echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr['ltr_00260'],'</span></h3>',PHP_EOL;
							
							$EVbk = 'EV';
							$s_e_e = 'Revenue';
							
							$EnNI = 'Revenue';
							
							echo '<p>',$lang_tr["ltr_00273"],' <b>',$lang_tr["ltr_00274"],'</b> ',
								 $lang_tr["ltr_00275"],' <b>',$lang_tr["ltr_00276"],'</b> ',$lang_tr["ltr_00277"],'.<br><br>',
								 $lang_tr["ltr_00278"],': <br>',
								 '• ',$lang_tr["ltr_00279"],'<br>',
								 '• ',$lang_tr["ltr_00280"],'<br><br>',
								 $lang_tr["ltr_00281"],':<br>',
								 '• ',$lang_tr["ltr_00282"],' ',$s_e_e,' ',$lang_tr["ltr_00283"],'<br>',
								 '• ',$lang_tr["ltr_00284"],' ',$EVbk,'/',$s_e_e,' ',$lang_tr["ltr_00285"],' ',$EVbk,'/',$s_e_e,
								 ' ',$lang_tr["ltr_00286"],' ',number_format($mult_common_grow, 1, '.', ''),'x ',$lang_tr["ltr_00287"],')<br>',
								 '</p>';
							
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'><b>",$lang_tr["ltr_00261"],"</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'><b>",$lang_tr["ltr_00262"],"</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'><b>",$lang_tr["ltr_00263"],"</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>",$lang_tr["ltr_00264"],"</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,$gp_4,$EnNI," (",$lang_tr["ltr_00265"],")</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(1)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format($fin_revenue_prev, 0, '.', ' ')."</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,$gp_4,$EnNI," (",$lang_tr["ltr_00266"],")</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(2)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format($fin_revenue_last, 0, '.', ' ')."</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,$gp_4,$EnNI," LTM</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(3)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format($RevenueLTM, 0, '.', ' ')."</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
							
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,$EnNI," LTM / last Q</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(4)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(3) / (2)</div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format($X__rel, 3, '.', '')."</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'>",$gp_4,$lang_tr["ltr_00267"]," ",$EnNI," (",$lang_tr["ltr_00268b"],")</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(5)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>( (2)-(1) ) * (4)</div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format(($fin_revenue_last - $fin_revenue_prev) * $X__rel, 0, '.', ' ')."</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
							
											echo "<div>".PHP_EOL;
												echo "<div class='in_row_YV1'>",$gp_4,$gp_4,$gp_4,$EV_P,"</div>".PHP_EOL;
												echo "<div class='in_row_YV2_formula'>(6)</div>".PHP_EOL;
												echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
												echo "<div class='in_row_YV2'>".number_format(($cap + $NetDebtLast + $paid), 0, '.', ' ')."</div>".PHP_EOL;
											echo "</div>".PHP_EOL;
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,"Mult</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(7)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(6) / (3)</div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format(($cap + $NetDebtLast + $paid) / $RevenueLTM, 1, '.', '')."x</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
									echo "<div>".PHP_EOL;
										echo "<div class='in_row_YV1'>",$gp_4,$gp_4,"Mult ",$lang_tr["ltr_00269"],"</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>(8)</div>".PHP_EOL;
										echo "<div class='in_row_YV2_formula'>const</div>".PHP_EOL;
										echo "<div class='in_row_YV2'>".number_format($mult_common_grow, 1, '.', '')."x</div>".PHP_EOL;
									echo "</div>".PHP_EOL;
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'>",$gp_4,"Mult avg</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(9)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>avgerage</div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format(($mult_common_grow + (($cap + $NetDebtLast + $paid) / $RevenueLTM))/2, 1, '.', '')."x</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
							
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'>",$gp_4,"Equity+</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(10)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(5) * (9)</div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format((($fin_revenue_last - $fin_revenue_prev) * $X__rel * (($cap + $NetDebtLast + $paid) / $RevenueLTM + $mult_common_grow) / 2), 0, '.', ' ')."</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'>",$gp_4,"FCF LTM</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(11)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format(($FCF_LTM + 0), 0, '.', ' ')."</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
							
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'><b>Value+</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(12)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(10) + (11)</div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format((($fin_revenue_last - $fin_revenue_prev) * $X__rel * (($cap + $NetDebtLast + $paid) / $RevenueLTM + $mult_common_grow) / 2 + $FCF_LTM), 0, '.', ' ')."</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							echo "<div>".PHP_EOL;
								echo "<div class='in_row_YV1'><b>Cap</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(13)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'></div>".PHP_EOL;
								echo "<div class='in_row_YV2'><b>".number_format($cap, 0, '.', ' ')."</b></div>".PHP_EOL;
							echo "</div>".PHP_EOL;
							
							echo "<div><div class='in_row_YV1'>",$gp_4,"</div><div class='in_row_YV2'>",$gp_4,"</div></div>".PHP_EOL;
							
							$stl_ycv = "";
							if ($year_created_value < 0.00) $stl_ycv = " style='color:#E51717;' ";
							if ($year_created_value > 0.05) $stl_ycv = " style='color:#31c421;' ";
							echo "<div",$stl_ycv,">".PHP_EOL;
								echo "<div class='in_row_YV1'><b>",$lang_tr["ltr_00270"],"</b></div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(14)</div>".PHP_EOL;
								echo "<div class='in_row_YV2_formula'>(12) / (13)</div>".PHP_EOL;
								echo '<div class="in_row_YV2"><b>',nice_percent_FCF_rate($year_created_value),'</b></div>',PHP_EOL;
							echo "</div>".PHP_EOL;
						echo "</div>".PHP_EOL;
					}
					
				echo '</div>',PHP_EOL;
				
				$admin_load_speed_timer['growing_US_2.php (23)'] = microtime(true);
				
				include '/html/blocks/block_table_alpha_beta.php';
				
				$admin_load_speed_timer['growing_US_2.php (24)'] = microtime(true);
				
			echo '</div>',PHP_EOL;
			
		echo '</div>',PHP_EOL;
	}
	
	include '/html/php_db/get_all_reviews_RS.php';
	
	$admin_load_speed_timer['growing_US_2.php (25)'] = microtime(true);
	
	$the_only_ticker = $_GET['name'];
	if (sizeOf($dates) > 0)
	{
		include $root.'/blocks/block_last_reviews_RS_universal_html.php';
	}
	
	$admin_load_speed_timer['growing_US_2.php (26)'] = microtime(true);
	
	include '/html/blocks/block_transcripts.php';
	
	$admin_load_speed_timer['growing_US_2.php (27)'] = microtime(true);
	
}

?>