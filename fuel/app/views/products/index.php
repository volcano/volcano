<?php
$layout->title = 'Product Lines';
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->pagenav = render('products/pagenav');
?>

<?php if (empty($products)): ?>
	<div class="alert alert-error">
		<p>This seller has no products.</p>
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
		<?php foreach ($products as $product): ?>
			<tr>
				<td><?php echo $product->id ?></td>
				<td><?php echo $product->name ?></td>
				<td><?php echo View_Helper::date($product->created_at) ?></td>
				<td><?php echo ($product->updated_at != $product->created_at) ? View_Helper::date($product->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($product->status) {
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
						<?php echo Str::ucfirst($product->status) ?>
					</span>
				</td>
				<td><?php echo Html::anchor($product->link('edit'), '<i class="icon icon-wrench"></i> Configure', array('class' => 'action-link')) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
