<?php

	// pr($_SESSION['q']);

?>

<!-- ============================================================== -->



<?php 

	$parts = rtrim($_GET['url'],'/'); 
	$parts = explode('/',$parts);		
	$home = ($c = array_shift($parts))? $c : 'index'; 			

?>




<h5>
	Tuition Fees by Level 
	| <?php $this->shovel('homelinks',$home); ?>
</h5>

<!-- ============================================================== -->


<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Fees</th>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td><?php echo $levels[$i]['id']; ?></td>
	<td> <a href="<?php echo URL.'accounts/fees/'.$levels[$i]['id']; ?>" > <?php echo $levels[$i]['name']; ?> </a></td>
</tr>
<?php endfor; ?>


</table>
