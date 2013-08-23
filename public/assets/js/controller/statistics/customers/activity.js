$(function() {
	var element = $('#chart-customer-activity');
	
	$.ajax({
		url  : element.data('url'),
		type : 'get'
	}).done(function (response) {
		renderChart(element, response);
	});
	
	var renderChart = function (element, data) {
		var series     = [];
		var stats      = {};
		
		var keys       = Object.keys(data);
		var key        = keys[0];
		var pieces     = key.split('-');
		var begin_date = Date.UTC(pieces[0], pieces[1]-1, pieces[2]);
		
		$.each(data, function (key, value) {
			$.each(value, function (key, value) {
				if (stats.hasOwnProperty(key)) {
					stats[key].push(value);
				} else {
					stats[key] = [];
					stats[key].push(value);
				}
			});
		});
		
		$.each(stats, function (key, value) {
			series.push({
				name: titleize(key),
				data: value
			})
		});
		
		element.highcharts('StockChart', {
			chart: {
				type: 'area',
				zoomType: 'x'
			},
			title: {
				text: 'Customer Activity',
				x: -20 //center
			},
			rangeSelector: {
				selected: 0
			},
			tooltip: {
				headerFormat: '<table><tr><td class="title" colspan="2">{point.key}</td></tr>',
				pointFormat:  '<tr><td class="label" style="color:{series.color};">{series.name}</td><td class="value">{point.y}</td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: {
					day: '%b %d',
					week: '%b %d',
					month: '%b %Y',
					year: '%Y'
				}
			},
			yAxis: {
				title: {
					text: 'Total'
				}
			},
			plotOptions: {
				area: {
					//stacking: 'normal',
					pointInterval: 24 * 3600000, // 1 Day
					pointStart: begin_date
				}
			},
			legend: {
				enabled: true
			},
			navigator: {
				enabled: false
			},
			scrollbar: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			series: series
		});
	};
});
