<?php
$layout->title = 'Event Callbacks';
$layout->pagenav = render('settings/callbacks/pagenav');
$layout->leftnav = render('settings/leftnav');
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['Event Callbacks'] = '';
?>

<?php if (empty($callbacks)): ?>
	<div class="alert alert-error">
		<p>This seller has no event callbacks.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Event</th>
		<th>Callback URL</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($callbacks as $callback): ?>
			<tr>
				<td><?php echo $callback->id ?></td>
				<td><?php echo Inflector::titleize($callback->event, '.') ?></td>
				<td><?php echo $callback->url ?></td>
				<td><?php echo View_Helper::date($callback->created_at) ?></td>
				<td><?php echo ($callback->updated_at != $callback->created_at) ? View_Helper::date($callback->updated_at) : '' ?></td>
				<td>
					<?php
						echo Html::anchor($callback->link('edit'), '<i class="icon icon-pencil"></i> Edit', array('class' => 'action-link'));
						echo Html::anchor(
							$callback->link('delete'),
							'<i class="icon icon-remove"></i> Delete',
							array('class' => 'action-link confirm', 'data-msg' => "Are you sure you want to delete this event callback?")
						);
					?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
