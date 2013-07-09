<?php echo '<?php echo Form::open(array("class"=>"form-horizontal")); ?>' ?>


	<fieldset>
<?php foreach ($fields as $field): ?>
		<div class="control-group">
			<?php echo "<?php echo Form::label('". \Inflector::humanize($field['name']) ."', '{$field['name']}', array('class'=>'control-label')); ?>\n"; ?>

			<div class="controls">
<?php switch($field['type']):

				case 'text':
					echo "\t\t\t\t<?php echo Form::textarea('{$field['name']}', Input::post('{$field['name']}', isset(\${$singular_name}) ? \${$singular_name}->{$field['name']} : ''), array('class' => 'span8', 'rows' => 8, 'placeholder'=>'".\Inflector::humanize($field['name'])."')); ?>\n";
				break;

				default:
					echo "\t\t\t\t<?php echo Form::input('{$field['name']}', Input::post('{$field['name']}', isset(\${$singular_name}) ? \${$singular_name}->{$field['name']} : ''), array('class' => 'span4', 'placeholder'=>'".\Inflector::humanize($field['name'])."')); ?>\n";

endswitch; ?>

			</div>
		</div>
<?php endforeach; ?>
		<div class="control-group">
			<label class='control-label'>&nbsp;</label>
			<div class='controls'>
				<?php echo '<?php'; ?> echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); <?php echo '?>'; ?>
			</div>
		</div>
	</fieldset>
<?php if ($csrf): ?>
	<?php echo '<?php'; ?> echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); <?php echo '?>'; ?>
<?php endif; ?>
<?php echo '<?php'; ?> echo Form::close(); <?php echo '?>'; ?>
