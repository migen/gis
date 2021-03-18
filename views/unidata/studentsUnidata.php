<h5>
	College Students
	| <?php $this->shovel('homelinks','College'); ?>
	
</h5>

<p>
/lvl, &order=lvl
</p>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Lvl</th>
	<th>Crid</th>
	<th>Scid</th>
	<th>Code</th>
	<th class="vc200" >Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $scid=$rows[$i]['scid']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo $rows[$i]['lvl']; ?></td>
	<td class="center" ><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $scid; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><a href="<?php echo URL.'unistudents/edit/'.$scid; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
