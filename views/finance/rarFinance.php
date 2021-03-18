<h3>
	Report AR / Prev Balance (<?php echo $count; ?>) <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
<?php if($dept=='gs'): ?>
	| <a href='<?php echo URL."finance/rar/$sy?dept=hs"; ?>' >HS</a>
<?php else: ?>
	| <a href='<?php echo URL."finance/rar/$sy?dept=gs"; ?>' >GS</a>
<?php endif; ?>

	| <a href="<?php echo URL.'syncs/syncEnrollments/'.$sy; ?>" >1) Sync-Enrollments</a>
	| <a href="<?php echo URL.'syncs/arToEnrollments/'.$sy; ?>" >2) AR-Enrollments</a>

</h3>


<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>Classroom</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Amount</th>
	<th>Ensumm</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$pkid=$rows[$i]['pkid'];
	$scid=$rows[$i]['scid'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $scid; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><a href="<?php echo URL.'students/balances/'.$scid; ?>" >Balances</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>