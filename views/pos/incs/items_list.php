
<?php 
	$numcols='11';
	$totalnumcols=$numcols-3;


?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>Barcode</th>
	<th>Product</th>
	<th>Cost</th>
	<th>UOM</th>
	<th>Price</th>
	<th>Sold</th>
	<th>Retd</th>
	<th>Revenues</th>
	<th>Date</th>
	<th>POS ID</th>
</tr>

<?php 
	$cgs=0; 
	$revenues=0; 
	$total_profit=0; 
	
	$subrevenues=0;$subcgs=0;$subprofit=0;
	
?>
<tr><th colspan="<?php echo $numcols; ?>" ><?php echo @$rows[0]['supplier']; ?></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$cgs+=$rows[$i]['cgs']; 
	$revenues+=$rows[$i]['revenues']; 
	$profit = $rows[$i]['revenues']-$rows[$i]['cgs']; 	
	$total_profit+=$profit; 
	
	/* 2 */
	$subcgs+=$rows[$i]['cgs']; 
	$subrevenues+=$rows[$i]['revenues']; 
	$subprofit+=$profit; 
	
	
?>
	<tr id="trow<?php echo $i; ?>"  >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['barcode']; ?></td>		
		<td><?php echo $rows[$i]['product']; ?></td>
		<td><?php echo number_format($rows[$i]['cost'],2); ?></td>
		<td><?php echo $rows[$i]['uom']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
		<?php $qty=$rows[$i]['sold']; ?>
		<?php echo ($qty>0)? "<td>".$qty."</td><td></td>":"<td></td><td>".$qty."</td>"; ?>
		<td class="right" ><?php echo number_format($rows[$i]['revenues'],2); ?></td>

		<td><?php echo $rows[$i]['date']; ?></td>		
		<td><?php echo $rows[$i]['pos_id']; ?></td>		
	</tr>

<?php 
	$j=$i+1;
	if($rows[$i]['suppid']!=@$rows[$j]['suppid']){
		$subrevenues=number_format($subrevenues,2);
		$subcgs=number_format($subcgs,2);
		$subprofit=number_format($subprofit,2);
		
		$totalrow="<tr><th colspan='".$totalnumcols."' >Total</th>";
		// $totalrow.="<th class='right'>".$subrevenues."</th><th class='right'>".$subcgs."</th>";
		$totalrow.="<th class='right'>".$subrevenues."</th><th class='right'></th>";
		$totalrow.="<th class='right' ></th></tr>";
		echo $totalrow;
		$subrevenues=0;$subcgs=0;$subprofit=0;
		
		/* 2 */		
		$lblsupp=isset($rows[$j]['suppid'])? $rows[$j]['supplier'].' - #'.$rows[$j]['suppid']:'NO Supplier';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
		
		
	} 
?>	
	
<?php endfor; ?>
</table>

<br />
<table class="gis-table-bordered table-fx" >
<tr><th class="vc200" >Item</th><th class="vc150 right" >Total</th></tr>
<tr><th>Sales</th><td class="right" ><?php echo number_format($revenues,2); ?></td></tr>
<tr><th>CGS</th><td class="right" ><?php echo number_format($cgs,2); ?></td></tr>
<tr><th>Profit</th><td class="right" ><?php echo number_format($total_profit,2); ?></td></tr>

</table>
