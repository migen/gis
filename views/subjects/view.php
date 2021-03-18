<h5>
	View Subject
	| <a href="<?php echo URL; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'subjects'; ?>">Subjects</a> 	
	| <a href="<?php echo URL.'subjects/edit/'.$row['id']; ?>">Edit</a> 	

</h5>

<?php if($data): ?>

<table class="gis-table-bordered table-fx" >
	<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
	<tr><th>Subject</th><td><?php echo $row['name']; ?></td></tr>
	<tr><td colspan="2"><?php pr($row); ?></td></tr>
</table>


<?php endif; ?>