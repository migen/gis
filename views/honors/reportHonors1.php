<?php 



?>

<h5>
	Honors Report - <?php echo $cr['name']; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>	
	| <span class="u" onclick="pclass('hd');" >ID Number</span>
	| <a href="<?php echo URL.'honors/level/'.$cr['level_id'].'?num=1'; ?>" >Level</a>
	| <a href="<?php echo URL.'honors/process/'.$crid; ?>" >Process</a>
	

</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th class="hd" >Scid</th>
<th class="hd" >ID No.</th>
<th>Student</th>
<th>Genave</th>
<th>Honor</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['genave']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['honor']+0); ?></td>
</tr>
<?php endfor; ?>
</table>


