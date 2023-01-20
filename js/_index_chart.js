//if ($("select").is("#select_emitent_1")){



$.ajax({
								  type: 'POST',
								  url: 'php_db/ajax/get_emitent_data_chart.php',
								  data: {ticker:vl, page:currLoc},
								  success: function(inf){
									  
										var result = JSON.parse(inf);
										
										var dataPoints1 = [];

										var labels = [];
										var data1 = [];
										var data2 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints1.push({
									        label: result[i].Q,
									        y: parseInt(result[i].Revenue)
									      });
									      labels.push(result[i].Q);
									      data1.push(parseInt(result[i].Revenue));
									    }
										
										var dataPoints2 = [];
										for (var i = 0; i <= result.length - 1; i++) {
									      dataPoints2.push({
									        label: result[i].Q,
									        y: parseInt(result[i].Ebitda)
									      });
									      data2.push(parseInt(result[i].Ebitda));
									    }
										
									   //  var chart = new CanvasJS.Chart("chart_container_emitent_data", {
										  // backgroundColor:"transparent",
										  // axisY:{
											 //  valueFormatString:"### ### ### ###", gridColor:"#ECECEC", labelFontColor: "#6783A0"
									   //    },
										  // axisX:{
											 //  gridColor:"#ECECEC", labelFontColor: "#6783A0"
									   //    },
									        
									   //    data: 
									   //    [
									   //  	  {
											 //    type: "column",
										  //       yValueFormatString:"### ### ### ###",
										  //   	color: "#a6adb3",
										  //       dataPoints: dataPoints1
									   //  	  },
									   //  	  {
												// type: "column",
										  //       yValueFormatString:"### ### ### ###",
											 //    color: "#78c1f5",
											 //    dataPoints: dataPoints2
										  //     }
									   //    ]
									   //  });
									   //  chart.render();
									 //const labels = ['2020 q1', '2020 q2', '2020 q3', '2020 q4', '2021 q1', '2021 q2'];
										const data = {
										  labels: labels,
										  datasets: [
										    {
										      label: 'Revenue',
										      data: data1,
										      borderColor: 'rgba(9, 62, 88, 0.5)',
										      backgroundColor: 'rgba(9, 62, 88, 0.8)',
										      borderWidth: 1,
										    },
										    {
										      label: 'EBITDA',
										      data: data2,
										      borderColor: 'rgba(21, 218, 244, 0.5)',
										      backgroundColor: 'rgba(21, 218, 244, 0.8)',
										    }
										  ]
										};
										var ctx = document.getElementById('chart_container_emitent_data').getContext('2d');
										var chart = new Chart(ctx, {
										  type: 'bar',
										  data: data,
										  options: {
										    responsive: true,
										    plugins: {
										      legend: {
										        position: 'top',
										      },
										      title: {
										        display: true,
										        text: 'Chart.js Bar Chart'
										      }
										    },
										    scales: {
										          y: {
										              beginAtZero: true
										          }
										      }
										  }
										});
									   	
								  }
								});
	

										