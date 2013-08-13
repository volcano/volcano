<?php
$layout->title = 'Transactions';
$layout->subtitle = $customer->name();
$layout->pagenav = render('customers/pagenav', array('customer' => $customer));
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Transactions'] = '';
?>

<?php if (empty($transactions)): ?>
	<div class="alert alert-error">
		<p>This customer has no transactions.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Amount</th>
		<th>Payment Method</th>
		<th>Date</th>
		<th>Status</th>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr>
				<td><?php echo $transaction->id ?></td>
				<td>$<?php echo $transaction->amount ?></td>
				<td><?php echo $transaction->paymentmethod() ?></td>
				<td><?php echo View_Helper::date($transaction->created_at) ?></td>
				<td>
					<?php
					switch ($transaction->status) {
						case 'paid':
							$status_label = 'label-success';
							break;
							
						case 'declined':
							$status_label = 'label-important';
							break;
							
						case 'refunded':
							$status_label = 'label-info';
							break;
							
						default:
							$status_label = 'label-warning';
					}
					?>
					<span class="label <?php echo $status_label ?>">
						<?php echo Str::ucfirst($transaction->status) ?>
					</span>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
