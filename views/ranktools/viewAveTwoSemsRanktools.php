<h3>
	Semestral Annual Average (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'ranktools/updateAveTwoSems/'.$lvl.DS.$sy.DS.'7'; ?>" >(Process)</a>
	| <a href="<?php echo URL.'registrars/qlra/'.$lvl.DS.$sy.DS.'7'; ?>" >Sort</a>

</h3>

<?php 
// pr($rows[0]);
?>

<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>Sem1</th>
	<th>Sem2</th>
	<th>Year</th>
	<th>Rank</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo number_format($rows[$i]['ave_q5'],$deciave); ?></td>
	<td><?php echo number_format($rows[$i]['ave_q6'],$deciave); ?></td>
	<td><?php echo number_format($rows[$i]['ave_q6'],$deciave); ?></td>
	<td class="center" ><?php echo $rows[$i]['rank_level_ave_q7']+0; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>
