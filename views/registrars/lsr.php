<?php 

// pr($data);
// pr($_SESSION['q']);

?>


<h5>
	Level Subject Ranking
	| <?php 	$this->shovel('homelinks','registrars'); ?>
	| <a href='<?php echo URL."registrars/lsr/$level_id/$subject_id/$sy/$qtr"; ?>'  >Qtr</a>
	| <a href='<?php echo URL."registrars/lsr/$level_id/$subject_id/$sy/5"; ?>'  >FG</a>
	
</h5>

<p>
<table class="gis-table-bordered table-fx"  >
	<tr><th class='white headrow'>Level-Subject</th><td><?php echo $level['level'].' - '.$subject['name']; ?></td></tr>
	<tr><th class='white headrow'>SY | Qtr</th><td><?php echo $sy.' | '.$qtr; ?></td></tr>
</table>
</p>



<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Section</th>
	<th>Grade</th>
	<th>Rank</th>
</tr>

<?php $rank=1; ?>
<?php $tie=false; ?>
<?php $i=0; ?>
<?php foreach($grades AS $row): ?>
<?php $j=$i-1; ?>

	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $row['student_code']; ?></td>
		<td><?php echo $row['student']; ?></td>
		<td><?php echo $row['section']; ?></td>
		<td><?php echo $row['grade']; ?></td>
		<?php if($grades[$i]['grade']<@$grades[$j]['grade']){ $tie = true; $rank++; }  ?>		
		<td class="<?php echo ($tie)? NULL:'red'; ?>" ><?php echo $rank; $tie=false; ?></td>
	</tr>

<?php $i++; ?>
<?php endforeach; ?>



</table>

