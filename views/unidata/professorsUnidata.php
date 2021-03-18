<h5>
	Professors List | <?php $this->shovel('homelinks'); ?>
	| <span>ID</span>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Tcid</th>
	<th>Professor</th>
	<th>Num<br />Crs</th>
	<th>Loads</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $tcid=$rows[$i]['tcid']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $rows[$i]['tcid']; ?></td>
	<td><?php echo $rows[$i]['professor']; ?></td>
	<td class="center" ><?php echo $rows[$i]['numcrs']; ?></td>
	<td><a href="<?php echo URL.'uniloads/tcid/'.$tcid; ?>" >Loads</a></td>
</tr>
<?php endfor; ?>
</table>
