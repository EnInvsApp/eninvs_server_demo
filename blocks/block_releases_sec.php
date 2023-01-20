<?php


// include '/html/php_db/calc_sec_form_10.php';
// include '/html/php_db/calc_sec_form_8.php';
// include '/html/php_db/calc_sec_form_6.php';
include '/html/php_db/calc_sec_forms_all.php';

$all_sec_data = [];

if (sizeOf($obj_sec_form_10) > 0 or sizeOf($obj_sec_form_8) > 0 or sizeOf($obj_sec_form_6) > 0)
{
	$sec_10_select = false;
	if($obj_sec_form_10 != null){
		$sec_10_select = true;
		foreach ($obj_sec_form_10 as $value) {
			$all_sec_data[] = [
				'ID' => $value['ID'],
				'comp_name' => $value['comp_name'],
				'ET_published_DT' => $value['ET_published_DT'],
				'q' => $value['q'],
				'form' => 10,
				'is_report' => $value['is_report']
			];
		}
	}

	$sec_8_select = false;
	if($obj_sec_form_8 != null){
		$sec_8_select = true;
		foreach ($obj_sec_form_8 as $value) {
			$all_sec_data[] = [
				'ID' => $value['ID'],
				'comp_name' => $value['comp_name'],
				'ET_published_DT' => $value['ET_published_DT'],
				'q' => $value['q'],
				'form' => 8,
				'is_report' => $value['is_report']
			];
		}
	}

	$sec_6_select = false;
	if($obj_sec_form_6 != null){
		$sec_6_select = true;
		foreach ($obj_sec_form_6 as $value) {
			$all_sec_data[] = [
				'ID' => $value['ID'],
				'comp_name' => $value['comp_name'],
				'ET_published_DT' => $value['ET_published_DT'],
				'q' => $value['q'],
				'form' => 6,
				'is_report' => $value['is_report']
			];
		}
	}

	for ($i = 0; $i < sizeOf($all_sec_data); $i++)
		for ($y = 1; $y < sizeOf($all_sec_data); $y++)
			if ($all_sec_data[$y]['ET_published_DT'] > $all_sec_data[$y - 1]['ET_published_DT'])
			{
				$temp = $all_sec_data[$y];
				$all_sec_data[$y] = $all_sec_data[$y - 1];
				$all_sec_data[$y - 1] = $temp;
			}

	echo '<div id="block_sec_form_10" class="float1 border1" >',PHP_EOL;
		
		echo '<h3 style="margin:2px 0px;"><span class="highlighted_text_about_2">','SEC forms','</span></h3>',PHP_EOL;
		
		echo '<input type="checkbox" id="hd-6" class="hide"/>',PHP_EOL;
		echo '<label for="hd-6" >'.$lang_tr["ltr_00161"].'</label>',PHP_EOL; // show / hide
		
		echo '<div style="padding-left:150px;" >',PHP_EOL;

		echo '<div id="btn_sort_sec_group">';

			if ($sec_10_select + $sec_8_select + $sec_6_select > 1) 
			{
				echo '<button id="btn_sort_sec_all" class="btn_sort_sec btn_sort_sec_select" onclick="sort_sec_form(\'all\')">All</button>';
				if($sec_10_select){
					echo '<button id="btn_sort_sec_10" class="btn_sort_sec" onclick="sort_sec_form(\'10\')">SEC form 10</button>';
				}
				if($sec_8_select){
					echo '<button id="btn_sort_sec_8" class="btn_sort_sec" onclick="sort_sec_form(\'8\')">SEC form 8</button>';
				}
				if($sec_6_select){
					echo '<button id="btn_sort_sec_6" class="btn_sort_sec" onclick="sort_sec_form(\'6\')">SEC form 6</button>';	
				}
			}
			
		echo '</div>';

		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:block;" id="block_sec_all_show_rep" onclick="block_sec_all_click_fin()" >Show financial reports only</p>',PHP_EOL;
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;"  id="block_sec_all_show_all" onclick="block_sec_all_click_all()" >Show all press releases</p>',PHP_EOL;
		
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;" id="block_sec_8_show_rep" onclick="block_sec_8_click_fin()" >Show financial reports only</p>',PHP_EOL;
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;"  id="block_sec_8_show_all" onclick="block_sec_8_click_all()" >Show all press releases</p>',PHP_EOL;
		
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;" id="block_sec_10_show_rep" onclick="block_sec_10_click_fin()" >Show financial reports only</p>',PHP_EOL;
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;"  id="block_sec_10_show_all" onclick="block_sec_10_click_all()" >Show all press releases</p>',PHP_EOL;
		
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;" id="block_sec_6_show_rep" onclick="block_sec_6_click_fin()" >Show financial reports only</p>',PHP_EOL;
		echo '<p style="padding-left:20px; text-decoration:underline; cursor:pointer; display:none;"  id="block_sec_6_show_all" onclick="block_sec_6_click_all()" >Show all press releases</p>',PHP_EOL;
		
		for ($i = 0; $i < sizeOf($all_sec_data); $i++)
		{
			$id_sec_form = 'sec10';

			if ($all_sec_data[$i]['form'] == 8)
			{
				$id_sec_form = 'sec8';
			}
			else if ($all_sec_data[$i]['form'] == 6)
			{
				$id_sec_form = 'sec6';
			}
				// $link_mini = '/press_release.php?source=sec&form_type=6&id='.$all_sec_data[$i]['ID'];
			$link_mini = '/press_release.php?source=sec&form_type='.$all_sec_data[$i]['form'].'&id='.$all_sec_data[$i]['ID'];
			$press_style_back = 'background-color:#F2FFFC;';
			$class_0 = 'press_can_be_hidden_sec_'.$all_sec_data[$i]['form'];

			$report_name = ' published news for ';
			if ($all_sec_data[$i]['is_report'])
			{
				$press_style_back = 'background-color:#D0FFC6;';
				$class_0 = '';
				$report_name = ' reported for ';
			}
			echo '<a class="',$class_0,' ',$id_sec_form,'" target="_blank" rel="noopener noreferrer" href="',$link_mini,'" >',PHP_EOL;
				echo '<div class="border1" style="float:left; margin:10px 20px; padding:20px; ',$press_style_back,'" >',PHP_EOL;
					echo '<div style="font-size: 18px; font-weight: bold; text-decoration: underline; display:inline-block; width:150px; vertical-align:top;">SEC form ',$all_sec_data[$i]['form'],'</div>',PHP_EOL;
					echo '<div style="display:inline-block; width:150px; vertical-align:top;">',substr($all_sec_data[$i]['ET_published_DT'], 0, 16),' ET','</div>',PHP_EOL;
					echo '<div style="display:inline-block; width:400px; vertical-align:top; margin-right:20px;">',$all_sec_data[$i]['comp_name'],$report_name, $all_sec_data[$i]['q'],'</div>',PHP_EOL;
					
				echo '</div>',PHP_EOL;
			echo '</a>',PHP_EOL;
			// }
			// else
			// {
				

				// $link_mini = '/press_release.php?source=sec&form_type='.$all_sec_data[$i]['form'].'&id='.$all_sec_data[$i]['ID'];
				// $press_style_back = 'background-color:#F2FFFC;';
				// echo '<a class="',$id_sec_form,'" target="_blank" rel="noopener noreferrer" href="',$link_mini,'" >',PHP_EOL;
				// 	echo '<div class="border1" style="float:left; margin:10px 20px; padding:20px; ',$press_style_back,'" >',PHP_EOL;
				// 		echo '<div style="font-size: 18px; font-weight: bold; text-decoration: underline; display:inline-block; width:150px; vertical-align:top;">SEC form ',$all_sec_data[$i]['form'],'</div>',PHP_EOL;
				// 		echo '<div style="display:inline-block; width:150px; vertical-align:top;">',substr($all_sec_data[$i]['ET_published_DT'], 0, 16),' ET','</div>',PHP_EOL;
				// 		echo '<div style="display:inline-block; width:400px; vertical-align:top; margin-right:20px;">',$all_sec_data[$i]['comp_name'],' reported for ', $all_sec_data[$i]['q'],'</div>',PHP_EOL;
						
				// 	echo '</div>',PHP_EOL;
				// echo '</a>',PHP_EOL;
			// }
		}
			
		echo '</div>',PHP_EOL;
	echo '</div>',PHP_EOL;
}
?>

<script>
function sort_sec_form(form) {
	console.log(form);

	if(form == 'all'){
		$(".press_can_be_hidden_sec_6").css('display','block');
		$(".press_can_be_hidden_sec_8").css('display','block');
		$(".press_can_be_hidden_sec_10").css('display','block');

		$("#block_sec_all_show_rep").css('display','block');
		$("#block_sec_all_show_all").css('display','none');

		$("#block_sec_6_show_all").css('display','none');
		$("#block_sec_6_show_rep").css('display','none');

		$("#block_sec_8_show_all").css('display','none');
		$("#block_sec_8_show_rep").css('display','none');

		$("#block_sec_10_show_all").css('display','none');
		$("#block_sec_10_show_rep").css('display','none');

		$('#btn_sort_sec_all').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_all').addClass('btn_sort_sec_select');

		$('#btn_sort_sec_10').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_8').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_6').removeClass('btn_sort_sec_select');

		$(".sec10").removeClass('hidden_sec');
		$(".sec8").removeClass('hidden_sec');
		$(".sec6").removeClass('hidden_sec');

		$(".sec10").addClass('show_sec');
		$(".sec8").addClass('show_sec');
		$(".sec6").addClass('show_sec');
	}

	if(form == '10'){
		$(".press_can_be_hidden_sec_6").css('display','none');
		$(".press_can_be_hidden_sec_8").css('display','none');
		$(".press_can_be_hidden_sec_10").css('display','block');

		$("#block_sec_all_show_rep").css('display','none');
		$("#block_sec_all_show_all").css('display','none');

		$("#block_sec_6_show_all").css('display','none');
		$("#block_sec_6_show_rep").css('display','none');

		$("#block_sec_8_show_all").css('display','none');
		$("#block_sec_8_show_rep").css('display','none');

		$("#block_sec_10_show_all").css('display','none');
		$("#block_sec_10_show_rep").css('display','block');


		$('#btn_sort_sec_10').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_10').addClass('btn_sort_sec_select');

		$('#btn_sort_sec_all').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_8').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_6').removeClass('btn_sort_sec_select');

		$(".sec10").removeClass('hidden_sec');
		$(".sec8").removeClass('show_sec');
		$(".sec6").removeClass('show_sec');

		$(".sec10").addClass('show_sec');
		$(".sec8").addClass('hidden_sec');
		$(".sec6").addClass('hidden_sec');
	}

	if(form == '8'){
		$(".press_can_be_hidden_sec_6").css('display','none');
		$(".press_can_be_hidden_sec_8").css('display','block');
		$(".press_can_be_hidden_sec_10").css('display','none');

		$("#block_sec_all_show_rep").css('display','none');
		$("#block_sec_all_show_all").css('display','none');

		$("#block_sec_6_show_all").css('display','none');
		$("#block_sec_6_show_rep").css('display','none');

		$("#block_sec_8_show_all").css('display','none');
		$("#block_sec_8_show_rep").css('display','block');

		$("#block_sec_10_show_all").css('display','none');
		$("#block_sec_10_show_rep").css('display','none');


		$('#btn_sort_sec_8').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_8').addClass('btn_sort_sec_select');

		$('#btn_sort_sec_10').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_all').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_6').removeClass('btn_sort_sec_select');

		$(".sec10").removeClass('show_sec');
		$(".sec8").removeClass('hidden_sec');
		$(".sec6").removeClass('show_sec');

		$(".sec10").addClass('hidden_sec');
		$(".sec8").addClass('show_sec');
		$(".sec6").addClass('hidden_sec');
	}

	if(form == '6'){
		$(".press_can_be_hidden_sec_6").css('display','block');
		$(".press_can_be_hidden_sec_8").css('display','none');
		$(".press_can_be_hidden_sec_10").css('display','none');
	
		$("#block_sec_all_show_rep").css('display','none');
		$("#block_sec_all_show_all").css('display','none');

		$("#block_sec_6_show_all").css('display','none');
		$("#block_sec_6_show_rep").css('display','block');

		$("#block_sec_8_show_all").css('display','none');
		$("#block_sec_8_show_rep").css('display','none');

		$("#block_sec_10_show_all").css('display','none');
		$("#block_sec_10_show_rep").css('display','none');


		$('#btn_sort_sec_6').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_6').addClass('btn_sort_sec_select');

		$('#btn_sort_sec_10').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_8').removeClass('btn_sort_sec_select');
		$('#btn_sort_sec_all').removeClass('btn_sort_sec_select');

		$(".sec10").removeClass('show_sec');
		$(".sec8").removeClass('show_sec');
		$(".sec6").removeClass('hidden_sec');

		$(".sec10").addClass('hidden_sec');
		$(".sec8").addClass('hidden_sec');
		$(".sec6").addClass('show_sec');
	}
}

function block_sec_all_click_fin()
{
	$(".press_can_be_hidden_sec_6").css('display','none');
	$(".press_can_be_hidden_sec_8").css('display','none');
	$(".press_can_be_hidden_sec_10").css('display','none');

	$("#block_sec_all_show_rep").css('display','none');
	$("#block_sec_all_show_all").css('display','block');
}

function block_sec_all_click_all()
{
	$(".press_can_be_hidden_sec_6").css('display','block');
	$(".press_can_be_hidden_sec_8").css('display','block');
	$(".press_can_be_hidden_sec_10").css('display','block');

	$("#block_sec_all_show_rep").css('display','block');
	$("#block_sec_all_show_all").css('display','none');
}

function block_sec_6_click_fin()
{
	$(".press_can_be_hidden_sec_6").css('display','none');

	$("#block_sec_6_show_rep").css('display','none');
	$("#block_sec_6_show_all").css('display','block');
}

function block_sec_6_click_all()
{
	$(".press_can_be_hidden_sec_6").css('display','block');

	$("#block_sec_6_show_rep").css('display','block');
	$("#block_sec_6_show_all").css('display','none');
}

function block_sec_8_click_fin()
{
	$(".press_can_be_hidden_sec_8").css('display','none');

	$("#block_sec_8_show_rep").css('display','none');
	$("#block_sec_8_show_all").css('display','block');
}

function block_sec_8_click_all()
{
	$(".press_can_be_hidden_sec_8").css('display','block');

	$("#block_sec_8_show_rep").css('display','block');
	$("#block_sec_8_show_all").css('display','none');
}

function block_sec_10_click_fin()
{
	$(".press_can_be_hidden_sec_10").css('display','none');

	$("#block_sec_10_show_rep").css('display','none');
	$("#block_sec_10_show_all").css('display','block');
}

function block_sec_10_click_all()
{
	$(".press_can_be_hidden_sec_10").css('display','block');

	$("#block_sec_10_show_rep").css('display','block');
	$("#block_sec_10_show_all").css('display','none');
}

</script>