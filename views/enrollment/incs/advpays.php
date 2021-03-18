<?php

// pr($advpays[0]);

 ?>

<?php $srid=$_SESSION['srid']; ?>

<div class="" >


<?php if($num_advpays>0): ?>

<h4>Advance Payments for SY <?php echo ($sy+1); ?></h4>

<table class="gis-table-bordered" >

<tr>
<th>#</th>
<th>Date</th>
<th>Fee</th>
<th>OR No</th>
<th>Amount</th>
</tr>
<?php for($i=0;$i<$num_advpays;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $advpays[$i]['date']; ?></td>
	<td><?php echo ($advpays[$i]['pointer']==0)? 'Reservation':'Tuition'; ?></td>
	<td>
	<span class="u" onclick="syOrnoValue(<?php echo $advpays[$i]['orno'].','.(DBYR+1); ?>);return false;" >
		<?php echo $advpays[$i]['orno']; ?></span>
	</td>
	<td class="right" ><?php echo number_format($advpays[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
</table>

<?php else: ?>
	<h4>No Advance Payments yet for SY <?php echo ($sy+1); ?>.</h4>
<?php endif; ?>

</div>