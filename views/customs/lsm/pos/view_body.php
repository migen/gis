<style>

#posDiv{width:50%;}
.poshead{font-size:16px;}
.posbody{font-size:16px;}
.tf14{ font-size:16px; }


</style>
<?php 
// pr($data);
// pr($itemwidth); 
// pr($positems[0]);

// pr($data['pos']);

?>


<div id="posDiv" >	<!-- receipt paper width rpw -->
<p class="center" ><span style="font-size:1.2em;font-weight:bold;" >Lourdes School of Mandaluyong</span>
<br />FASSS POS Terminal <?php echo $pos['terminal']; ?></p>


<p><table class="nogis-table-bordered table-fx poshead" >
	<tr>
		<td>POS ID:</td>
		<td><?php echo $pos['id']; ?></td></tr>
	<tr><td>Date Time</td><td><?php echo $pos['datetime']; ?></td></tr>
	<tr><td>ID Number</td><td><?php echo $pos['customer_code']; ?></td></tr>
	<tr><td>Customer</td><td><?php echo $pos['customer']; ?></td></tr>
	<tr><td>Cashier</td><td><?php echo $pos['employee']; ?></td></tr>	
</table></p>


<table class="nogis-table-bordered table-fx posbody" >
<tr>
<th>Qty</th>
<th class="vc200" >Item</th>
<th class="vc60" >Subtotal</th>
</tr>
<?php $numitems=0; ?>
<?php foreach($positems AS $row): ?>
<?php $numitems+=$row['qty']; ?>
<tr>
	<td><?php echo $row['qty']; ?></td>
	<td style="width:<?php echo $itemwidth; ?>;" ><?php echo $row['code'].' - '.$row['product'].' @'.$row['price']; ?></td>
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


<p>*Replacement within 7 days from purchase date. Present this OR.</p>


<?php if($has_rxref): ?>
<hr />
<h4>Reference to Original OR | ID#<?php echo $pos['rxref_posid']; ?><br /><?php echo $rxref['pos']['datetime']; ?></h4>
<table class="nogis-table-bordered table-fx <?php echo $posbody; ?>" >

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
<table class="nogis-table-bordered table-fx <?php echo $posbody; ?>" >

	<?php foreach($rx['positems'] AS $row): ?>
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
	
	
</div>	<!-- receipt paper width rpw -->