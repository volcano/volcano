<?php
$layout->title = 'Totals';
$layout->pagenav = render('statistics/customers/pagenav');
$layout->leftnav = render('statistics/leftnav');
$layout->breadcrumbs['Statistics'] = 'statistics';
$layout->breadcrumbs['Customers'] = '';
$layout->breadcrumbs['Totals'] = '';

render('common/chart', array('type' => 'highstock'));
Casset::js('js/controller/statistics/customers/totals.js', true, 'page');
?>

<div id="chart-customer-totals" style="width:100%; height:400px;" data-url="/api/customers/statistics/totals"></div>
