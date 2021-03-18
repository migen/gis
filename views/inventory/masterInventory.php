<h5 class="screen" >
		Master Inventory Report (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >SHD</span>

	
</h5>

<?php 

// pr($data);
// exit;
?>

<?php include_once('incs/report_filter.php'); ?>

<?php if(isset($_GET['submit'])): ?>
<?php include_once('incs/report_table.php'); ?>
<?php endif; ?>

<div class="ht100" ></div>

<script>

$(function(){
	// shd();
})


</script>
