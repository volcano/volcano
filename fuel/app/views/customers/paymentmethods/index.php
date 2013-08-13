<?php
$layout->title = 'Payment Methods';
$layout->subtitle = $customer->name();
$layout->pagenav = render('customers/pagenav', array('customer' => $customer));
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Payment Methods'] = '';
?>

<?php if (empty($paymentmethods)): ?>
	<div class="alert alert-error">
		<p>This customer has no payment methods.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Primary</th>
		<th>Type</th>
		<th>Account</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
	</thead>
	<tbody>
		<?php foreach ($paymentmethods as $paymentmethod): ?>
			<tr>
				<td><?php echo $paymentmethod->id ?></td>
				<td><?php echo $paymentmethod->primary ? '<i class="icon-ok"></i>' : '' ?></td>
				<td><?php echo $paymentmethod->type() ?></td>
				<td><?php echo $paymentmethod->account() ?></td>
				<td><?php echo View_Helper::date($paymentmethod->created_at) ?></td>
				<td><?php echo ($paymentmethod->updated_at != $paymentmethod->created_at) ? View_Helper::date($paymentmethod->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($paymentmethod->status) {
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
						<?php echo Str::ucfirst($paymentmethod->status) ?>
					</span>
				</td>

			</tr>
		<?php endforeach ?>
	</tbody>
</table>
