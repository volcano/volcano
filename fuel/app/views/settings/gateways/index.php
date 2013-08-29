<?php
$layout->title = 'Gateways';
$layout->pagenav = render('settings/gateways/pagenav');
$layout->leftnav = render('settings/leftnav');
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Gateways'] = '';
?>

<?php if (empty($gateways)): ?>
	<div class="alert alert-error">
		<p>This seller has no gateways.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Type</th>
		<th>Processor</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($gateways as $gateway): ?>
			<tr>
				<td><?php echo $gateway->id ?></td>
				<td><?php echo Inflector::titleize($gateway->type) ?></td>
				<td><?php echo Inflector::titleize($gateway->processor) ?></td>
				<td><?php echo View_Helper::date($gateway->created_at) ?></td>
				<td><?php echo ($gateway->updated_at != $gateway->created_at) ? View_Helper::date($gateway->updated_at) : '' ?></td>
				<td><?php echo Html::anchor($gateway->link('edit'), '<i class="icon icon-pencil"></i> Edit', array('class' => 'action-link')) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
