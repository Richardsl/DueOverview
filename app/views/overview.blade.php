@extends('base')

@section('title')
<title>Overdue Overview</title>
@stop

@section('head')

@stop

@section('style')
	.highcharts-input-group{
		visibility: hidden;
	}

@stop


@section('content')


<div class="row">
	<div class="container">
		<div class="col-sm-12">
			<div class="page-header" >	
				<h1 class="h">Overdue Overview </h1>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="container">
	<?php //var_dump($graph2_data); ?>
		<script>		
		$(function () {
		
			var graph1;
			var graph2;
			var mouseDown = false;
			
		
			
			/*
			* Function som skal laga en array me baatdata som man can bruke i alle callbacksa	
			*/
			function FboatData(data) {
				//console.log(data);
				var boatData = {
					boat : [], 
					boatNames : [],
				};
				
				jQuery.each(data['data'], function(index, value) {			
					boatData.boat.push({
						color: value.color,
						name: index,
						y: value.percentage,
					});	
					boatData.boatNames.push([index]);
				});
				
				return boatData;
				
			}
			
			
			var graph1Options = {
				/*
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					events:{
						load: function(e){}
					}
				},
				*/
				credits: {
					enabled: false
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y:.2f}%</b>',		
				},
				plotOptions: {
					/*
					yAxis:{
						allowDecimals: false,
						ceiling: 10,
						floor: 0,
					},
					*/
					column: {
						allowPointSelect: true,
						cursor: 'pointer',
						animation: true,	
						dataLabels: {
							enabled: true,
							format: '{point.y:.2f}%',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					},
					series: {
						animation: {
							duration: 1000,
						}
					}
				},
				exporting: {
					enabled: false
				},
				yAxis:{
					tickInterval: 0.5,
					allowDecimals: false,
					min: 0,
					title: {
						text: 'Overdue Percentage %'
					},		
					floor:0,
					max:6,
					ceiling:6,
					plotBands: [
						{color: 'rgba(255,0,0,0.15)',from:4,to:10,}, //red
						{color: 'rgba(255,150,0,0.15)',from:1.5,to:4,},   // orange
						{color: 'rgba(0,255,0,0.15)',from:0,to:1.5,},	//green
					]
					
				},
				series: [{
					name: 'Overdue percentage',
					type: 'column',
				}]
			};
			
			
			
			var graph2Options = {	
				exporting: {
					enabled: false
				},
				scrollbar: {
					enabled: false
				},
				navigator: {
					height: 120,
					margin: 0,
					enabled: true,
					xAxis:{
						tickInterval: 30 * 24 * 3600 * 1000,
						labels: {	
							enabled: true,			
						},
					},
					yAxis:{
						tickInterval: 1,
						tickWidth: 1,
						tickPosition: "inside",
						allowDecimals: false,
						labels: {	
							enabled: true,
							
						},
					},
				},
				rangeSelector: {
					labelStyle: {
						visibility: 'hidden',	
					},
					buttons:[],
					selected: 1,
					inputEnabled: true,
				},	
				credits: {
					enabled: false
				},				
				chart: {		
					type: 'spline',
					events:{
						load: function(e){
							$.ajax({
								url: 'api/point/1',
								type: "GET",
								dataType: "json",
								success: function(data) {
									
									graph1Options.title = {text : data['date']};
									
									boatData = FboatData(data);

									graph1Options.series[0].data = (boatData.boat);				
									graph1Options.xAxis = {categories:boatData.boatNames};
										
									$('#graph').highcharts(graph1Options);
									
								},
								cache: false
							})
						},
					}
				}, 
				title: {
					text: ''
				},
				subtitle: {
					text: ''
				},
				
				legend:{
					enabled: true,
				
				},
				xAxis: {
					ordinal: false,
					type: 'datetime',
					dateTimeLabelFormats: {
						month: '%e. %b',
						year: '%b'
					},
					title: {
						text: 'Date'
					}
				},
				yAxis: {
					title: {
						text: 'Overdue %'
					},
					min: 0,
					opposite: false,
					
				},
				
				
				tooltip: {
					enabled: false,
				//	headerFormat: '<b>{series.name}</b><br>',
				//	pointFormat: '{point.x:%e. %b}: {point.y:.2f} %<br>',
					borderWidth: 0,
					shadow: false,
				//	backgroundColor: (190, 190, 90, 0.85),
				//	crosshairs: [true],
				},
				
				series: [	
					@foreach($graph2_data as $boat)
						{
							name: '{{ $boat['name'] }}',
							allowPointSelect: true,
							color: '{{ $boat['color'] }}',
							id : '{{ $boat['id'] }}',
							data: [			
								@foreach($boat['list'] as $due)
								{
									x: Date.UTC({{ $due['storageDate'] }}),
									y:  {{ $due['percentage'] }},
									id: {{ $due['id'] }},
								},
								@endforeach	
								
							],
						}, 	
					
					
						@if(count($boat['flags']) > 0)
							{	
								onSeries : '{{ $boat['id'] }}',
								shape : 'squarepin',
								color: '{{ $boat['color'] }}',
								type: 'flags',
								data: [
									@foreach($boat['flags'] as $flag)
											{	
												x: Date.UTC({{{ $flag['storageDate'] }}}),
												title:  "{{{ $flag['text'] }}}",
											},		
									@endforeach
								],
							},
						@endif
					@endforeach
				
				],
				
				plotOptions: {
					series: {
					
						cursor: 'pointer',
						
						point: {
							events: {
								click: function (e) {			
									$.ajax({
										url: 'api/point/1/' + this.id,
										type: "GET",
										dataType: "json",
										success: function(data) {
										
											graph1 = $('#graph').highcharts();
											
											graph1.setTitle({text : data['date']});		
											
											boatData = FboatData(data);
											
											graph1.series[0].setData(boatData.boat);	
											
										},
										cache: false
									})
								}
							}
						},
						
						states: {
							hover: {
								lineWidthPlus: 5
							}
						}
						
					}
				},
			}
		
			graph2 = $('#graph2').highcharts('StockChart', graph2Options);
			
			$('.highcharts-navigator, .highcharts-navigator-handle-left, .highcharts-navigator-handle-right').mousedown(function(){
				mouseDown = true;
			});
			$(document).mouseup(function(){
				if(mouseDown == true){	
					//console.log($('input.highcharts-range-selector:eq(0)').val());
					//console.log($('input.highcharts-range-selector:eq(1)').val());
					$.ajax({
						url: 'api/avg/1/' + $('input.highcharts-range-selector:eq(0)').val() +'/'+ $('input.highcharts-range-selector:eq(1)').val(),
						type: "GET",
						dataType: "json",
						success: function(data) {
	
							graph1 = $('#graph').highcharts();
						
							graph1.setTitle({text : data['date']});
							
							boatData = FboatData(data);
							
							graph1.series[0].setData(boatData.boat);

						},
						cache: false
					});
					mouseDown = false;
				}	
				
			});
		});
		</script>
		<div id="graph" style="width:80%; height:300px; margin:0 auto;"></div>
		<div id="graph2" style="width:80%; height:450px; margin:0px auto 0px auto;"></div>
		<h2 style="width:250px; margin:0px auto 0px auto;">(overdue&#x00F7;totalJobs)&#8226;100</h2>
	</div>
</div>


<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
{{--<script type="text/javascript" src="Highcharts-4.0.4/js/themes/gray.js"></script>--}}

@stop