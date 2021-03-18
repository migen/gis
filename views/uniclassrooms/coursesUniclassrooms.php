<h5>
	<?php echo $cr['code']; ?> Courses | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'unicourses/add/'.$crid; ?>" >Add</a>
	| <span class="u" onclick="pclass('shd');" >SHD</span>

</h5>


<?php 

$rows=empty($rows)? NULL:$rows;
debug($rows[0]);
// pr($rows[0]);


?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Lvl</th>
	<th>Sem</th>
	<th>Course</th>
	<th>Subject</th>
	<th>Units</th>
	<th>Teacher</th>
	<th>Prerequisite<br />List</th>
	<th>Days</th>
	<th>Start</th>
	<th>End</th>	
	<th class="shd" >IO</th>
	<th class="shd" >inGA</th>
	<th class="shd" >is<br />Num</th>	
	<th>Cls<br />Crs</th>
	<th>Grades</th>
	<td></td>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo $rows[$i]['crs']; ?></td>
	<td class="center" ><?php echo $rows[$i]['level_id']; ?></td>
	<td class="center" ><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['units']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td><?php echo $rows[$i]['prerequisite_list']; ?></td>
	<td><?php echo $rows[$i]['days']; ?></td>
	<td><?php echo $rows[$i]['time_start']; ?></td>
	<td><?php echo $rows[$i]['time_end']; ?></td>	
	<td class="shd center" ><?php echo $rows[$i]['is_active']; ?></td>
	<td class="shd center" ><?php echo $rows[$i]['in_genave']; ?></td>
	<td class="shd center" ><?php echo $rows[$i]['is_numeric']; ?></td>	
	<td><a href="<?php echo URL.'uniclasslists/crs/'.$rows[$i]['crs']; ?>" >List</a></td>
	<td><a href="<?php echo URL.'unigrades/crs/'.$rows[$i]['crs']; ?>" >Grades</a></td>
	<td><a href="<?php echo URL.'unicourses/edit/'.$rows[$i]['crs']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>


<script>

$(function(){
	shd();
	
})

</script>
