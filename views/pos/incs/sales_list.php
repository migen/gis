<h5>
	Sales Itemized

</h5>


<?php 

// pr($rows);



?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>Trml</th>
	<th>Datetime</th>
	<th>Employee ID</th>
	<th>Customer ID</th>
	<th class="right" >Total</th>
	<th>Tender<br />Cash</th>
	<th>Tender<br />Etc</th>
	<th>Cr</th>
	<th>Pd</th>	
	<th>Payment</th>
	<th>Bank</th>
	<th>Ref No.</th>
	<th>POS</th>
</tr>

<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['total']; ?>
	<tr id="trow<?php echo $i; ?>"  >
		<td><?php echo $i+1; ?></td>		
		<td><?php echo $rows[$i]['terminal']; ?></td>		
		<td><?php echo date('M d, H:i',strtotime($rows[$i]['datetime'])); ?></td>
		<td><?php echo $rows[$i]['emplcode']; ?></td>
		<td><?php echo $rows[$i]['custcode']; ?></td>
		<td class="right" ><?php echo $rows[$i]['total']; ?></td>
		<td class="right" ><?php echo $rows[$i]['tendercs']; ?></td>
		<td class="right" ><?php echo $rows[$i]['tenderetc']; ?></td>
		<td><?php echo ($rows[$i]['is_credit']==1)? 'Cr':NULL; ?></td>
		<td id="pd<?php echo $i; ?>" ><?php echo ($rows[$i]['is_paid']==1)? 'Y':'N'; ?></td>		
		<td><?php echo $rows[$i]['ptcode']; ?></td>
		<td><?php echo $rows[$i]['bankcode']; ?></td>
		<td><?php echo $rows[$i]['etcno']; ?></td>
		<input id="pos_id<?php echo $i; ?>" type="hidden" value="<?php echo $rows[$i]['pos_id']; ?>" />
		<td><?php echo $rows[$i]['pos_id']; ?></td>
	</tr>
<?php endfor; ?>
</table>

<h5 class="brown" >Total: P<?php echo number_format($total,2); ?> </h5>





