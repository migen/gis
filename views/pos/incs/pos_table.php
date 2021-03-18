<div style="width:1200px;float:left;"  >	<!-- pos_table -->

<table id="tblExport" class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>Datetime</th>
	<th>Customer</th>
	<th class="right" >Total</th>
	<th>Employee</th>
	<th>OR No</th>
	<th>Trml</th>
	<th>Cr</th>
	<th>&nbsp;</th>
	<th>PosID</th>
</tr>

<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['total']; ?>
	<tr id="trow<?php echo $i; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo date('M d, H:i',strtotime($rows[$i]['datetime'])); ?></td>
		<td><?php echo $rows[$i]['customer']; ?></td>
		<td class="right" ><?php echo $rows[$i]['total']; ?></td>
		<td><?php echo $rows[$i]['employee']; ?></td>
		<td><?php echo $rows[$i]['orno']; ?></td>
		<td><?php echo $rows[$i]['terminal']; ?></td>
		<td><?php echo ($rows[$i]['is_credit']==1)? 'Cr':NULL; ?></td>
		<input id="pos_id<?php echo $i; ?>" type="hidden" value="<?php echo $rows[$i]['pos_id']; ?>" />
		<td>
			<a href='<?php echo URL."pos/view/".$rows[$i]['pos_id']; ?>' >View</a>
			| <a href='<?php echo URL."pos/edit/".$rows[$i]['pos_id']; ?>' >Edit</a>
			<span class="hd" >| <u onclick="xdeletePOS(<?php echo $i; ?>);" class='blue' 
				rel="<?php echo isset($row['id'])? $row['id']:''; ?>">Delete</u></span>
		</td>
		<td><?php echo $rows[$i]['pos_id']; ?></td>
	</tr>
<?php endfor; ?>
</table>

</div>	<!-- pos_table -->