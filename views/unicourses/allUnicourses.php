<h5>
	All Courses | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'unicourses/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'unilocks'; ?>" >Locks</a>


</h5>


<?php 

debug($rows[0]);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Clsrm</th>
	<th>Lvl</th>
	<th>Sem</th>
	<th>Code</th>
	<th>Subject</th>
	<th>Units</th>
	<th>Teacher</th>
	<th>Prerequisite<br />List</th>
	<th>Days</th>
	<th>Start</th>
	<th>End</th>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['crcode']; ?></td>
	<td class="center" ><?php echo $rows[$i]['level_id']; ?></td>
	<td class="center" ><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['subcode']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['units']+0); ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td><?php echo $rows[$i]['prerequisite_list']; ?></td>
	<td><?php echo $rows[$i]['days']; ?></td>
	<td><?php echo $rows[$i]['time_start']; ?></td>
	<td><?php echo $rows[$i]['time_end']; ?></td>
	<td><a href="<?php echo URL.'unicourses/edit/'.$rows[$i]['crs']; ?>" >Edit</a></td>
	<td><a href="<?php echo URL.'uniclasslists/crs/'.$rows[$i]['crs']; ?>" >Roster</a></td>
	<td><a href="<?php echo URL.'unigrades/crs/'.$rows[$i]['crs']; ?>" >Grades</a></td>
</tr>
<?php endfor; ?>
</table>
