<?php

date_default_timezone_set('Europe/Moscow');

$commIDs_OFF = [];

echo PHP_EOL,'<script>$("title").html("',$lang_tr['ltr_00015'],'");</script>',PHP_EOL;

echo '<div class="float2 over-auto-mob">'.PHP_EOL;
echo '<div class="asd-av">'.PHP_EOL;
	
    echo '<div style="height:15px;"> </div>'.PHP_EOL;
    echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr["ltr_00015"],'</span></h3>'.PHP_EOL;
		
		$root = $_SERVER['DOCUMENT_ROOT'];
		include_once $root.'/php_db/single_functions.php';
		include $root.'/php_db/get_commodity_list.php';
		
		// ----------------------------------------------------------------
		
		$sY2 = date('Y');
		$sM0 = date('m');
		
		$sY1 = $sY2 - 1;
		$sM2 = '';
		$sM1 = '';
		$sD1 = '01';
		$last_quarter = '';
		
		if      ($sM0+0 > 10) { $sM2 = '09'; $sD2 = "30"; $sM1 = '10'; $last_quarter = $sY2.' q3'; }
		else if ($sM0+0 >  7) { $sM2 = '06'; $sD2 = "30"; $sM1 = '07'; $last_quarter = $sY2.' q2'; }
		else if ($sM0+0 >  4) { $sM2 = '03'; $sD2 = "31"; $sM1 = '04'; $last_quarter = $sY2.' q1'; }
		else if ($sM0+0 >  1) { $sM2 = '12'; $sD2 = "31"; $sM1 = '01'; $sY2 = $sY2 - 1; $last_quarter = $sY2.' q4'; }
		else                  { $sM2 = '09'; $sD2 = "30"; $sM1 = '10'; $sY2 = $sY2 - 1; $last_quarter = $sY2.' q3'; }
		
		$ss1 = $sY1.'-'.$sM1.'-'.$sD1;
		$ss2 = $sY2.'-'.$sM2.'-'.$sD2;
		
		// ----------------------------------------------------------------
		
		$sY2_1 = date('Y');
		$sM0_1 = date('m');
		
		$sY1_1 = $sY2_1 - 1;
		$sM2_1 = '';
		$sM1_1 = '';
		$sD1_1 = '01';
		$last_quarter_1_Y = '';
		
		if      ($sM0_1+0 > 10) { $sM2_1 = '09'; $sD2_1 = "30"; $sM1_1 = '10'; $last_quarter_1_Y = $sY2_1.' q3'; }
		else if ($sM0_1+0 >  7) { $sM2_1 = '06'; $sD2_1 = "30"; $sM1_1 = '07'; $last_quarter_1_Y = $sY2_1.' q2'; }
		else if ($sM0_1+0 >  4) { $sM2_1 = '03'; $sD2_1 = "31"; $sM1_1 = '04'; $last_quarter_1_Y = $sY2_1.' q1'; }
		else if ($sM0_1+0 >  1) { $sM2_1 = '12'; $sD2_1 = "31"; $sM1_1 = '01'; $sY2_1 = $sY2_1 - 1; $last_quarter_1_Y = $sY2_1.' q4'; }
		else                    { $sM2_1 = '09'; $sD2_1 = "30"; $sM1_1 = '10'; $sY2_1 = $sY2_1 - 1; $last_quarter_1_Y = $sY2_1.' q3'; }
		
		// ----------------------------------------------------------------
		
		echo '<div style="height:15px;"> </div>'.PHP_EOL;
		echo '<div class="commodities-mob_width" style="width:600px; font-size:13px;">'.
			'*',$lang_tr["ltr_00213"],' ('.$ss1.'&nbsp;&nbsp;—&nbsp;&nbsp;'.$ss2.') </div>'.PHP_EOL;
		echo '<div style="height:20px;"> </div>'.PHP_EOL;
		echo '<div class="mainContainerCommodities">'.PHP_EOL;
			echo "<div>".PHP_EOL;
			echo "<div class='in_row_container_head'>".PHP_EOL;
			echo "<div class='in_row_1 in_row_1_head first_col_yes first_col_yes_comm'><div class='first_inner_div'><b>",$lang_tr["ltr_00208"],"</b></div></div>".PHP_EOL;
			echo "<div class='in_row_1 in_row_1_head first_col_no'><b>",$lang_tr["ltr_00071"]," / day</b></div>".PHP_EOL;
			echo "<div class='in_row_1 in_row_1_head first_col_no'><b>",$lang_tr["ltr_00069"],"</b></div>".PHP_EOL;
			echo "<div class='in_row_1 in_row_1_head first_col_no'><b>",$lang_tr["ltr_00212"]," LTM*</b></div>".PHP_EOL;
			
			if (isset($siteUserLogin___) && $siteUserLogin___ == 'Admin')
			{
				echo '<div class="in_row_1 in_row_1_head first_col_no Comm_Link_Name_Cell" ><b>',$lang_tr['ltr_00209'],'</b></div>',PHP_EOL;
			}
			else if (!isset($_COOKIE['language']) || $_COOKIE['language'] != 'EN')
			{
				echo '<div class="in_row_1 in_row_1_head first_col_no Comm_Link_Name_Cell" ><b>',$lang_tr['ltr_00209'],'</b></div>',PHP_EOL;
			}
			
			echo '</div>',PHP_EOL;
			echo '</div>',PHP_EOL;
			
			echo '<div>',PHP_EOL;
			$lastCat = '';
			for ($i = 0; $i < count($ShortNames); $i++)
			{
				if (!in_array($commIDs[$i], $commIDs_OFF))
				{
					if ($Categories[$i] != $lastCat)
					{
						echo "<div class='in_row_container_head'><div class='in_row_1 first_col_no'> </div></div>".PHP_EOL;
						echo "<div class='in_row_container_head'><div class='in_row_1 in_row_1_head_cat first_col_yes first_col_yes_comm'><b>".substr($Categories[$i], 3)."</b></div></div>".PHP_EOL;
						$lastCat = $Categories[$i];
					}
					echo "<a href='commodity.php?id=".$commIDs[$i]."' target='_blank'>".PHP_EOL;
					echo "<div class='in_row_container'>".PHP_EOL;
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
						if (!isset($_COOKIE['language']) || $_COOKIE['language'] != 'EN')
						{
							$descr = '';
							if (strlen($Descriptions[$i]) > 3) $descr = " / ".$Descriptions[$i];
							echo "<div class='in_row_1 first_col_yes first_col_yes_comm'>".$ShortNames[$i]."<span style='color:grey;'>".$descr."</span></div>".PHP_EOL;
						}
						else
						{
							echo "<div class='in_row_1 first_col_yes first_col_yes_comm'>".$ShortNamesEN[$i]."</div>".PHP_EOL;
						}
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
						$commPriceNOW = get_comm_NOW_by_commID($commIDs[$i], $mysqli);
						$signs_after_dot = 0;
						if      ($commPriceNOW <  50) $signs_after_dot = 2;
						else if ($commPriceNOW < 100) $signs_after_dot = 1;
						
						$s0 = '';
						switch (date('w'))
						{
							case 1: 
								$s0 = '-73 hours';
								break;
							case 2: 
								$s0 = '-25 hours';
								break;
							case 3: 
								$s0 = '-25 hours';
								break;
							case 4: 
								$s0 = '-25 hours';
								break;
							case 5: 
								$s0 = '-25 hours';
								break;
							case 6: 
								$s0 = '-48 hours';
								break;
							case 0: 
								$s0 = '-72 hours';
								break;
						}
						$L_dt = date('Y-m-d', strtotime($s0));
						$yesterday_value = get_comm_by_commID_on_date($commIDs[$i], $L_dt, $mysqli);
						$ch = $commPriceNOW / $yesterday_value - 1;
						echo 
							'<div class="in_row_1 first_col_no" >',
								'<span style="font-size:12px;" >',number_format($commPriceNOW, $signs_after_dot, '.', ' '),'</span>',
								'<span style="font-size:10px; display:inline-block; width:35px; text-align:right; opacity:0.6;" >',nice_percent_span($ch),'</span>',
							'</div>',
							PHP_EOL;
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
						if (substr($Categories[$i], 3) == 'Stats') echo '<div class="in_row_1 first_col_no" > </div>',PHP_EOL; else echo '<div class="in_row_1 first_col_no" >',get_comm_Currency_by_commID($commIDs[$i]),'</div>',PHP_EOL;
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
						$commPriceLTM = get_comm_LTM_by_commID($commIDs[$i], $last_quarter_1_Y, $mysqli);
						$growth_color_1 = '';
						if ($commPriceNOW < $commPriceLTM) $growth_color_1 = " style='color:#E51717;'"; // red
						else $growth_color_1 = " style='color:#31c421;'"; // green
						
						$temp_to_ltm_change = '';
						if ($commPriceLTM != 0)
						{
							$temp_to_ltm_change = number_format(($commPriceNOW/$commPriceLTM - 1)*100, 1)."%";
						}
						echo "<div class='in_row_1 first_col_no'".$growth_color_1.">".$temp_to_ltm_change."</div>".PHP_EOL;
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
						$Link = get_comm_Link_by_commID($commIDs[$i]);
						$Link_Name = get_comm_Link_Name_by_commID($commIDs[$i]);
						
						if ((isset($siteUserLogin___) && $siteUserLogin___ == 'Admin') && strlen($Link) > 5)
						{
							echo 
								'<div class="in_row_1 first_col_no Comm_Link_Name_Cell" >',
									'<a href="',$Link,'" target="_blank" style="color:#175996; text-decoration:underline;" >',
										$Link_Name,
									'</a>',
								'</div>',
								PHP_EOL;
						}
						else if (!isset($_COOKIE['language']) || $_COOKIE['language'] != 'EN')
						{
							echo '<div class="in_row_1 first_col_no Comm_Link_Name_Cell" >',$Link_Name,'</div>',PHP_EOL;
						}
						
						// ------------ ------------ ------------ ------------ ------------ ------------
						
					echo '</div>',PHP_EOL;
					echo '</a>',PHP_EOL;
				}
			}
			
		echo '</div>',PHP_EOL;
		
    echo '</div>',PHP_EOL;

echo '</div>',PHP_EOL;
echo '</div>',PHP_EOL;


// ----------------------------------------------------------------
$sY2_1 = date('Y', strtotime('-12 hour'));
$sM0_1 = date('m', strtotime('-12 hour'));

$sY1_1 = $sY2_1 - 1;
$sM2_1 = "";
$sM1_1 = "";
$sD1_1 = '01';
$last_quarter_1 = "";

if      ($sM0_1+0 > 9) { $sM2_1 = '09'; $sD2_1 = "30"; $sM1_1 = '10'; $last_quarter_1 = $sY2_1.' q3'; }
else if ($sM0_1+0 > 6) { $sM2_1 = '06'; $sD2_1 = "30"; $sM1_1 = '07'; $last_quarter_1 = $sY2_1.' q2'; }
else if ($sM0_1+0 > 3) { $sM2_1 = '03'; $sD2_1 = "31"; $sM1_1 = '04'; $last_quarter_1 = $sY2_1.' q1'; }
else                   { $sM2_1 = '12'; $sD2_1 = "31"; $sM1_1 = '01'; $sY2_1 = $sY2_1 - 1; $last_quarter_1 = $sY2_1.' q4'; }

// ----------------------------------------------------------------

echo '<div class="float2 border1" id="changes_in_commodity_groups">'.PHP_EOL;
    echo '<div style="height:15px;"> </div>'.PHP_EOL;
    echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr["ltr_00206"],'</span></h3>'.PHP_EOL;
			echo '<div style="height:15px;"> </div>'.PHP_EOL;
			echo '<div style="width:200px; font-size:13px;">'.
				'**',$lang_tr["ltr_00207"],' </div>'.PHP_EOL;
			echo '<div style="height:20px;"> </div>'.PHP_EOL;
			echo '<div style="font-size:13px;">'.PHP_EOL;
				echo "<div>".PHP_EOL;
				echo "<div class='in_row_container_head'>".PHP_EOL;
				echo "<div class='in_row_comm_groups in_row_1_head first_col_yes_comm_groups'><b>",$lang_tr["ltr_00210"],"**</b></div>".PHP_EOL;
				echo "<div class='in_row_comm_groups in_row_1_head first_col_no'><b>",$lang_tr["ltr_00211"],"</b></div>".PHP_EOL;
				$last_quarter0 = substr($last_quarter_1,6,1).substr($last_quarter_1,5,1).substr($last_quarter_1,2,1).substr($last_quarter_1,3,1);
				echo "<div class='in_row_comm_groups in_row_1_head first_col_no'><b>",$lang_tr["ltr_00212"]," ".$last_quarter0."</b></div>".PHP_EOL;
				echo "<div class='in_row_comm_groups in_row_1_head first_col_no'><b>",$lang_tr["ltr_00212"]," LTM</b></div>".PHP_EOL;
				echo "</div>".PHP_EOL;
				echo "</div>".PHP_EOL;
				
				echo '<div style="height:20px;"> </div>'.PHP_EOL;
				
				echo "<div>".PHP_EOL;
				$lastCat = "";
				
				for ($i = 0; $i < count($ShortNames); $i++)
				{
					$lastCat = $Categories[$i];
					$counter0 = 0;
					$counter1 = 0;
					$counter2 = 0;
					$sum0     = 0;
					$sum1     = 0;
					$sum2     = 0;
					while ($i < count($ShortNames) && $Categories[$i] == $lastCat)
					{
						$commPriceNOW = get_comm_NOW_by_commID($commIDs[$i], $mysqli);
						$commPriceL_W = get_comm_L_W_by_commID($commIDs[$i]);
						$commPriceL_Q = get_comm_L_Q_by_commID($commIDs[$i], $last_quarter_1);
						$commPriceLTM = get_comm_LTM_by_commID($commIDs[$i], $last_quarter_1_Y, $mysqli);
						$currNOW = get_course_RUB_NOW($Measures[$i], $mysqli);
						$currL_W = get_course_RUB_L_W($Measures[$i]);
						$currL_Q = get_course_RUB_L_Q($Measures[$i], $last_quarter_1);
						$currLTM = get_course_RUB_LTM($Measures[$i], $last_quarter_1_Y, $mysqli);
						if ($commPriceL_W > 0 && $currL_W > 0) { $counter0++; $sum0 += ($commPriceNOW * $currNOW) / ($commPriceL_W * $currL_W) - 1; }
						if ($commPriceL_Q > 0 && $currL_Q > 0) { $counter1++; $sum1 += ($commPriceNOW * $currNOW) / ($commPriceL_Q * $currL_Q) - 1; }
						if ($commPriceLTM > 0 && $currLTM > 0) { $counter2++; $sum2 += ($commPriceNOW * $currNOW) / ($commPriceLTM * $currLTM) - 1; }
						$i++;
					}
					$i--;
					
					$val0 = "<span style='color:#DCDCDC;'><i>н/д</i></span>";
					$val1 = "<span style='color:#DCDCDC;'><i>н/д</i></span>";
					$val2 = "<span style='color:#DCDCDC;'><i>н/д</i></span>";
					if ($counter0 > 0)
					{ 
						$val0 = $sum0 / $counter0;
						if      ($val0 >  0.00) { $val0 = "<span style='color:#31c421;'>".number_format($val0 * 100, 1)."%</span>"; }
						else if ($val0 < -0.00) { $val0 = "<span style='color:#E51717;'>".number_format($val0 * 100, 1)."%</span>"; }
						else                    { $val0 = "<span                       >".number_format($val0 * 100, 1)."%</span>"; }
					}
					if ($counter1 > 0)
					{ 
						$val1 = $sum1 / $counter1;
						if      ($val1 >  0.01) { $val1 = "<span style='color:#31c421;'>".number_format($val1 * 100, 1)."%</span>"; }
						else if ($val1 < -0.01) { $val1 = "<span style='color:#E51717;'>".number_format($val1 * 100, 1)."%</span>"; }
						else                    { $val1 = "<span                       >".number_format($val1 * 100, 1)."%</span>"; }
					}
					if ($counter2 > 0)
					{
						$val2 = $sum2 / $counter2;
						if      ($val2 >  0.01) { $val2 = "<span style='color:#31c421;'>".number_format($val2 * 100, 1)."%</span>"; }
						else if ($val2 < -0.01) { $val2 = "<span style='color:#E51717;'>".number_format($val2 * 100, 1)."%</span>"; }
						else                    { $val2 = "<span                       >".number_format($val2 * 100, 1)."%</span>"; }
					}
					echo "<div class='in_row_container'>".PHP_EOL;
						echo "<div class='in_row_comm_groups first_col_yes_comm_groups'>".substr($lastCat,3)."</div>".PHP_EOL;
						echo "<div class='in_row_comm_groups first_col_no'>".$val0."</div>".PHP_EOL;
						echo "<div class='in_row_comm_groups first_col_no'>".$val1."</div>".PHP_EOL;
						echo "<div class='in_row_comm_groups first_col_no'>".$val2."</div>".PHP_EOL;
					echo "</div>".PHP_EOL;
				}
				
			echo "</div>".PHP_EOL;
    echo '</div>'.PHP_EOL;


echo '</div>'.PHP_EOL;
echo '<div class="float2 border1" style="width: 320px">'.PHP_EOL;
include 'blocks/block_search_commodity_in_description.php';
echo '</div>'.PHP_EOL;

?>