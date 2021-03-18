<?php 

// pr($data);

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Descriptions | 
	<?php 	$this->shovel('homelinks','mis'); ?>
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="table-fx gis-table-bordered table-altrow">
<tr class='headrow'>
	<th>#</th>
	<th>Rating</th>
	<th>Description</th>
	<th>From</th>
	<th>To</th>
	<th>Type</th>
	<th>PS</th>
	<th>GS</th>
	<th>HS</th>
</tr>
<?php for($i=0;$i<$num_descriptions;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $descriptions[$i]['rating']; ?></td>
		<td><?php echo $descriptions[$i]['description']; ?></td>
		<td><?php echo $descriptions[$i]['grade_floor']; ?></td>
		<td><?php echo $descriptions[$i]['grade_ceiling']; ?></td>
		<td><?php echo $descriptions[$i]['crstype']; ?></td>
		<td><?php echo ($descriptions[$i]['is_ps'])? 'PS' : NULL; ?></td>
		<td><?php echo ($descriptions[$i]['is_gs'])? 'GS' : NULL; ?></td>
		<td><?php echo ($descriptions[$i]['is_hs'])? 'HS' : NULL; ?></td>
	</tr>	
<?php endfor; ?>

</table>
<br />

<!------------------------------------------------------------------------->


