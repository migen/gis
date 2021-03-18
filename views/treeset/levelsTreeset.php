<h3>
	Treeset Levels | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 

	debug($rows[0]);
?>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Level</th>
	<th>ID</th>
</tr>
<?php $i=0; ?>
<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['id']; ?></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>


</table>
