<h5 class="screen" >
	Inventory Summary Report
	
</h5>

<?php include_once('incs/report_filter.php'); ?>

<?php if(isset($_GET['submit'])): ?>
<?php include_once('incs/report_table.php'); ?>
<?php endif; ?>


