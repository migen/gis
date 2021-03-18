<h5>
	Duplicate Cavs (<?php echo $cr['name']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'dupes/cleanCridcavs/'.$row['crid']; ?>" >Purge</a>
	| <a href="<?php echo URL.'dupes/lvlcavs/'.$cr['level_id']; ?>" >Lvl#<?php echo $cr['level_id']; ?> Cavs</a>

	
</h5>

<?php 
	if(isset($_GET['debug'])){ pr($q); }

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Crid</th>
	<th>GID</th>
	<th>Cri</th>
	<th>Criteria</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['gid']; ?></td>
	<td><?php echo $rows[$i]['criteria_id']; ?></td>
	<td><?php echo $rows[$i]['criteria']; ?></td>
</tr>
<?php endfor; ?>

</table>
