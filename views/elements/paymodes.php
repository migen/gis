<?php 

$paymodes = $data['paymodes'];
$numpays = $data['numpays'];
$paydates = $data['paydates'];
$annuity = $data['annuity'];

?>



<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th class="" >#</th>
	<th class="vc300" >Schedule</th>
	<th class="vc120 right" >Amount</th>
</tr>
<?php for($i=0;$i<$numpays;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $paydates[$i]; ?></td>
	<td class="right" ><?php echo number_format($annuity,2); ?></td>
</tr>
<?php endfor; ?>
</table>