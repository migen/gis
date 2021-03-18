<?php 
	debug($rows[0]); 
	// pr($rows[0]); 

?>

<h5>
	<?php echo "#".$club_id; ?> formSyncClubGrades (<?php echo $count; ?>)	
	
	Club #<?php echo $club['id']; ?>

	| <a href="<?php echo URL.'clubs/members/'.$club_id; ?>" >Members</a>
	| <a href="<?php echo URL.'clubs/scores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Scores</a>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Grades</a>

</h5>


<form method="POST" >
<?php $is_synced=true; ?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Classroom</th>
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
	<td><?php echo '#'.$rows[$i]['summcrid'].'-'.$rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['summcrid']; ?></td>
	<td><?php echo $rows[$i]['clubcrs']; ?></td>
	<td><?php $matched=($rows[$i]['clubcrs']==$rows[$i]['summclubcrs'])? true:false;  ?>
		<?php if($matched): ?>
			<?php // echo $rows[$i]['summclubcrs']; ?>
		<?php else: ?>
			<?php if($is_synced){ $is_synced=false; } ?>
			<input type="hidden" class="vc50" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>"  >
			<input class="vc50" name="posts[<?php echo $i; ?>][clubcrs]" value="<?php echo $rows[$i]['clubcrs']; ?>" >

		<?php endif; ?>
	</td>
	<td><a href="<?php echo URL.'classrooms/courses/'.$rows[$i]['summcrid']; ?>" >crs</a></td>
</tr>
<?php endfor; ?>
</table>

<?php if(!$is_synced): ?>
	<p><input type="submit" name="submit" value="Sync" ></p>
<?php endif; ?>

</form>

<div class="ht50" ></div>

