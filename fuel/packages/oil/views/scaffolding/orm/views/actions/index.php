<h2>Listing <span class='muted'><?php echo \Str::ucfirst($plural_name); ?></span></h2>
<br>
<?php echo "<?php if (\${$plural_name}): ?>"; ?>

<table class="table table-striped">
	<thead>
		<tr>
<?php foreach ($fields as $field): ?>
			<th><?php echo \Inflector::humanize($field['name']); ?></th>
<?php endforeach; ?>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php echo '<?php'; ?> foreach ($<?php echo $plural_name; ?> as $<?php echo $singular_name; ?>): <?php echo '?>'; ?>
		<tr>

<?php foreach ($fields as $field): ?>
			<td><?php echo '<?php'; ?> echo $<?php echo $singular_name.'->'.$field['name']; ?>; <?php echo '?>'; ?></td>
<?php endforeach; ?>
			<td>
				<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/view/'.$<?php echo $singular_name; ?>->id, '<i class="icon-eye-open" title="View"></i>'); <?php echo '?>'; ?> |
				<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/edit/'.$<?php echo $singular_name; ?>->id, '<i class="icon-wrench" title="Edit"></i>'); <?php echo '?>'; ?> |
				<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/delete/'.$<?php echo $singular_name; ?>->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); <?php echo '?>'; ?>


			</td>
		</tr>
<?php echo '<?php endforeach; ?>'; ?>
	</tbody>
</table>

<?php echo '<?php else: ?>'; ?>

<p>No <?php echo \Str::ucfirst($plural_name); ?>.</p>

<?php echo '<?php endif; ?>'; ?>
<p>
	<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/create', 'Add new <?php echo \Inflector::humanize($singular_name); ?>', array('class' => 'btn btn-success')); <?php echo '?>'; ?>


</p>
