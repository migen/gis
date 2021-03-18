<style>


</style>

<h5>
	Classroom Club Scores (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php 
	$decicard=$_SESSION['settings']['decicard'];
	// pr($rows[0]);
?>

<table class="gis-table-bordered table-altrow" >
<tr><th class="" ><?php echo '#'.$cr['crid'].'-'.$cr['classroom']; 
	if($_SESSION['srid']!=RTEAC){ echo ' - #'.$cr['acid'].'-'.$cr['adviser']; } ?></th></tr>
</table>
<br />

<?php $updated=true; ?>

<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th class="left" >Student</th>
	<th class="left" >Club</th>
	<?php foreach($clubcriteria AS $sel): ?>
		<th><?php echo ucfirst($sel['code']); ?></th>	
	<?php endforeach; ?>	
	<th>Grade</th>
	<?php if($is_admin): ?>
		<th>Edit</th>
		<th>Club#</th>
		<th>Grades</th>
	<?php endif; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="left" ><?php echo $rows[$i]['student']; ?></td>
	<td class="left" ><?php echo $rows[$i]['club']; ?></td>
	<td class="center" ><?php echo $rows[$i]['cri1']; ?></td>
	<td class="center" ><?php echo $rows[$i]['cri2']; ?></td>
	<td class="center" ><?php echo $rows[$i]['cri3']; ?></td>
	<?php $total=$rows[$i]['cri1']+$rows[$i]['cri2']+$rows[$i]['cri3'];?>
<td class="center" ><?php $cardgrade=number_format($rows[$i]['q'.$qtr],$decicard); echo $cardgrade; ?>
	<?php if($total!=$cardgrade): ?>
		<?php $updated=false; ?>
		<br /><input class="vc50 red center" name="posts[<?php echo $i; ?>][total]" value="<?php echo $total; ?>" >	
			<input type="hidden" class="vc50" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $rows[$i]['gid']; ?>" >
			
	<?php endif; ?>	
</td>

	<?php if($is_admin): ?>
		<th><a href="<?php echo URL.'clubs/student/'.$rows[$i]['scid']; ?>" ><?php echo $rows[$i]['scid']; ?></a></th>
		<th><a href="<?php echo URL.'clubs/scores/'.$rows[$i]['club_id']; ?>" >Scores</a></th>
		<th><a href="<?php echo URL.'clubs/grades/'.$rows[$i]['club_id']; ?>" >Grades</a></th>
	<?php endif; ?>	
</tr>
<?php endfor; ?>
</table>

<?php if(!$updated): ?>
	<p><input type="submit" name="submit" value="Update" /></p>
<?php endif; ?>

</form>

<div class="ht100" ></div>