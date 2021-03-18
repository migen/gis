<h5>
	List Trans 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'dreams/migrate'; ?>" >Migrate</a>

	<?php 
		// pr($rows[0]);
	?>
	
</h5>

<h4><?= $message; ?></h4>

<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Year</th><th>Name</th><th>DB</th><th>Edit</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['year']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['dbname']; ?></td>
	<td><a href="<?php echo URL.'dreams/edit/'.$rows[$i]['id'].'&dbname='.$rows[$i]['dbname']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
