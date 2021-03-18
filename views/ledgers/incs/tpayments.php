<?php 
// pr($tpays);
// pr($tpays);



?>

<table class="gis-table-bordered" >
<tr>
	<th>Payments</th>
	<th>Date</th>
	<th>OR No.</th>
	<th>Amount</th>
</tr>


<?php 
	$count = count($tpays[$i]);
	for($l=0;$l<$count;$l++):

?>
<tr>
	<td><?php echo $tpays[$i][$l]['feetype'].' - '.getOrdinal($tpays[$i][$l]['pointer']); ?></td>
	<td><?php echo $tpays[$i][$l]['datepaid']; ?></td>
	<td><?php echo $tpays[$i][$l]['orno']; ?></td>
	<td class="right" ><?php echo $tpays[$i][$l]['amountpaid']; ?></td>
</tr>
<?php endfor; ?>



</table>