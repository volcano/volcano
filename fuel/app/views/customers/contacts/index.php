<?php
$layout->title = 'Contacts';
$layout->subtitle = $customer->name();
$layout->pagenav = render('customers/pagenav', array('customer' => $customer));
$layout->breadcrumbs['Customers'] = 'customers';
$layout->breadcrumbs[$customer->name()] = $customer->link('contacts');
$layout->breadcrumbs['Contacts'] = '';
?>

<?php if (empty($contacts)): ?>
	<div class="alert alert-error">
		<p>This customer has no contacts.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Primary</th>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Date Created</th>
		<th>Date Updated</th>
	</thead>
	<tbody>
		<?php foreach ($contacts as $contact): ?>
			<tr>
				<td><?php echo $contact->id ?></td>
				<td><?php echo ($contact == $primary) ? '<i class="icon-ok"></i>' : '' ?></td>
				<td><?php echo $contact->name() ?></td>
				<td><?php echo Html::mail_to($contact->email) ?></td>
				<td><?php echo $contact->phone() ?></td>
				<td>
					<?php if (!empty($contact->address)): ?>
						<?php echo $contact->address . ' ' . $contact->address2 ?><br />
						<?php echo $contact->city . ', ' . $contact->state . ' ' . $contact->zip ?><br />
						<?php echo $contact->country() ?>
					<?php endif ?>
				</td>
				<td><?php echo View_Helper::date($contact->created_at) ?></td>
				<td><?php echo ($contact->updated_at != $contact->created_at) ? View_Helper::date($contact->updated_at) : '' ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
