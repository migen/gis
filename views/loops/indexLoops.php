<h5>
	Loops (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<h4>For Loop</h4>
<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Student</th><th>Genave</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['genave']; ?></td>
</tr>
<?php // if($rows[$i]['genave']<=94) break; ?>
<?php if(round($rows[$i]['genave'])==97) continue; ?>
<?php endfor; ?>
</table>




<h4>Do While > 97 Loop</h4>
<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Student</th><th>Genave</th></tr>
<?php $i=0; ?>
<?php while($rows[$i]['genave']>97): ?>
<tr><td><?php echo $i+1; ?></td>
<td><?php echo $rows[$i]['student']; ?></td>
<td><?php echo $rows[$i]['genave']; ?></td>
</tr>
<?php $i++; ?>
<?php endwhile; ?>
</table>


