<?php // pr($itemwidth); 
$pos_id=$pos['id'];


?>

<div style="float:left;width:300px;border:1px solid white;" >	<!-- receipt paper width rpw -->
<p><table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >
	<tr><th>POS ID</th><td class="vc200" ><?php echo $pos['id']; ?></td></tr>
	<tr><th>OR #</th><td><?php echo $pos['orno']; ?></td></tr>
	<tr><th>Terminal</th><td><?php echo $pos['terminal']; ?></td></tr>
	<tr><th>Time</th><td><?php echo $pos['datetime']; ?></td></tr>
	<tr><th>ID Number</th><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><th>Customer</th><td><?php echo $pos['customer']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $pos['classroom']; ?></td></tr>
	<tr><th>Cashier</th><td><?php echo $pos['employee']; ?></td></tr>	
	<tr><th>Paid</th><td>
		<?php echo ($pos['is_paid']==1)? 'Yes':'No'; ?>
		<?php echo ($pos['is_credit']==1)? ' | Credit':NULL; ?>
	</td></tr>	

</table></p>
</div>

<div class="clear" ></div>

<div style="float:left;width:400px;border:1px solid white;" >	<!-- receipt paper width rpw -->
<table class="gis-table-bordered table-fx <?php echo $tfsize; ?>" >
<tr>
<th>Qty</th>
<th class="vc200" >Item</th>
<th class="vc60" >Subtotal</th>
<th class="vc100" >Del</th>
</tr>
<?php $numitems=0; ?>
<?php $is_rx=false; ?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<?php if($row['qty']<0){ $is_rx=true; } ?>
<tr>
	<td><?php echo $row['qty']; ?></td>
	<td style="width:<?php echo $itemwidth; ?>;" ><?php echo $row['product']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<?php $pdid=$row['pdid']; ?>
	<td><a onclick="xdelposdetail(<?php echo $pdid.','.$pos_id; ?>);" class="u" >DEL</a>
			| <a href="<?php echo URL.'products/view/'.$row['product_id']; ?>" ><?php echo $row['product_id']; ?></a>
		</td>
</tr>
<?php endforeach; ?>
	<tr><td colspan="2" >Item(s) Sold</td><td class="right" ><?php echo $numitems; ?></td><td></td></tr>
	<tr><td colspan="2" >Discount</td><td class="right" ><?php echo $pos['discount']; ?></td><td></td></tr>
	<tr><th colspan="2" >Total</th><td class="right" ><?php echo $pos['total']; ?></td><td></td></tr>
	<tr><td colspan="2" >Tender Cash</td><td class="right" ><?php echo $pos['tendercs']; ?></td><td></td></tr>
	<?php if($pos['tenderetc']>0): ?>
		<tr><td colspan="2" >Bank</td><td class="right" ><?php echo $pos['bank']; ?></td><td></td></tr>
		<tr><td colspan="2" >Etc No.</td><td class="right" ><?php echo $pos['etcno']; ?></td><td></td></tr>
		<tr><td colspan="2" >Tender Etc</td><td class="right" ><?php echo $pos['tenderetc']; ?></td><td></td></tr>
	<?php endif; ?>
	<tr><td colspan="2" >Change</td><td class="right" ><?php echo $pos['change']; ?></td><td></td></tr>

</table>

<?php if($is_rx): ?>
	<h5>Return / Exchange</h5>
<?php endif; ?>	


</div>	<!-- receipt paper width rpw -->