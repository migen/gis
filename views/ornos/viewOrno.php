<?php 


?>
<h5>
	View OR | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payments/edit/'.$pkid; ?>">Edit</a>


</h5>


<?php 
extract($or);
// pr($or);


?>

<table class="gis-table-bordered" >
<tr><th>S/N Pkid</th><td><?php echo $pkid; ?></td></tr>
<tr><th>Date</th><td><?php echo $date; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $classroom; ?></td></tr>
<tr><th>Student</th><td><?php echo $studname; ?></td></tr>
<tr><th>Employee</th><td><?php echo $emplname; ?></td></tr>
<tr><th>Bank</th><td><?php echo $bank; ?></td></tr>
<tr><th>Reference</th><td><?php echo $reference; ?></td></tr>
<tr><th>Total</th><td class="right" ><?php echo number_format($total,2); ?></td></tr>
</table><br />

<table class="gis-table-bordered" >
<tr>
	<th>Date</th>
	<th>Feetype</th>
	<th>Amount</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php extract($rows[$i]); ?>
<tr>
	<td><?php echo $date; ?></td>
	<td><?php echo $feetype; ?></td>
	<td class="right" ><?php echo number_format($amount,2); ?></td>
</tr>
<?php endfor; ?>
</table>