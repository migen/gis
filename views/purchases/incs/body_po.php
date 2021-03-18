
<?php 
	// pr($total_rxqty);
	// pr($rows[0]);

?>


<div style="float:left;width:40%;"  >
<table class="gis-table-bordered" >
	<tr><th>POID</th><td class="vc200" ><?php echo $row['id']; ?></td></tr>
	<tr><th>Reference</th><td class="vc200" ><?php echo $row['reference']; ?></td></tr>
	<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
	<tr><th>Customer</th><td><?php echo $_SESSION['settings']['school_name']; ?></td></tr>
	<tr><th>Contact Person</th><td><?php echo $row['employee']; ?></td></tr>
	<tr><th>Terminal</th><td><?php echo $row['terminal']; ?></td></tr>
	<tr><th>Invoice</th><td><?php echo $row['invoice']; ?></td></tr>
	<tr><th>Status (Delivery)</th><td><?php echo ($total_rxqty==0)? '':$delivery_status.' Delivery'; ?></td></tr>
	<tr><th>Status (Payment)</th><td><?php echo $payment_status; ?> </td></tr>
	<tr><th>Assessed</th><td class=" vc120" ><?php echo number_format($row['assessed'],2); ?></td></tr>
	<tr><th>Discount</th><td class="" ><?php echo number_format($row['discount'],2); ?></td></tr>
	<tr><th>PO Total</th><td class="" ><?php echo number_format($row['total'],2); ?></td></tr>
	<tr><th>Total Paid</th><td class="" ><?php echo number_format($row['paid'],2); ?></td></tr>
	<tr><th>Balance</th><td class="" ><?php echo number_format($row['balance'],2); ?></td></tr>
	
</table>

</div>


<div class="third"  >
<table class="gis-table-bordered" >
	<tr><th>Supplier</th><td><?php echo $supplier['fullname']; ?></td></tr>
	<tr><th>Contact Person</th><td><?php echo $supplier['contact_person']; ?></td></tr>
	<tr><th>Mobile</th><td><?php echo $supplier['mobile']; ?></td></tr>
	<tr><th>phone</th><td><?php echo $supplier['phone']; ?></td></tr>
	<tr><th>Email</th><td><?php echo $supplier['email']; ?></td></tr>
	<tr><th>Address</th><td><?php echo $supplier['address']; ?></td></tr>
	<tr><th>PO Remarks</th><td><?php echo $row['remarks']; ?></td></tr>
</table>

</div>

<div class="clear" >&nbsp;</div>


<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Code</th>
	<th>Product</th>
	<th class="right" >Qty</th>
	<th>Cost</th>
	<th>Amount</th>
	<th>Dlvd</th>
	<th></th>
</tr>


<?php 
	$count = count($rows); 
	
	
?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_decimal'])? $rows[$i]['roqty']:round($rows[$i]['roqty']); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cost'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_decimal'])? $rows[$i]['rxqty']:round($rows[$i]['rxqty']); ?></td>
	<td class="right hd" ><a href="<?php echo URL.'products/view/'.$rows[$i]['product_id']; ?>" >
		<span class="screen" ><?php print($rows[$i]['product_id']); ?></span></a></td>
	
</tr>
<?php endfor; ?>

<tr>
<th colspan="3" >Total Ordered</th>
<th class="right" ><?php echo $total_roqty; ?></th>
<th colspan="2" >Delivered</th>
<th class="right" ><?php echo $total_rxqty; ?></th>
<td></td>
</tr>


</table>


<br />
<?php $count = count($pays); ?>
<?php if($count>0): ?>
	<h4>Payments</h4>
<table class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th>Amount</th>
	<th>Reference</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $pays[$i]['date']; ?></td>
	<td class="right" ><?php echo number_format($pays[$i]['amount'],2); ?></td>
	<td><?php echo $pays[$i]['reference']; ?></td>	
</tr>
<?php endfor; ?>
</table>
<?php else: ?>	<!-- has payments -->
	<h4>No payments made yet.</h4>
<?php endif; ?>	<!-- has payments -->
