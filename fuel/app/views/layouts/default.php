<?php
Casset::less('less/layouts/default/config.less', true, 'base');
Casset::less('less/layouts/default/layout.less', true, 'base');
Casset::less('less/layouts/default/config.less', true, 'page');
Casset::js('libs/jquery/jquery.min.js', false, 'base');
Casset::js('libs/bootstrap/js/bootstrap-transition.js', true, 'base');
Casset::js('libs/bootstrap/js/bootstrap-alert.js', true, 'base');
Casset::js('libs/jquery/plugins/jquery.validate.js', true, 'page');
Casset::js('js/common/common.validate.js', true, 'page');

$app_name = Config::get('app_name');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php if (isset($title)): ?>
			<?php if (!isset($title_prefix) || $title_prefix): ?>
				<?php echo $app_name ?> -
			<?php endif; ?>
			<?php echo $title ?>
			<?php if (!empty($subtitle)): ?>
				- <?php echo $subtitle ?>
			<?php endif ?>
		<?php else: ?>
			<?php echo $app_name ?>
		<?php endif; ?>
	</title>
	
	<?php
	echo Casset::render_css('base');
	echo Casset::render_css('page');
	?>
</head>

<body class="<?php if (!empty($leftnav)) echo 'leftnav' ?>">
	<div class="page-wrapper">
		<div class="navbar navbar-inverse navbar-top">
			<div class="navbar-inner">
				<?php echo Html::anchor('', $app_name, array('class' => 'pull-left brand')) ?>
			</div>
		</div>
		
		<div class="navbar navbar-inverse navbar-bottom">
			<div class="navbar-inner">
				<?php if (!empty($topnav)): ?>
					<?php echo $topnav ?>
				<?php else: ?>
					<?php echo render('layouts/default/topnav') ?>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="content">
			<?php if (!empty($leftnav)): ?>
				<div class="leftnav">
					<?php echo $leftnav ?>
				</div>
			<?php endif ?>
			
			<div class="body">
				<div class="container-fluid">
					<?php if (empty($hide_breadcrumbs)): ?>
						<?php echo View_Helper::breadcrumbs((array) $breadcrumbs) ?>
					<?php endif ?>
					
					<?php if (!empty($pagenav)): ?>
						<?php echo $pagenav ?>
					<?php endif; ?>
					
					<?php if (!empty($title) && empty($hide_title)): ?>
						<h1 class="page-title">
							<?php
								echo $title
							?><?php if (!empty($subtitle)): ?>:
								<span class="sub-title"><?php echo $subtitle ?></span>
							<?php endif ?>
						</h1>
					<?php endif ?>
					
					<?php echo View_Helper::alerts() ?>
					
					<?php echo $content ?>
				</div>
			</div>
		</div>
		
		<footer></footer>
	</div>
	
	<?php
	echo Casset::render_js('base');
	echo Casset::render_js('page');
	?>
</body>
</html>
