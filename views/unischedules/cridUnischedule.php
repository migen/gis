

<h5>
	Crid Courses Schedule <?php $this->shovel("homelinks"); ?>
	| <a href="<?php echo URL.'unischedules/upsched'; ?>" >Upsched</a>
	| <span class="u" onclick="traceshd();" >ID</span>
	
</h5>


<?php 
	// pr($rows[0]);
	if(!empty($rows)){ debug($rows[0]); }
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >ID</th>
	<th>Lvl</th>
	<th>Sem</th>
	<th>Course</th>
	<th>Teacher</th>
	<th>Schedule</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td class="" ><?php echo $rows[$i]['teacher']; ?></td>
	<td class="" ><?php echo $rows[$i]['schedule']; ?></td>
	<td><a href="<?php echo URL.'unischedules/crs/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>


<script>


$(function(){
	shd();
	
})

</script>