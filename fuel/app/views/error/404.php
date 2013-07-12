<div class="padded">
	<h4>The page you requested was not found.</h4>
	
	<p>You may have clicked an expired link or mistyped the address. Some web addresses are case sensitive.</p>
	
	<ul>
		<li>
			<?php echo Html::anchor('/', 'Return home') ?>
		</li>
		<li>
			<?php echo Html::anchor('javascript:void(0);', 'Go back to the previous page', array('onclick' => 'history.back();')) ?>
		</li>
	</ul>
</div>
