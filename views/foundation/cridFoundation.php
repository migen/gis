<?php 

// pr($data);

// pr($data['cr']);


?>

<h5>
	<?php echo $sy; ?> Foundation Report (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'foundation'; ?>" >Foundation</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid.DS.$sy.DS.$qtr; ?>" >Matrix</a>
	<?php if($sy!=DBYR): ?>	
		| <a href='<?php echo URL."foundation/crid/$crid"; ?>' >Current</a>
	<?php else: ?>
		| <a href='<?php echo URL."foundation/crid/$crid/".(DBYR-1); ?>' ><?php echo (DBYR-1); ?></a>	
	<?php endif; ?>
	| <a class="u" id="btnExport" >Excel</a> 
		
	
</h5>



<?php $this->shovel('classroom_details',$cr);  ?>

<?php if($cr['subdepartment_id']==4): ?>
<?php $incs="incs/shsFdn_table.php";include_once($incs); ?>
<?php endif; ?>

<div class="ht50" ></div>




<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();


})


</script>
