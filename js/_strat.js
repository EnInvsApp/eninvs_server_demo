var colorArray = [
		  '#333333', '#941732', '#FFFF88', '#CCCCCC', '#FF00FF',
		  '#FFFF00', '#FF8888', '#88FF88', '#8888FF', '#FF0000',
		  '#00FF00', '#0000FF', '#6AABD4', '#00FFBB', '#999999',
		  '#FFB41E', '#035D03', '#888888', '#0CAFD4', '#D479A2',
		  '#333333', '#E64D66', '#4DB380', '#FF4D4D', '#66664D',
		  '#99E6E6', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
		  '#E666B3', '#33991A', '#CC9999', '#B33300', '#CC80CC',
		  '#4D8066', '#FFFF7D', '#E6FF80', '#1AFF33', '#999933',
		  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
		  '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
		  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
		  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
		  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
		  '#66994D', '#B366CC', '#4D8000', '#B3B31A', '#00E680',
		  '#6666FF', '#8F9900',
		  '#333333', '#941732', '#FFFF88', '#CCCCCC', '#FF00FF',
		  '#FFFF00', '#FF8888', '#88FF88', '#8888FF', '#FF0000',
		  '#00FF00', '#0000FF', '#6AABD4', '#00FFBB', '#999999',
		  '#FFB41E', '#035D03', '#888888', '#0CAFD4', '#D479A2',
		  '#333333', '#E64D66', '#4DB380', '#FF4D4D', '#66664D',
		  '#99E6E6', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
		  '#E666B3', '#33991A', '#CC9999', '#B33300', '#CC80CC',
		  '#4D8066', '#FFFF7D', '#E6FF80', '#1AFF33', '#999933',
		  '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
		  '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
		  '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
		  '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
		  '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
		  '#66994D', '#B366CC', '#4D8000', '#B3B31A', '#00E680',
		  '#6666FF', '#8F9900'
		];

$(window).on('pageshow', function(){
	
	graphs_strategy_grow();
	graphs_strategy_grow_all();
	graphs_strategy_comm();
	graphs_strategy_comm_all();
	graphs_strategy_gaap_all();
})

function method_change() {
	vl = $('#strat_input_method_select').val();
	if (vl == 'mult') document.getElementById("strat_input_common_select").disabled = true;
	else              document.getElementById("strat_input_common_select").disabled = false;
}

function graphs_strategy_grow()
{
	if ($("div").is("#graphs_strategy_grow"))
	{
		ticker = $("#ticker_hidden_div").html();
		buy_c = parseFloat($("#buy_condition").html()) / 100;
		date_1 = $("#date_1_hidden_div").html();
		date_2 = $("#date_2_hidden_div").html();
		Dprice = $("#Dprice_hidden_div").html();
		save_R = $("#save_R_hidden_div").html();
		method = $("#method_hidden_div").html();
		common = $("#common_hidden_div").html();
		
		$('#strat_input_1_select').val(ticker);
		$('#strat_input_2').val(buy_c * 100);
		$('#strat_input_3').val(date_1);
		$('#strat_input_4').val(date_2);
		$('#strat_input_5_select').val(Dprice);
		$('#strat_input_6_select').val(save_R);
		$('#strat_input_method_select').val(method);
		$('#strat_input_common_select').val(common);
		
		var minPrice = 0;
		var maxPrice = 0;
		var minPrice_high = 0;
		var maxPrice_high = 0;
		
		var drawdown =         0;
		var drawdown_high =    0;
		var draw_dv_sum =      0;
		var draw_dv_sum_high = 0;
		var minPriceMemory      = 0;
		var maxPriceMemory      = 0;
		var minPriceMemory_high = 0;
		var maxPriceMemory_high = 0;
		var minDate      = "";
		var maxDate      = "";
		var minDate_high = "";
		var maxDate_high = "";
		
		var maxDateTemp = "";
		var maxDateTemp_high = "";
		var t0 = 0;
		
		var inStock = false;
		var inStockYest = false;
		var depo = 1;
		var startPrice = 0;
		
		var startDate = 0;
		var endDate   = 0;
		var datesSum  = 0;
		var price_DIV_high_FULL = 0;
		
		// potential
		var inf2   = $("#potential_json_hidden_div").html();
		var result = JSON.parse(inf2);
		
		// dividend
		var inf_div = $("#dividend_json_hidden_div").html();
		var result_div = JSON.parse(inf_div);
		var result_div_marked = 0;
		for (var y = 0; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) < new Date(result[0].Date)) result_div_marked++;
		
		var price_IN = result[0].Price*1;
		var price_OUT = result[result.length - 2].Price*1;
		if (Dprice == "t")
		{
			price_IN = result[1].Price*1;
			price_OUT = result[result.length - 1].Price*1;
		}
		else if (Dprice == "yt")
		{
			price_IN  = (result[0].Price*1 + result[1].Price*1) / 2;
			price_OUT = (result[result.length - 2].Price*1 + result[result.length - 1].Price*1) / 2;
		}
		
		// income rate
		price_IN  = parseFloat(price_IN);
		price_OUT = parseFloat(price_OUT);
		price_DIV = parseFloat(document.getElementById("sum_dividend_all").innerHTML);
		var income_rate_all = (price_OUT + price_DIV) / price_IN - 1;
		
		var dt_2 = new Date(result[result.length - 1].Date);
		var dt_1 = new Date(result[1                ].Date);
		var date_gap = (dt_2.getTime() - dt_1.getTime()) / (1000*60*60*24);
		var income_rate_all_y = Math.pow(income_rate_all+1, 365/date_gap) - 1;
		
		// price graph
		var dataPoints10 = [];
		var dataPoints11 = [];
		var dataPoints_div = [];
		
		for (var i = 0; i <= result.length - 1; i++)
		{
			var div_push_val = false;
			var dv = 0;
			for (var y = result_div_marked; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) <= new Date(result[i].Date)) 
				{ dv = parseFloat(result_div[y].Dv); div_push_val = true; result_div_marked++; continue; };
			
			if (div_push_val)
				dataPoints_div.push({
						label: result[i].Date,
						y: dv
					  });
			else
				dataPoints_div.push({
						label: result[i].Date,
						y: null
					  });
			
			if (result[i].Potential >= buy_c || (i > 0 && result[i-1].Potential >= buy_c))
			{
				dataPoints10.push({
					label: result[i].Date,
					y: null
				  });
				dataPoints11.push({
					label: result[i].Date,
					y: parseFloat(result[i].Price)
				  });
			}
			else
			{
				dataPoints10.push({
					label: result[i].Date,
					y: parseFloat(result[i].Price)
				  });
				dataPoints11.push({
					label: result[i].Date,
					y: null
				  });
			}
		}			
		
		var chart = new CanvasJS.Chart("graphs_strategy_price", {
		  axisY:{
				  valueFormatString:"######",
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
		  },
		  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
		  },
	      data: 
	      [
	    	  {
			    type: "line",
		        yValueFormatString:"######.######",
		    	color: "#78c1f5",
		        dataPoints: dataPoints10
	    	  },
			  {
			    type: "line",
		        yValueFormatString:"######.######",
		    	color: "#00FF00",
		        dataPoints: dataPoints11
	    	  },
			  {
			    type: "scatter",
		        yValueFormatString:"######.######",
		    	color: "#FF9900",
		        dataPoints: dataPoints_div
	    	  }
	      ]
	    });
	    chart.render();
		
		// potential graph
		var dataPoints1 = [];
		var dataPoints2 = [];
		var dataPoints3 = [];
		var dataPoints4 = [];
		for (var i = 0; i <= result.length - 1; i++)
		{
			if (result[i].Potential >= buy_c)
			{
				dataPoints1.push({
					label: result[i].Date,
					y: parseFloat(result[i].Potential)
				});
				dataPoints2.push({
					label: result[i].Date,
					y: null
				});
			}
			else
			{
				dataPoints1.push({
					label: result[i].Date,
					y: null
				});
				dataPoints2.push({
					label: result[i].Date,
					y: parseFloat(result[i].Potential)
				});
			}
			
			dataPoints3.push({
				label: result[i].Date,
				y: buy_c
			});
			dataPoints4.push({
				label: result[i].Date,
				y: 0
			});
		}
		
		var chart2 = new CanvasJS.Chart("graphs_strategy_potential", {
			axisY:{
					valueFormatString:"#####%",
					gridColor:"#ECECEC",
				    labelFontColor: "#6783A0"
			},
			axisX:{
					gridColor:"#ECECEC",
				    labelFontColor: "#6783A0"
			},
			data: 
			[
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#00BB00",
					dataPoints: dataPoints1
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#BB0000",
					dataPoints: dataPoints2
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#5A269D",
					dataPoints: dataPoints3
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#5A269D",
					dataPoints: dataPoints4
				}
			]
		});
		chart2.render();
		
		// drawdown
		for (var i = 0; i <= result.length - 1; i++)
		{
			if (i == 0)
			{
				minPrice = result[i].Price;
				maxPrice = result[i].Price;
				draw_dv_sum = dv;
				maxDateTemp = result[i].Date;
			}
			else
			{
				if (result[i].Price > maxPrice - draw_dv_sum)
				{
					maxPrice = result[i].Price;
					draw_dv_sum = dv;
					minPrice = result[i].Price;
					maxDateTemp = result[i].Date;
				}
				else 
				{
					draw_dv_sum += dv;
					if (result[i].Price < minPrice)
					{
						minPrice = result[i].Price;
						t0 = ((minPrice + draw_dv_sum) / maxPrice) - 1;
						if (drawdown > t0)
						{
							drawdown = t0;
							minDate = result[i].Date;
							maxDate = maxDateTemp;
							minPriceMemory = minPrice;
							maxPriceMemory = maxPrice;
						}
					}
				}
			}
			
			// drawdown high
			if (result[i].Potential >= buy_c)
			{
				if (result[i].Price > maxPrice_high - draw_dv_sum_high)
				{
					maxPrice_high = result[i].Price;
					draw_dv_sum_high = dv;
					minPrice_high = result[i].Price;
					maxDateTemp_high = result[i].Date;
				}
				else 
				{
					draw_dv_sum_high += dv;
					if (result[i].Price < minPrice_high)
					{
						minPrice_high = result[i].Price;
						t0 = ((minPrice_high + draw_dv_sum_high) / maxPrice_high) - 1;
						if (drawdown_high > t0)
						{
							drawdown_high = t0;
							minDate_high = result[i].Date;
							maxDate_high = maxDateTemp_high;
							minPriceMemory_high = minPrice_high;
							maxPriceMemory_high = maxPrice_high;
						}
					}
				}
			}
			else
			{
				maxPrice_high    = 0;
				draw_dv_sum_high = 0;
			}
		}
		
		// in / out
		for (var i = 0; i <= result.length - 1; i++)
		{
			if (inStock == false && result[i].Potential >= buy_c && i  < result.length - 2)
			{
				inStock   = true;
				startDate = new Date(result[i + 1].Date);
				startPrice = parseFloat(result[i].Price);
				if (Dprice == "t") startPrice = parseFloat(result[i + 1].Price);
				else if (Dprice == "yt") startPrice = (parseFloat(result[i].Price) + parseFloat(result[i + 1].Price)) / 2;
				startPrice = parseFloat(startPrice.toFixed(6));
				
				document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Entry:  <span class='span_right_float'>", 
						result[i + 1].Date, "&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;", startPrice, "</span></div>");
			}
			else if (inStock == true)
			{
				// end price
				var endPrice = parseFloat(result[i].Price);
				if (Dprice == "t") endPrice = parseFloat(result[i + 1].Price);
				else if (Dprice == "yt") endPrice = (parseFloat(result[i].Price) + parseFloat(result[i + 1].Price)) / 2;
				endPrice = parseFloat(endPrice.toFixed(6));
					
				endDate  = new Date(result[i + 1].Date);
				
				if (result[i].Potential < buy_c || i >= result.length - 2)
				{
					inStock  = false;
					datesSum += (endDate.getTime() - startDate.getTime()) / (1000*60*60*24);
					
					var price_DIV_high = 0;
					for (var y = 0; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) >= startDate && new Date(result_div[y].D) < endDate) price_DIV_high += parseFloat(result_div[y].Dv);
					price_DIV_high_FULL += price_DIV_high;
					var change = (endPrice + price_DIV_high) / startPrice;
					depo = depo * change;
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
						document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Out:  <span class='span_right_float'>", 
							result[i+1].Date, "&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;", endPrice, "</span></div>");
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
						document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Profitability:  <span class='span_right_float'>", 
							((change - 1)*100).toFixed(2), "%</span></div><br>");
					startPrice = 0;
				}
			}
		}
		
		var income_rate_high = depo - 1;
		var income_rate_high_y = Math.pow(income_rate_high+1, 365/datesSum) - 1;
		
		// text output
		document.getElementById("strategy_calculation_time"         ).innerHTML = document.getElementById("strategy_calculation_time_hidden").innerHTML;
		document.getElementById("strategy_len_all_period"           ).innerHTML = date_gap;
		
		document.getElementById("strategy_all_period_in"            ).innerHTML = price_IN*1;
		document.getElementById("strategy_all_period_out"           ).innerHTML = price_OUT*1;
		
		document.getElementById("strategy_len_all_period"           ).innerHTML = date_gap;
		document.getElementById("strategy_income_rate_all_period"   ).innerHTML = ((income_rate_all    *100).toFixed(2)).concat("%");
		
		if (income_rate_all_y  >= 10) document.getElementById("strategy_income_rate_all_period_y" ).innerHTML = ">1000%";
		else                          document.getElementById("strategy_income_rate_all_period_y" ).innerHTML = ((income_rate_all_y  *100).toFixed(2)).concat("%");
		
		document.getElementById("max_drawdown"                      ).innerHTML = ((drawdown           *100).toFixed(2)).concat("%");
		document.getElementById("max_drawdown_top"                  ).innerHTML = '('.concat(maxDate,      ') ', maxPriceMemory*1);
		document.getElementById("max_drawdown_bottom"               ).innerHTML = '('.concat(minDate,      ') ', minPriceMemory*1);
		
		document.getElementById("max_drawdown_high"                 ).innerHTML = ((drawdown_high      *100).toFixed(2)).concat("%");
		document.getElementById("max_drawdown_high_top"             ).innerHTML = '('.concat(maxDate_high, ') ', maxPriceMemory_high*1);
		document.getElementById("max_drawdown_high_bottom"          ).innerHTML = '('.concat(minDate_high, ') ', minPriceMemory_high*1);
		
		document.getElementById("strategy_len_high_period"          ).innerHTML = datesSum;
		document.getElementById("strategy_income_rate_high_period"  ).innerHTML = ((income_rate_high   *100).toFixed(2)).concat("%");
		
		if (income_rate_high_y >= 10) document.getElementById("strategy_income_rate_high_period_y").innerHTML = ">1000%";
		else                          document.getElementById("strategy_income_rate_high_period_y").innerHTML = ((income_rate_high_y *100).toFixed(2)).concat("%");
	}
}

function graphs_strategy_gaap_all() {
	if ($("div").is("#graphs_portfolio_gaap"))
	{
		// GRAPH
		var inf   = $("#chn_json_hidden_div").html();
		var result = JSON.parse(inf);
		
		var dataPointsP = [];
		var dataPointsI = [];
		for (var i = 0; i <= result.length - 1; i++) {
				dataPointsP.push({
						label: result[i].Date,
						y: result[i].Change+1
					  });
				dataPointsI.push({
						label: result[i].Date,
						y: result[i].IMOEX
					  });
		}
		
		var chart = new CanvasJS.Chart("graphs_portfolio_gaap", {
		  height:300,
		  axisY:{
				  gridColor:"#ECECEC",
				  valueFormatString:"#####%",
				  labelFontColor: "#6783A0"
		  },
		  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
		  },
	      data: 
	      [
	    	  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#EBD441",
		        dataPoints: dataPointsP
	    	  },
			  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#B8B9CA",
		        dataPoints: dataPointsI
	    	  }
	      ]
	    });
	    chart.render();
		
		// SMART DIAGRAM
		var inf_S   = $("#emitents_parts_diagram_data_json_hidden_div").html();
		var result_S = JSON.parse(inf_S);
		var dataPointsArr = [result_S.length];
		for (var i = 0; i <= result_S.length - 1; i++) {
			dataPointsArr[i] = [];
			for (var y = 0; y < result_S[i][1].length; y++)
				if (i < result_S.length - 1)
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"] + " " + result_S[i][0],
							y:     result_S[i][1][y]["vals"]
						  });
				else
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"],
							y:     result_S[i][1][y]["vals"]
						  });
		}
		
		areaType = "rangeArea";
		lineWidth = 0;
		diagram_opacity = 0.7;
		
		var data_array = new Array();
		
		for (var i = 0; i <= result_S.length - 1; i++) {
			data_array.push(
				{ legendText: result_S[i][0], dataPoints: dataPointsArr[i], color: colorArray[i], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
			);
		}
		
		if (result_S.length < 25)
		{
			var chart = new CanvasJS.Chart("diagram_portfolio", {
			  height:300,
			  axisY:{
				  valueFormatString:"###%",
				  maximum:"1",
				  minimum:"0",
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  legend: { fontSize: 13 },
			  data: data_array
			  // [
				  // { legendText: result_S[0][0], dataPoints: dataPointsArr[0], color: colorArray[0], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[1][0], dataPoints: dataPointsArr[1], color: colorArray[1], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[2][0], dataPoints: dataPointsArr[2], color: colorArray[2], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[3][0], dataPoints: dataPointsArr[3], color: colorArray[3], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[4][0], dataPoints: dataPointsArr[4], color: colorArray[4], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[5][0], dataPoints: dataPointsArr[5], color: colorArray[5], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[6][0], dataPoints: dataPointsArr[6], color: colorArray[6], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[7][0], dataPoints: dataPointsArr[7], color: colorArray[7], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[8][0], dataPoints: dataPointsArr[8], color: colorArray[8], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[9][0], dataPoints: dataPointsArr[9], color: colorArray[9], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[10][0],dataPoints: dataPointsArr[10],color: colorArray[10],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  // { legendText: result_S[11][0],dataPoints: dataPointsArr[11],color: colorArray[11],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth }
			  // ]
			});
		}
		else
		{
			var chart = new CanvasJS.Chart("diagram_portfolio", {
			  axisY:{
				  valueFormatString:"###%",
				  maximum:"1",
				  minimum:"0",
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  legend: { fontSize: 13 },
			  data: 
			  [
				  { legendText: result_S[0][0], dataPoints: dataPointsArr[0], color: colorArray[0], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[1][0], dataPoints: dataPointsArr[1], color: colorArray[1], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[2][0], dataPoints: dataPointsArr[2], color: colorArray[2], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[3][0], dataPoints: dataPointsArr[3], color: colorArray[3], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[4][0], dataPoints: dataPointsArr[4], color: colorArray[4], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[5][0], dataPoints: dataPointsArr[5], color: colorArray[5], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[6][0], dataPoints: dataPointsArr[6], color: colorArray[6], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[7][0], dataPoints: dataPointsArr[7], color: colorArray[7], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[8][0], dataPoints: dataPointsArr[8], color: colorArray[8], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[9][0], dataPoints: dataPointsArr[9], color: colorArray[9], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[10][0],dataPoints: dataPointsArr[10],color: colorArray[10],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[11][0],dataPoints: dataPointsArr[11],color: colorArray[11],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[12][0],dataPoints: dataPointsArr[12],color: colorArray[12],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[13][0],dataPoints: dataPointsArr[13],color: colorArray[13],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[14][0],dataPoints: dataPointsArr[14],color: colorArray[14],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[15][0],dataPoints: dataPointsArr[15],color: colorArray[15],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[16][0],dataPoints: dataPointsArr[16],color: colorArray[16],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[17][0],dataPoints: dataPointsArr[17],color: colorArray[17],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[18][0],dataPoints: dataPointsArr[18],color: colorArray[18],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[19][0],dataPoints: dataPointsArr[19],color: colorArray[19],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[20][0],dataPoints: dataPointsArr[20],color: colorArray[20],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[21][0],dataPoints: dataPointsArr[21],color: colorArray[21],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[22][0],dataPoints: dataPointsArr[22],color: colorArray[22],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[23][0],dataPoints: dataPointsArr[23],color: colorArray[23],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[24][0],dataPoints: dataPointsArr[24],color: colorArray[24],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[25][0],dataPoints: dataPointsArr[25],color: colorArray[25],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[26][0],dataPoints: dataPointsArr[26],color: colorArray[26],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[27][0],dataPoints: dataPointsArr[27],color: colorArray[27],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[28][0],dataPoints: dataPointsArr[28],color: colorArray[28],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[29][0],dataPoints: dataPointsArr[29],color: colorArray[29],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[30][0],dataPoints: dataPointsArr[30],color: colorArray[30],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[31][0],dataPoints: dataPointsArr[31],color: colorArray[31],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[32][0],dataPoints: dataPointsArr[32],color: colorArray[32],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[33][0],dataPoints: dataPointsArr[33],color: colorArray[33],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[34][0],dataPoints: dataPointsArr[34],color: colorArray[34],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[35][0],dataPoints: dataPointsArr[35],color: colorArray[35],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[36][0],dataPoints: dataPointsArr[36],color: colorArray[36],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[37][0],dataPoints: dataPointsArr[37],color: colorArray[37],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[38][0],dataPoints: dataPointsArr[38],color: colorArray[38],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[39][0],dataPoints: dataPointsArr[39],color: colorArray[39],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[40][0],dataPoints: dataPointsArr[40],color: colorArray[40],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[41][0],dataPoints: dataPointsArr[41],color: colorArray[41],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[42][0],dataPoints: dataPointsArr[42],color: colorArray[42],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[43][0],dataPoints: dataPointsArr[43],color: colorArray[43],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[44][0],dataPoints: dataPointsArr[44],color: colorArray[44],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[45][0],dataPoints: dataPointsArr[45],color: colorArray[45],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[46][0],dataPoints: dataPointsArr[46],color: colorArray[46],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[47][0],dataPoints: dataPointsArr[47],color: colorArray[47],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth }
				  /*
				  ,
				  { legendText: result_S[48][0],dataPoints: dataPointsArr[48],color: colorArray[48],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[49][0],dataPoints: dataPointsArr[49],color: colorArray[49],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[50][0],dataPoints: dataPointsArr[50],color: colorArray[50],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[51][0],dataPoints: dataPointsArr[51],color: colorArray[51],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[52][0],dataPoints: dataPointsArr[52],color: colorArray[52],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[53][0],dataPoints: dataPointsArr[53],color: colorArray[53],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[54][0],dataPoints: dataPointsArr[54],color: colorArray[54],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[55][0],dataPoints: dataPointsArr[55],color: colorArray[55],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[56][0],dataPoints: dataPointsArr[56],color: colorArray[56],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[57][0],dataPoints: dataPointsArr[57],color: colorArray[57],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[58][0],dataPoints: dataPointsArr[58],color: colorArray[58],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[59][0],dataPoints: dataPointsArr[59],color: colorArray[59],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[60][0],dataPoints: dataPointsArr[60],color: colorArray[60],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[61][0],dataPoints: dataPointsArr[61],color: colorArray[61],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[62][0],dataPoints: dataPointsArr[62],color: colorArray[62],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[63][0],dataPoints: dataPointsArr[63],color: colorArray[63],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[64][0],dataPoints: dataPointsArr[64],color: colorArray[64],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[65][0],dataPoints: dataPointsArr[65],color: colorArray[65],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[66][0],dataPoints: dataPointsArr[66],color: colorArray[66],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[67][0],dataPoints: dataPointsArr[67],color: colorArray[67],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[68][0],dataPoints: dataPointsArr[68],color: colorArray[68],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[69][0],dataPoints: dataPointsArr[69],color: colorArray[69],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[70][0],dataPoints: dataPointsArr[70],color: colorArray[70],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[71][0],dataPoints: dataPointsArr[71],color: colorArray[71],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[72][0],dataPoints: dataPointsArr[72],color: colorArray[72],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[73][0],dataPoints: dataPointsArr[73],color: colorArray[73],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[74][0],dataPoints: dataPointsArr[74],color: colorArray[74],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[75][0],dataPoints: dataPointsArr[75],color: colorArray[75],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[76][0],dataPoints: dataPointsArr[76],color: colorArray[76],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[77][0],dataPoints: dataPointsArr[77],color: colorArray[77],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[78][0],dataPoints: dataPointsArr[78],color: colorArray[78],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[79][0],dataPoints: dataPointsArr[79],color: colorArray[79],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[80][0],dataPoints: dataPointsArr[80],color: colorArray[80],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[81][0],dataPoints: dataPointsArr[81],color: colorArray[81],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[82][0],dataPoints: dataPointsArr[82],color: colorArray[82],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[83][0],dataPoints: dataPointsArr[83],color: colorArray[83],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[84][0],dataPoints: dataPointsArr[84],color: colorArray[84],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[85][0],dataPoints: dataPointsArr[85],color: colorArray[85],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[86][0],dataPoints: dataPointsArr[86],color: colorArray[86],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[87][0],dataPoints: dataPointsArr[87],color: colorArray[87],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[88][0],dataPoints: dataPointsArr[88],color: colorArray[88],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[89][0],dataPoints: dataPointsArr[89],color: colorArray[89],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[90][0],dataPoints: dataPointsArr[90],color: colorArray[90],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[91][0],dataPoints: dataPointsArr[91],color: colorArray[91],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[92][0],dataPoints: dataPointsArr[92],color: colorArray[92],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[93][0],dataPoints: dataPointsArr[93],color: colorArray[93],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[94][0],dataPoints: dataPointsArr[94],color: colorArray[94],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[95][0],dataPoints: dataPointsArr[95],color: colorArray[95],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth }
				  */
			  ]
			});
		}
		
	    chart.render();
	}
}

function graphs_strategy_grow_all() {
	if ($("div").is("#graphs_portfolio_grow"))
	{
		date_1 = $("#portfolio_date_from_hidden_div").html();
		date_2 = $("#portfolio_date_to_hidden_div"  ).html();
		pot    = $("#portfolio_pot_hidden_div"      ).html();
		exc    = $("#portfolio_exc_hidden_div"      ).html();
		flex   = $("#portfolio_flex_hidden_div"     ).html();
		buy    = $("#portfolio_buy_hidden_div"      ).html();
		method = $("#portfolio_method_hidden_div"   ).html();
		$("#strat_input_date_from").val(date_1);
		$("#strat_input_date_to"  ).val(date_2);
		$("#strat_input_pot"      ).val(pot   );
		$("#strat_input_exc"      ).val(exc   );
		$("#strat_input_flex"     ).val(flex  );
		$("#strat_input_buy"      ).val(buy   );
		$("#strat_input_method"   ).val(method);
		
		// GRAPH
		var inf   = $("#chn_json_hidden_div").html();
		var result = JSON.parse(inf);
		
		var dataPointsP = [];
		var dataPointsI = [];
		for (var i = 0; i <= result.length - 1; i++) {
				dataPointsP.push({
						label: result[i].Date,
						y: result[i].Change+1
					  });
				dataPointsI.push({
						label: result[i].Date,
						y: result[i].IMOEX
					  });
		}
		
		var chart = new CanvasJS.Chart("graphs_portfolio_grow", {
		  axisY:{
				  gridColor:"#ECECEC",
				  valueFormatString:"#####%",
				  labelFontColor: "#6783A0"
		  },
		  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
		  },
	      data: 
	      [
	    	  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#EBD441",
		        dataPoints: dataPointsP
	    	  },
			  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#B8B9CA",
		        dataPoints: dataPointsI
	    	  }
	      ]
	    });
	    chart.render();
		
		// SMART DIAGRAM
		var inf_S   = $("#emitents_parts_diagram_data_json_hidden_div").html();
		var result_S = JSON.parse(inf_S);
		var dataPointsArr = [result_S.length];
		for (var i = 0; i <= result_S.length - 1; i++) {
			dataPointsArr[i] = [];
			for (var y = 0; y < result_S[i][1].length; y++)
				if (i < result_S.length - 1)
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"] + " " + result_S[i][0],
							y:     result_S[i][1][y]["vals"]
						  });
				else
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"],
							y:     result_S[i][1][y]["vals"]
						  });
		}
		
		areaType = "rangeArea";
		lineWidth = 0;
		diagram_opacity = 0.7;
		
		if (result_S.length < 25)
		{
			var chart = new CanvasJS.Chart("diagram_portfolio", {
			  axisY:{
				  valueFormatString:"###%",
				  maximum:"1",
				  minimum:"0",
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  legend: { fontSize: 13 },
			  data: 
			  [
				  { legendText: result_S[0][0], dataPoints: dataPointsArr[0], color: colorArray[0], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[1][0], dataPoints: dataPointsArr[1], color: colorArray[1], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[2][0], dataPoints: dataPointsArr[2], color: colorArray[2], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[3][0], dataPoints: dataPointsArr[3], color: colorArray[3], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[4][0], dataPoints: dataPointsArr[4], color: colorArray[4], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[5][0], dataPoints: dataPointsArr[5], color: colorArray[5], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[6][0], dataPoints: dataPointsArr[6], color: colorArray[6], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[7][0], dataPoints: dataPointsArr[7], color: colorArray[7], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[8][0], dataPoints: dataPointsArr[8], color: colorArray[8], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[9][0], dataPoints: dataPointsArr[9], color: colorArray[9], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[10][0],dataPoints: dataPointsArr[10],color: colorArray[10],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[11][0],dataPoints: dataPointsArr[11],color: colorArray[11],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth }
			  ]
			});
		}
		else
		{
			var chart = new CanvasJS.Chart("diagram_portfolio", {
			  axisY:{
				  valueFormatString:"###%",
				  maximum:"1",
				  minimum:"0",
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  axisX:{
				  gridColor:"#ECECEC",
				  labelFontColor: "#6783A0"
			  },
			  legend: { fontSize: 13 },
			  data: 
			  [
				  { legendText: result_S[0][0], dataPoints: dataPointsArr[0], color: colorArray[0], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[1][0], dataPoints: dataPointsArr[1], color: colorArray[1], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[2][0], dataPoints: dataPointsArr[2], color: colorArray[2], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[3][0], dataPoints: dataPointsArr[3], color: colorArray[3], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[4][0], dataPoints: dataPointsArr[4], color: colorArray[4], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[5][0], dataPoints: dataPointsArr[5], color: colorArray[5], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[6][0], dataPoints: dataPointsArr[6], color: colorArray[6], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[7][0], dataPoints: dataPointsArr[7], color: colorArray[7], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[8][0], dataPoints: dataPointsArr[8], color: colorArray[8], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[9][0], dataPoints: dataPointsArr[9], color: colorArray[9], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[10][0],dataPoints: dataPointsArr[10],color: colorArray[10],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[11][0],dataPoints: dataPointsArr[11],color: colorArray[11],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[12][0],dataPoints: dataPointsArr[12],color: colorArray[12],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[13][0],dataPoints: dataPointsArr[13],color: colorArray[13],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[14][0],dataPoints: dataPointsArr[14],color: colorArray[14],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[15][0],dataPoints: dataPointsArr[15],color: colorArray[15],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[16][0],dataPoints: dataPointsArr[16],color: colorArray[16],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[17][0],dataPoints: dataPointsArr[17],color: colorArray[17],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[18][0],dataPoints: dataPointsArr[18],color: colorArray[18],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[19][0],dataPoints: dataPointsArr[19],color: colorArray[19],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[20][0],dataPoints: dataPointsArr[20],color: colorArray[20],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[21][0],dataPoints: dataPointsArr[21],color: colorArray[21],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[22][0],dataPoints: dataPointsArr[22],color: colorArray[22],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[23][0],dataPoints: dataPointsArr[23],color: colorArray[23],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[24][0],dataPoints: dataPointsArr[24],color: colorArray[24],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[25][0],dataPoints: dataPointsArr[25],color: colorArray[25],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[26][0],dataPoints: dataPointsArr[26],color: colorArray[26],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[27][0],dataPoints: dataPointsArr[27],color: colorArray[27],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[28][0],dataPoints: dataPointsArr[28],color: colorArray[28],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[29][0],dataPoints: dataPointsArr[29],color: colorArray[29],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[30][0],dataPoints: dataPointsArr[30],color: colorArray[30],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[31][0],dataPoints: dataPointsArr[31],color: colorArray[31],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[32][0],dataPoints: dataPointsArr[32],color: colorArray[32],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[33][0],dataPoints: dataPointsArr[33],color: colorArray[33],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[34][0],dataPoints: dataPointsArr[34],color: colorArray[34],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[35][0],dataPoints: dataPointsArr[35],color: colorArray[35],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[36][0],dataPoints: dataPointsArr[36],color: colorArray[36],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[37][0],dataPoints: dataPointsArr[37],color: colorArray[37],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[38][0],dataPoints: dataPointsArr[38],color: colorArray[38],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[39][0],dataPoints: dataPointsArr[39],color: colorArray[39],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[40][0],dataPoints: dataPointsArr[40],color: colorArray[40],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[41][0],dataPoints: dataPointsArr[41],color: colorArray[41],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[42][0],dataPoints: dataPointsArr[42],color: colorArray[42],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[43][0],dataPoints: dataPointsArr[43],color: colorArray[43],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[44][0],dataPoints: dataPointsArr[44],color: colorArray[44],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[45][0],dataPoints: dataPointsArr[45],color: colorArray[45],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[46][0],dataPoints: dataPointsArr[46],color: colorArray[46],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
				  { legendText: result_S[47][0],dataPoints: dataPointsArr[47],color: colorArray[47],type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth }
			  ]
			});
		}
		
	    chart.render();
	}
}

function graphs_strategy_comm() {
	if ($("div").is("#graphs_strategy"))
	{
		// share price
		ticker = $("#ticker_hidden_div").html();
		buy_c = parseFloat($("#buy_condition").html()) / 100;
		date_1 = $("#date_1_hidden_div").html();
		date_2 = $("#date_2_hidden_div").html();
		Dprice = $("#Dprice_hidden_div").html();
		con =    $("#con_hidden_div").html();
		save_R = $("#save_R_hidden_div").html();
		
		$('#strat_input_1_select').val(ticker);
		$('#strat_input_2').val(buy_c * 100);
		$('#strat_input_3').val(date_1);
		$('#strat_input_4').val(date_2);
		$('#strat_input_5_select').val(Dprice);
		$('#strat_input_con_select').val(con);
		$('#strat_input_6_select').val(save_R);
		
		// potential
		var inf2   = $("#potential_json_hidden_div").html();
		var result = JSON.parse(inf2);
		
		// dividend
		var inf_div = $("#dividend_json_hidden_div").html();
		var result_div = JSON.parse(inf_div);
		var result_div_marked = 0;
		for (var y = 0; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) < new Date(result[0].Date)) result_div_marked++;
		
		// income rate
		var inStock = false;
		var inStockYest = false;
		var depo = 1;
		var startPrice = 0;
		
		var dataPoints10 = [];
		var dataPoints11 = [];
		var dataPoints_div = [];
		
		var startDate = 0;
		var endDate   = 0;
		var datesSum  = 0;
		
		var minPrice = 0;
		var maxPrice = 0;
		var minPrice_high = 0;
		var maxPrice_high = 0;
		
		var drawdown =         0;
		var drawdown_high =    0;
		var draw_dv_sum =      0;
		var draw_dv_sum_high = 0;
		var minPriceMemory      = 0;
		var maxPriceMemory      = 0;
		var minPriceMemory_high = 0;
		var maxPriceMemory_high = 0;
		var minDate      = "";
		var maxDate      = "";
		var minDate_high = "";
		var maxDate_high = "";
		
		var maxDateTemp = "";
		var maxDateTemp_high = "";
		var t0 = 0;
		
		var price_DIV_high_FULL = 0;
		
		for (var i = 0; i <= result.length - 1; i++) {
			
			var div_push_val = false;
			var dv = 0;
			for (var y = result_div_marked; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) <= new Date(result[i].Date)) 
				{ dv = parseFloat(result_div[y].Dv); div_push_val = true; result_div_marked++; continue; };
			
			if (div_push_val)
				dataPoints_div.push({
						label: result[i].Date,
						y: dv
					  });
			else
				dataPoints_div.push({
						label: result[i].Date,
						y: null
					  });
			
			if (i == 0)
			{
				minPrice = result[i].Price;
				maxPrice = result[i].Price;
				draw_dv_sum = dv;
				maxDateTemp = result[i].Date;
			}
			else
			{
				if (result[i].Price > maxPrice - draw_dv_sum)
				{
					maxPrice = result[i].Price;
					draw_dv_sum = dv;
					minPrice = result[i].Price;
					maxDateTemp = result[i].Date;
				}
				else 
				{
					draw_dv_sum += dv;
					if (result[i].Price < minPrice)
					{
						minPrice = result[i].Price;
						t0 = ((minPrice + draw_dv_sum) / maxPrice) - 1;
						if (drawdown > t0)
						{
							drawdown = t0;
							minDate = result[i].Date;
							maxDate = maxDateTemp;
							minPriceMemory = minPrice;
							maxPriceMemory = maxPrice;
						}
					}
				}
			}
			
			if (inStock || inStockYest)
			{
				if (inStock) inStockYest = true;
				else inStockYest = false;
				
				dataPoints10.push({
					label: result[i].Date,
					y: null
				  });
				dataPoints11.push({
					label: result[i].Date,
					y: parseFloat(result[i].Price)
				  });
			}
			else
			{
				dataPoints10.push({
					label: result[i].Date,
					y: parseFloat(result[i].Price)
				  });
				dataPoints11.push({
					label: result[i].Date,
					y: null
				  });
			}
			
			// drawdown
			if (inStock == true)
			{
				if (result[i].Price > maxPrice_high - draw_dv_sum_high)
				{
					maxPrice_high = result[i].Price;
					draw_dv_sum_high = dv;
					minPrice_high = result[i].Price;
					maxDateTemp_high = result[i].Date;
				}
				else 
				{
					draw_dv_sum_high += dv;
					if (result[i].Price < minPrice_high)
					{
						minPrice_high = result[i].Price;
						t0 = ((minPrice_high + draw_dv_sum_high) / maxPrice_high) - 1;
						if (drawdown_high > t0)
						{
							drawdown_high = t0;
							minDate_high = result[i].Date;
							maxDate_high = maxDateTemp_high;
							minPriceMemory_high = minPrice_high;
							maxPriceMemory_high = maxPrice_high;
						}
					}
				}
			}
			
			// in / out
		    if (inStock == false && result[i].Potential >= buy_c && i  < result.length - 2)
			{
				inStock   = true;
				startDate = new Date(result[i + 1].Date);
				startPrice = parseFloat(result[i].Price);
				if (Dprice == "t") startPrice = parseFloat(result[i + 1].Price);
				else if (Dprice == "yt") startPrice = (parseFloat(result[i].Price) + parseFloat(result[i + 1].Price)) / 2;
				startPrice = parseFloat(startPrice.toFixed(6));
				
				// drawdown
				maxPrice_high = startPrice;
				draw_dv_sum_high = 0; // dv;
				minPrice_high = startPrice;
				maxDateTemp_high = result[i+1].Date;
				
				document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Entry:  <span class='span_right_float'>", 
						result[i + 1].Date, "&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;", startPrice, "</span></div>");
			}
			else if (inStock == true)
			{
				// end price
				var endPrice = parseFloat(result[i].Price);
				if (Dprice == "t") endPrice = parseFloat(result[i + 1].Price);
				else if (Dprice == "yt") endPrice = (parseFloat(result[i].Price) + parseFloat(result[i + 1].Price)) / 2;
				endPrice = parseFloat(endPrice.toFixed(6));
				
				endDate  = new Date(result[i + 1].Date);
				
				if (result[i].Potential < buy_c || i >= result.length - 2)
				{
					inStock  = false;
					datesSum += (endDate.getTime() - startDate.getTime()) / (1000*60*60*24);
					
					var price_DIV_high = 0;
					for (var y = 0; y <= result_div.length - 1; y++) if (new Date(result_div[y].D) >= startDate && new Date(result_div[y].D) < endDate) price_DIV_high += parseFloat(result_div[y].Dv);
					price_DIV_high_FULL += price_DIV_high;
					var change = (endPrice + price_DIV_high) / startPrice;
					depo = depo * change;
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
						document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Out:  <span class='span_right_float'>", 
							result[i+1].Date, "&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;", endPrice, "</span></div>");
					document.getElementById("strategy_income_rate_high_period_comments").innerHTML  = 
						document.getElementById("strategy_income_rate_high_period_comments").innerHTML.concat("<div>Profitability:  <span class='span_right_float'>", 
							((change - 1)*100).toFixed(2), "%</span></div><br>");
					startPrice = 0;
				}
			}
	    }
		
	    var chart = new CanvasJS.Chart("graphs_strategy_price", {
		  axisY:{
			  valueFormatString:"######",
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
		  axisX:{
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
	      data: 
	      [
	    	  {
			    type: "line",
		        yValueFormatString:"######.######",
		    	color: "#78c1f5",
		        dataPoints: dataPoints10
	    	  },
			  {
			    type: "line",
		        yValueFormatString:"######.######",
		    	color: "#00FF00",
		        dataPoints: dataPoints11
	    	  },
			  {
			    type: "scatter",
		        yValueFormatString:"######.######",
		    	color: "#FF9900",
		        dataPoints: dataPoints_div
	    	  }
	      ]
	    });
	    chart.render();
		
		var price_IN = result[0].Price;
		var price_OUT = result[result.length - 2].Price;
		if (Dprice == "t")
		{
			price_IN = result[1].Price;
			price_OUT = result[result.length - 1].Price;
		}
		else if (Dprice == "yt")
		{
			price_IN  = (result[0].Price + result[1].Price) / 2;
			price_OUT = (result[result.length - 2].Price + result[result.length - 1].Price) / 2;
		}
		
		price_IN  = parseFloat(price_IN.toFixed(6));
		price_OUT = parseFloat(price_OUT.toFixed(6));
		price_DIV = parseFloat(document.getElementById("sum_dividend_all").innerHTML);
		var income_rate_all = (price_OUT + price_DIV) / price_IN - 1;
		
		var dt_2 = new Date(result[result.length - 1].Date);
		var dt_1 = new Date(result[1                ].Date);
		var date_gap = (dt_2.getTime() - dt_1.getTime()) / (1000*60*60*24);
		var income_rate_all_y = Math.pow(income_rate_all+1, 365/date_gap) - 1;
		
		var income_rate_high = depo - 1;
		var income_rate_high_y = Math.pow(income_rate_high+1, 365/datesSum) - 1;
		
		document.getElementById("strategy_all_period_in"            ).innerHTML = price_IN;
		document.getElementById("strategy_all_period_out"           ).innerHTML = price_OUT;
		
		document.getElementById("strategy_len_all_period"           ).innerHTML = date_gap;
		document.getElementById("strategy_income_rate_all_period"   ).innerHTML = ((income_rate_all    *100).toFixed(2)).concat("%");
		
		if (income_rate_all_y  >= 10) document.getElementById("strategy_income_rate_all_period_y" ).innerHTML = ">1000%";
		else                          document.getElementById("strategy_income_rate_all_period_y" ).innerHTML = ((income_rate_all_y  *100).toFixed(2)).concat("%");
		
		document.getElementById("strategy_len_high_period"          ).innerHTML = datesSum;
		document.getElementById("strategy_income_rate_high_period"  ).innerHTML = ((income_rate_high   *100).toFixed(2)).concat("%");
		
		if (income_rate_high_y >= 10) document.getElementById("strategy_income_rate_high_period_y").innerHTML = ">1000%";
		else                          document.getElementById("strategy_income_rate_high_period_y").innerHTML = ((income_rate_high_y *100).toFixed(2)).concat("%");
		
		document.getElementById("strategy_calculation_time"         ).innerHTML = document.getElementById("strategy_calculation_time_hidden").innerHTML;
		document.getElementById("sum_dividend_high"                 ).innerHTML = price_DIV_high_FULL.toFixed(2);
		
		document.getElementById("max_drawdown"                      ).innerHTML = ((drawdown           *100).toFixed(2)).concat("%");
		document.getElementById("max_drawdown_top"                  ).innerHTML = '('.concat(maxDate,      ') ', maxPriceMemory);
		document.getElementById("max_drawdown_bottom"               ).innerHTML = '('.concat(minDate,      ') ', minPriceMemory);
		
		document.getElementById("max_drawdown_high"                 ).innerHTML = ((drawdown_high      *100).toFixed(2)).concat("%");
		document.getElementById("max_drawdown_high_top"             ).innerHTML = '('.concat(maxDate_high, ') ', maxPriceMemory_high);
		document.getElementById("max_drawdown_high_bottom"          ).innerHTML = '('.concat(minDate_high, ') ', minPriceMemory_high);
		
		var dataPoints1 = [];
		var dataPoints2 = [];
		var dataPoints3 = [];
		var dataPoints4 = [];
		for (var i = 0; i <= result.length - 1; i++) {
			if (result[i].Potential >= buy_c)
			{
				dataPoints1.push({
					label: result[i].Date,
					y: parseFloat(result[i].Potential)
				});
				dataPoints2.push({
					label: result[i].Date,
					y: null
				});
			}
			else
			{
				dataPoints1.push({
					label: result[i].Date,
					y: null
				});
				dataPoints2.push({
					label: result[i].Date,
					y: parseFloat(result[i].Potential)
				});
			}
			
			dataPoints3.push({
				label: result[i].Date,
				y: buy_c
			});
			dataPoints4.push({
				label: result[i].Date,
				y: 0
			});
		}
		
		var chart2 = new CanvasJS.Chart("graphs_strategy_potential", {
			axisY:{
				valueFormatString:"#####%",
				gridColor:"#ECECEC",
			    labelFontColor: "#6783A0"
			},
			axisX:{
				gridColor:"#ECECEC",
			    labelFontColor: "#6783A0"
			},
			data: 
			[
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#00BB00",
					dataPoints: dataPoints1
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#BB0000",
					dataPoints: dataPoints2
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#5A269D",
					dataPoints: dataPoints3
				},
				{
					type: "line",
					yValueFormatString:"#####.#%",
					color: "#5A269D",
					dataPoints: dataPoints4
				}
			]
		});
		chart2.render();
	}
}

function graphs_strategy_comm_all() {
	if ($("div").is("#graphs_portfolio"))
	{
		date_1 = $("#portfolio_date_from_hidden_div").html();
		date_2 = $("#portfolio_date_to_hidden_div"  ).html();
		pot    = $("#portfolio_pot_hidden_div"      ).html();
		exc    = $("#portfolio_exc_hidden_div"      ).html();
		flex   = $("#portfolio_flex_hidden_div"     ).html();
		buy    = $("#portfolio_buy_hidden_div"      ).html();
		con    = $("#portfolio_con_hidden_div"      ).html();
		$("#strat_input_date_from").val(date_1);
		$("#strat_input_date_to"  ).val(date_2);
		$("#strat_input_pot"      ).val(pot   );
		$("#strat_input_exc"      ).val(exc   );
		$("#strat_input_flex"     ).val(flex  );
		$("#strat_input_buy"      ).val(buy   );
		$("#strat_input_con"      ).val(con   );
		
		// GRAPH
		var inf   = $("#chn_json_hidden_div").html();
		var result = JSON.parse(inf);
		
		var dataPointsP = [];
		var dataPointsI = [];
		for (var i = 0; i <= result.length - 1; i++) {
				dataPointsP.push({
						label: result[i].Date,
						y: result[i].Change+1
					  });
				dataPointsI.push({
						label: result[i].Date,
						y: result[i].IMOEX
					  });
		}
		
		var chart = new CanvasJS.Chart("graphs_portfolio", {
		  axisY:{
			  valueFormatString:"#####%",
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
		  axisX:{
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
	      data: 
	      [
	    	  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#EBD441",
		        dataPoints: dataPointsP
	    	  },
			  {
			    type: "line",
		        yValueFormatString:"#####.#%",
		    	color: "#B8B9CA",
		        dataPoints: dataPointsI
	    	  }
	      ]
	    });
	    chart.render();
		
		// SMART DIAGRAM
		var inf_S   = $("#emitents_parts_diagram_data_json_hidden_div").html();
		var result_S = JSON.parse(inf_S);
		var dataPointsArr = [result_S.length];
		for (var i = 0; i <= result_S.length - 1; i++) {
			dataPointsArr[i] = [];
			for (var y = 0; y < result_S[i][1].length; y++)
				if (i < result_S.length - 1)
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"] + " " + result_S[i][0],
							y:     result_S[i][1][y]["vals"]
						  });
				else
					dataPointsArr[i].push({
							label: result_S[i][1][y]["Date"],
							y:     result_S[i][1][y]["vals"]
						  });
		}
		
		
		
		while(dataPointsArr.length < 17)
		{
			dataPointsArr.push(dataPointsArr[dataPointsArr.length-1]);
			result_S.push(result_S[result_S.length-1]);
		}
		
		areaType = "rangeArea";
		lineWidth = 0;
		diagram_opacity = 0.7;
		
		var data_array = new Array();
		
		for (var i = 0; i <= result_S.length - 1; i++) {
			data_array.push(
				{ legendText: result_S[i][0], dataPoints: dataPointsArr[i], color: colorArray[i], type: areaType, showInLegend: true, fillOpacity: diagram_opacity, yValueFormatString:"###.##%", lineThickness: lineWidth },
			);
		}
		
		var chart = new CanvasJS.Chart("diagram_portfolio", {
		  axisY:{
			  valueFormatString:"###%",
			  maximum:"1",
			  minimum:"0",
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
		  axisX:{
			  gridColor:"#ECECEC",
			  labelFontColor: "#6783A0"
		  },
		  legend: { fontSize: 13 },
	      data: data_array
	    });
	    chart.render();
		
	}
}

function calculate_strategy_grow()
{
	$("#strategy_menu_button").prop( "disabled", true);
	
	ticker = $('#strat_input_1_select').val();
	buy_c_100  = parseFloat($('#strat_input_2').val());
	date_1 = $('#strat_input_3').val();
	date_2 = $('#strat_input_4').val();
	Dprice = $('#strat_input_5_select').val();
	save_R = $('#strat_input_6_select').val();
	method = $('#strat_input_method_select').val();
	common = $('#strat_input_common_select').val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("name=",ticker,"&");
	link = link.concat("db=",date_1,"&");
	link = link.concat("de=",date_2,"&");
	link = link.concat("buy=",buy_c_100,"&");
	link = link.concat("deal=",Dprice,"&");
	link = link.concat("save=",save_R,"&");
	link = link.concat("method=",method,"&");
	link = link.concat("common=",common);
	
	window.location.href = link;
}

function calculate_strategy_comm()
{
	$("#strategy_menu_button").prop( "disabled", true);
	
	ticker = $('#strat_input_1_select').val();
	buy_c_100  = parseFloat($('#strat_input_2').val());
	date_1 = $('#strat_input_3').val();
	date_2 = $('#strat_input_4').val();
	Dprice = $('#strat_input_5_select').val();
	con    =  $('#strat_input_con_select').val();
	save_R = $('#strat_input_6_select').val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("name=",ticker,"&");
	link = link.concat("db=",date_1,"&");
	link = link.concat("de=",date_2,"&");
	link = link.concat("buy=",buy_c_100,"&");
	link = link.concat("deal=",Dprice,"&");
	link = link.concat("save=",save_R,"&");
	link = link.concat("con=",con);
	
	window.location.href = link;
}

function calculate_strategy_comm_all()
{
	$("#strategy_menu_button_portfolio").prop( "disabled", true);
	
	date_1 = $('#strat_input_date_from').val();
	date_2 = $('#strat_input_date_to'  ).val();
	pot    = $('#strat_input_pot'      ).val();
	buy    = $('#strat_input_buy'      ).val();
	con    = $('#strat_input_con'      ).val();
	exc    = $('#strat_input_exc'      ).val();
	flex   = $('#strat_input_flex'     ).val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("db=",date_1,"&de=",date_2,"&pot=",pot,"&buy=",buy,"&con=",con);
	if (exc  != null && exc  != "") link = link.concat("&exc=",exc );
	if (flex != null && flex != "") link = link.concat("&flex=",flex);
	
	window.location.href = link;
}

function calculate_strategy_grow_US2_all()
{
	$("#strategy_menu_button_portfolio").prop( "disabled", true);
	
	date_1  = $('#strat_input_date_from').val();
	date_2  = $('#strat_input_date_to'  ).val();
	gr_lim  = $('#strat_input_gr_lim'   ).val();
	multmin = $('#strat_input_mult_min' ).val();
	multmax = $('#strat_input_mult_max' ).val();
	buy     = $('#strat_input_buy'      ).val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("db=",date_1,"&de=",date_2,"&multmin=",multmin,"&multmax=",multmax,"&gr_lim=",gr_lim,"&buy=",buy);
	
	window.location.href = link;
}

function calculate_strategy_GAAP_US2_all()
{
	$("#strategy_menu_button_portfolio").prop( "disabled", true);
	
	date_1  = $('#strat_input_date_from').val();
	date_2  = $('#strat_input_date_to'  ).val();
	gr_lim  = $('#strat_input_gr_lim'   ).val();
	multmin = $('#strat_input_mult_min' ).val();
	multmax = $('#strat_input_mult_max' ).val();
	maxemit = $('#strat_input_max_emitents_in_portfolio' ).val();
	GAAPday = $('#strat_input_days_around_gaap' ).val();
	buy     = $('#strat_input_buy'      ).val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("db=",date_1,"&de=",date_2,"&multmin=",multmin,"&multmax=",multmax,"&emitents_in_portfolio=",maxemit,"&days_around_gaap=",GAAPday,"&gr_lim=",gr_lim,"&buy=",buy);
	
	window.location.href = link;
}

function calculate_strategy_grow_all()
{
	$("#strategy_menu_button_portfolio").prop( "disabled", true);
	
	date_1 = $('#strat_input_date_from').val();
	date_2 = $('#strat_input_date_to'  ).val();
	pot    = $('#strat_input_pot'      ).val();
	buy    = $('#strat_input_buy'      ).val();
	exc    = $('#strat_input_exc'      ).val();
	flex   = $('#strat_input_flex'     ).val();
	method = $('#strat_input_method'   ).val();
	
	link = document.location.href;
	p = link.indexOf('.php') + 4;
	link = link.substring(0,p).concat("?");
	link = link.concat("db=",date_1,"&de=",date_2,"&pot=",pot,"&buy=",buy,"&method=",method);
	if (exc  != null && exc  != "") link = link.concat("&exc=",  exc);
	if (flex != null && flex != "") link = link.concat("&flex=",flex);
	
	window.location.href = link;
}