<?php
$layout->title = 'Orders';
$layout->subtitle = $customer->name();
$layout->leftnav = render('customers/leftnav', array('customer' => $customer));
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Orders'] = '';
?>

<?php if (empty($orders)): ?>
	<div class="alert alert-error">
		<p>This customer has no orders.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Transaction ID</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
	</thead>
	<tbody>
		<?php foreach ($orders as $order): ?>
			<tr>
				<td><?php echo $order->id ?></td>
				<td><?php echo $order->transaction_id ?></td>
				<td><?php echo View_Helper::date($order->created_at) ?></td>
				<td><?php echo ($order->updated_at != $order->created_at) ? View_Helper::date($order->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($order->status) {
						case 'completed':
							$status_label = 'label-success';
							break;
							
						case 'pending':
							$status_label = 'label-info';
							break;
							
						case 'canceled':
						default:
							$status_label = '';
					}
					?>
					<span class="label <?php echo $status_label ?>">
						<?php echo Str::ucfirst($order->status) ?>
					</span>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
