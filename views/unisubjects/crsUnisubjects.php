<h5>
	<span class="" ><?php echo $subject['name']; ?></span> 
	| <?php $this->shovel('homelinks','College'); ?>
	| <span onclick="traceshd();" >More</span>
	| <a href="<?php echo URL.'unisubjects'; ?>" >Subjects</a>

	
</h5>

<?php 

debug($rows[0]);

?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Sxn</th>
	<th>Teacher</th>
	<th>Year</th>
	<th>Sem</th>
	<th>Room</th>
	<th>Days</th>
	<th>Start</th>
	<th>End</th>
	<th class="shd" >IO</th>
	<th class="shd" >inGA</th>
	<th class="shd" >Num</th>	
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $crs=$rows[$i]['crs']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crcode']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td class="center" ><?php echo $rows[$i]['level_id']; ?></td>
	<td class="center" ><?php echo $rows[$i]['semester']; ?></td>
	<td class="center" ><?php echo $rows[$i]['room']; ?></td>
	<td class="center" ><?php echo $rows[$i]['days']; ?></td>
	<td><?php echo $rows[$i]['time_start']; ?></td>
	<td><?php echo $rows[$i]['time_end']; ?></td>
	<td class="shd center" ><?php echo $rows[$i]['is_active']; ?></td>
	<td class="shd center" ><?php echo $rows[$i]['in_genave']; ?></td>
	<td class="shd center" ><?php echo $rows[$i]['is_numeric']; ?></td>
	<td><a href="<?php echo URL.'unicourses/edit/'.$crs; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>


<script>

$(function(){
	shd();
	
})

</script>