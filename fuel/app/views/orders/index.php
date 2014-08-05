<?php
$layout->title = 'Order Overview';
$layout->breadcrumbs['Orders'] = 'orders';
?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Customer</th>
		<th>Transaction Id</th>
		<th>Amount</th>
		<th>Date Created</th>
		<th>Date Updated</th>
	</thead>
	<tbody>
		<?php foreach ($orders as $order): ?>
			<tr>
				<td><?php echo $order->id ?></td>
				<td><?php 
				    echo Html::anchor($order->customer->link('contacts'), $order->customer->name())
				?></td>
				<td><?php echo Html::anchor($order->customer->link('transactions'), $order->transaction_id) ?></td>
				<td>$<?php echo $order->transaction->amount ?></td>
				<td><?php echo View_Helper::date($order->created_at) ?></td>
				<td><?php echo ($order->updated_at != $order->created_at) ? View_Helper::date($order->updated_at) : '' ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination->render() ?>