<?php
$layout->title = 'Fees';
$layout->subtitle = $option->name;
$layout->leftnav = render('products/options/leftnav', array('option' => $option));
$layout->breadcrumbs['Product Lines'] = 'products';
$layout->breadcrumbs[$product->name] = $product->link('edit');
$layout->breadcrumbs['Options'] = $product->link('options');
$layout->breadcrumbs[$option->name] = $option->link('edit');
$layout->breadcrumbs['Fees'] = '';
$layout->pagenav = render('products/options/fees/pagenav', array('option' => $option));
?>

<?php if (empty($fees)): ?>
	<div class="alert alert-error">
		<p>This product option has no fees.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Price</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($fees as $fee): ?>
			<tr>
				<td><?php echo $fee->id ?></td>
				<td><?php echo $fee->name ?></td>
				<td>
					$<?php echo number_format($fee->interval_price) ?>
					<?php if (!$fee->recurring()): ?>
						(nonrecurring)
					<?php else: ?>
						<?php if ($fee->interval == 1): ?>
							/ <?php echo $fee->interval_unit ?>
						<?php else: ?>
							/ <?php echo $fee->interval . ' ' . Inflector::pluralize($fee->interval_unit) ?>
						<?php endif ?>
					<?php endif ?>
				</td>
				<td><?php echo View_Helper::date($fee->created_at) ?></td>
				<td><?php echo ($fee->updated_at != $fee->created_at) ? View_Helper::date($fee->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($fee->status) {
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
						<?php echo Str::ucfirst($fee->status) ?>
					</span>
				</td>
				<td>
					<?php echo Html::anchor($fee->link('edit'), '<i class="icon icon-pencil"></i> Edit', array('class' => 'action-link')) ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
