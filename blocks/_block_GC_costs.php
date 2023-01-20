<?php

if (isset($_GET['ticker']) || isset($ticker))
{
	if (isset($_GET['ticker'])) $ticker = $_GET['ticker'];
	
	include '/html/php_db/_GC_costs_calc.php';
	
	// ------------
	
	$qu = 
		'
			SELECT 
				annulized_smart, 
				annulized_all, 
				
				SHORT_ON_annulized_smart, 
				SHORT_ON_annulized_all, 
				
				gap_EBITDA_percent_E, 
				gap_EBITDA_percent_prev, 
				
				neighbor_Q_gap_EBITDA_percent_E, 
				neighbor_Q_gap_EBITDA_percent_prev 
				
			FROM GC_sectoral_backtest_results 
			WHERE Ticker = ? 
		';
	
	$stmt = $mysqli->prepare($qu);
	$stmt->bind_param('s', $ticker);
	$stmt->execute();
	$s = $stmt->get_result();
	
	$backtest_stats_found = false;
	
	if ($data = $s->fetch_array(MYSQLI_BOTH))
	{
		$annulized_smart = $data['annulized_smart'];
		$annulized_all = $data['annulized_all'];
		
		$SHORT_ON_annulized_smart = $data['SHORT_ON_annulized_smart'];
		$SHORT_ON_annulized_all = $data['SHORT_ON_annulized_all'];
		
		$gap_EBITDA_percent_E = $data['gap_EBITDA_percent_E'];
		$gap_EBITDA_percent_prev = $data['gap_EBITDA_percent_prev'];
		
		$neighbor_Q_gap_EBITDA_percent_E = $data['neighbor_Q_gap_EBITDA_percent_E'];
		$neighbor_Q_gap_EBITDA_percent_prev = $data['neighbor_Q_gap_EBITDA_percent_prev'];
		
		$backtest_stats_found = true;
	}
	
	// ------------
	
	if (isset($___obj) && sizeOf($___obj) > 0)
	{
		if ($divider == 4) $temp_qH = $lang_tr['ltr_00803a'];
		else               $temp_qH = $lang_tr['ltr_00803b'];
		
		echo '<div style="margin:15px; padding:5px; min-width:1080px; float:left;" >',PHP_EOL;
		
			echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2" >',$lang_tr['ltr_00795'],'</span></h3>'.PHP_EOL;
			// echo '<h3>','Revenue influence degree: ',number_format($weight_revenue_on_cost * 100, 1, '.', ''),'%</h3><br>',PHP_EOL;
			
			// ------------
			
			if ($neighbor_quarter_mode)
			{
				echo 
					'<div style="margin:18px 0px 22px 0px;" >',
						'<a style="color:#175996; text-decoration:underline; font-size:14px;" href="/company_world.php?name=',$ticker,'&forecast_model_q_neighbor=0" >',
							'Switch to y/y (N-4 quarter) forecasting model',
						'</a>',
					'</div>',
					PHP_EOL;
			}
			else
			{
				echo 
					'<div style="margin:18px 0px 22px 0px;" >',
						'<a style="color:#175996; text-decoration:underline; font-size:14px;" href="/company_world.php?name=',$ticker,'&forecast_model_q_neighbor=1" >',
							'Switch to neighbor (N-1 quarter) forecasting model',
						'</a>',
					'</div>',
					PHP_EOL;
			}
			
			// ------------
			
			$temp_p = '<p style="margin:20px; font-size:14px; max-width:800px;" >';
			
			echo $temp_p,$lang_tr['ltr_00796'],'</p>',PHP_EOL;
			
			// ------------
			
			echo $temp_p,$lang_tr['ltr_00798a'],$lang_tr['ltr_00799'],'<br>',PHP_EOL;
			
				if ($rev_diff_all < -0.5) echo $lang_tr['ltr_00799a'],$lang_tr['ltr_00800a'],$lang_tr['ltr_00801'],number_format(abs($rev_diff_all), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($rev_diff_all / $avg_revenue) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
				if ($rev_diff_all >= 0.5) echo $lang_tr['ltr_00799a'],$lang_tr['ltr_00800b'],$lang_tr['ltr_00801'],number_format(abs($rev_diff_all), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($rev_diff_all / $avg_revenue) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
			
				if ($ebitda_diff_all < -0.5) echo $lang_tr['ltr_00799b'],$lang_tr['ltr_00800a'],$lang_tr['ltr_00801'],number_format(abs($ebitda_diff_all), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($ebitda_diff_all / $avg_ebitda) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
				if ($ebitda_diff_all >= 0.5) echo $lang_tr['ltr_00799b'],$lang_tr['ltr_00800b'],$lang_tr['ltr_00801'],number_format(abs($ebitda_diff_all), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($ebitda_diff_all / $avg_ebitda) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
			
			echo '</p>',PHP_EOL;
			
			// ------------
			
			echo $temp_p,$lang_tr['ltr_00798b'],$lang_tr['ltr_00799'],'<br>',PHP_EOL;
			
				if ($rev_diff_year < -0.5) echo $lang_tr['ltr_00799a'],$lang_tr['ltr_00800a'],$lang_tr['ltr_00801'],number_format(abs($rev_diff_year), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($rev_diff_year / $avg_revenue_year) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
				if ($rev_diff_year >= 0.5) echo $lang_tr['ltr_00799a'],$lang_tr['ltr_00800b'],$lang_tr['ltr_00801'],number_format(abs($rev_diff_year), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($rev_diff_year / $avg_revenue_year) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
			
				if ($ebitda_diff_year < -0.5) echo $lang_tr['ltr_00799b'],$lang_tr['ltr_00800a'],$lang_tr['ltr_00801'],number_format(abs($ebitda_diff_year), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($ebitda_diff_year / $avg_ebitda_year) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
				if ($ebitda_diff_year >= 0.5) echo $lang_tr['ltr_00799b'],$lang_tr['ltr_00800b'],$lang_tr['ltr_00801'],number_format(abs($ebitda_diff_year), 0,'.',''),$lang_tr['ltr_00802'],number_format(abs($ebitda_diff_year / $avg_ebitda_year) * 100, 1, '.', ''),'%',$temp_qH,')<br>',PHP_EOL;
			
			echo '</p>',PHP_EOL;
			
			// ------------
			
			if ($backtest_stats_found)
			{
				echo '<div style="margin-left:20px;" >',PHP_EOL;
					
					$color_good = '#31c421';
					$color_bad = '#E51717';
					
					// --------
					
					if (!$neighbor_quarter_mode)
					{
						$color = null;
						if ($gap_EBITDA_percent_E < $gap_EBITDA_percent_prev)
						{
							$color = $color_good;
						}
						else
						{
							$color = $color_bad;
						}
						
						if ($gap_EBITDA_percent_E !== null)
						{
							echo '<div>','<span style="width:300px; display:inline-block;" >','EBITDA forecast error (%, abs, our model)',': </span>','<span style="color:',$color,';" >',number_format($gap_EBITDA_percent_E * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						}
						
						if ($gap_EBITDA_percent_prev !== null)
						{
							echo '<div>','<span style="width:300px; display:inline-block;" >','EBITDA forecast error (%, abs, previous)',': </span>','<span style="color:',$color,';" >',number_format($gap_EBITDA_percent_prev * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						}
					}
					else
					{
						$color = null;
						if ($neighbor_Q_gap_EBITDA_percent_E < $neighbor_Q_gap_EBITDA_percent_prev)
						{
							$color = $color_good;
						}
						else
						{
							$color = $color_bad;
						}
						
						if ($neighbor_Q_gap_EBITDA_percent_E !== null)
						{
							echo '<div>','<span style="width:300px; display:inline-block;" >','EBITDA forecast error (%, abs, our model)',': </span>','<span style="color:',$color,';" >',number_format($neighbor_Q_gap_EBITDA_percent_E * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						}
						
						if ($neighbor_Q_gap_EBITDA_percent_prev !== null)
						{
							echo '<div>','<span style="width:300px; display:inline-block;" >','EBITDA forecast error (%, abs, previous year)',': </span>','<span style="color:',$color,';" >',number_format($neighbor_Q_gap_EBITDA_percent_prev * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						}
					}
					
					// --------
					
					if ($annulized_all != 0)
					{
						$color = null;
						if ($annulized_smart > $annulized_all)
						{
							$color = $color_good;
						}
						else
						{
							$color = $color_bad;
						}
						
						echo '<br>',PHP_EOL;
						echo '<div>','<b>','Backtest efficiency','</b>','</div>',PHP_EOL;
						echo '<div>','<span style="width:300px; display:inline-block;" >','Annualized return (high potential)',': </span>','<span style="color:',$color,';" >',number_format($annulized_smart * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						echo '<div>','<span style="width:300px; display:inline-block;" >','Annualized return (all the time)',': </span>','<span style="color:',$color,';" >',number_format($annulized_all * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						
						if ($SHORT_ON_annulized_all != 0)
						{
							$color = null;
							if ($SHORT_ON_annulized_smart > $SHORT_ON_annulized_all)
							{
								$color = $color_good;
							}
							else
							{
								$color = $color_bad;
							}
							
							echo '<br>',PHP_EOL;
							echo '<div>','<span style="width:300px; display:inline-block;" >','Annualized return with short (high potential)',': </span>','<span style="color:',$color,';" >',number_format($SHORT_ON_annulized_smart * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
							echo '<div>','<span style="width:300px; display:inline-block;" >','Annualized return with short (all the time)',': </span>','<span style="color:',$color,';" >',number_format($SHORT_ON_annulized_all * 100, 1, '.', ''),'%','</span>','</div>',PHP_EOL;
						}
					}
					
				echo '</div>',PHP_EOL;
			}
			
			// ------------
			
			// ссылка на страницу полного бэктеста компании
			
			echo 
				'<div style="margin:18px 0px 22px 0px;" >',
					'<a style="color:#175996; text-decoration:underline; font-size:14px;" href="/strategy_comm_Wd.php?name=',$ticker,'&short_available=1" target="_blank" >',
						$lang_tr['GC_backtest_link'],
					'</a>',
				'</div>',
				PHP_EOL;
			
			// ------------
			
			echo '<table style="font-size:12px; text-align:right;" id="_GC_costs_table_1" >',PHP_EOL;
			
				echo '<tr>',PHP_EOL;
					
					echo '<th>','Q','</th>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<th>','Revenue','</th>',PHP_EOL;
					echo '<th>','Revenue X','</th>',PHP_EOL;
					echo '<th>','Revenue E','</th>',PHP_EOL;
					echo '<th>','Revenue diff','</th>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<th>','EBITDA','</th>',PHP_EOL;
					echo '<th>','EBITDA X','</th>',PHP_EOL;
					echo '<th>','EBITDA E','</th>',PHP_EOL;
					echo '<th>','EBITDA diff','</th>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<th>','Cost','</th>',PHP_EOL;
					echo '<th>','Cost X','</th>',PHP_EOL;
					echo '<th>','Cost E','</th>',PHP_EOL;
					echo '<th>','Cost diff','</th>',PHP_EOL;
					
					/*
					echo '<th style="background-color:#CBFF65;" >','Rev Weight','</th>',PHP_EOL;
					echo '<th style="background-color:#CBFF65;" >','Used','</th>',PHP_EOL;
					*/
					
					/*
					echo '<th>','','</th>',PHP_EOL;
					echo '<th>','Cost E0','</th>',PHP_EOL;
					echo '<th>','Cost diff0','</th>',PHP_EOL;
					*/
					
				echo '</tr>',PHP_EOL;
				
			for ($i = 0; $i < sizeOf($objects); $i++)
			{
				if ($i % 4 == 0) echo '<tr><td>&nbsp;</td></tr>',PHP_EOL;
				
				echo '<tr>',PHP_EOL;
					
					echo '<td>',$objects[$i]['Q'],'</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',number_format($objects[$i]['Revenue'],0,'.',' '),'</td>',PHP_EOL;
					if (isset($objects[$i]['Revenue_X'])) echo '<td class="_GC_costs_table_td_X" >',number_format($objects[$i]['Revenue_X'],3,'.',''),'</td>',PHP_EOL; else echo '<td>','','</td>',PHP_EOL;
					if (isset($objects[$i]['Revenue_E'])) echo '<td>',number_format($objects[$i]['Revenue_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					if (isset($objects[$i]['Revenue_E'])) echo '<td style="background-color:#EEFFEE;" >',number_format($objects[$i]['Revenue'] - $objects[$i]['Revenue_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',number_format($objects[$i]['EBITDA'],0,'.',' '),'</td>',PHP_EOL;
					if (isset($objects[$i]['EBITDA_X'])) echo '<td class="_GC_costs_table_td_X" >',number_format($objects[$i]['EBITDA_X'],3,'.',''),'</td>',PHP_EOL; else echo '<td>','','</td>',PHP_EOL;
					if (isset($objects[$i]['EBITDA_E'])) echo '<td>',number_format($objects[$i]['EBITDA_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					if (isset($objects[$i]['EBITDA_E'])) echo '<td style="background-color:#EEFFEE;" >',number_format($objects[$i]['EBITDA'] - $objects[$i]['EBITDA_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',number_format($objects[$i]['Cost'],0,'.',' '),'</td>',PHP_EOL;
					if (isset($objects[$i]['Cost_X_not_mod'])) echo '<td class="_GC_costs_table_td_X" >',number_format($objects[$i]['Cost_X_not_mod'],3,'.',''),'</td>',PHP_EOL; else echo '<td>','','</td>',PHP_EOL;
					if (isset($objects[$i]['Cost_E'])) echo '<td>',number_format($objects[$i]['Cost_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					if (isset($objects[$i]['Cost_E'])) echo '<td style="background-color:#EEFFEE;" >',number_format($objects[$i]['Cost'] - $objects[$i]['Cost_E'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					
					/*
					if (isset($objects[$i]['Rev_Weight'])) echo '<td style="background-color:#CBFF65;" >',number_format($objects[$i]['Rev_Weight'],3,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					if (isset($objects[$i]['Rev_Weight_Used'])) echo '<td style="background-color:#CBFF65;" >',number_format($objects[$i]['Rev_Weight_Used'],3,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					*/
					
					/*
					echo '<td>',' ','</td>',PHP_EOL;
					if (isset($objects[$i]['Cost_E_not_mod'])) echo '<td>',number_format($objects[$i]['Cost_E_not_mod'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					if (isset($objects[$i]['Cost_E_not_mod'])) echo '<td style="background-color:#EEFFEE;" >',number_format($objects[$i]['Cost'] - $objects[$i]['Cost_E_not_mod'],0,'.',' '),'</td>',PHP_EOL; else echo '<td>','</td>',PHP_EOL;
					*/
					
				echo '</tr>',PHP_EOL;
			}
				echo '<tr><td>&nbsp;</td></tr>',PHP_EOL;
			
				echo '<tr>',PHP_EOL;
					
					echo '<td><b>','AVG','</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($rev_diff_all,0,'.',' '),'</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($ebitda_diff_all,0,'.',' '),'</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($cost_diff_all,0,'.',' '),'</b></td>',PHP_EOL;
					
					/*
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					*/
					
					/*
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format(array_sum($cost_diff_arr_0) / sizeOf($cost_diff_arr_0),0,'.',' '),'</b></td>',PHP_EOL;
					*/
					
				echo '</tr>',PHP_EOL;
			
				echo '<tr>',PHP_EOL;
					echo '<td><b>','AVG ABS','</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($rev_diff_all_abs,0,'.',' '),'</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($ebitda_diff_all_abs,0,'.',' '),'</b></td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format($cost_diff_all_abs,0,'.',' '),'</b></td>',PHP_EOL;
					
					/*
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					*/
					
					/*
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td>',' ','</td>',PHP_EOL;
					echo '<td><b>',number_format(array_sum($cost_diff_arr_abs_0) / sizeOf($cost_diff_arr_abs_0),0,'.',' '),'</b></td>',PHP_EOL;
					*/
					
				echo '</tr>',PHP_EOL;
			
			echo '</table>',PHP_EOL;
		echo '</div>',PHP_EOL;
	}
}

?>