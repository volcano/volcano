<?php
$layout->title = 'API Keys';
$layout->pagenav = render('settings/api/pagenav');
$layout->leftnav = render('settings/leftnav');
$layout->breadcrumbs['Settings'] = 'settings';
$layout->breadcrumbs['API Keys'] = '';
?>

<?php if (empty($keys)): ?>
	<div class="alert alert-error">
		<p>This seller has no API keys.</p>
	</div>
	<?php return ?>
<?php endif ?>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Key</th>
		<th>Date Created</th>
		<th>Date Updated</th>
		<th>Status</th>
		<th>Actions</th>
	</thead>
	<tbody>
		<?php foreach ($keys as $key): ?>
			<tr>
				<td><?php echo $key->id ?></td>
				<td><?php echo $key->key ?></td>
				<td><?php echo View_Helper::date($key->created_at) ?></td>
				<td><?php echo ($key->updated_at != $key->created_at) ? View_Helper::date($key->updated_at) : '' ?></td>
				<td>
					<?php
					switch ($key->status) {
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
						<?php echo Str::ucfirst($key->status) ?>
					</span>
				</td>
				<td>
					<?php
					if ($key->active()) {
						echo Html::anchor(
							$key->link('delete'),
							'<i class="icon icon-remove"></i> Remove',
							array('class' => 'action-link confirm', 'data-msg' => "Are you sure you want to remove this API key?")
						);
					}
					?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
