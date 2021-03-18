

<?php 


?>

<!-- ====================================================================  -->

<h5>
	Tuition
	| <a href="<?php echo URL.'registrars'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'registrars/enrollment'; ?>">Enrollment</a>
</h5>


<!-- ================ page details ============================================== -->

<table class="gis-table-bordered table-fx" >
<tr><th class='white headrow'>Level</th><td><?php echo $tuition['level']; ?></td></tr>
<tr><th class="white headrow">School Year</th><td><?php echo $sy.' - '.$next_sy; ?></td></tr>
<tr><th class='white headrow'>Total</th><td><?php echo $tuition['total']; ?></td></tr>	
</table>


<!-- ====================================================================  -->

<?php if($num_fees): ?>

<?php $total = 0; ?>

<h4> Tuition Details </h4>
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Particulars</th>
	<th>Amount</th>
</tr>
<?php for($i=0;$i<$num_fees;$i++): ?>
<?php $total += $fees[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ucfirst($fees[$i]['tuition_type']); ?></td>
	<td class="right" ><?php echo $fees[$i]['amount']; ?></td>
	
	
</tr>
<?php endfor; ?>

<tr><td class="right b" colspan="3"><?php echo number_format($total,2);  ?></td></tr>

</table>


<?php endif; ?>