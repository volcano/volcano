<?php
$layout->title = 'Metas';
$layout->subtitle = $product->name;
$layout->leftnav = render('products/leftnav', array('product' => $product));
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Metas'] = '';
$layout->pagenav = render('products/metas/pagenav', array('product' => $product));
?>

<?php if (empty($metas)): ?>
	<div class="alert alert-error">
		<p>This product has no metas.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($metas as $meta): ?>
			<tr>
				<td><?php echo $meta->id ?></td>
				<td><?php echo $meta->name ?></td>
				<td><?php echo View_Helper::date($meta->created_at) ?></td>
				<td><?php echo ($meta->updated_at != $meta->created_at) ? View_Helper::date($meta->updated_at) : '' ?></td>
				<td><?php echo Html::anchor($meta->link('edit'), '<i class="icon icon-pencil"></i> Edit', array('class' => 'action-link')) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
