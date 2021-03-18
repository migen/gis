<?php 

// exit;

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

<div class="clear" ></div>
