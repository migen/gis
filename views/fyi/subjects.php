<h5>
	Subjects
	| <a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Code</th>
	<th>Subject</th>
	<th>Position</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $subjects[$i]['id']; ?></td>
		<td><?php echo $subjects[$i]['code']; ?></td>
		<td><?php echo $subjects[$i]['name']; ?></td>
		<td><?php echo $subjects[$i]['position']; ?></td>
	</tr>
<?php endfor; ?>
</table>