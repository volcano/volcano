<?php
$layout->title = 'Options';
$layout->subtitle = $product->name;
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs['Options: ' . $product->name] = '';
$layout->pagenav = render('products/options/pagenav', array('product' => $product));
?>

<?php if (empty($options)): ?>
	<div class="alert alert-error">
		<p>This product has no options.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($options as $option): ?>
			<tr>
				<td><?php echo $option->id ?></td>
				<td><?php echo $option->name ?></td>
				<td><?php echo View_Helper::date($option->created_at) ?></td>
				<td><?php echo View_Helper::date($option->updated_at) ?></td>
				<td>
					<?php
					switch ($option->status) {
						case 'active':
							$status_label = ' label-success';
							break;
							
						case 'deleted':
							$status_label = ' label-important';
							break;
							
						default:
							$status_label = '';
					}
					?>
					<span class="label<?php echo $status_label ?>">
						<?php echo Str::ucfirst($option->status) ?>
					</span>
				</td>
				<td>
					<?php echo Html::anchor($option->link('edit'), '<i class="icon icon-pencil"></i> Edit', array('class' => 'action-link')) ?>
					<?php echo Html::anchor($option->link('fees'), '<i class="icon icon-wrench"></i> Manage', array('class' => 'action-link')) ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
