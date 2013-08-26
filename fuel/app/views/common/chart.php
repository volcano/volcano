<?php
Casset::less('less/common/chart.less', true, 'page');

if (empty($type)) {
	$type = 'highcharts';
}

Casset::js("libs/highcharts/$type.js", true, 'page');
Casset::js('libs/highcharts/modules/exporting.js', true, 'page');
?>
