<?php 
	$decicard=$_SESSION['settings']['decicard'];
	$deciave=$_SESSION['settings']['deciave'];
	
	
	
?>

<?php 
	// pr($crs_row);
?>

<h5>
	Averages
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Student</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
	<th>Final</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo number_format($rows[$i]['q1'],$decicard); ?></td>
	<td><?php echo number_format($rows[$i]['q2'],$decicard); ?></td>
	<td><?php echo number_format($rows[$i]['q3'],$decicard); ?></td>
	<td><?php echo number_format($rows[$i]['q4'],$decicard); ?></td>
	<td><?php echo number_format($rows[$i]['q5'],$deciave); ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>

