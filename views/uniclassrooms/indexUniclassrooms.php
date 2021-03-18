<h5>
	College Classrooms | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'uniclassrooms/upname'; ?>" >Upname</a>
	| <a href="<?php echo URL.'uniclassrooms/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniclassrooms/batch'; ?>" >Create</a>
	| <a href="<?php echo URL.'unisections'; ?>" >Sections</a>
	| <span class="u" onclick="traceshd();" >ID</span>


</h5>

<?php 


// pr($_SESSION['q']);
// pr($rows[0]);
if(!empty($rows)){ debug($rows[0]); }


?>




<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th class="" >Code</th>
	<th class="vc100" >Name</th>
	<th class="" >Major</th>
	<th class="" >Section</th>
	<th class="" >Courses</th>
	<th class="" >FC</th>
	<th class="" >Clslist</th>
	<th class="" >Sched</th>
	<th class="center" >Crs/s</th>
	<th class="center" >Cards</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $years=$rows[$i]['years']; ?>
	<?php $id=$rows[$i]['crid']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['major_code']; ?><span class="shd" ><?php echo ' #'.$rows[$i]['major_id']; ?></span></td>
	<td><?php echo $rows[$i]['section']; ?><span class="shd" ><?php echo ' #'.$rows[$i]['section_id']; ?></span></td>
	<td><?php for($y=1;$y<=$years;$y++): ?>
			<a href="<?php echo URL.'uniclassrooms/courses/'.$rows[$i]['crid'].DS.$y.' '; ?>" ><?php echo $y; ?></a>			
		<?php endfor; ?></td>
	<td><a href="<?php echo URL.'uniflowcharts/major/'.$rows[$i]['major_id']; ?>" >FC</a></td>		
	<td><?php for($y=1;$y<=$years;$y++): ?>
			<a href="<?php echo URL.'uniclasslists/crid/'.$rows[$i]['crid'].DS.$y.' '; ?>" ><?php echo $y; ?></a>			
		<?php endfor; ?></td>		
	<td><a href="<?php echo URL.'unischedules/crid/'.$rows[$i]['crid']; ?>" >Sched</a></td>		
	<td class="center" ><a href="<?php echo URL.'uniclassrooms/syncGrades/'.$rows[$i]['crid']; ?>" >Sync</a></td>		
	<td><?php for($y=1;$y<=$years;$y++): ?>
			<a href="<?php echo URL.'unicards/crid/'.$rows[$i]['crid'].DS.$y.' '; ?>" ><?php echo $y; ?></a>			
		<?php endfor; ?></td>	
	<td><a href='<?php echo URL."uniclassrooms/edit/$id"; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>


<p>
*FC - Flowchart
</p>


<script>

$(function(){
	shd();
	
})

</script>
