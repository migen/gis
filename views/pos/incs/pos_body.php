<style>

#letterhead{ font-size:1.2em;font-weight:bold; }
#rxnote, tr > td, tr > th { font-size:1.0em; font-family:Arial,Helvetica,sans-serif; }
.col-qty{ width:10%; }
.col-amt{ text-align:right; }


</style>
<?php 


?>


<p class="" ><span id="letterhead" >Lourdes School of Mandaluyong</span>
<br />FASSS POS Terminal <?php echo $pos['terminal']; ?></p>

<p><table>
	<tr>
		<td>POS ID:</td>
		<td><?php echo $pos['id']; ?></td></tr>
	<tr><td>Date Time</td><td><?php echo $pos['datetime']; ?></td></tr>
	<tr><td>ID Number</td><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><td>Customer</td><td><?php echo $pos['customer']; ?></td></tr>
	<tr><td>Cashier</td><td><?php echo $pos['employee']; ?></td></tr>	
</table></p>


<table class="" >
<tr>
<th class="col-qty" >Qty</th>
<th>Item</th>
<th class="col-amt" >Subtotal</th>
</tr>
<?php $numitems=0; ?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<tr>
	<td class="col-qty" ><?php echo $row['qty']; ?></td>
	<td><?php echo $row['code'].' - '.$row['product'].' @'.$row['price']; ?></td>
	<td class="col-amt" ><?php echo number_format($row['amount'],2); ?></td>
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


<p id="rxnote" >*Replacement within 7 days from purchase date. Present this OR.</p>


<?php if($has_rxref): ?>
<hr />
<h4>Reference to Original OR | ID#<?php echo $pos['rxref_posid']; ?><br /><?php echo $rxref['pos']['datetime']; ?></h4>
<table class="" >
<?php foreach($rxref['positems'] AS $row): ?>
	<?php $numitems+=$row['qty']; ?>
	<?php if($row['qty']<0){ $is_rx=true; } ?>
	<tr>
		<td><?php echo $row['qty']; ?></td>
		<td style="width:<?php echo $itemwidth; ?>;" ><?php echo $row['code'].' - '.$row['product'].' @'.$row['price']; ?></td>
		<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
	
	
<?php if($has_rx): ?>
<hr />
<h4>Reference to RX OR | ID#<?php echo $pos['rxid']; ?><br /><?php echo $rx['pos']['datetime']; ?></h4>
<table class="nogis-table-bordered table-fx" >

	<?php foreach($rx['positems'] AS $row): ?>
	<?php $numitems+=$row['qty']; ?>
	<?php if($row['qty']<0){ $is_rx=true; } ?>
	<tr>
		<td><?php echo $row['qty']; ?></td>
		<td><?php echo $row['code'].' - '.$row['product'].' @'.$row['price']; ?></td>
		<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>
	
