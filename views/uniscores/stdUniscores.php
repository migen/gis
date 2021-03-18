<h5>
	STD Scores - <?php echo $course['name']; ?> | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >ID</span>
	| <a href="<?php echo URL.'unisync/scores/'.$crs; ?>" >Sync</a>
	| <a href="<?php echo URL.'uniscores/add/'.$crs; ?>" >+Scores</a>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs; ?>" ><?php echo strtoupper(VCFOLDER); ?></a>
	
	
</h5>

<?php 
// pr($data);

debug($course);
debug($activities[0]);
// pr($activities[0]);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
<?php foreach($activities AS $cell): ?>
	<td class="center" ><?php echo '#'.$cell['aid'].'<br />'.$cell['cricode'].'<br />';
	echo ucfirst($cell['activity']).'<br />'.date('M d',strtotime($cell['date'])).'<br />('.($cell['max_score']+0).')'; ?>
		<br /><a href="<?php echo URL.'uniscoresManager/edit/'.$cell['aid']; ?>" >Edit</a>
	</td>
<?php endforeach; ?>
<th></th>
</tr>
<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php $scid=$students[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
<?php foreach($scores[$i] AS $cell): ?>
	<td class="center" ><?php echo $cell['score']+0; ?></td>
<?php endforeach; ?>	
<td><a href="<?php echo URL.'uniscoresManager/editScid/'.$crs.DS.$scid; ?>" >Edit</a></td>	
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>