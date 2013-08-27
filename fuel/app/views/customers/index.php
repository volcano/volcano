<?php
$layout->title = 'Customers';
$layout->breadcrumbs['Customers'] = 'customers';
?>

<?php if (empty($customers)): ?>
	<div class="alert alert-error">
		<p>This seller has no customers.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($customers as $customer): ?>
			<tr>
				<td><?php echo $customer->id ?></td>
				<td><?php echo $customer->name() ?></td>
				<td><?php echo $customer->email() ?></td>
				<td><?php echo View_Helper::date($customer->created_at) ?></td>
				<td><?php echo ($customer->updated_at != $customer->created_at) ? View_Helper::date($customer->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($customer->status) {
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
						<?php echo Str::ucfirst($customer->status) ?>
					</span>
				</td>
				<td>
					<?php echo Html::anchor($customer->link('contacts'), '<i class="icon icon-wrench"></i> Manage', array('class' => 'action-link')) ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<?php echo $pagination->render() ?>
