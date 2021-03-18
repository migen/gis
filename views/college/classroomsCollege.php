<h5>
	TMP 00 Classrooms
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'college'; ?>" >College</a>		
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th class="vc200" >Classrooms</th>
<th>Lvl</th>
<th>Sxn</th>
<th>Num</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo '#'.$rows[$i]['id'].' - '.$rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['section_id']; ?></td>
	<td><?php echo $rows[$i]['major_id']; ?></td>
</tr>
<?php endfor; ?>
</table>
