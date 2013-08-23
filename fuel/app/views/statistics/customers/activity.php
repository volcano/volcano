<?php
$layout->title = 'Activity';
$layout->pagenav = render('statistics/customers/pagenav');
$layout->leftnav = render('statistics/leftnav');
$layout->breadcrumbs['Statistics'] = 'statistics';
$layout->breadcrumbs['Customers'] = '';
$layout->breadcrumbs['Activity'] = '';

render('common/chart', array('type' => 'highstock'));
Casset::js('js/controller/statistics/customers/activity.js', true, 'page');
?>

<div id="chart-customer-activity" style="width:100%; height:400px;" data-url="/api/customers/statistics/activity"></div>
