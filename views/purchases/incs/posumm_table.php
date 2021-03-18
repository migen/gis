
<?php // pr($rows[0]); ?>

<br />

<table class="gis-table-bordered table-altrow" >

<tr>
	<th>#</th>
	<th>ID</th>
	<th>Supp</th>
	<th>Comm</th>
	<th>Code</th>
	<th>Product</th>
	<th>Order <br />Qty</th>
	<th>Recd <br />Qty</th>
	<th>Invoice</th>
	<th>Fully<br />Paid</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['comm']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['order_total']; ?></td>
	<td class="right" ><?php echo $rows[$i]['recd_total']; ?></td>
	<td class="right" ><?php echo $rows[$i]['invoice']; ?></td>
	<td class="right" ><?php 
		echo ($rows[$i]['is_paid']>0)? ($rows[$i]['is_paid']==2)? 'O':'Y':'-'; 
	?></td>
	<td class="right" >
		<a href="<?php echo URL.'purchases/viewPO/'.$rows[$i]['po_id']; ?>" >View</a>
	</td>
	
</tr>
<?php endfor; ?>


</table>