<?php 
$numcols='12';

?>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Supp</th>
	<th>Prid</th>
	<th>Barcode</th>
	<th>Product</th>
	<th class="right" >Cost</th>
	<th class="right" >Price</th>
	<th class="right" >Sold</th>
	<th class="right" >Retd</th>
	<th class="right" >Revenues</th>
	<th class="right" >CGS</th>
	<th class="right" >Gross<br />Profit</th>
</tr>

<?php $total=0; ?>
<?php $tcgs=0; ?>
<?php $profits=0; ?>
<tr><th colspan="<?php echo $numcols; ?>" ><?php echo @$rows[0]['supplier']; ?></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$revenue=$rows[$i]['revenue'];
	$total+=$revenue;

	$cgs=$rows[$i]['cost']*$rows[$i]['sold'];
	$tcgs+=$cgs;

	$profit=$revenue-$cgs;
	$profits+=$profit;
	
	
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['suppid']; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cost'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
	<td class="right" ><?php echo $rows[$i]['sold']; ?>
		<?php 
			// if($rows[$i]['rxqty']>0){ echo "<br />(".$rows[$i]['rxqty'].")"; }
		?>
	
	</td>
	<td class="right vc50" ><?php echo $rows[$i]['rxqty']; ?></td>
	<td class="right" ><?php echo number_format($revenue,2); ?></td>
	<td class="right" ><?php echo number_format($cgs,2); ?></td>
	<td class="right" ><?php echo number_format($profit,2); ?></td>
</tr>
<?php 
	$j=$i+1;
	if($rows[$i]['suppid']!=@$rows[$j]['suppid']){
		$lblsupp=isset($rows[$j]['suppid'])? $rows[$j]['supplier'].' - #'.$rows[$j]['suppid']:'NO Supplier';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
	} 
?>
<?php endfor; ?>
<tr>
	<th colspan="9" >Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th class="right" ><?php echo number_format($tcgs,2); ?></th>
	<th class="right" ><?php echo number_format($profits,2); ?></th>
</tr>
</table>
