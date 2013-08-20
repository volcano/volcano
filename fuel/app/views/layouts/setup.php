<?php
Casset::less('less/layouts/default/layout.less', true, 'base');
Casset::js('libs/jquery/jquery.min.js', false, 'base');
Casset::js('libs/jquery/plugins/jquery.validate.js', true, 'page');
Casset::js('libs/bootstrap/js/bootstrap-alert.js', true, 'base');
Casset::js('libs/bootstrap/js/bootstrap-transition.js', true, 'base');
Casset::js('js/common.js', true, 'base');
Casset::js('js/common/common.validate.js', true, 'page');

$app_name = Config::get('app_name');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo $app_name ?>
		<?php if (isset($title)): ?>
			- <?php echo $title ?>
		<?php endif ?>
	</title>
	
	<?php
	echo Casset::render_css('base');
	echo Casset::render_css('page');
	?>
</head>

<body>
	<div class="page-wrapper">
		<div class="navbar navbar-inverse navbar-top">
			<div class="navbar-inner">
				<?php echo Html::anchor('/', Html::img('assets/img/logo-mini.png'), array('class' => 'pull-left brand')) ?>
			</div>
		</div>
		
		<div class="navbar navbar-inverse navbar-bottom"></div>
		
		<div id="content">
			<div class="body">
				<div class="container-fluid">
					<?php if (!empty($title)): ?>
						<h1 class="page-title">
							<?php echo $title ?>
						</h1>
					<?php endif ?>
					
					<?php echo View_Helper::alerts() ?>
					
					<?php echo $content ?>
				</div>
			</div>
			
			<footer></footer>
		</div>
	</div>
	
	<?php
	echo Casset::render_js('base');
	echo Casset::render_js('page');
	?>
</body>
</html>
