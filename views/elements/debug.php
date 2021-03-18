
<?php if($_SESSION['settings']['show_debug']=='1'): ?>
	<div class="hd"  >
	<?php 
		echo "Debug: "; pr($data);
	?>
	</div>
<?php endif; ?>
