<style>


<?php for($i=10;$i<100;$i+=10): ?>
	.w<?php echo $i; ?>{ width:<?php echo $i; ?>px; }
<?php endfor; ?>	
	
</style>


<h5>
	Test Column Width 
	| <?php $this->shovel('homelinks'); ?>

</h5>

<?php 
	$tr=array(
		'ATTEMPTS TO FEED SELF AND/OR FINISHES FOOD',
		'EXPRESSES FEELING THROUGH WORDS/GESTURES',
		'INDICATES TOILET NEEDS TO AVOID ACCIDENTS',
	);
	$ct=count($tr);
	
?>


<table class="gis-table-bordered" >
<tr><th>#</th>
<?php for($i=0;$i<$ct;$i++): ?>
	<th class="w50" ><?php echo ucfirst(strtolower($tr[0])); ?></th>
<?php endfor; ?>

</tr>






</table>




