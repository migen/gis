<?php 

// pr($data);

$fees 		= $data['fees'];
$num_fees 	= $data['num_fees'];

?>


<?php if($num_fees): ?>

<?php $total = 0; ?>

<h4> Tuition Details </h4>
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc300" >Particulars</th>
	<th class="vc150 right" >Amount</th>
</tr>
<?php for($i=0;$i<$num_fees;$i++): ?>
<?php $total += $fees[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ucfirst($fees[$i]['feetype']); ?></td>
	<td class="right" ><?php echo $fees[$i]['amount']; ?></td>
	
	
</tr>
<?php endfor; ?>

<tr>
	<td class="right b" colspan="3"><?php echo number_format($total,2);  ?></td>
</tr>

</table>


<?php endif; ?>