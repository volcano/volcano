<?php
$layout->title = 'Products';
$layout->subtitle = $customer->name();
$layout->leftnav = render('customers/leftnav', array('customer' => $customer));
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Products'] = '';
?>

<?php if (empty($products)): ?>
	<div class="alert alert-error">
		<p>This customer has no products.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Product</th>
		<th>Product Option</th>
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
				<td><?php echo Html::anchor($product->option->product->link('options'), $product->option->product->name) ?></td>
				<td><?php echo Html::anchor($product->option->link('fees'), $product->option->name) ?></td>
				<td><?php echo View_Helper::date($product->created_at) ?></td>
				<td><?php echo ($product->updated_at != $product->created_at) ? View_Helper::date($product->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($product->status) {
						case 'active':
							$status_label = ' label-success';
							break;
							
						case 'canceled':
						default:
							$status_label = '';
					}
					?>
					<span class="label <?php echo $status_label ?>">
						<?php echo Str::ucfirst($product->status) ?>
					</span>
				</td>
				<td>
					<?php
					if ($product->active()) {
						echo Html::anchor(
							$product->link('cancel'),
							'<i class="icon icon-remove"></i> Cancel',
							array('class' => 'action-link confirm', 'data-msg' => "Are you sure you want to cancel this customer's product?")
						);
					} elseif ($product->canceled()) {
						echo Html::anchor(
							$product->link('activate'),
							'<i class="icon icon-repeat"></i> Activate',
							array('class' => 'action-link confirm', 'data-msg' => "Are you sure you want to activate this customer's product?")
						);
					}
					?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
