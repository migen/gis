<?php 

// pr($data);

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Departments | 
	<?php 	$this->shovel('homelinks','mis'); ?>
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$num_departments;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $departments[$i]['code']; ?></td>
		<td><?php echo $departments[$i]['name']; ?></td>
	</tr>	
<?php endfor; ?>

</table>
<br />

<!------------------------------------------------------------------------->


