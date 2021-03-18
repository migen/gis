<h5>
	Manage Student Cavs
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'dupes/cleanCridcavs/'.$row['crid']; ?>" >Purge</a>

	
</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>GID</th>
	<th>Cri</th>
	<th>Criteria</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['gid']; ?></td>
	<td><?php echo $rows[$i]['criteria_id']; ?></td>
	<td><?php echo $rows[$i]['criteria']; ?></td>
</tr>
<?php endfor; ?>

</table>
