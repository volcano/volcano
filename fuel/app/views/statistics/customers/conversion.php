<?php
$layout->title = 'Conversion';
$layout->pagenav = render('statistics/customers/pagenav');
$layout->leftnav = render('statistics/leftnav');
$layout->breadcrumbs['Statistics'] = 'statistics';
$layout->breadcrumbs['Customers'] = '';
$layout->breadcrumbs['Conversion'] = '';

render('common/chart');
Casset::js('libs/highcharts/modules/funnel.js', true, 'page');
Casset::js('js/controller/statistics/customers/conversion.js', true, 'page');
?>

<div id="chart-customer-conversion" style="width:600px; height:400px;" data-url="/api/customers/statistics/conversion"></div>
