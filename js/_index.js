
$(document).ready(function()
{
    if ($('select').is('#calculator_depo_curr') && $('div').is('#yes_calculator_default'))
	{
		if ($('#calculator_depo_curr').val() == 'RUB')
		{
			$('#calculator_checkbox_label_RF').click();
			calculator_checkbox_onclick_RF();
		}
		if ($('#calculator_depo_curr').val() == 'USD')
		{
			$('#calculator_checkbox_label_RS').click();
			calculator_checkbox_onclick_RS();
			$('#calculator_checkbox_label_TI').click();
			calculator_checkbox_onclick_TI();
			$('#calculator_checkbox_label_GC').click();
			calculator_checkbox_onclick_GC();
		}
	}
	
	if ($('a').is('#screener_a_csv'))
	{
		$('#screener_a_csv').css('display','inline-block');
	}
});

function getCookie(name)
{
	var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

function goFreeTrialPage()
{
	document.location.href = '/upgrade.php';
}

function calculate_check_sub()
{
	$("#check_sub_button_1").prop( "disabled", true);
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	
	key = $('#check_sub_key_').val();
	link = link.concat("key=",key);
	
	window.location.href = link;
}

function calculate_traffic_strategy()
{
	$("#traffic_strategy_button_1").prop( "disabled", true);
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	
	cat = $('#traffic_strategy_categories').val();
	link = link.concat("cat=",cat);
	
	period = $('#traffic_strategy_period').val();
	if (period != null && period != "") link = link.concat("&period=",period);
	
	size = $('#traffic_strategy_size').val();
	if (size != null && size != "") link = link.concat("&size=",size);
	
	evs = $('#traffic_strategy_EVS').val();
	if (evs != null && evs != "") link = link.concat("&evs=",evs);
	
	lep = $('#traffic_strategy_last_EBITDA').val();
	if (lep != null && lep != "") link = link.concat("&lep=",lep);
	
	dir = $('#traffic_strategy_LONG_SHORT').val();
	if (dir != null && dir != "") link = link.concat("&dir=",dir);
	
	window.location.href = link;
}

function cohort_analysis_calc_aum()
{
	$("#cohort_analysis__button_1_aum").prop( "disabled", true);
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	metrix = $('#cohort_analysis_select_aum').val();
	link = link.concat("metrix=",metrix);
	window.location.href = link;
}

function cohort_analysis_calc()
{
	$("#cohort_analysis__button_1").prop( "disabled", true);
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	metrix = $('#cohort_analysis_select').val();
	link = link.concat("sub_type=",metrix);
	window.location.href = link;
}

function calculate_alpha_beta_strategy()
{
	$("#alpha_beta_button_1").prop( "disabled", true);
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	metrix = $('#alpha_beta_Metrix_X').val();
	link = link.concat("metrix=",metrix);
	window.location.href = link;
}

function calculate_alpha_beta_screener()
{
	$("#alpha_beta_button_1").prop( "disabled", true);
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	
	metrix = $('#alpha_beta_Metrix_X').val();
	sector = $('#alpha_beta_Sector'  ).val();
	trend  = $('#alpha_beta_Trend'   ).val();
	sorting = $('#alpha_beta_sort_method').val();
	direction = $('#alpha_beta_sort_direction').val();
	link = link.concat("run=1&metrix=",metrix,"&sector=",sector,"&trend=",trend,"&sorting=",sorting,"&direction=",direction);
	
	cap_0 = $('#alpha_beta_input_cap_min').val();
	cap_1 = $('#alpha_beta_input_cap_max').val();
	rev_hist_0 = $('#alpha_beta_input_Growth_Hist_Revenue_min').val();
	rev_hist_1 = $('#alpha_beta_input_Growth_Hist_Revenue_max').val();
	rev_last_0 = $('#alpha_beta_input_Growth_Last_Revenue_min').val();
	rev_last_1 = $('#alpha_beta_input_Growth_Last_Revenue_max').val();
	EV_sales_0 = $('#alpha_beta_input_EV_sales_min').val();
	EV_sales_1 = $('#alpha_beta_input_EV_sales_max').val();
	Rent_FCF_0 = $('#alpha_beta_input_Rent_FCF_min').val();
	Rent_FCF_1 = $('#alpha_beta_input_Rent_FCF_max').val();
	Beta_0 = $('#alpha_beta_input_Beta_min').val();
	Beta_1 = $('#alpha_beta_input_Beta_max').val();
	Alpha_0 = $('#alpha_beta_input_Alpha_min').val();
	Alpha_1 = $('#alpha_beta_input_Alpha_max').val();
	if (cap_0 != null && cap_0 != "") link = link.concat("&cap_0=",cap_0);
	if (cap_1 != null && cap_1 != "") link = link.concat("&cap_1=",cap_1);
	if (rev_hist_0 != null && rev_hist_0 != "") link = link.concat("&rev_hist_0=",rev_hist_0);
	if (rev_hist_1 != null && rev_hist_1 != "") link = link.concat("&rev_hist_1=",rev_hist_1);
	if (rev_last_0 != null && rev_last_0 != "") link = link.concat("&rev_last_0=",rev_last_0);
	if (rev_last_1 != null && rev_last_1 != "") link = link.concat("&rev_last_1=",rev_last_1);
	if (EV_sales_0 != null && EV_sales_0 != "") link = link.concat("&EV_sales_0=",EV_sales_0);
	if (EV_sales_1 != null && EV_sales_1 != "") link = link.concat("&EV_sales_1=",EV_sales_1);
	if (Rent_FCF_0 != null && Rent_FCF_0 != "") link = link.concat("&Rent_FCF_0=",Rent_FCF_0);
	if (Rent_FCF_1 != null && Rent_FCF_1 != "") link = link.concat("&Rent_FCF_1=",Rent_FCF_1);
	if (Beta_0 != null && Beta_0 != "") link = link.concat("&Beta_0=",Beta_0);
	if (Beta_1 != null && Beta_1 != "") link = link.concat("&Beta_1=",Beta_1);
	if (Alpha_0 != null && Alpha_0 != "") link = link.concat("&Alpha_0=",Alpha_0);
	if (Alpha_1 != null && Alpha_1 != "") link = link.concat("&Alpha_1=",Alpha_1);
	
	window.location.href = link;
}





// ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------ ------





$(function(){
  $('#product_div_1').height($('#product_div_1').width()*1.5);

  $(window).resize(function(){
    $('#product_div_1').height($('#product_div_1').width()*1.5);
  });
});

$(function(){
  $('#div_fully_transp_operations_2').height($('#div_fully_transp_operations_2').width()*1.8);

  $(window).resize(function(){
    $('#div_fully_transp_operations_2').height($('#div_fully_transp_operations_2').width()*1.8);
  });
});

function screener_settings_change()
{
	vl = $("#select_category_US_2").val();
	pname = document.location.href;
	p = pname.indexOf(".php");
	pname = pname.substring(0, p);
	p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
	pname = pname.substring(p + 1);
	vl = vl.replace(" ", "_");
	hrf = "/" + pname + ".php?cat=" + vl;
	
	if
	(
		$("input").is("#gainers_losers_from_date") && 
		(
			vl == "year_gainers" || 
			vl == "year_losers"
		)
	)
	{
		v2 = $("#gainers_losers_from_date").val();
		if (v2.length > 5) hrf += "&dts=" + v2;
	}
	
	document.location.href = (hrf);
}

function RR_strategy_settings_change()
{
	vl = $("#select_RR_strategies").val();
	pname = document.location.href;
	p = pname.indexOf(".php");
	pname = pname.substring(0, p);
	p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
	pname = pname.substring(p + 1);
	vl = vl.replace(" ", "_");
	hrf = "/" + pname + ".php?type=" + vl;
	document.location.href = (hrf);
}

function UI_strategy_settings_change()
{
	vl = $("#select_UI_strategies").val();
	pname = document.location.href;
	p = pname.indexOf(".php");
	pname = pname.substring(0, p);
	p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
	pname = pname.substring(p + 1);
	vl = vl.replace(" ", "_");
	hrf = "/" + pname + ".php?type=" + vl;
	document.location.href = (hrf);
}

function screener_settings_change_JSE()
{
	vl = $("#select_screener_JSE").val();
	pname = document.location.href;
	p = pname.indexOf(".php");
	pname = pname.substring(0, p);
	p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
	pname = pname.substring(p + 1);
	vl = vl.replace(" ", "_");
	hrf = "/" + pname + ".php?cat=" + vl;
	document.location.href = (hrf);
}

$(window).on('pageshow', function(){
	
	showCompanyInfo();
	showCommodityInfo();
	showCurrencyInfo();
	showClientInfo();
	drawTWchart();
	drawTWchart_hybrid();
	comm_reserves_graph();
	main_factor_graph_revenue();
	all_factor_graph_revenue();
	all_factor_graph_revenue_Wd();
	Profitability_graph();
	potential_strategy();
	showQuoteInfo();
	showGraphIndexLevelOnMain();
	showAimPortfolioWd();
	show_chart_traffic();
	key_parameters_graphs();
	
	$("#select_RR_strategies").change(function () { RR_strategy_settings_change(); });
	
	if ($("select").is("#select_RR_strategies"))
	{
		vl = $("#hidden_container_RR_strategies").html();
		$('#select_RR_strategies').val(vl);
	}
	
	$("#select_UI_strategies").change(function () { UI_strategy_settings_change(); });
	
	if ($("select").is("#select_UI_strategies"))
	{
		vl = $("#hidden_container_UI_strategies").html();
		$('#select_UI_strategies').val(vl);
	}
	
	$("#select_screener_JSE").change(function () { screener_settings_change_JSE(); });
	
	if ($("select").is("#select_screener_JSE"))
	{
		vl = $("#hidden_screener_container_JSE").html();
		$('#select_screener_JSE').val(vl);
	}
	
	$("#select_category_US_2").change(function () { screener_settings_change(); });
	$("#gainers_losers_from_date").change(function () { screener_settings_change(); });
	
	if ($("select").is("#select_category_US_2"))
	{
		vl = $("#hidden_category_container_US_2").html();
		$('#select_category_US_2').val(vl);
	}
	
	if ($("input").is("#gainers_losers_from_date"))
	{
		vl = $("#hidden_gainers_losers_from_date").html();
		$('#gainers_losers_from_date').val(vl);
	}
	
	$("#select_about_RF_currency").change(function () {
		vl = $("#select_about_RF_currency").val();
		if (vl == 'USD')
		{
			document.location.href = ("/about.php?RF_graph=USD");
			//document.getElementById('about_RF_div_RUB').style.display = 'none';
			//document.getElementById('about_RF_div_USD').style.display = 'block';
		}
		else
		{
			document.location.href = ("/about.php?RF_graph=RUB");
			//document.getElementById('about_RF_div_USD').style.display = 'none';
			//document.getElementById('about_RF_div_RUB').style.display = 'block';
		}
	});
	
	$("#select_client_stat_depo_currency").change(function () {
		vl = $("#select_client_stat_depo_currency").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("currency", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'USD') document.location.href = hrf + symb + 'currency=USD';
		else             document.location.href = hrf + symb + 'currency=RUB';
	});

	$("#select_US_insider_trades_sort").change(function () {
		vl = $("#select_US_insider_trades_sort").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("sort", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'abs') document.location.href = hrf + symb + 'sort=abs';
		else             document.location.href = hrf + symb + 'sort=rel';
	});

	$("#select_US_insider_trades_table_buy_sell").change(function () {
		vl = $("#select_US_insider_trades_table_buy_sell").val();
		console.log(vl);
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("deals_filter", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'all') document.location.href = hrf + symb + 'deals_filter=all';
		if (vl == 'buy') document.location.href = hrf + symb + 'deals_filter=buy';
		if (vl == 'sell') document.location.href = hrf + symb + 'deals_filter=sell';
	});

	$("#select_US_insider_trades_mode").change(function () {
		vl = $("#select_US_insider_trades_mode").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("mode", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'all') document.location.href = hrf + symb + 'mode=all';
		else             document.location.href = hrf + symb + 'mode=no_comps';
	});

	$("#select_US_insider_trades_period").change(function () {
		vl = $("#select_US_insider_trades_period").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("period", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'week') document.location.href = hrf + symb + 'period=week';
		if (vl == 'month') document.location.href = hrf + symb + 'period=month';
		if (vl == '3month') document.location.href = hrf + symb + 'period=3month';
	});

	$("#select_US_insider_trades_spb").change(function () {
		vl = $("#select_US_insider_trades_spb").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("spb", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == 'all') document.location.href = hrf + symb + 'spb=all';
		if (vl == 'spb') document.location.href = hrf + symb + 'spb=spb';
	});
	
	$("#select_client_stat_diagram_detailed").change(function () {
		vl = $("#select_client_stat_diagram_detailed").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("detailed", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == '1') document.location.href = hrf + symb + 'detailed=1';
		else           document.location.href = hrf + symb + 'detailed=0';
	});
	
	$("#select_client_stat_graph_corrected").change(function () {
		vl = $("#select_client_stat_graph_corrected").val();
		
		hrf = document.location.href;
		p = hrf.indexOf('#');
		if (p > 0) hrf = hrf.substring(0, p);
		hrf = removeParam("inout", hrf);
		symb = '?';
		if (hrf.indexOf(symb) >= 0) symb = '&';
		
		if (vl == '1') document.location.href = hrf + symb + 'inout=1';
		else           document.location.href = hrf + symb + 'inout=0';
	});
	
	$("#select_emitent_1").change(function () {
		vl = $("#select_emitent_1").val();
		pname = document.location.href;
		p = pname.indexOf(".php");
		pname = pname.substring(0, p);
		p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
		pname = pname.substring(p + 1);
		document.location.href = ("/" + pname + ".php?name=" + vl);
	});
	
	$("#select_client_1").change(function () {
		vl = $("#select_client_1").val();
		pname = document.location.href;
		p = pname.indexOf(".php");
		pname = pname.substring(0, p);
		p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
		pname = pname.substring(p + 1);
		document.location.href = ("/" + pname + ".php?client=" + vl);
	});
	
	$("#select_quote_emitent").change(function () {
		vl = $("#select_quote_emitent").val();
		pname = document.location.href;
		p = pname.indexOf(".php");
		pname = pname.substring(0, p);
		p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
		pname = pname.substring(p + 1);
		document.location.href = ("/" + pname + ".php?name=" + vl);
	});
	
	$("#select_intraday_potential_emitent").change(function () {
		vl = $("#select_intraday_potential_emitent").val();
		pname = document.location.href;
		p = pname.indexOf(".php");
		pname = pname.substring(0, p);
		p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
		pname = pname.substring(p + 1);
		document.location.href = ("/" + pname + ".php?name=" + vl);
	});
	
	$("#select_commodity_1").change(function () {
		vl = $("#select_commodity_1").val();
		document.location.href = ("/commodity.php?id=" + vl);
	});
	
	$("#select_currency_1").change(function () {
		vl = $("#select_currency_1").val();
		document.location.href = ("/currency.php?id=" + vl);
	});
	
	// -----------------------------------------------------------------------
	
	/*
	$('#html-content-holder-US').on('click', function ()
	{
		window.setTimeout(function(){
			html2canvas($('#html-content-holder-US'), 
			{
				onrendered: function (canvas) 
				{
					$('#previewImage-US').append(canvas);
				}
			});
			$('#html-content-holder-US').css('display','none');
        }, 0);
		
	});
	
	$('#html-content-holder-Wd').on('click', function ()
	{
		html2canvas($('#html-content-holder-Wd'), 
		{
			onrendered: function (canvas) 
			{
				$('#previewImage-Wd').append(canvas);
			}
		});
		$('#html-content-holder-Wd').css('display','none');
	});
	
	$('#html-content-holder-RS').on('click', function ()
	{
		window.setTimeout(function(){
			html2canvas($('#html-content-holder-RS'), 
			{
				onrendered: function (canvas) 
				{
					$('#previewImage-RS').append(canvas);
				}
			});
			$('#html-content-holder-RS').css('display','none');
        }, 0);
	});
	*/
	
	//$('#html-content-holder-US').click();
	//$('#html-content-holder-Wd').click();
	//$('#html-content-holder-RS').click();
})

function show_chart_traffic()
{
	if ($("div").is("#chart_container_traffic"))
	{
		var result = $("#data_traffic").html();
		result = JSON.parse(result);
		var dataPointsValue = [];
		for (var i = 0; i <= result.length - 1; i++) {
			dataPointsValue.push({
				label: result[i].Month,
				y: parseFloat(result[i].Visits_M)
			});
		}
	
		var chart = new CanvasJS.Chart("chart_container_traffic", {
			  backgroundColor:"transparent",
			  axisY:  { gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			  legend: { fontSize: 13 },
			  
			  data: 
			  [
				  {
					type: "area",
					color: "#78c1f5",
					dataPoints: dataPointsValue
				  }
			  ]
		});
		chart.render();
	}
}

function show_search_window()
{
	document.getElementById('div_glass_1').style.display = 'none';
	document.getElementById('div_search_1').style.visibility  = 'visible';
	document.getElementById('ls_query').focus();
	document.getElementById('ls_query').select();
}

function language_chosen_container_RU_onclick()
{
	hrf = document.location.href;
	p = hrf.indexOf('#');
	if (p > 0) hrf = hrf.substring(0, p);
	hrf = removeParam("lang", hrf);
	symb = '?';
	if (hrf.indexOf(symb) >= 0) symb = '&';
	document.location.href = hrf + symb + 'lang=RU';
}

function language_chosen_container_EN_onclick()
{
	hrf = document.location.href;
	p = hrf.indexOf('#');
	if (p > 0) hrf = hrf.substring(0, p);
	hrf = removeParam("lang", hrf);
	symb = '?';
	if (hrf.indexOf(symb) >= 0) symb = '&';
	document.location.href = hrf + symb + 'lang=EN';
}

function RS_performance_show_more_button_1_onclick()
{
	document.getElementById('RS_performance_show_more_button_1').style.display = 'none';
	for (let el of document.querySelectorAll('.RS_performance_tr_hide')) el.style.display = 'table';
}

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
	rtn = rtn.replace("?&","?");
	if (rtn.slice(-1) == '?') rtn = rtn.substring(0, rtn.length - 1);
    return rtn;
}

function showAimPortfolioWd()
{
	if ($("div").is("#portfolio_chart_aim_Wd"))
	{
		$.ajax({
			type: 'POST',
			url: 'php_db/ajax/get_AimPortfolio_Wd.php',
			data: { },
			success: function(inf){
				var result = JSON.parse(inf);
				var dataPointsValue = [];
				for (var i = 0; i <= result.length - 1; i++) {
					dataPointsValue.push({
						label: result[i].Name,
						y: parseFloat(result[i].Share*100)
					});
				}
				
				CanvasJS.addColorSet("canvasJS_ColorSet_1",
				 [
					"#3D5A80",
					"#98C1D9",
					"#E0FBFC",
					"#EE6C4D",
					"#293241",
					"#26395E",
					"#5F7C92",
					"#8CA0A0",
					"#AE4430",
					"#1A2031",
					"#6F444E",
					"#C8A2A8",
					"#F5E7E7",
					"#ED534C",
					"#3A2B2E"
				]);
								
				var chart = new CanvasJS.Chart("portfolio_chart_aim_Wd", {
					  backgroundColor:"transparent",
					  colorSet:  "canvasJS_ColorSet_1",
					  data: 
					  [
						  {
							type: "pie",
							startAngle: 270,
							yValueFormatString: "##0.0\"%\"",
							indexLabel: "{label} {y}",
							dataPoints: dataPointsValue
						  }
					  ]
				});
				chart.render();
			}
		});
	}
}

function showGraphIndexLevelOnMain()
{
	if ($("div").is("#graph_invest_level_on_main"))
	{
		$.ajax({
			type: 'POST',
			url: 'php_db/ajax/get_Invest_Level_Index_chart.php',
			data: { },
			success: function(inf){
				var result = JSON.parse(inf);
				var dataPointsValue = [];
				var dataPointsValue_p75 = [];
				var dataPointsProgr = [];
				for (var i = 0; i <= result.length - 1; i++) {
					dataPointsValue.push({
						time: result[i].D,
						value: parseFloat(result[i].L) * 100
					});
					dataPointsValue_p75.push({
						time: result[i].D,
						value: parseFloat(result[i].p75) * 100
					});
				}

				let chart = LightweightCharts.createChart(document.getElementById('graph_invest_level_on_main'), {
					mode: LightweightCharts.PriceScaleMode.Percentage,
					localization: {
						/*priceFormatter: price =>
							// add $ sign before price
							price + '%'
						,*/
						locale: 'en-us',
					},
					rightPriceScale: {
						visible: false,
					},
					leftPriceScale: {
						priceScaleId: 'left',
						visible: true,
						autoScale: true,
						alignLabels: true,

						scaleMargins: {
							top: 0.1,
							bottom: 0.1,
						},
						//mode: LightweightCharts.PriceScaleMode.IndexedTo100,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					/*handleScale: {
						axisPressedMouseMove: false,
						mouseWheel: false,
						pinch: false,
						price: false,
					},*/
					timeScale: {
						rightOffset: 120,
						fixRightEdge: true,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					layout: {
						backgroundColor: '#ffffff',
						textColor: '#000000',
					},
					grid: {
						vertLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
						horzLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
					},
				});

				let areaSeries = chart.addAreaSeries({
					lineColor: '#6783A0',
					showInLegend: true,
					legendText: 'Invest Level Index',
					lineWidth: 2,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});
				
				let extraSeries = chart.addAreaSeries({
	 				lineColor: '#1868C1',
					showInLegend: true,
					legendText: 'percentile',
	 				lineWidth: 1,
	 				bottomColor: 'transparent',
	 				topColor: 'transparent',
	 			});
	 			
	 			areaSeries.setData(dataPointsValue);
	 			extraSeries.setData(dataPointsValue_p75);
				
				chart.timeScale().fitContent();
				/*var chart = new CanvasJS.Chart("graph_invest_level_on_main", {
					  backgroundColor:"transparent",
					  axisY:  { valueFormatString:"########.#%", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
					  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
					  legend: { fontSize: 13 },
					
					  data: 
					  [
						  {
							type: "line",
							yValueFormatString:"########.#%",
							color: "#78c1f5",
							dataPoints: dataPointsValue
						  }
						//,
						//{
						//  type: "line",
						//  yValueFormatString:"########.#%",
						//  color: "#F5B922",
						//  dataPoints: dataPointsProgr
						//}
					  ]
				});
				chart.render();*/
			}
		});
	}
}

// Новый код
function Profitability_graph() {
	

	// Конец нового кода
/*
function Profitability_graph() {
	if ($("div").is("#chart_profitability_RF_RUB")) {
		$.ajax({
			type: 'POST',
			url: 'php_db/ajax/get_profitability_chart_RF_RUB.php',
			data: {},
			success: function (inf) {
				var result = JSON.parse(inf);
				var dataPointsValue = [];
				var dataPointsIMOEX = [];
				var dataPoints_2015 = [];
				var dataPoints_2016 = [];
				var dataPoints_2017 = [];
				var dataPoints_2018 = [];
				var dataPoints_2019 = [];
				var dataPoints_2020 = [];
				for (var i = 0; i <= result.length - 1; i++) {
					dataPointsValue.push({
						label: result[i].D,
						y: parseFloat(result[i].Value)
					});
					dataPointsIMOEX.push({
						label: result[i].D,
						y: parseFloat(result[i].IMOEX)
					});
					dataPoints_2015.push({
						label: result[i].D,
						y: parseFloat(result[i].v2015)
					});
					dataPoints_2016.push({
						label: result[i].D,
						y: parseFloat(result[i].v2016)
					});
					dataPoints_2017.push({
						label: result[i].D,
						y: parseFloat(result[i].v2017)
					});
					dataPoints_2018.push({
						label: result[i].D,
						y: parseFloat(result[i].v2018)
					});
					dataPoints_2019.push({
						label: result[i].D,
						y: parseFloat(result[i].v2019)
					});
					dataPoints_2020.push({
						label: result[i].D,
						y: parseFloat(result[i].v2020)
					});
				}
				var chart = new CanvasJS.Chart("chart_profitability_RF_RUB", {
					backgroundColor: "transparent",
					axisY: {
						valueFormatString: "########",
						gridThickness: 0,
						gridColor: "#ECECEC",
						labelFontColor: "#6783A0"
					},
					axisX: {gridColor: "#ECECEC", labelFontColor: "#6783A0"},
					data:
						[
							{
								type: "line",
								showInLegend: false,
								legendText: "Strategy",
								yValueFormatString: "########",
								color: "#EBD441",
								dataPoints: dataPointsValue
							},
							{
								type: "line",
								showInLegend: false,
								legendText: "IMOEX Index",
								yValueFormatString: "########",
								color: "#B8B9CA",
								dataPoints: dataPointsIMOEX
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2015
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2016
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2017
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2018
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2019
							},
							{
								type: "line",
								lineDashType: "shortDash",
								lineThickness: 1,
								yValueFormatString: "########",
								color: "#999999",
								dataPoints: dataPoints_2020
							}
						]
				});
				chart.render();
			}
		});
	}
*/

	
	// if ($("div").is("#chart_profitability_RF_USD"))
	// {
	// 	$.ajax({
	// 		  type: 'POST',
	// 		  url: 'php_db/ajax/get_profitability_chart_RF_USD.php',
	// 		  data: { },
	// 		  success: function(inf){
	// 				var result = JSON.parse(inf);

	// 				var dataPointsValue = [];
	// 				var dataPointsIMOEX = [];
	// 				var dataPoints_2015 = [];
	// 				var dataPoints_2016 = [];
	// 				var dataPoints_2017 = [];
	// 				var dataPoints_2018 = [];
	// 				var dataPoints_2019 = [];
	// 				var dataPoints_2020 = [];
	// 				for (var i = 0; i <= result.length - 1; i++) {
	// 					dataPointsValue.push({
	// 			        time: result[i].D,
	// 						value: parseFloat(result[i].Value)
	// 			      });
	// 					dataPointsIMOEX.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].IMOEX)
	// 				  });
	// 					dataPoints_2015.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].v2015)
	// 					  });
	// 					dataPoints_2016.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].v2016)
	// 					  });
	// 					dataPoints_2017.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].v2017)
	// 					  });
	// 					dataPoints_2018.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].v2018)
	// 					  });
	// 					dataPoints_2019.push({
	// 						time: result[i].D,
	// 						value: parseFloat(result[i].v2019)
	// 					  });
	// 					dataPoints_2020.push({
	// 						time: result[i].D,
	// 					    value: parseFloat(result[i].v2020)
	// 					  });
	// 			    }
	// 			  let allvalues = dataPointsValue.concat(dataPoints_2015, dataPoints_2016,
	// 				  dataPoints_2017, dataPoints_2018, dataPoints_2019, dataPoints_2020);
	// 			  let chart = LightweightCharts.createChart('chart_profitability_RF_USD', {

	// 				  localization: {
	// 					  locale: 'en-us',
	// 				  },
	// 				  rightPriceScale: {
	// 					  visible: false,
	// 				  },

	// 				  leftPriceScale: {
	// 					  priceScaleId: 'left',
	// 					  visible: true,
	// 					  autoScale: true,
	// 					  alignLabels: true,
	// 					  scaleMargins: {
	// 						  top: 0.1,
	// 						  bottom: 0.1,
	// 					  },
	// 					  borderColor: 'rgba(197, 203, 206, 0.4)',
	// 				  },

	// 				  timeScale: {
	// 					  rightOffset: 120,
	//					  fixRightEdge: true,
	// 					  borderColor: 'rgba(197, 203, 206, 0.4)',
	// 				  },
	// 				  layout: {
	// 					  backgroundColor: '#ffffff',
	// 					  textColor: '#000000',
	// 				  },
	// 				  grid: {
	// 					  vertLines: {
	// 						  color: 'rgba(197, 203, 206, 0.4)',
	// 						  style: LightweightCharts.LineStyle.Dotted,
	// 					  },
	// 					  horzLines: {
	// 						  color: 'rgba(197, 203, 206, 0.4)',
	// 						  style: LightweightCharts.LineStyle.Dotted,
	// 					  },
	// 				  },
	// 			  });

	// 			  let areaSeries = chart.addAreaSeries({
	// 				  lineColor: '#ffb700',
	// 				  lineWidth: 2,
	// 				  bottomColor: 'transparent',
	// 				  topColor: 'transparent',
	// 			  });

	// 			  let extraSeries = chart.addAreaSeries({
	// 				  lineColor: '#B8B9CA',
	// 				  lineWidth: 2,
	// 				  bottomColor: 'transparent',
	// 				  topColor: 'transparent',
	// 			  });
	// 			  //
	// 			  areaSeries.setData(dataPointsValue);
	// 			  extraSeries.setData(dataPointsIMOEX);
	// 			  chart.timeScale().fitContent();
	// 			  /*chart.timeScale().setVisibleRange({
	// 				  from: (new Date(Date.UTC(2014, 1, 1, 0, 0, 0, 0))).getTime() / 1000,
	// 				  to: (new Date(Date.UTC(2100, 1, 1, 0, 0, 0, 0))).getTime() / 1000,
	// 			  });*/
	// 			    /*var chart = new CanvasJS.Chart("chart_profitability_RF_USD", {
	// 				  backgroundColor:"transparent",
	// 				  axisY:  { valueFormatString:"########", gridThickness: 0, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
	// 				  axisX:  { gridColor:"#ECECEC", labelFontColor: "#6783A0"},
	// 			      data: 
	// 			      [
	// 			    	  {
	// 					    type: "line",
	// 			    	    showInLegend: false,
	// 			            legendText: "Strategy",
	// 				        yValueFormatString:"########",
	// 				    	color: "#EBD441",
	// 				        dataPoints: dataPointsValue
	// 			    	  },
	// 			    	  {
	// 						type: "line",
	// 			    	    showInLegend: false,
	// 			            legendText: "IMOEX Index",
	// 					    yValueFormatString:"########",
	// 					    color: "#B8B9CA",
	// 					    dataPoints: dataPointsIMOEX
	// 				      },
	// 				      {
	// 				    	    type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 				    	    yValueFormatString:"########",
	// 				    	    color: "#999999",
	// 				    	    dataPoints: dataPoints_2015
	// 					  },
	// 					  {
	// 					    	type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 							yValueFormatString:"########",
	// 							color: "#999999",
	// 							dataPoints: dataPoints_2016
	// 					  },
	// 					  {
	// 					    	type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 							yValueFormatString:"########",
	// 							color: "#999999",
	// 							dataPoints: dataPoints_2017
	// 					  },
	// 					  {
	// 					    	type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 							yValueFormatString:"########",
	// 							color: "#999999",
	// 							dataPoints: dataPoints_2018
	// 					  },
	// 					  {
	// 					    	type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 							yValueFormatString:"########",
	// 							color: "#999999",
	// 							dataPoints: dataPoints_2019
	// 					  },
	// 					  {
	// 					    	type: "line",
	// 				    	    lineDashType: "shortDash",
	// 							lineThickness: 1,
	// 							yValueFormatString:"########",
	// 							color: "#999999",
	// 							dataPoints: dataPoints_2020
	// 					  }
	// 			      ]
	// 			    });
	// 			    chart.render();*/
	// 		  }
	// 		});
	// }
}


function comm_reserves_graph() {
	if ($("div").is("#comm_reserves_graph"))
	{
	ticker = $("#comm_reserves_ticker_id").html();
	$.ajax({
			type: 'POST',
			url: 'php_db/ajax/get_comm_reserves_array_from_to.php',
			data: {
				ticker: ticker 
			},
			success: function(inf){
				var result = JSON.parse(inf);
				
				var dataPoints1 = [];

				for (var i = 0; i <= result.length - 1; i++) {
					dataPoints1.push({
						time: result[i].y,
						value: parseFloat(result[i].value)
					});
				}
				let chart = LightweightCharts.createChart('comm_reserves_graph', {
					localization: {
						locale: 'en-us',
					},
					rightPriceScale: {
						visible: false,
					},
					leftPriceScale: {
						priceScaleId: 'left',
						visible: true,
						autoScale: true,
						alignLabels: true,

						scaleMargins: {
							top: 0.1,
							bottom: 0.1,
						},
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					timeScale: {
						rightOffset: 0,
						fixRightEdge: true,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					layout: {
						backgroundColor: '#ffffff',
						textColor: '#000000',
					},
					grid: {
						vertLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
						horzLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
					},
				});

				let extraSeries = chart.addAreaSeries({
					lineColor: '#3A6579',
					showInLegend: true,
					lineWidth: 2,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});

				extraSeries.applyOptions({
					priceFormat: {
						type: 'price',
						precision: 1,
						minMove: 0.1,
					},
				});

				extraSeries.setData(dataPoints1);
				chart.timeScale().fitContent();

			}
		});
	}
}

function main_factor_graph_revenue() {
	if ($("div").is("#main_factor_graph_revenue"))
		{
		comm_ID_rev = $("#main_factor_id_revenue").html();
		last_Q = $("#lastQ").html();
		avgLTM_1 = $("#avg_LTM_1_rev_factor").html();
		$.ajax({
			  type: 'POST',
			  url: 'php_db/ajax/get_commodity_D_chart_and_avg_LTM_for_company_page.php',
			  data: {commID:comm_ID_rev, lastQ:last_Q, avg_LTM_1:avgLTM_1 },
			  success: function(inf){
					var result = JSON.parse(inf);

					var dataPoints1 = [];
					var dataPoints2 = [];
					for (var i = 0; i <= result.length - 1; i++) {
				      dataPoints1.push({
				        time: result[i].D,
				        value: parseFloat(result[i].Value)
				      });
				      dataPoints2.push({
					    time: result[i].D,
					    value: parseFloat(result[i].avgLTM)
					  });
				    }
					
					/*
					
				    var chart = new CanvasJS.Chart("main_factor_graph_revenue", {
					  backgroundColor:"transparent",
					  axisY:{
						  valueFormatString:"########",
						  gridColor:"#ECECEC", labelFontColor: "#6783A0"
					  },
					  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
				      data: 
				      [
				    	  {
						    type: "line",
					        yValueFormatString:"########.##",
					    	color: "#78c1f5",
					        dataPoints: dataPoints1
				    	  },
				    	  {
							type: "line",
						    yValueFormatString:"########.##",
						    color: "#990000",
						    dataPoints: dataPoints2
					      },
				      ]
				    });
				    chart.render();
					
					*/
					
					  let chart = LightweightCharts.createChart('main_factor_graph_revenue', {
						  mode: LightweightCharts.PriceScaleMode.Percentage,
						  localization: {
							  locale: 'en-us',
						  },
						  rightPriceScale: {
							  visible: false,
						  },
						  leftPriceScale: {
							  priceScaleId: 'left',
							  visible: true,
							  autoScale: true,
							  alignLabels: true,

							  scaleMargins: {
								  top: 0.1,
								  bottom: 0.1,
							  },
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  timeScale: {
							  rightOffset: 12,
							  fixRightEdge: true,
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  layout: {
							  backgroundColor: '#ffffff',
							  textColor: '#000000',
						  },
						  grid: {
							  vertLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
							  horzLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
						  },
					  });

						let areaSeries = chart.addAreaSeries({
							lineColor: '#FFB700',
							showInLegend: true,
							title: 'percentile',
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						let extraSeries = chart.addAreaSeries({
							lineColor: '#3A6579',
							showInLegend: true,
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						areaSeries.setData(dataPoints2);
						extraSeries.setData(dataPoints1);
						chart.timeScale().fitContent();

			  }
			});
		}
}

function key_parameters_graphs() {
	if ($("span").is("#key_param_data_count"))
	{
		counter = $("#key_param_data_count").html();
		for (coun = 0; coun < counter; coun++)
		{
			if ($("div").is("#key_param_graphs_" + coun))
			{
				data = $("#key_param_data_" + coun).html();
				key_param_name = $("#key_param_name_" + coun).html();
		
				var result = JSON.parse(data);
				var dataPoints1 = [];


				for (var i = 0; i <= result.length - 1; i++) {
					dataPoints1.push({
						time: result[i].time,
						value: parseFloat(result[i].value)
					});
				}

				let chart = LightweightCharts.createChart('key_param_graphs_' + coun, {
					// mode: LightweightCharts.PriceScaleMode.Percentage,
					localization: {
						locale: 'en-us',
					},
					rightPriceScale: {
						visible: false,
					},
					leftPriceScale: {
						priceScaleId: 'left',
						visible: true,
						autoScale: true,
						alignLabels: true,

						scaleMargins: {
							top: 0.1,
							bottom: 0.1,
						},
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					timeScale: {
						// rightOffset: 2,
						fixRightEdge: true,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					layout: {
						backgroundColor: '#ffffff',
						textColor: '#000000',
					},
					grid: {
						vertLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
						horzLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
					},
				});

				let areaSeries = chart.addHistogramSeries({
					// lineColor: '#3A6579',
					// showInLegend: true,
					// title: 'percentile',
					// lineWidth: 2,
					color: '#3A6579',
					// downColor: '#3A6579',
				});

				areaSeries.setData(dataPoints1);
				chart.timeScale().fitContent();
			}

		}
	}
	
}

function all_factor_graph_revenue_Wd() {
	if ($("div").is("#all_factor_graph_revenue_Wd"))
	{
		ticker = $("#all_factor_ticker").html();
		ids1 = $("#all_factor_id_revenue_1").html();
		ids2 = $("#all_factor_id_revenue_2_share").html();
		last_Q = $("#lastQ").html();
		
		$.ajax({
			  type: 'POST',
			  url: 'php_db/ajax/get_commodity_D_chart_and_avg_LTM_many_Wd.php',
			  data: { ids:ids1, shs:ids2, lastQ:last_Q, ticker:ticker },
			  success: function(inf){
					
					var result = JSON.parse(inf);

					var dataPoints1 = [];
					var dataPoints2 = [];
					for (var i = 0; i <= result.length - 1; i++) {
				      dataPoints1.push({
				        time: result[i].D,
				        value: parseFloat(result[i].Value)
				      });
				      dataPoints2.push({
					    time: result[i].D,
					    value: parseFloat(result[i].avgLTM)
					  });
				    }
					
					/*
					
				    var chart = new CanvasJS.Chart("all_factor_graph_revenue_Wd", {
					  backgroundColor:"transparent",
					  axisY:{
						  valueFormatString:"####%", gridColor:"#ECECEC", labelFontColor: "#6783A0" 
					  },
					  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
				      data: 
				      [
				    	  {
						    type: "line",
					        yValueFormatString:"####.#%",
					    	color: "#78c1f5",
					        dataPoints: dataPoints1
				    	  },
				    	  {
							type: "line",
						    yValueFormatString:"####.#%",
						    color: "#990000",
						    dataPoints: dataPoints2
					      },
				      ]
				    });
				    chart.render();
					
					*/
					
					  let chart = LightweightCharts.createChart('all_factor_graph_revenue_Wd', {
						  mode: LightweightCharts.PriceScaleMode.Percentage,
						  localization: {
							  locale: 'en-us',
						  },
						  rightPriceScale: {
							  visible: false,
						  },
						  leftPriceScale: {
							  priceScaleId: 'left',
							  visible: true,
							  autoScale: true,
							  alignLabels: true,

							  scaleMargins: {
								  top: 0.1,
								  bottom: 0.1,
							  },
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  timeScale: {
							  rightOffset: 12,
							  fixRightEdge: true,
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  layout: {
							  backgroundColor: '#ffffff',
							  textColor: '#000000',
						  },
						  grid: {
							  vertLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
							  horzLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
						  },
					  });

						let areaSeries = chart.addAreaSeries({
							lineColor: '#FFB700',
							showInLegend: true,
							title: 'percentile',
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						let extraSeries = chart.addAreaSeries({
							lineColor: '#3A6579',
							showInLegend: true,
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						areaSeries.setData(dataPoints2);
						extraSeries.setData(dataPoints1);
						chart.timeScale().fitContent();
					
			  }
			});
	}
}

function all_factor_graph_revenue() {
	if ($("div").is("#all_factor_graph_revenue"))
		{
		ticker = $("#all_factor_ticker").html();
		ids1 = $("#all_factor_id_revenue_1").html();
		ids2 = $("#all_factor_id_revenue_2_share").html();
		last_Q = $("#lastQ").html();
		$.ajax({
			  type: 'POST',
			  url: 'php_db/ajax/get_commodity_D_chart_and_avg_LTM_many.php',
			  data: { ids:ids1, shs:ids2, lastQ:last_Q, ticker:ticker },
			  success: function(inf){
					var result = JSON.parse(inf);

					var dataPoints1 = [];
					var dataPoints2 = [];
					for (var i = 0; i <= result.length - 1; i++) {
				      dataPoints1.push({
				        time: result[i].D,
				        value: parseFloat(result[i].Value)
				      });
				      dataPoints2.push({
					    time: result[i].D,
					    value: parseFloat(result[i].avgLTM)
					  });
				    }
					
					/*
					
				    var chart = new CanvasJS.Chart("all_factor_graph_revenue", {
					  backgroundColor:"transparent",
					  axisY:{
						  valueFormatString:"####%", gridColor:"#ECECEC", labelFontColor: "#6783A0" 
					  },
					  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
				      data: 
				      [
				    	  {
						    type: "line",
					        yValueFormatString:"####.#%",
					    	color: "#78c1f5",
					        dataPoints: dataPoints1
				    	  },
				    	  {
							type: "line",
						    yValueFormatString:"####.#%",
						    color: "#990000",
						    dataPoints: dataPoints2
					      },
				      ]
				    });
				    chart.render();
					
					*/
					
					  let chart = LightweightCharts.createChart('all_factor_graph_revenue', {
						  mode: LightweightCharts.PriceScaleMode.Percentage,
						  localization: {
							  locale: 'en-us',
						  },
						  rightPriceScale: {
							  visible: false,
						  },
						  leftPriceScale: {
							  priceScaleId: 'left',
							  visible: true,
							  autoScale: true,
							  alignLabels: true,

							  scaleMargins: {
								  top: 0.1,
								  bottom: 0.1,
							  },
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  timeScale: {
							  rightOffset: 12,
							  fixRightEdge: true,
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  layout: {
							  backgroundColor: '#ffffff',
							  textColor: '#000000',
						  },
						  grid: {
							  vertLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
							  horzLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
						  },
					  });

						let areaSeries = chart.addAreaSeries({
							lineColor: '#17D4E3',
							showInLegend: true,
							title: 'percentile',
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						let extraSeries = chart.addAreaSeries({
							lineColor: '#3A6579',
							showInLegend: true,
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						areaSeries.setData(dataPoints2);
						extraSeries.setData(dataPoints1);
						chart.timeScale().fitContent();
						
			  }
			});
		}
}

function showCurrencyInfo() {
	if ($("select").is("#select_currency_1"))
	{
		vl = $("#hidden_currID_container").html();
		$('#select_currency_1').val(vl);
		
		if (vl != null && vl > 0)
		{
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_currency_D_chart_and_avg_LTM_for_currency_page.php',
								  data: {currID:vl},
								  success: function(inf){
									  	
										var result = JSON.parse(inf);

										var dataPoints1 = [];
										var dataPoints2 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        label: result[i].D,
									        y: parseFloat(result[i].Value)
									      });
									      dataPoints2.push({
										    label: result[i].D,
										    y: parseFloat(result[i].avgLTM)
										  });
									    }
										
									    var chart = new CanvasJS.Chart("chart_container_currency_D_data", {
										  backgroundColor:"transparent",
										  axisY:{
											  valueFormatString:"########.##", gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
										  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
									      data: 
									      [
									    	  {
											    type: "line",
										        yValueFormatString:"########.##",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  },
									    	  {
												type: "line",
											    yValueFormatString:"########.##",
											    color: "#990000",
											    dataPoints: dataPoints2
										      }
									      ]
									    });
									    chart.render();
								  }
								});
							
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_currency_Q_chart.php',
								  data: {currID:vl},
								  success: function(inf){
									  
										var result = JSON.parse(inf);
										
										var dataPoints1 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        label: result[i].Q,
									        y: parseFloat(result[i].Value)
									      });
									    }
										
									    var chart = new CanvasJS.Chart("chart_container_currency_Q_data", {
										  backgroundColor:"transparent",
										  axisY:{
											  valueFormatString:"########.##", gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
										  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
									      data: 
									      [
									    	  {
											    type: "line",
										        yValueFormatString:"########.##",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  }
									      ]
									    });
									    chart.render();
								  }
								});
							
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_emitents_influence_curr.php',
								  data: {currID:vl},
								  success: function(inf){
									  if (inf.length > 2) $('#emitents_influence_positive_curr').html(inf);
								  }
							});
		}
		else
		{
			var id = document.getElementById('select_currency_1').options[0].value;
			window.location = "/currency.php?id=" + id;
		}
	}
}

function showCommodityInfo() {
	if ($("select").is("#select_commodity_1"))
	{
		vl = $("#hidden_commID_container").html();
		$('#select_commodity_1').val(vl);
		
		if (vl != null && vl > 0)
		{
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_commodity_D_chart_and_avg_LTM_for_commodity_page.php',
								  data: {commID:vl},
								  success: function(inf){
									  	
										var result = JSON.parse(inf);

										var dataPoints1 = [];
										var dataPoints2 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        time: result[i].D,
									        value: parseFloat(result[i].Value)
									      });
									      dataPoints2.push({
										    time: result[i].D,
										    value: parseFloat(result[i].avgLTM)
										  });
									    }
										
										/*
										
									    var chart = new CanvasJS.Chart("chart_container_commodity_D_data", {
										  backgroundColor:"transparent",
										  axisY:{
											  valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
										  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
									      data: 
									      [
									    	  {
											    type: "line",
										        yValueFormatString:"########.##",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  },
									    	  {
												type: "line",
											    yValueFormatString:"########.##",
											    color: "#990000",
											    dataPoints: dataPoints2
										      }
									      ]
									    });
									    chart.render();
										
										*/
										
					  let chart = LightweightCharts.createChart('chart_container_commodity_D_data', {
						  mode: LightweightCharts.PriceScaleMode.Percentage,
						  localization: {
							  locale: 'en-us',
						  },
						  rightPriceScale: {
							  visible: false,
						  },
						  leftPriceScale: {
							  priceScaleId: 'left',
							  visible: true,
							  autoScale: true,
							  alignLabels: true,

							  scaleMargins: {
								  top: 0.1,
								  bottom: 0.1,
							  },
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  timeScale: {
							  rightOffset: 12,
							  fixRightEdge: true,
							  borderColor: 'rgba(197, 203, 206, 0.4)',
						  },
						  layout: {
							  backgroundColor: '#ffffff',
							  textColor: '#000000',
						  },
						  grid: {
							  vertLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
							  horzLines: {
								  color: 'rgba(197, 203, 206, 0.4)',
								  style: LightweightCharts.LineStyle.Dotted,
							  },
						  },
					  });

						let areaSeries = chart.addAreaSeries({
							lineColor: '#17D4E3',
							showInLegend: true,
							title: 'percentile',
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						let extraSeries = chart.addAreaSeries({
							lineColor: '#3A6579',
							showInLegend: true,
							lineWidth: 2,
							bottomColor: 'transparent',
							topColor: 'transparent',
						});

						areaSeries.setData(dataPoints2);
						extraSeries.setData(dataPoints1);
						chart.timeScale().fitContent();
										
								  }
								});
							
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_commodity_Q_chart.php',
								  data: {commID:vl},
								  success: function(inf){
									  
										var result = JSON.parse(inf);
										
										var str_prev = '';
										
										var dataPoints1 = [];
										for (var i = 0; i <= result.length - 1; i++)
										{
											str = result[i].Q;
											str = str.replace(' q1', '-3-31');
											str = str.replace(' q2', '-6-30');
											str = str.replace(' q3', '-9-30');
											str = str.replace(' q4', '-12-31');
											
											if (str == 'Now')
											{
												var d = new Date();
												var curr_date = d.getDate();
												var curr_month = d.getMonth() + 1;
												var curr_year = d.getFullYear();
												var formated_date = curr_year + "-" + curr_month + "-" + curr_date;
												var today1 = new Date(formated_date);
												
												var today2 = new Date(str_prev);
												today2.setDate(today2.getDate()+1);
												
												var today = today1;
												if (today2 > today1) today = today2;
												
												str = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
											}
											
											str_prev = str;
											
									      dataPoints1.push({
									        time: str,
									        value: parseFloat(result[i].Value)
									      });
									    }
										
										/*
										
									    var chart = new CanvasJS.Chart("chart_container_commodity_Q_data", {
										  backgroundColor:"transparent",
										  axisY:{
											  valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
										  axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
									      data: 
									      [
									    	  {
											    type: "line",
										        yValueFormatString:"########.##",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  }
									      ]
									    });
									    chart.render();
										
										*/
										
										  let chart = LightweightCharts.createChart('chart_container_commodity_Q_data', {
											  mode: LightweightCharts.PriceScaleMode.Percentage,
											  localization: {
												  locale: 'en-us',
											  },
											  rightPriceScale: {
												  visible: false,
											  },
											  leftPriceScale: {
												  priceScaleId: 'left',
												  visible: true,
												  autoScale: true,
												  alignLabels: true,

												  scaleMargins: {
													  top: 0.1,
													  bottom: 0.1,
												  },
												  borderColor: 'rgba(197, 203, 206, 0.4)',
											  },
											  timeScale: {
												  rightOffset: 12,
												  fixRightEdge: true,
												  borderColor: 'rgba(197, 203, 206, 0.4)',
											  },
											  layout: {
												  backgroundColor: '#ffffff',
												  textColor: '#000000',
											  },
											  grid: {
												  vertLines: {
													  color: 'rgba(197, 203, 206, 0.4)',
													  style: LightweightCharts.LineStyle.Dotted,
												  },
												  horzLines: {
													  color: 'rgba(197, 203, 206, 0.4)',
													  style: LightweightCharts.LineStyle.Dotted,
												  },
											  },
										  });

											let areaSeries = chart.addAreaSeries({
												lineColor: '#3A6579',
												showInLegend: true,
												lineWidth: 2,
												bottomColor: 'transparent',
												topColor: 'transparent',
											});
											
											areaSeries.setData(dataPoints1);
											chart.timeScale().fitContent();
						
								  }
								});
							
							lng_ = $('#emitents_influence_lang').html();
							
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_emitents_influence.php',
								  data: {commID:vl, Direction:1, lng:lng_},
								  success: function(inf){
									  if (inf.length > 2) $('#emitents_influence_positive').html(inf);
								  }
							});
							
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_emitents_influence.php',
								  data: {commID:vl, Direction:-1, lng:lng_},
								  success: function(inf){
									  if (inf.length > 2) $('#emitents_influence_negative').html(inf);
								  }
							});
		}
		else
		{
			var id = document.getElementById('select_commodity_1').options[0].value;
			window.location = "/commodity.php?id=" + id;
			
			/*
			try
			{
				var div = document.getElementById('div_ajax_response');
			    while(div.firstChild) div.removeChild(div.firstChild);
			}
			catch {}
			*/
		}
	}
}

function potential_strategy() {
	if ($("select").is("#select_intraday_potential_emitent"))
	{
		vl = $("#hidden_intraday_potential_ticker_container").html();
		$('#select_intraday_potential_emitent').val(vl);
		
		if (vl != null && vl.length > 0)
		{
			
		}
		else
		{
			var ticker = document.getElementById('select_intraday_potential_emitent').options[0].value;
			pname = document.location.href;
			p = pname.indexOf(".php");
			pname = pname.substring(0, p);
			p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
			pname = pname.substring(p + 1);
			window.location = "/" + pname + ".php?name=" + ticker;
		}
	}
}

function showQuoteInfo() {
	if ($("select").is("#select_quote_emitent"))
	{
		vl = $("#hidden_quote_ticker_container").html();
		$('#select_quote_emitent').val(vl);
		
		if (vl != null && vl.length > 0)
		{
			
		}
		else
		{
			var ticker = document.getElementById('select_quote_emitent').options[0].value;
			pname = document.location.href;
			p = pname.indexOf(".php");
			pname = pname.substring(0, p);
			p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
			pname = pname.substring(p + 1);
			window.location = "/" + pname + ".php?name=" + ticker;
		}
	}
	
	if ($("div").is("#json_hidden_div_quotes_balance_liq_1"))
	{
		vl_1 = $("#json_hidden_div_quotes_balance_liq_1").html();
		vl_2 = $("#json_hidden_div_quotes_balance_liq_2").html();
		vl_3 = $("#json_hidden_div_quotes_balance_liq_3").html();
		vl_4 = $("#json_hidden_div_quotes_balance_liq_4").html();
		vl_5 = $("#json_hidden_div_quotes_balance_liq_5").html();
		
		var res_1 = JSON.parse(vl_1);
		var res_2 = JSON.parse(vl_2);
		var res_3 = JSON.parse(vl_3);
		var res_4 = JSON.parse(vl_4);
		var res_5 = JSON.parse(vl_5);
		
		var dataPointsValue_price   = [];
		var dataPointsValue_balance = [];
		var dataPointsValue_balance_050 = [];
		var dataPointsValue_balance_100 = [];
		
		var dataPointsValue_liq_B     = [];
		var dataPointsValue_liq_S     = [];
		
		for (var i = 0; i <= res_1.length - 1; i++)
		{
			dataPointsValue_price.push  ({ label: res_1[i], y: parseFloat(res_2[i]) });
			dataPointsValue_balance.push({ label: res_1[i], y: parseFloat(res_3[i]) });
			dataPointsValue_balance_050.push({ label: res_1[i], y: 0.5 });
			dataPointsValue_balance_100.push({ label: res_1[i], y: 1.0 });
			
			dataPointsValue_liq_B.push({ label: res_1[i], y: parseFloat(res_4[i]) });
			dataPointsValue_liq_S.push({ label: res_1[i], y: parseFloat(res_5[i]) });
		}
		
		var chart = new CanvasJS.Chart("graph_conteiner_quotes_Price", {
			backgroundColor:"transparent",
			axisY:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			data: 
			[
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "#78c1f5",
					dataPoints: dataPointsValue_price
				}
			]
		});
		chart.render();
		
		var chart = new CanvasJS.Chart("graph_conteiner_quotes_B_S_Balance", {
			backgroundColor:"transparent",
			axisY:{
				maximum: 1,
				minimum: 0,
				gridColor:"#ECECEC", labelFontColor: "#6783A0"
			},
			axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			data: 
			[
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "orange",
					dataPoints: dataPointsValue_balance
				},
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "grey",
					dataPoints: dataPointsValue_balance_050
				},
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "grey",
					dataPoints: dataPointsValue_balance_100
				}
			]
		});
		chart.render();
		
		var chart = new CanvasJS.Chart("graph_conteiner_quotes_B_S_liq", {
			backgroundColor:"transparent",
			axisY:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			axisX:{ gridColor:"#ECECEC", labelFontColor: "#6783A0" },
			data: 
			[
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "#8ECE8E",
					dataPoints: dataPointsValue_liq_B
				},
				{
					type: "line",
					yValueFormatString:"########.########",
					color: "#D49494",
					dataPoints: dataPointsValue_liq_S
				}
			]
		});
		chart.render();
	}
}

function showCompanyInfo() {
	// если на странице существует элемент "#select_emitent_1"
	if ($("select").is("#select_emitent_1"))
	{
		vl = $("#hidden_ticker_container").html();
		$('#select_emitent_1').val(vl);
		
		if (vl != null && vl.length > 0)
		{
							var stl = document.createElement('style');
							document.head.appendChild(stl);
							stl.sheet.insertRule(".border_1_style {" + "padding:10px; }");
									//"border-style:solid; " +
									//"border-width:1px; " +
									//"border-color:#B0E3B0; " +
									//"border-radius:5px; }");
							
							var currLoc = window.location.href;
							
				    	  	// Revenue and EBITDA graph
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_emitent_data_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  
							// 			var result = JSON.parse(inf);
										
							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints1.push({
							// 		        label: result[i].Q,
							// 		        y: parseInt(result[i].Revenue)
							// 		      });
							// 		    }
										
							// 			var dataPoints2 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints2.push({
							// 		        label: result[i].Q,
							// 		        y: parseInt(result[i].Ebitda)
							// 		      });
							// 		    }
										
							// 		   //  var chart = new CanvasJS.Chart("chart_container_emitent_data", {
							// 			  // backgroundColor:"transparent",
							// 			  // axisY:{
							// 				 //  valueFormatString:"### ### ### ###", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 		   //    },
							// 			  // axisX:{
							// 				 //  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 		   //    },
									        
							// 		   //    data: 
							// 		   //    [
							// 		   //  	  {
							// 				 //    type: "column",
							// 			  //       yValueFormatString:"### ### ### ###",
							// 			  //   	color: "#a6adb3",
							// 			  //       dataPoints: dataPoints1
							// 		   //  	  },
							// 		   //  	  {
							// 					// type: "column",
							// 			  //       yValueFormatString:"### ### ### ###",
							// 				 //    color: "#78c1f5",
							// 				 //    dataPoints: dataPoints2
							// 			  //     }
							// 		   //    ]
							// 		   //  });
							// 		   //  chart.render();
									 
									   	
							// 	  }
							// 	});
							
							// // Revenue and EBITDA GROWTH graph
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_emitent_growth_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  
							// 			var result = JSON.parse(inf);
										
							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints1.push({
							// 		        label: result[i].Q,
							// 		        y: parseFloat(result[i].Revenue)
							// 		      });
							// 		    }
										
							// 			var dataPoints2 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints2.push({
							// 		        label: result[i].Q,
							// 		        y: parseFloat(result[i].Ebitda)
							// 		      });
							// 		    }
										
							// 		    var chart = new CanvasJS.Chart("chart_container_emitent_growth", {
							// 			  backgroundColor:"transparent",
							// 			  axisY:{
							// 				  valueFormatString:"####%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  //gridThickness: 0,
							// 			      //tickLength: 0,
							// 		      },
							// 		      axisX:{
							// 				  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 		      },
							// 		      data: 
							// 		      [
							// 		    	  {
							// 				    type: "line",
							// 				    lineThickness: 1,
							// 			        yValueFormatString:"####.#%",
							// 			    	color: "#a6adb3",
							// 			        dataPoints: dataPoints1
							// 		    	  },
							// 		    	  {
							// 					type: "line",
							// 				    lineThickness: 1,
							// 			        yValueFormatString:"####.#%",
							// 				    color: "#78c1f5",
							// 				    dataPoints: dataPoints2
							// 			      }
							// 		      ]
							// 		    });
							// 		    chart.render();
							// 	  }
							// 	});
							
							// // FCF graph
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_FCF_data_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  	
							// 			var result = JSON.parse(inf);

							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 			   dataPoints1.push({
							// 				   label: result[i].Q,
							// 			   	y: parseFloat(result[i].FCF_Q)
							// 			   });
							// 			}
										
							// 			var chart = new CanvasJS.Chart("chart_container_FCF_data", {
							// 				backgroundColor:"transparent",
							// 				axisY:{
							// 					valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				},
							// 				axisX:{
							// 					gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				},
							// 				data: 
							// 				[
							// 				    {
							// 				    	type: "column",
							// 						yValueFormatString:"### ### ### ###",
							// 						color: "#78c1f5",
							// 						dataPoints: dataPoints1
							// 				    }
							// 				]
										
							// 			});
							// 			chart.render();
							// 	  }
							// 	});
							
							// NetDebt graph
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_netDebt_data_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  	
							// 			var result = JSON.parse(inf);

							// 			var maxND = Math.max.apply(Math, result.map(function(o) { return o.NetDebt; })); 
							// 			var minND = Math.min.apply(Math, result.map(function(o) { return o.NetDebt; })); 
										
							// 			if (Math.abs(maxND) + Math.abs(minND) > 0)
							// 			{
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 			      dataPoints1.push({
							// 			        label: result[i].Q,
							// 			        y: parseFloat(result[i].NetDebt)
							// 			      });
							// 			    }
											
							// 			    var chart = new CanvasJS.Chart("chart_container_netDebt_data", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 			      data: 
							// 			      [
							// 			    	  {
							// 			    		  type: "column",
							// 					        yValueFormatString:"### ### ### ###",
							// 						    color: "#78c1f5",
							// 						    dataPoints: dataPoints1
							// 			    	  }
							// 			      ]
							// 			    });
							// 			    chart.render();
							// 	  		}
							// 			else
							// 			{
							// 				var stl = document.createElement('style');
							// 				document.head.appendChild(stl);
							// 				stl.sheet.insertRule(".NetDebtElement {display:none;}");
							// 			}
							// 	  }
							// 	});
							
							// // Price graph
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_price_data_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  
							// 			var result = JSON.parse(inf);
										
							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints1.push({
							// 		        label: result[i].Date,
							// 		        y: parseFloat(result[i].Price)
							// 		      });
							// 		    }
										
							// 		    var chart = new CanvasJS.Chart("chart_container_price_data", {
							// 			  backgroundColor:"transparent",
							// 			  axisY:{
							// 				  valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 			  axisX:{
							// 				gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 		      data: 
							// 		      [
							// 		    	  {
							// 				    type: "line",
							// 			        yValueFormatString:"########.########",
							// 			    	color: "#78c1f5",
							// 			        dataPoints: dataPoints1
							// 		    	  }
							// 		      ]
							// 		    });
							// 		    chart.render();
							// 	  }
							// 	});
							
							// if ($("div").is("#chart_container_mult_data_GC"))
							// {
							// 	// Mult graph
							// 	$.ajax({
							// 		  type: 'POST',
							// 		  url: 'php_db/ajax/get_mult_data_chart_GC.php',
							// 		  data: {ticker:vl, page:currLoc},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				var dataPoints2 = [];
							// 				var dataPoints3 = [];
							// 				var dataPoints4 = [];
							// 				for (var i = 0; i <= result.length - 1; i++)
							// 				{
							// 					  dataPoints1.push({
							// 						label: result[i].Date,
							// 						y: parseFloat(result[i].Mult)
							// 					  });
							// 					  dataPoints2.push({
							// 						label: result[i].Date,
							// 						y: parseFloat(result[i].p75)
							// 					  });
							// 					  dataPoints3.push({
							// 						label: result[i].Date,
							// 						y: parseFloat(result[i].E_Mult)
							// 					  });
							// 					  dataPoints4.push({
							// 						label: result[i].Date,
							// 						y: parseFloat(result[i].E_p75)
							// 					  });
							// 				}
											
							// 				var chart = new CanvasJS.Chart("chart_container_mult_data_GC", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"########.#x", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						lineThickness: 1,
							// 						yValueFormatString:"########.##x",
							// 						color: "#9A9A9A",
							// 						dataPoints: dataPoints3
							// 					  },
							// 					  {
							// 						type: "line",
							// 						lineThickness: 1,
							// 						yValueFormatString:"########.##x",
							// 						color: "#9A9A9A",
							// 						dataPoints: dataPoints4
							// 					  },
							// 					  {
							// 						type: "line",
							// 						lineThickness: 1,
							// 						yValueFormatString:"########.##x",
							// 						color: "#990000",
							// 						dataPoints: dataPoints2
							// 					  },
							// 					  {
							// 						type: "line",
							// 						yValueFormatString:"########.##x",
							// 						color: "#78c1f5",
							// 						dataPoints: dataPoints1
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
							
							// if ($("div").is("#chart_container_mult_data"))
							// {
							// 	// Mult graph
							// 	$.ajax({
							// 		  type: 'POST',
							// 		  url: 'php_db/ajax/get_mult_data_chart.php',
							// 		  data: {ticker:vl, page:currLoc},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints1.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].Mult)
							// 				  });
							// 				}

							// 				var dataPoints2 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints2.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].p75)
							// 				  });
							// 				}
											
							// 				var chart = new CanvasJS.Chart("chart_container_mult_data", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"########.#x", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						yValueFormatString:"########.##x",
							// 						color: "#78c1f5",
							// 						dataPoints: dataPoints1
							// 					  },
							// 					  {
							// 						type: "line",
							// 						lineThickness: 1,
							// 						yValueFormatString:"########.##x",
							// 						color: "#990000",
							// 						dataPoints: dataPoints2
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
							
							// if ($("div").is("#chart_container_mult_data_EV_Sales"))
							// {
							// 	// Mult graph (EV / Sales)
							// 	$.ajax({
							// 		  type: 'POST',
							// 		  url: 'php_db/ajax/get_mult_data_chart_EV_Sales_US_2.php',
							// 		  data: {ticker:vl, page:currLoc},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints1.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].Mult)
							// 				  });
							// 				}

							// 				var chart = new CanvasJS.Chart("chart_container_mult_data_EV_Sales", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"########.#x", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						yValueFormatString:"########.##x",
							// 						color: "#78c1f5",
							// 						dataPoints: dataPoints1
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
								
								// BBL chart
								if ($("div").is("#chart_container_graphs_bbl"))
								{
										var result = JSON.parse($("#hidden_bbl_container").html());
										
										var dataPoints1 = [];
										var dataPoints2 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        label: result[i].Q,
									        y: parseFloat(result[i].UP_bbl)
									      });
										  dataPoints2.push({
									        label: result[i].Q,
									        y: parseFloat(result[i].DW_bbl)
									      });
									    }

									    var chart = new CanvasJS.Chart("chart_container_graphs_bbl", {
										  backgroundColor:"transparent",
										  axisY:  { labelFontSize: 13, valueFormatString:"######.#", gridColor:"#ECECEC", labelFontColor: "#6783A0" },
										  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
										  legend: { fontSize: 13 },
										  
									      data: 
									      [
									    	  {
											    type: "line",
												showInLegend: true,
												legendText: "Upstream EBITDA $/bbl",
										        yValueFormatString:"########.##",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  },
											  {
											    type: "line",
												showInLegend: true,
												legendText: "Downstream EBITDA $/bbl",
										        yValueFormatString:"########.##",
										    	color: "#A47A00",
										        dataPoints: dataPoints2
									    	  }
									      ]
									    });
									    chart.render();
								}
							
							// // Dividend graph
							// if ($("div").is("#chart_container_dividend_data"))
							// $.ajax({
							// 	  type: 'POST',
							// 	  url: 'php_db/ajax/get_dividend_data_chart.php',
							// 	  data: {ticker:vl, page:currLoc},
							// 	  success: function(inf){
									  
							// 			var result = JSON.parse(inf);
										
							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints1.push({
							// 		        label: result[i].Q,
							// 		        y: parseFloat(result[i].Dividend)
							// 		      });
							// 		    }
										
							// 		    var chart = new CanvasJS.Chart("chart_container_dividend_data", {
							// 			  backgroundColor:"transparent",
							// 			  axisY:{
							// 				  valueFormatString:"########", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 			  axisX:{
							// 				  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 		      data: 
							// 		      [
							// 		    	  {
							// 				    type: "column",
							// 			    	color: "#78c1f5",
							// 			        dataPoints: dataPoints1
							// 		    	  }
							// 		      ]
							// 		    });
							// 		    chart.render();
							// 	  }
							// 	});
							
							// Volatility graph RF
							/*
							if ($("div").is("#chart_container_price_volatility"))
							$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_price_volatility_chart_RF.php',
								  data: {ticker:vl},
								  success: function(inf){
									  
										var result = JSON.parse(inf);
										
										var dataPoints1 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        label: result[i].Date,
									        y: parseFloat(result[i].Volatility)
									      });
									    }
										
									    var chart = new CanvasJS.Chart("chart_container_price_volatility", {
										  backgroundColor:"transparent",
										  axisY:{
											  valueFormatString:"#####.#%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
										  axisX:{
											  gridColor:"#ECECEC", labelFontColor: "#6783A0"
										  },
									      data: 
									      [
									    	  {
											    type: "line",
										        yValueFormatString:"#####.##%",
										    	color: "#78c1f5",
										        dataPoints: dataPoints1
									    	  }
									      ]
									    });
									    chart.render();
								  }
								});
							*/
							
							// // Potential graph commRF
							// if ($("div").is("#chart_container_potential_hist_commRF"))
							// $.ajax({
							// 	  type: 'POST',		
							// 	  url: 'php_db/ajax/get_potential_data_chart_commRF.php',	
							// 	  data: {ticker:vl},
							// 	  success: function(inf){
										
							// 			var result = JSON.parse(inf);
										
							// 			var dataPoints1 = [];
							// 			for (var i = 0; i <= result.length - 1; i++) {
							// 		      dataPoints1.push({
							// 		        label: result[i].Date,
							// 		        y: parseFloat(result[i].Potential)
							// 		      });
							// 		    }
										
							// 		    var chart = new CanvasJS.Chart("chart_container_potential_hist_commRF", {
							// 			  backgroundColor:"transparent",
							// 			  axisY:{
							// 				  valueFormatString:"#####.#%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 			  axisX:{
							// 				  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 			  },
							// 		      data: 
							// 		      [
							// 		    	  {
							// 				    type: "line",
							// 			    	color: "#78c1f5",
							// 					yValueFormatString:"#####.#%",
							// 			        dataPoints: dataPoints1
							// 		    	  }
							// 		      ]
							// 		    });
							// 			chart.render();
							// 	  }
							// 	});
							
							// if ($("div").is("#chart_container_potential_hist_growRF"))
							// {
							// 	// Potential graph growRF
							// 	$.ajax({
							// 		  type: 'POST',		
							// 		  url: 'php_db/ajax/get_potential_data_chart_growRF.php',	
							// 		  data: {ticker:vl},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints1.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].Potential)
							// 				  });
							// 				}
											
							// 				var chart = new CanvasJS.Chart("chart_container_potential_hist_growRF", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"#####.#%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						color: "#78c1f5",
							// 						yValueFormatString:"#####.#%",
							// 						dataPoints: dataPoints1
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
							
							// if ($("div").is("#chart_container_potential_hist_growUS"))
							// {
							// 	// Potential graph growUS
							// 	$.ajax({
							// 		  type: 'POST',		
							// 		  url: 'php_db/ajax/get_potential_data_chart_growUS.php',	
							// 		  data: {ticker:vl},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints1.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].Potential)
							// 				  });
							// 				}
											
							// 				var chart = new CanvasJS.Chart("chart_container_potential_hist_growUS", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"#####.#%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						color: "#78c1f5",
							// 						yValueFormatString:"#####.#%",
							// 						dataPoints: dataPoints1
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
							
							// if ($("div").is("#chart_container_potential_hist_commWd"))
							// {
							// 	// Potential graph growUS
							// 	$.ajax({
							// 		  type: 'POST',		
							// 		  url: 'php_db/ajax/get_potential_data_chart_commWd.php',	
							// 		  data: {ticker:vl},
							// 		  success: function(inf){
											
							// 				var result = JSON.parse(inf);
											
							// 				var dataPoints1 = [];
							// 				for (var i = 0; i <= result.length - 1; i++) {
							// 				  dataPoints1.push({
							// 					label: result[i].Date,
							// 					y: parseFloat(result[i].Potential)
							// 				  });
							// 				}
											
							// 				var chart = new CanvasJS.Chart("chart_container_potential_hist_commWd", {
							// 				  backgroundColor:"transparent",
							// 				  axisY:{
							// 					  valueFormatString:"#####.#%", gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  axisX:{
							// 					  gridColor:"#ECECEC", labelFontColor: "#6783A0"
							// 				  },
							// 				  data: 
							// 				  [
							// 					  {
							// 						type: "line",
							// 						color: "#78c1f5",
							// 						yValueFormatString:"#####.#%",
							// 						dataPoints: dataPoints1
							// 					  }
							// 				  ]
							// 				});
							// 				chart.render();
							// 		  }
							// 		});
							// }
							
							// NORM GROWTH GRAPH
							vl_Q = $("#data_container_con5y_Q").html();
							vl_R = $("#data_container_con5y_R").html();
							vl_E = $("#data_container_con5y_E").html();
							vl_ch_R = $("#data_container_ch_R").html();
							vl_ch_E = $("#data_container_ch_E").html();
							vl_ch_a = $("#data_container_ch_a").html();
							
							if (typeof(vl_Q) !== 'undefined' && vl_Q.length > 5)
							{
								var result_con_Q = JSON.parse(vl_Q);
								var result_con_R = JSON.parse(vl_R);
								var result_con_E = JSON.parse(vl_E);
								var result_ch_R = JSON.parse(vl_ch_R);
								var result_ch_E = JSON.parse(vl_ch_E);
								var result_ch_a = JSON.parse(vl_ch_a);
								
								var dataPointsValue_R = [];
								var dataPointsValue_E = [];
								var dataPointsValue_R_ch = [];
								var dataPointsValue_E_ch = [];
								var dataPointsValue_a_ch = [];
								
								for (var i = 0; i <= result_con_Q.length - 1; i++) {
									dataPointsValue_R.push({
										label: result_con_Q[i],
										y: parseFloat(result_con_R[i])
									  });
									dataPointsValue_E.push({
										label: result_con_Q[i],
										y: parseFloat(result_con_E[i])
									  });
									dataPointsValue_R_ch.push({
										label: result_con_Q[i],
										y: parseFloat(result_ch_R[i])
									});
									dataPointsValue_E_ch.push({
										label: result_con_Q[i],
										y: parseFloat(result_ch_E[i])
									});
									dataPointsValue_a_ch.push({
										label: result_con_Q[i],
										y: parseFloat(result_ch_a[i])
									});
								}
								
								var chart = new CanvasJS.Chart("chart_container_con5y_R_E", {
								  backgroundColor:"transparent",
								  axisY:  { valueFormatString:"######", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
								  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
								  legend: { fontSize: 13 },
								  data: 
								  [
									  {
										type: "column",
										showInLegend: true,
										legendText: "Revenue",
										yValueFormatString:"######",
										color: "#a6adb3",
										dataPoints: dataPointsValue_R
									  },
									  {
										type: "column",
										showInLegend: true,
										legendText: "EBITDA",
										yValueFormatString:"######",
										color: "#78c1f5",
										dataPoints: dataPointsValue_E
									  }
								  ]
								});
								chart.render();
								
								var chart = new CanvasJS.Chart("chart_container_con5y_R_E_ch", {
								  backgroundColor:"transparent",
								  axisY:  { valueFormatString:"######", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
								  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
								  legend: { fontSize: 13 },
								  data: 
								  [
									  {
										type: "line",
										showInLegend: true,
										legendText: "Revenue",
										yValueFormatString:"#####.#%",
										color: "#a6adb3",
										dataPoints: dataPointsValue_R_ch
									  },
									  {
										type: "line",
										showInLegend: true,
										legendText: "EBITDA",
										yValueFormatString:"#####.#%",
										color: "#78c1f5",
										dataPoints: dataPointsValue_E_ch
									  },
									  {
										type: "line",
										showInLegend: true,
										legendText: "average",
										yValueFormatString:"#####.#%",
										color: "#990000",
										dataPoints: dataPointsValue_a_ch,
										markerSize: 2
									  }
								  ]
								});
								chart.render();
							}
							
							
							
							//else
							
							
					      	// $('#topDiv').html("");
				    	  	
				    	    //var div = document.getElementById('chart_container_emitent_data');
				    	    //while(div.firstChild) div.removeChild(div.firstChild);
				    	    
				    	    //div = document.getElementById('chart_container_price_data');
				    	    //while(div.firstChild) div.removeChild(div.firstChild);
		}
		else
		{
			var ticker = document.getElementById('select_emitent_1').options[0].value;
			
			pname = document.location.href;
			p = pname.indexOf(".php");
			pname = pname.substring(0, p);
			p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
			pname = pname.substring(p + 1);
			
			window.location = "/" + pname + ".php?name=" + ticker;
			
			/*
			try
			{
				var div = document.getElementById('div_ajax_response');
			    while(div.firstChild) div.removeChild(div.firstChild);
			}
			catch {}
			*/
		}
		
		// ----------------------------------------------------------------------------------
		
		if ($("div").is("#AFKS_discount_graph"))
		{
			vl_AFKS = $("#data_container_AFKS").html();
			var result = JSON.parse(vl_AFKS);

			var dataPoints1 = [];
			var dataPoints2 = [];
			for (var i = 0; i <= result.length - 1; i++) {
			  dataPoints1.push({
				time: result[i].D,
				value: parseFloat(result[i].Discount)
			  });
			  dataPoints2.push({
				time: result[i].D,
				value: parseFloat(result[i].p75)
			  });
			}
			
			  let chart = LightweightCharts.createChart('AFKS_discount_graph', {
				  mode: LightweightCharts.PriceScaleMode.Percentage,
				  localization: {
					  locale: 'en-us',
				  },
				  rightPriceScale: {
					  visible: false,
				  },
				  leftPriceScale: {
					  priceScaleId: 'left',
					  visible: true,
					  autoScale: true,
					  alignLabels: true,

					  scaleMargins: {
						  top: 0.1,
						  bottom: 0.1,
					  },
					  borderColor: 'rgba(197, 203, 206, 0.4)',
				  },
				  timeScale: {
					  rightOffset: 12,
					  fixRightEdge: true,
					  borderColor: 'rgba(197, 203, 206, 0.4)',
				  },
				  layout: {
					  backgroundColor: '#ffffff',
					  textColor: '#000000',
				  },
				  grid: {
					  vertLines: {
						  color: 'rgba(197, 203, 206, 0.4)',
						  style: LightweightCharts.LineStyle.Dotted,
					  },
					  horzLines: {
						  color: 'rgba(197, 203, 206, 0.4)',
						  style: LightweightCharts.LineStyle.Dotted,
					  },
				  },
			  });

			let areaSeries = chart.addAreaSeries({
				lineColor: '#17D4E3',
				showInLegend: true,
				title: 'percentile',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});

			let extraSeries = chart.addAreaSeries({
				lineColor: '#3A6579',
				showInLegend: true,
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});

			areaSeries.setData(dataPoints2);
			extraSeries.setData(dataPoints1);
			chart.timeScale().fitContent();
		}
	}
}

function button_show_main_menu(){
	if (document.getElementById('main_menu_container').style.display == 'none') 
	{
		document.getElementById('main_menu_container').style.display = 'table';
		$('#main_menu_container').fadeTo(400, 1.0);
	}
	else
	{
		document.getElementById('main_menu_container').style.opacity = '0.0';
		document.getElementById('main_menu_container').style.display = 'none';
	}
}

function show_contact_us_form(){
	if (document.getElementById('contact_us_outer').style.display == 'none') 
	{
		document.getElementById('contact_us_outer').style.display = 'block';
		$('#contact_us_outer').fadeTo(600, 0.9);
		document.getElementById('news_wall_outer').style.opacity = '0.0';
		document.getElementById('news_wall_outer').style.display = 'none';
	}
	else
	{
		document.getElementById('contact_us_outer').style.opacity = '0.0';
		document.getElementById('contact_us_outer').style.display = 'none';
	}
}

function show_news_wall(){
	if (document.getElementById('news_wall_outer').style.display == 'none') 
	{
		document.getElementById('news_wall_outer').style.display = 'block';
		$('#news_wall_outer').fadeTo(600, 0.95);
		document.getElementById('contact_us_outer').style.opacity = '0.0';
		document.getElementById('contact_us_outer').style.display = 'none';
	}
	else
	{
		document.getElementById('news_wall_outer').style.opacity = '0.0';
		document.getElementById('news_wall_outer').style.display = 'none';
	}
}

function contact_us_form_onchange(){
	var vn = document.getElementById('contact_us_input_personname').value;
	var ve = document.getElementById('contact_us_input_email').value;
	var vt = document.getElementById('contact_us_input_details').value;
	
	if (
			vn.length > 0 && ve.length > 6 && vt.length > 5 && 
			vn.length <= 500 && ve.length <= 500 && vt.length <= 5000 && 
			ve.includes('@') && ve.includes('.')
	   )
		{
			document.getElementById('contact_us_input_submit').disabled = false;
			document.getElementById('contact_us_input_submit').style.opacity = '1.0';
		}
	else
		{
			document.getElementById('contact_us_input_submit').disabled = true;
			document.getElementById('contact_us_input_submit').style.opacity = '0.5';
		}
}

function setCookie(cname, cvalue, exp) {
	var d = new Date();
	d.setTime(d.getTime() + exp); 
	var expires = "expires="+ d.toUTCString(); document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function get_guest_status(){
	setCookie("network",    null, 0);
	setCookie("identity",   null, 0);
	setCookie("first_name", null, 0);
	setCookie("is_authorized_subscriber_user", null, 0);
	setCookie("is_authorized_subscriber_pass", null, 0);
	document.location.reload(true);
}

function showClientInfo() {
	
	if ($("span").is("#client_stat_final_return_all"))
	{
		val = $("#client_stat_final_return_all").html();
		
		if (val > -1)
		{
			vl00 = '';
			if (val >= 0.0005) vl00 = '+';
			val = vl00.concat((val * 100).toFixed(1).concat('%'));
			$("#client_stat_span_returl_all_show").text(val);
		}
	}

								if ($("div").is("#Invest_Level_Ind_graph_Wd"))
								{
									$.ajax({
										  type: 'POST',
										  url: 'php_db/ajax/get_Invest_Level_Index_chart_Wd.php',
										  data: { },
										  success: function(inf){
												var result = JSON.parse(inf);
												var dataPointsValue = [];
												var dataPointsValue_p75 = [];
												var dataPointsProgr = [];
												for (var i = 0; i <= result.length - 1; i++) {
													dataPointsValue.push({
														time: result[i].D,
														value: parseFloat(result[i].L) * 100
												  });
													dataPointsValue_p75.push({
														time: result[i].D,
														value: parseFloat(result[i].p75) * 100
													});
												  dataPointsProgr.push({
													label: result[i].D,
													y: parseFloat(result[i].V)
												  });
												}

												// Начало нового кода



											  let chart = LightweightCharts.createChart('Invest_Level_Ind_graph_Wd_container', {
												  mode: LightweightCharts.PriceScaleMode.Percentage,
												  localization: {
													  locale: 'en-us',
												  },
												  rightPriceScale: {
													  visible: false,
												  },
												  leftPriceScale: {
													  priceScaleId: 'left',
													  visible: true,
													  autoScale: true,
													  alignLabels: true,

													  scaleMargins: {
														  top: 0.1,
														  bottom: 0.1,
													  },
													  borderColor: 'rgba(197, 203, 206, 0.4)',
												  },
												  timeScale: {
													  rightOffset: 12,
													  fixRightEdge: true,
													  borderColor: 'rgba(197, 203, 206, 0.4)',
												  },
												  layout: {
													  backgroundColor: '#ffffff',
													  textColor: '#000000',
												  },
												  grid: {
													  vertLines: {
														  color: 'rgba(197, 203, 206, 0.4)',
														  style: LightweightCharts.LineStyle.Dotted,
													  },
													  horzLines: {
														  color: 'rgba(197, 203, 206, 0.4)',
														  style: LightweightCharts.LineStyle.Dotted,
													  },
												  },
											  });

												let areaSeries = chart.addAreaSeries({
													lineColor: '#1868C1',
													showInLegend: true,
													title: 'percentile',
													lineWidth: 1,
													bottomColor: 'transparent',
													topColor: 'transparent',
												});

												let extraSeries = chart.addAreaSeries({
													lineColor: '#6783A0',
													showInLegend: true,
													lineWidth: 2,
													bottomColor: 'transparent',
													topColor: 'transparent',
												});

												areaSeries.setData(dataPointsValue_p75);
												extraSeries.setData(dataPointsValue);
												chart.timeScale().fitContent();



											  	// Конец нового кода

												/*var chart = new CanvasJS.Chart("Invest_Level_Ind_graph_Wd", {
												  backgroundColor:"transparent",
												  axisY:  { valueFormatString:"########.#%", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  legend: { fontSize: 13 },
												  data:
												  [
													  {
														type: "line",
														yValueFormatString:"########.#%",
														color: "#78c1f5",
														dataPoints: dataPointsValue
													  }
												  ]
												});
												chart.render();*/

										  }
										});
								}

								if ($("div").is("#Invest_Level_Ind_graph_US"))
								{
									$.ajax({
										  type: 'POST',
										  url: 'php_db/ajax/get_Invest_Level_Index_chart_US.php',
										  data: { },
										  success: function(inf){
												var result = JSON.parse(inf);
												var dataPointsValue = [];
												var dataPointsValue_p75 = [];
												var dataPointsProgr = [];
												for (var i = 0; i <= result.length - 1; i++) {
												  dataPointsValue.push({
													time: result[i].D,
													value: parseFloat(result[i].L) * 100
												  });
													dataPointsValue_p75.push({
														time: result[i].D,
														value: parseFloat(result[i].p75) * 100
													});
												  dataPointsProgr.push({
													label: result[i].D,
													y: parseFloat(result[i].V)
												  });
												}



											  let chart = LightweightCharts.createChart('Invest_Level_Ind_graph_US_container', {
												  mode: LightweightCharts.PriceScaleMode.Percentage,
												  localization: {
													  locale: 'en-us',
												  },
												  rightPriceScale: {
													  visible: false,
												  },
												  leftPriceScale: {
													  priceScaleId: 'left',
													  visible: true,
													  autoScale: true,
													  alignLabels: true,

													  scaleMargins: {
														  top: 0.1,
														  bottom: 0.1,
													  },
													  borderColor: 'rgba(197, 203, 206, 0.4)',
												  },
												  timeScale: {
													  rightOffset: 12,
													  fixRightEdge: true,
													  borderColor: 'rgba(197, 203, 206, 0.4)',
												  },
												  layout: {
													  backgroundColor: '#ffffff',
													  textColor: '#000000',
												  },
												  grid: {
													  vertLines: {
														  color: 'rgba(197, 203, 206, 0.4)',
														  style: LightweightCharts.LineStyle.Dotted,
													  },
													  horzLines: {
														  color: 'rgba(197, 203, 206, 0.4)',
														  style: LightweightCharts.LineStyle.Dotted,
													  },
												  },
											  });

												let areaSeries = chart.addAreaSeries({
													lineColor: '#1868C1',
													showInLegend: true,
													title: 'percentile',
													lineWidth: 1,
													bottomColor: 'transparent',
													topColor: 'transparent',
												});

												let extraSeries = chart.addAreaSeries({
													lineColor: '#6783A0',
													showInLegend: true,
													lineWidth: 2,
													bottomColor: 'transparent',
													topColor: 'transparent',
												});

												areaSeries.setData(dataPointsValue_p75);
												extraSeries.setData(dataPointsValue);
												chart.timeScale().fitContent();

												/*var chart = new CanvasJS.Chart("Invest_Level_Ind_graph_US", {
												  backgroundColor:"transparent",
												  axisY:  { valueFormatString:"########.#%", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  legend: { fontSize: 13 },
												  data:
												  [
													  {
														type: "line",
														yValueFormatString:"########.#%",
														color: "#78c1f5",
														dataPoints: dataPointsValue
													  }
													  //,
													  //{
													  //  type: "line",
													  //  yValueFormatString:"########.#%",
													  //  color: "#F5B922",
													  //  dataPoints: dataPointsProgr
													  //}
												  ]
												});
												chart.render();*/
										  }
										});
								}
	
	if ($("select").is("#select_client_1") || $("div").is("#client_portfolio_chart") || $("div").is("#client_portfolio_chart_US") || $("div").is("#client_portfolio_chart_dist"))
	{
		vl = $("#hidden_client_container").html();
		$('#select_client_1').val(vl);
		
		if (vl != null && vl.length > 0)
		{
							vl_T = $("#client_portfolio_names").html();
							vl_P = $("#client_portfolio_parts").html();
							vl_C = $("#client_portfolio_depos").html();
							
							if (typeof(vl_T) !== 'undefined' && vl_T.length > 5)
							{
								var result_T = JSON.parse(vl_T);
								var result_P = JSON.parse(vl_P);
								var dataPointsValue_P = [];
								for (var i = 0; i <= result_T.length - 1; i++) {
									if (result_P[i] >= 0.05)
										dataPointsValue_P.push({
											label: result_T[i],
											y: parseFloat(result_P[i])
										  });
								}
								CanvasJS.addColorSet("canvasJS_ColorSet_1",
								 [
									"#3D5A80",
									"#98C1D9",
									"#E0FBFC",
									"#EE6C4D",
									"#293241",
									"#26395E",
									"#5F7C92",
									"#8CA0A0",
									"#AE4430",
									"#1A2031",
									"#6F444E",
									"#C8A2A8",
									"#F5E7E7",
									"#ED534C",
									"#3A2B2E"
								]);
								
								if ($("div").is("#client_portfolio_chart"))
								{
									var chart = new CanvasJS.Chart("client_portfolio_chart", {
									  backgroundColor:"transparent",
									  colorSet:  "canvasJS_ColorSet_1",
									  height:370,
									  width:370,
									  data: 
									  [
										  {
											type: "pie",
											startAngle: 270,
											yValueFormatString: "##0.0\"%\"",
											indexLabel: "{label} {y}",
											dataPoints: dataPointsValue_P
										  }
									  ]
									});
									chart.render();
								}
								
								if ($("div").is("#client_portfolio_chart_US"))
								{
									var chart = new CanvasJS.Chart("client_portfolio_chart_US", {
									  backgroundColor:"transparent",
									  colorSet:  "canvasJS_ColorSet_1",
									  height:370,
									  width:370,
									  data: 
									  [
										  {
											type: "pie",
											startAngle: 270,
											yValueFormatString: "##0.0\"%\"",
											indexLabel: "{label} {y}",
											dataPoints: dataPointsValue_P
										  }
									  ]
									});
									chart.render();
								}
								
								if ($("div").is("#client_portfolio_chart_dist"))
								{
									var chart = new CanvasJS.Chart("client_portfolio_chart_dist", {
									  backgroundColor:"transparent",
									  colorSet:  "canvasJS_ColorSet_1",
									  height:270,
									  width:270,
									  data: 
									  [
										  {
											type: "pie",
											startAngle: 270,
											yValueFormatString: "##0.0\"%\"",
											indexLabel: "{y}",
											dataPoints: dataPointsValue_P
										  }
									  ]
									});
									chart.render();
								}
								
								if ($("div").is("#client_portfolio_graph"))
								{
									var result_C = JSON.parse(vl_C);
									var dataPointsValue_C = [];
									var temp = 0.8888;
									for (var i = 0; i <= result_C.length - 1; i++) {
										if (temp != result_C[i]['D'])
										{
											dataPointsValue_C.push({
												time: result_C[i]['D'],
												value: parseFloat(result_C[i]['Depo'])
											});
											temp = result_C[i]['D'];
										}
									}
									
									if (dataPointsValue_C.length > 0)
									{
										let chart = LightweightCharts.createChart("client_portfolio_graph", {
											
											localization: {
												locale: 'en-us',
											},
											rightPriceScale: {
												visible: false,
											},

											leftPriceScale: {
												priceScaleId: 'left',
												visible: true,
												autoScale: true,
												alignLabels: true,
												 scaleMargins: {
													top: 0.15,
													bottom: 0.15,
												},
												borderColor: 'rgba(197, 203, 206, 0.4)',
											},

											timeScale: {
												rightOffset: 120,
												fixRightEdge: true,
												borderColor: 'rgba(197, 203, 206, 0.4)',
												
											},
											layout: {
												backgroundColor: '#ffffff',
												textColor: '#000000',
											},
											grid: {
												vertLines: {
													color: 'rgba(197, 203, 206, 0.4)',
													style: LightweightCharts.LineStyle.Dotted,
												},
												horzLines: {
													color: 'rgba(197, 203, 206, 0.4)',
													style: LightweightCharts.LineStyle.Dotted,
												},
											},
										});

										let areaSeries = chart.addAreaSeries({
											lineColor: '#3E3E87',
											lineWidth: 2,
											bottomColor: 'transparent',
											topColor: 'transparent',
										});
										
										areaSeries.applyOptions({
											priceFormat: {
												type: 'volume',
												precision: 2,
												minMove: 1,
											},
										});
										
										areaSeries.setData(dataPointsValue_C);
										chart.timeScale().setVisibleRange({
											from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
											to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
										});
									}
								}
							}
							
								if ($("div").is("#Invest_Level_Ind_graph"))
								{
									$.ajax({
										  type: 'POST',
										  url: 'php_db/ajax/get_Invest_Level_Index_chart.php',
										  data: { },
										  success: function(inf){
												var result = JSON.parse(inf);
												var dataPointsValue = [];
												var dataPointsValue_p75 = [];
												for (var i = 0; i <= result.length - 1; i++) {
													dataPointsValue.push({
													label: result[i].D,
													y: parseFloat(result[i].L)
												  });
													dataPointsValue_p75.push({
													label: result[i].D,
													y: parseFloat(result[i].p75)
												  });
												}
												
												var chart = new CanvasJS.Chart("Invest_Level_Ind_graph", {
												  backgroundColor:"transparent",
												  axisY:  { valueFormatString:"########.#%", gridThickness: 0, labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  axisX:  { labelFontSize: 13, gridColor:"#ECECEC", labelFontColor: "#6783A0" },
												  legend: { fontSize: 13 },
													
												  data: 
												  [
													  {
														type: "line",
														yValueFormatString:"########.#%",
														color: "#78c1f5",
														showInLegend: true,
														legendText: 'Invest Level Index',
														dataPoints: dataPointsValue
													  },
													  {
														type: "line",
														yValueFormatString:"########.#%",
														color: "#1868C1",
														showInLegend: true,
														legendText: 'percentile',
														dataPoints: dataPointsValue_p75
													  }
												  ]
												});
												chart.render();
										  }
										});
								}
		}
		else
		{
			var client = document.getElementById('select_client_1').options[0].value;
			pname = document.location.href;
			p = pname.indexOf(".php");
			pname = pname.substring(0, p);
			p = Math.max(pname.lastIndexOf("/"), pname.lastIndexOf("\\"));
			pname = pname.substring(p + 1);
			window.location = "/" + pname + ".php?client=" + client;
		}
	}
	
	if ($("div").is("#client_dist_chart"))
	{
		vl_C = $("#client_dist_json").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_D = [];
		var minDepo = 1000000000;
		var maxDepo = 0;
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_D.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['Depo'])
			});
			minDepo = Math.min(minDepo, result_C[i]['Depo']);
			maxDepo = Math.max(maxDepo, result_C[i]['Depo']);
		}
		var minDepo_0 = minDepo;
		if (minDepo <= 100) minDepo = Math.min(70, minDepo - 10);
		else minDepo = Math.floor((minDepo * 3/5) / 1000) * 1000;
		minDepo = Math.max(0, minDepo);
		if (minDepo < 0.7) minDepo = Math.min(0.7, minDepo_0 + 0.7 - 1);
		maxDepo = Math.round((maxDepo * 7/6) / 1000) * 1000;
		var chart = new CanvasJS.Chart("client_dist_chart", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: minDepo,
				   maximum: maxDepo,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###",
				color: "#EBD441",
				dataPoints: dataPointsValue_D
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#SPAC_3_prices_graph"))
	{
		vl_C = $("#SPAC_3_prices_graph_data").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_1 = [];
		var dataPointsValue_2 = [];
		var dataPointsValue_3 = [];
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_1.push({
				label: result_C[i][0],
				y: parseFloat(result_C[i][1])
			});
			dataPointsValue_2.push({
				label: result_C[i][0],
				y: parseFloat(result_C[i][2])
			});
			dataPointsValue_3.push({
				label: result_C[i][0],
				y: parseFloat(result_C[i][3])
			});
		}
		var chart = new CanvasJS.Chart("SPAC_3_prices_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: 0,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###.##",
				color: "#EC8115",
				dataPoints: dataPointsValue_1
			  },
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###.##",
				color: "#4BC6FF",
				dataPoints: dataPointsValue_2
			  },
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###.##",
				color: "#000077",
				dataPoints: dataPointsValue_3
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#SPAC_stat_hist_graph"))
	{
		vl_C = $("#SPAC_stat_hist_graph_data").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var dataPointsValue_I = [];
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['SPAC'])
			});
			dataPointsValue_I.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['SP500'])
			});
		}
		var chart = new CanvasJS.Chart("SPAC_stat_hist_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: 0,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###.##",
				color: "#EBD441",
				dataPoints: dataPointsValue_C
			  },
			  {
				type: "line",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###.##",
				color: "#000000",
				dataPoints: dataPointsValue_I
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#SPAC_stat_hist_graph_price"))
	{
		vl_C = $("#SPAC_stat_hist_graph_data_price").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['SPAC'])
			});
		}
		var chart = new CanvasJS.Chart("SPAC_stat_hist_graph_price", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: 0,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###.##",
				color: "#3E3E87",
				dataPoints: dataPointsValue_C
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#SPAC_stat_potential_graph"))
	{
		vl_C = $("#SPAC_stat_potential_graph_data").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var dataPointsValue_C2 = [];
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['Ratio'])
			});
			dataPointsValue_C2.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['Ratio_W'])
			});
		}
		var chart = new CanvasJS.Chart("SPAC_stat_potential_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: -1.2,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"######.#%",
				color: "#3E3E87",
				dataPoints: dataPointsValue_C
			  },
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"######.#%",
				color: "#D85A00",
				dataPoints: dataPointsValue_C2
			  }
		  ]
		});
		chart.render();
	}
	
	/*
	if ($("div").is("#AUM_sums_graph"))
	{
		vl_C = $("#AUM_sums").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var minDepo = 1000000000;
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S'])
			});
			minDepo = Math.min(minDepo, result_C[i]['S']);
		}
		var minDepo_0 = minDepo;
		if (minDepo <= 100) minDepo = Math.min(70, minDepo - 10);
		else minDepo = Math.floor((minDepo * 3/5) / 100000) * 100000;
		minDepo = Math.max(0, minDepo);
		if (minDepo < 0.7) minDepo = Math.min(0.7, minDepo_0 + 0.7 - 1);
		var chart = new CanvasJS.Chart("AUM_sums_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: minDepo,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "line",
				lineThickness: 2,
				yValueFormatString:"### ### ### ###",
				color: "#3E3E87",
				dataPoints: dataPointsValue_C
			  }
		  ]
		});
		chart.render();
	}
	*/
	
	if ($("div").is("#AUM_sums_graph"))
	{
		vl_C = $("#AUM_sums").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var temp = 0.8888;
		for (var i = 0; i <= result_C.length - 1; i++)
		{
			if (temp != result_C[i]['D'])
			{
				dataPointsValue_C.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['S'])
				});
				temp = result_C[i]['D'];
			}
		}
		
		var chart = LightweightCharts.createChart("AUM_sums_graph",
		{
			
			localization: {
				locale: 'en-us',
			},
			rightPriceScale: {
				visible: false,
			},

			leftPriceScale: {
				priceScaleId: 'left',
				visible: true,
				autoScale: true,
				alignLabels: true,
				 scaleMargins: {
					top: 0.15,
					bottom: 0.05,
				},
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},

			timeScale: {
				rightOffset: 120,
				fixRightEdge: true,
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},
			layout: {
				backgroundColor: '#ffffff',
				textColor: '#000000',
			},
			grid: {
				vertLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
				horzLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
			},
		});

		var areaSeries = chart.addAreaSeries({
			lineColor: '#3E3E87',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});
		
		areaSeries.applyOptions({
			priceFormat: {
				type: 'volume',
				precision: 2,
				minMove: 1,
			},
		});
		
		areaSeries.setData(dataPointsValue_C);
		chart.timeScale().setVisibleRange({
			from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
			to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
		});
	}
	
	if ($("div").is("#sub_sums_graph"))
	{
		vl_C = $("#sub_sums").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var minDepo = 1000000000;
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S'])
			});
			minDepo = Math.min(minDepo, result_C[i]['S']);
		}
		var minDepo_0 = minDepo;
		if (minDepo <= 100) minDepo = Math.min(70, minDepo - 10);
		else minDepo = Math.floor((minDepo * 3/5) / 100000) * 100000;
		minDepo = Math.max(0, minDepo);
		if (minDepo < 0.7) minDepo = Math.min(0.7, minDepo_0 + 0.7 - 1);
		var chart = new CanvasJS.Chart("sub_sums_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: minDepo,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				type: "column",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###",
				color: "#6BAFFC",
				dataPoints: dataPointsValue_C
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#rev_sums_graph"))
	{
		vl_C = $("#rev_sums").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var dataPointsValue_C2 = [];
		var minDepo = 0;
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S1'])
			});
			dataPointsValue_C2.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S2'])
			});
		}
		var chart = new CanvasJS.Chart("rev_sums_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: minDepo,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				showInLegend: true, 
				name: "series1",
				legendText: "Asset management",
				
				type: "stackedColumn",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###",
				color: "#3E3E87",
				dataPoints: dataPointsValue_C
			  },
			  {
				showInLegend: true, 
				name: "series2",
				legendText: "Subscriptions",
				
				indexLabelPlacement: "outside",  
				indexLabelOrientation: "horizontal",
				type: "stackedColumn",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###",
				color: "#6BAFFC",
				dataPoints: dataPointsValue_C2
			  }
		  ]
		});
		chart.render();
	}
	
	if ($("div").is("#rev_USD_sums_graph"))
	{
		vl_C = $("#rev_USD_sums").html();
		var result_C = JSON.parse(vl_C);
		var dataPointsValue_C = [];
		var dataPointsValue_C2 = [];
		var minDepo = 0;
		for (var i = 0; i <= result_C.length - 1; i++) {
			dataPointsValue_C.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S1'])
			});
			dataPointsValue_C2.push({
				label: result_C[i]['D'],
				y: parseFloat(result_C[i]['S2'])
			});
		}
		var chart = new CanvasJS.Chart("rev_USD_sums_graph", {
		  backgroundColor:"transparent",
		  axisY:{
				   minimum: minDepo,
				   gridColor:"#ECECEC",
				   labelFontColor: "#6783A0"
				 },
		  axisX:{
				   labelFontColor: "#6783A0", gridColor:"#ECECEC"
				 },
		  data: 
		  [
			  {
				showInLegend: true, 
				name: "series1",
				legendText: "Asset management",
				
				type: "stackedColumn",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###",
				color: "#3E3E87",
				dataPoints: dataPointsValue_C
			  },
			  {
				showInLegend: true, 
				name: "series2",
				legendText: "Subscriptions",
				
				indexLabelPlacement: "outside",  
				indexLabelOrientation: "horizontal",
				type: "stackedColumn",
				lineThickness: 1,
				yValueFormatString:"### ### ### ###",
				color: "#6BAFFC",
				dataPoints: dataPointsValue_C2
			  }
		  ]
		});
		chart.render();
	}
	
	// если на странице существует элемент с id
	graph_div_id = '_GC_neutral_graph';
	if ($("div").is("#".concat(graph_div_id)))
	{
		vl_C = $("#_GC_neutral_data").html();
		let result_C = JSON.parse(vl_C);
		
		let dataPointsValue_C = [];
		let dataPointsValue_SP = [];
		for (let i = 0; i <= result_C.length - 1; i++)
		{
			dataPointsValue_C.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['L1'])
			});
			dataPointsValue_SP.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['L2'])
			});
		}
		
		let chart = LightweightCharts.createChart(graph_div_id, {
			
			localization: {
				locale: 'en-us',
			},
			rightPriceScale: {
				visible: false,
			},

			leftPriceScale: {
				priceScaleId: 'left',
				visible: true,
				autoScale: true,
				alignLabels: true,
				 scaleMargins: {
					top: 0.15,
					bottom: 0.15,
				},
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},

			timeScale: {
				rightOffset: 120,
				fixRightEdge: true,
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},
			layout: {
				backgroundColor: '#ffffff',
				textColor: '#000000',
			},
			grid: {
				vertLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
				horzLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
			},
		});

		let areaSeries = chart.addAreaSeries({
			lineColor: '#B8B9CA',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});

		let extraSeries = chart.addAreaSeries({
			lineColor: '#17D4E3',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});
		areaSeries.setData(dataPointsValue_SP);
		extraSeries.setData(dataPointsValue_C);
		//chart.timeScale.fitContent();
		chart.timeScale().setVisibleRange({
			from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
			to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
		});
	}
	
	graph_div_id = 'invest_level_mod_graph';
	if ($("div").is("#".concat(graph_div_id)))
	{
		vl_C = $('#'.concat(graph_div_id).concat('_data')).html();
		let result_C = JSON.parse(vl_C);
		
		let dataPointsValue_C = [];
		let dataPointsValue_C_Mod = [];
		let dataPointsValue_IL = [];
		let dataPointsValue_IL_p75 = [];
		for (let i = 0; i <= result_C.length - 1; i++)
		{
			dataPointsValue_C.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['P0'])
			});
			dataPointsValue_C_Mod.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['P_p_Mod'])
			});
			dataPointsValue_IL.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['L'])
			});
			dataPointsValue_IL_p75.push({
				time: result_C[i]['D'],
				value: parseFloat(result_C[i]['L_per'])
			});
		}
		
		let chart = LightweightCharts.createChart(graph_div_id, {
			
			localization: {
				locale: 'en-us',
			},
			rightPriceScale: {
				visible: false,
			},

			leftPriceScale: {
				priceScaleId: 'left',
				visible: true,
				autoScale: true,
				alignLabels: true,
				 scaleMargins: {
					top: 0.15,
					bottom: 0.15,
				},
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},

			timeScale: {
				rightOffset: 120,
				fixRightEdge: true,
				borderColor: 'rgba(197, 203, 206, 0.4)',
			},
			layout: {
				backgroundColor: '#ffffff',
				textColor: '#000000',
			},
			grid: {
				vertLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
				horzLines: {
					color: 'rgba(197, 203, 206, 0.4)',
					style: LightweightCharts.LineStyle.Dotted,
				},
			},
		});

		let areaSeries = chart.addAreaSeries({
			lineColor: '#C0FF5A',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});

		let extraSeries1 = chart.addAreaSeries({
			lineColor: '#B8B9CA',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});

		let extraSeries2 = chart.addAreaSeries({
			lineColor: '#444444',
			lineWidth: 2,
			bottomColor: 'transparent',
			topColor: 'transparent',
		});
		
		areaSeries.setData(dataPointsValue_C);
		extraSeries1.setData(dataPointsValue_IL);
		extraSeries2.setData(dataPointsValue_IL_p75);
		//chart.timeScale.fitContent();
		chart.timeScale().setVisibleRange({
			from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
			to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
		});
	}
	
}

function drawTWchart_hybrid() {
	
	let graph_divs =
	[
		['hybrid_usd_graph_div', 'hybrid_usd_graph_json'],
	];
	
	for (let u = 0; u < graph_divs.length; u++)
	{
		// если на странице существует элемент с id
		if ($("div").is("#".concat(graph_divs[u][0])))
		{
			// берем из тега с id всё содержимое (json) и преобразуем в массив массивов
			vl_C = $("#".concat(graph_divs[u][1])).html();
			let result_C = JSON.parse(vl_C);
			
			// разбиваем полученный массив на 2: для отображения графика портфеля и для отображения графика SP500
			
			let dataPointsValue_C = [];
			let dataPointsValue_SP = [];
			
			let dataPointsValue_US = [];
			let dataPointsValue_GC = [];
			let dataPointsValue_RS = [];
			let dataPointsValue_TI = [];
			let dataPointsValue_SH = [];
			let dataPointsValue_RR = [];
			let dataPointsValue_UI = [];
			
			for (let i = 0; i <= result_C.length - 1; i++) {
				
				dataPointsValue_C.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['Depo'])
				});
				dataPointsValue_SP.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['SP500'])
				});
				
				// --------
				
				dataPointsValue_US.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['US'])
				});
				dataPointsValue_GC.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['GC'])
				});
				dataPointsValue_RS.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['RS'])
				});
				dataPointsValue_TI.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['TI'])
				});
				dataPointsValue_SH.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['SH'])
				});
				dataPointsValue_RR.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['RR'])
				});
				dataPointsValue_UI.push({
					time: result_C[i]['D'],
					value: parseFloat(result_C[i]['UI'])
				});
			}
			
			let chart = LightweightCharts.createChart(graph_divs[u][0], {
				
				localization: {
					locale: 'en-us',
				},
				rightPriceScale: {
					visible: false,
				},

				leftPriceScale: {
					priceScaleId: 'left',
					visible: true,
					autoScale: true,
					alignLabels: true,
					 scaleMargins: {
						top: 0.15,
						bottom: 0.15,
					},
					borderColor: 'rgba(197, 203, 206, 0.4)',
				},

				timeScale: {
					rightOffset: 120,
					fixRightEdge: true,
					borderColor: 'rgba(197, 203, 206, 0.4)',
				},
				layout: {
					backgroundColor: '#ffffff',
					textColor: '#000000',
				},
				grid: {
					vertLines: {
						color: 'rgba(197, 203, 206, 0.4)',
						style: LightweightCharts.LineStyle.Dotted,
					},
					horzLines: {
						color: 'rgba(197, 203, 206, 0.4)',
						style: LightweightCharts.LineStyle.Dotted,
					},
				},
			});

			let areaSeries = chart.addAreaSeries({
				lineColor: '#B8B9CA',
				lineWidth: 2,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			areaSeries.setData(dataPointsValue_SP);
			
			let extraSeries = chart.addAreaSeries({
				lineColor: '#17D4E3',
				lineWidth: 2,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries.setData(dataPointsValue_C);
			
			// --------
			
			let extraSeries_US = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_US.setData(dataPointsValue_US);
			
			let extraSeries_GC = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_GC.setData(dataPointsValue_GC);
			
			let extraSeries_RS = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_RS.setData(dataPointsValue_RS);
			
			let extraSeries_TI = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_TI.setData(dataPointsValue_TI);
			
			let extraSeries_SH = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_SH.setData(dataPointsValue_SH);
			
			let extraSeries_RR = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_RR.setData(dataPointsValue_RR);
			
			let extraSeries_UI = chart.addAreaSeries({
				lineColor: '#D9E3F7',
				lineWidth: 1,
				bottomColor: 'transparent',
				topColor: 'transparent',
			});
			extraSeries_UI.setData(dataPointsValue_UI);
			
			// --------
			
			//chart.timeScale.fitContent();
			chart.timeScale().setVisibleRange({
				from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
				to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
			});
		}
	}
}

// GRAPHS Profitability vs Market Index

function drawTWchart() {
	
	let graph_divs =
	[
		['client_portfolio_graph_RS_page', 'client_portfolio_depos_RS'],
		['client_portfolio_graph_Rs_about_page', 'client_portfolio_depos_Rs'],
		
		['client_portfolio_graph_TI_page', 'client_portfolio_depos_TI'],
		['client_portfolio_graph_TI_about_page', 'client_portfolio_depos_TI'],
		
		['client_portfolio_graph_Wd_page', 'client_portfolio_depos_Wd'],
		['client_portfolio_graph_Wd_about_page', 'client_portfolio_depos_Wd'],
		
		['client_portfolio_graph_US_page', 'client_portfolio_depos_US'],
		['client_portfolio_graph_US_about_page', 'client_portfolio_depos_US'],
		
		['client_portfolio_graph_UI_page', 'client_portfolio_depos_UI'], 
		['client_portfolio_graph_UI_about_page', 'client_portfolio_depos_UI'], 
		
		['client_portfolio_graph_SH_page', 'client_portfolio_depos_SH'],
		['client_portfolio_graph_SH_about_page', 'client_portfolio_depos_SH'],
		
		['client_portfolio_graph_RR_page', 'client_portfolio_depos_RR'], 
		['client_portfolio_graph_RR_about_page', 'client_portfolio_depos_RR'], 
		
		['client_portfolio_graph_RS_SPB_page', 'client_portfolio_depos_RS_SPB'],
		
		['client_portfolio_graph_SW_page', 'client_portfolio_depos_SW'],
		
		['client_portfolio_graph_GC_E_page', 'client_portfolio_depos_GC_E'],
		
		['client_portfolio_graph_TR_page', 'client_portfolio_depos_TR'],
		['client_portfolio_graph_ST_page', 'client_portfolio_depos_ST'],
		['client_portfolio_graph_JSE_page', 'client_portfolio_depos_JSE'],
		
		['us_insiders_backtest_graph', 'us_insiders_backtest_json'],
		['strategy_backtest_graph', 'strategy_backtest_json'],
	];
	
	for (let u = 0; u < graph_divs.length; u++)
	{
		// если на странице существует элемент с id
		if ($("div").is("#".concat(graph_divs[u][0])))
		{
			if (graph_divs[u][0] == 'client_portfolio_graph_GC_E_page')
			{
				// берем из тега с id всё содержимое (json) и преобразуем в массив массивов
				vl_C = $("#".concat(graph_divs[u][1])).html();
				let result_C = JSON.parse(vl_C);
				
				// разбиваем полученный массив на 2: для отображения графика портфеля и для отображения графика SP500
				let dataPointsValue_C = [];
				let dataPointsValue_GC_E = [];
				let dataPointsValue_SP = [];
				for (let i = 0; i <= result_C.length - 1; i++) {
					dataPointsValue_C.push({
						time: result_C[i]['D'],
						value: parseFloat(result_C[i]['Depo'])
					});
					dataPointsValue_SP.push({
						time: result_C[i]['D'],
						value: parseFloat(result_C[i]['SP500'])
					});
					
					if (
							result_C[i]['D'] == '2021-04-25' ||
							result_C[i]['D'] == '2021-04-26' || 
							result_C[i]['D'] == '2021-04-27' || 
							result_C[i]['D'] == '2021-04-28' || 
							result_C[i]['D'] == '2021-04-29'
						)
					{
						dataPointsValue_GC_E.push({
							time: result_C[i]['D'],
							value: 174.1
						});
					}
				}
				
				let chart = LightweightCharts.createChart(graph_divs[u][0], {
					
					localization: {
						locale: 'en-us',
					},
					rightPriceScale: {
						visible: false,
					},

					leftPriceScale: {
						priceScaleId: 'left',
						visible: true,
						autoScale: true,
						alignLabels: true,
						 scaleMargins: {
							top: 0.15,
							bottom: 0.15,
						},
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},

					timeScale: {
						rightOffset: 120,
						fixRightEdge: true,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					layout: {
						backgroundColor: '#ffffff',
						textColor: '#000000',
					},
					grid: {
						vertLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
						horzLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
					},
				});
				
				let areaSeries = chart.addAreaSeries({
					lineColor: '#B8B9CA',
					lineWidth: 2,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});
				
				let extraSeries2 = chart.addAreaSeries({
					lineColor: '#EB415A',
					lineWidth: 4,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});
				
				let extraSeries = chart.addAreaSeries({
					lineColor: '#17D4E3',
					lineWidth: 2,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});
				
				areaSeries.setData(dataPointsValue_SP);
				extraSeries2.setData(dataPointsValue_GC_E);
				extraSeries.setData(dataPointsValue_C);
				//chart.timeScale.fitContent();
				chart.timeScale().setVisibleRange({
					from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
					to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
				});
			}
			else
			{
				// берем из тега с id всё содержимое (json) и преобразуем в массив массивов
				vl_C = $("#".concat(graph_divs[u][1])).html();
				let result_C = JSON.parse(vl_C);
				
				// разбиваем полученный массив на 2: для отображения графика портфеля и для отображения графика SP500
				let dataPointsValue_C = [];
				let dataPointsValue_SP = [];
				for (let i = 0; i <= result_C.length - 1; i++) {
					dataPointsValue_C.push({
						time: result_C[i]['D'],
						value: parseFloat(result_C[i]['Depo'])
					});
					dataPointsValue_SP.push({
						time: result_C[i]['D'],
						value: parseFloat(result_C[i]['SP500'])
					});
				}
				
				let chart = LightweightCharts.createChart(graph_divs[u][0], {
					
					localization: {
						locale: 'en-us',
					},
					rightPriceScale: {
						visible: false,
					},

					leftPriceScale: {
						priceScaleId: 'left',
						visible: true,
						autoScale: true,
						alignLabels: true,
						 scaleMargins: {
							top: 0.15,
							bottom: 0.15,
						},
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},

					timeScale: {
						rightOffset: 120,
						fixRightEdge: true,
						borderColor: 'rgba(197, 203, 206, 0.4)',
					},
					layout: {
						backgroundColor: '#ffffff',
						textColor: '#000000',
					},
					grid: {
						vertLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
						horzLines: {
							color: 'rgba(197, 203, 206, 0.4)',
							style: LightweightCharts.LineStyle.Dotted,
						},
					},
				});

				let areaSeries = chart.addAreaSeries({
					lineColor: '#B8B9CA',
					lineWidth: 2,
					bottomColor: 'transparent',
					topColor: 'transparent',
				});
				areaSeries.setData(dataPointsValue_SP);
				
				temp = 0;
				for (var a = 0; a < dataPointsValue_C.length; a++) 
				{
					temp = temp + dataPointsValue_C[a]['value'];
				}
				temp = temp / dataPointsValue_C.length;
				
				if (temp != 100)
				{
					let extraSeries = chart.addAreaSeries({
						lineColor: '#17D4E3',
						lineWidth: 2,
						bottomColor: 'transparent',
						topColor: 'transparent',
					});
					extraSeries.setData(dataPointsValue_C);
				}
				
				//chart.timeScale.fitContent();
				chart.timeScale().setVisibleRange({
					from: (new Date(Date.UTC(2010, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
					to: (new Date(Date.UTC(2100, 12, 31, 0, 0, 0, 0))).getTime() / 1000,
				});
			}
		}
	}
}