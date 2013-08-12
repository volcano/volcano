<?php foreach ($alerts as $type => $message): ?>
	<?php if (!empty($message)): ?>
	<div class="alert alert-<?php echo $type ?>">
		<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
		<?php if ($type == 'success'): ?>
			<strong class="alert-heading">Success!</strong>
		<?php elseif ($type == 'error'): ?>
			<strong class="alert-heading">Problem!</strong>
		<?php endif; ?>
		<p><?php echo $message ?></p>
	</div>
	<?php endif; ?>
<?php endforeach; ?>
