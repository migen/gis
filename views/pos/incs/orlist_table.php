<script>
var gurl = "http://<?php echo GURL; ?>";

$(function(){
	
})

</script>


<?php 
// pr($rows[0]);

// pr($rows);

$fontsize=isset($_GET['fontsize'])? $_GET['fontsize']:1;
?>




<div style="width:1200px;float:left;"  >	<!-- pos_table -->
<table id="tblExport" class="gis-table-bordered table-fx table-altrow" style="font-size:<?php echo $fontsize; ?>em;"  >
<tr class="headrow" >
	<th>OR ID</th>
	<th>Datetime</th>
	<th>Customer</th>
	<th class="right" >Amount</th>
	<th>Employee</th>
	<th>Trml</th>
	<th>&nbsp;</th>
</tr>

<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['total']; ?>
	<tr id="trow<?php echo $i; ?>"  >
		<td><?php echo $rows[$i]['pos_id']; ?></td>
		<td><?php echo date('M d, H:i',strtotime($rows[$i]['datetime'])); ?></td>
		<td class="vc100" ><?php echo (!empty($rows[$i]['guest']))? $rows[$i]['guest']:$rows[$i]['customer']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>
		<td><?php echo $rows[$i]['employee']; ?></td>
		<td><?php echo $rows[$i]['terminal']; ?></td>
		<td><a href='<?php echo URL."npos/view/".$rows[$i]['pos_id'].DS.$sy; ?>' >Print</a></td>
	</tr>
<?php endfor; ?>
<tr><th colspan="3" >Total</th>
<th class="right" ><?php echo number_format($total,2); ?></th><th colspan="3" ></th></tr>
</table>

</div>	<!-- orlist_table -->