<?php $bc_cntr = 0 ?>
<ul class="breadcrumb">
	<?php foreach ($breadcrumbs as $title => $link): ?>
		<?php $bc_cntr++ ?>
		<?php if ($bc_cntr == count($breadcrumbs)): ?>
			<li class="active">
				<?php echo $title ?>
			</li>
		<?php else: ?>
			<li>
				<?php echo Html::anchor($link, $title) ?>
				<span class="divider">/</span>
			</li>
		<?php endif ?>
	<?php endforeach ?>
</ul>
