<style>

.poshead{font-size:1.0em;}
.posbody{font-size:0.9em;}


</style>
<?php 
// pr($itemwidth); 
// pr($positems[0]);
?>


<div style="float:left;width:300px;border:1px solid white;" >	<!-- receipt paper width rpw -->
<p class="center" ><span style="font-size:1.2em;font-weight:bold;" >Lourdes School of Mandaluyong</span>
<br />FASSS POS Terminal <?php echo $pos['terminal']; ?></p>


<p><table class="nogis-table-bordered table-fx <?php echo $poshead; ?>" >
	<tr>
		<td>POS ID: <?php echo $pos['id']; ?></td>
		<td></td></tr>
	<tr><td>Date Time</td><td><?php echo $pos['datetime']; ?></td></tr>
	<tr><td>ID Number</td><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><td>Customer</td><td><?php echo $pos['customer']; ?></td></tr>
	<tr><td>Cashier</td><td><?php echo $pos['employee']; ?></td></tr>	
</table></p>


<table class="nogis-table-bordered table-fx <?php echo $posbody; ?>" >
<tr>
<th>Qty</th>
<th class="vc200" >Item</th>
<th class="vc60" >Subtotal</th>
</tr>
<?php $numitems=0; ?>
<?php $is_rx=false; ?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<?php if($row['qty']<0){ $is_rx=true; } ?>
<tr>
	<td><?php echo $row['qty']; ?></td>
	<td style="width:<?php echo $itemwidth; ?>;" ><?php echo $row['code'].' - '.$row['product']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
</tr>
<?php endforeach; ?>
	<tr><td colspan="2" >Item(s) Sold</td><td class="right" ><?php echo $numitems; ?></td></tr>
	<tr><td colspan="2" >Discount</td><td class="right" ><?php echo $pos['discount']; ?></td></tr>
	<tr><th colspan="2" >Total</th><td class="right" ><?php echo number_format($pos['total'],2); ?></td></tr>
	<tr><td colspan="2" >Tender Cash</td><td class="right" ><?php echo number_format($pos['tendercs'],2); ?></td></tr>
	<?php if($pos['tenderetc']>0): ?>
		<tr><td colspan="2" >Bank</td><td class="right" ><?php echo $pos['bank']; ?></td></tr>
		<tr><td colspan="2" >Etc No.</td><td class="right" ><?php echo $pos['etcno']; ?></td></tr>
		<tr><td colspan="2" >Tender Etc</td><td class="right" ><?php echo number_format($pos['tenderetc'],2); ?></td></tr>
	<?php endif; ?>
	<tr><td colspan="2" >Change</td><td class="right" ><?php echo $pos['change']; ?></td></tr>

</table>

<?php if($is_rx): ?>
	<h5>Return / Exchange</h5>
<?php endif; ?>	


</div>	<!-- receipt paper width rpw -->