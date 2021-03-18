<h5>
	Purge Clscrs (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'matrix/grades/'.$crid.DS.$sy.DS.$qtr; ?>" >Matrix</a>
	
</h5>

<h4><?php echo '#'.$classroom['id'].'-'.$classroom['name'].' | #'.$classroom['acid'].'-'.$classroom['adviser']; ?></h4>

<p class="brown" >
	1) Purge - grades,scores <br />
	2) Acts/Scores - activities and scores by qtr <br />
</p>

<table class="gis-table-bordered" >
<tr>
	<th>Crs</th>
	<th>Course</th>
	<th>Teacher</th>
	<th>View<br />Scores</th>
	<th>Purge<br />Acts<br />Scores</th>
	<th>Purge</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td>
		<a href="<?php echo URL.'teachers/scores/'.$rows[$i]['crs'].DS.$sy.DS.'1'; ?>" >Q1</a>
		<a href="<?php echo URL.'teachers/scores/'.$rows[$i]['crs'].DS.$sy.DS.'2'; ?>" >Q2</a>
		<a href="<?php echo URL.'teachers/scores/'.$rows[$i]['crs'].DS.$sy.DS.'3'; ?>" >Q3</a>
		<a href="<?php echo URL.'teachers/scores/'.$rows[$i]['crs'].DS.$sy.DS.'4'; ?>" >Q4</a>
	</td>
	<td>
		<a href="<?php echo URL.'purge/activitiesScores/'.$rows[$i]['crs'].DS.$sy.DS.'1'; ?>" >Q1</a>
		<a href="<?php echo URL.'purge/activitiesScores/'.$rows[$i]['crs'].DS.$sy.DS.'2'; ?>" >Q2</a>
		<a href="<?php echo URL.'purge/activitiesScores/'.$rows[$i]['crs'].DS.$sy.DS.'3'; ?>" >Q3</a>
		<a href="<?php echo URL.'purge/activitiesScores/'.$rows[$i]['crs'].DS.$sy.DS.'4'; ?>" >Q4</a>
	</td>
	<td><a href="<?php echo URL.'purge/crs/'.$rows[$i]['crs']; ?>" >Purge</a></td>
</tr>
<?php endfor; ?>
</table>
