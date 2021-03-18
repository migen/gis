<h3>
	AR (<?php echo $count; ?>) <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'syncs/syncEnrollments/'.$sy; ?>" >1) Sync-Enrollments</a>
	| <a href="<?php echo URL.'syncs/arToEnrollments/'.$sy; ?>" >2) AR-Enrollments</a>

</h3>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Balance</th>
	<th>Ensumm</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$arid=$rows[$i]['arid'];
	$scid=$rows[$i]['scid'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $scid; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<td><a href="<?php echo URL.'students/ensumm/'.$scid; ?>" >Ensumm</a></td>
	<td><a href="<?php echo URL.'finance/editAR/'.$arid; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>