$(function() {
	var element = $('#chart-customer-conversion');
	
	$.ajax({
		url  : element.data('url'),
		type : 'get'
	}).done(function (response) {
		renderChart(element, response);
	});
	
	var renderChart = function (element, data) {
		var series = [];
		
		var keys = Object.keys(data);
		var key  = keys[0];
		
		var pieces = key.split('-');
		var date   = new Date(pieces[0], pieces[1], pieces[2]);
		
		$.each(data[key], function (key, value) {
			series.push([titleize(key), value]);
		});
		
		element.highcharts({
			chart: {
				type: 'funnel',
				marginRight: 100
			},
			title: {
				text: 'Customer Conversion Rate',
				x: -50
			},
			subtitle: {
				text: date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear(),
				x: -50
			},
			tooltip: {
				enabled: false
			},
			plotOptions: {
				series: {
					dataLabels: {
						enabled: true,
						format: '<strong><span style="color:{point.color};">{point.name}:</span> {point.y:,.0f}</strong> ({point.percentage:.1f}%)',
						useHTML: true
					}
				}
			},
			credits: {
				enabled: false
			},
			series: [{
				name: 'Total Customers',
				data: series
			}]
		});
	};
});
