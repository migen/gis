<?php 
extract($row);

?>
<h5>
	View OR | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payments/edit/'.$pkid; ?>">Edit</a>


</h5>


<form method="POST"  >
<table class="gis-table-bordered table-fx" >
<tr><th>PKID</th><td><?php echo $pkid; ?></td></tr>
<tr><th>OR No</th><td><?php echo $orno; ?></td></tr>
<tr><th>Date</th><td><?php echo $date; ?></td></tr>
<tr><th>Employee</th><td><?php echo $emplname; ?></td></tr>
<tr><th>Student</th><td><?php echo $studname; ?></td></tr>
<tr><th>Feetype</th><td><?php echo $feetype; ?></td></tr>
<tr><th>Amount</th><td><?php echo number_format($amount,2); ?></td></tr>
<tr><th>Reference</th><td><?php echo $reference; ?></td></tr>

</table>
</form>