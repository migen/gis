<h5>
	Classroom Courses (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Classlist</a>	
	
</h5>

<?php 
// pr($cr);
?>

<p class="brown" >&debug | param[0]=crid</p>

<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr class="headrow"><td>Sem </td><td><?php echo 'Count'; ?></td></tr>
<tr><td>Adviser</td><td><?php echo $cr['adviser'].' #'.$cr['acid']; ?></td></tr>
<tr><td>Name</td><td><?php echo $cr['name'].' #'.$cr['id']; ?></td></tr>
<tr><td>Label</td><td><?php echo $cr['label'] ?></td></tr>
</table>
</div>

<div class="fourth" >
<table class="gis-table-bordered table-altrow" >
<tr class="headrow"><td>Sem </td><td><?php echo 'Count'; ?></td></tr>
<tr><td>Sem 0</td><td><?php echo $count_sem0; ?></td></tr>
<tr><td>Sem 1</td><td><?php echo $count_sem1; ?></td></tr>
<tr><td>Sem 2</td><td><?php echo $count_sem2; ?></td></tr>
</table>
</div>


<div class="clear" ><br /></div>

<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Crs</th>
	<th>Type</th>
	<th>Subject</th>
	<th>Crs Code</th>
	<th>Course Label</th>
	<th>Sem</th>
	<th>Teacher</th>
	<th>Pos</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']!=1)? 'red':NULL; ?>" >
	<td><?php echo $i+1; ?></td>
	<td class="vc30" ><?php echo $rows[$i]['crs']; ?></td>
	<td class="center vc30" ><?php echo $rows[$i]['crstype_id']; ?></td>
	<td class="vc200" ><?php echo $rows[$i]['subject'].' #'.$rows[$i]['subid']; ?></td>
	<td><?php echo $rows[$i]['crscode'].' #'.$rows[$i]['crs']; ?></td>
	<td class="vc300" ><?php echo $rows[$i]['crslabel']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td class="vc300" ><?php echo $rows[$i]['teacher']; ?></td>
	<td class="center vc30" ><?php echo $rows[$i]['position']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht50" ></div>

