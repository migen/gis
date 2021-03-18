<?php debug($rows[0]); ?>

<h5>
	<?php echo "#".$club_id; ?> formSyncClubGrades (<?php echo $count; ?>)	

</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Student</th>
	<th>Scid</th>
	<th>Summ<br />crid</th>
	<th>Club<br />crs</th>
	<th>Summ<br />Club<br />crs</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$scid=$rows[$i]['scid'];
	$crid=$rows[$i]['summcrid'];
	$club_id=$club_id;
	$clubcrs=$rows[$i]['clubcrs'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['summcrid']; ?></td>
	<td><?php echo $rows[$i]['clubcrs']; ?></td>
	<td><?php $ok=($rows[$i]['summclubcrs']>0)? true:false;  ?>
		<?php if($ok): ?>
			<?php echo $rows[$i]['summclubcrs']; ?>
		<?php else: ?>
			<a class="red" >Sync</a>
		<?php endif; ?>
	</td>
	<td><a href="<?php echo URL.'classrooms/courses/'.$rows[$i]['summcrid']; ?>" >crs</a></td>
	<td><a href='<?php echo URL."clubs/updateSyncStudentSummclubcrs/$scid/$crid/$club_id/$clubcrs"; ?>' >sync</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>

