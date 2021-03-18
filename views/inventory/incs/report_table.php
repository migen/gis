<?php
// pr($rows);
// exit;

if(isset($_GET['debug'])){ pr($q); }

// pr($rows[0]);

?>

<div class="center clear" >
<?php 
	$page="Master Inventory Report (MIR)";
	$page.="<br />Date: ".$_GET['start']." to ".$_GET['end'];
	$page.="<br />".$supp['name']." #".$supp['id'];
	$data['page']=&$page;
	$inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); 
?>
</div>



<table class="gis-table-bordered table-altrow" >
<tr>
	<th class="shd" >Prid</th>
	<th>Barcode</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Price</th>
	<th>Dvry</th>
	<th>Shrx</th>
	<th>Sold</th>
	<th>Revenues</th>
	<th>CGS</th>
	<th>Gross<br />Profit</th>
	<th>Level</th>
	<th class="shd" >T1</th>
	<th class="shd" >T2</th>
	<th class="shd" >T3</th>
	<th class="shd" >T4</th>
	<th class="shd" >T5</th>
	<th class="shd" >T6</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="shd right" ><?php echo $rows[$i]['prid']; ?></td>
	<td class="left" ><?php echo $rows[$i]['barcode']; ?></td>
	<td class="left" ><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php $cost=&$rows[$i]['cost']; echo $cost; ?></td>
	<td class="right" ><?php $price=&$rows[$i]['price']; echo $price; ?></td>
	<td><div class="right" ><?php $drqty=$rows[$i]['dr']; echo number_format($drqty,0); ?></div></td>
	<td><div class="right" ><?php $skqty=$sk[$i]['shrinkages']; echo number_format($skqty,0); ?></div></td>
	<td><div class="right" ><?php $sdqty=$sd[$i]['sold']; echo number_format($sdqty,0); ?></div></td>
	<?php 
		$rev=($price*$sdqty);
		$cgs=($cost*$sdqty);
		$gprofit=($rev-$cgs);
	?>
	<td><div class="right" ><?php echo number_format($rev,2); ?></div></td>
	<td><div class="right" ><?php echo number_format($cgs,2); ?></div></td>
	<td><div class="right" ><?php echo number_format($gprofit,2); ?></div></td>
	<td><div class="right" ><?php echo number_format($rows[$i]['level'],0); ?></div></td>
	<td class="shd right" ><?php $t1=&$rows[$i]['t1']; echo number_format($t1,0); ?></td>
	<td class="shd right" ><?php $t2=&$rows[$i]['t2']; echo number_format($t2,0); ?></td>
	<td class="shd right" ><?php $t3=&$rows[$i]['t3']; echo number_format($t3,0); ?></td>
	<td class="shd right" ><?php $t4=&$rows[$i]['t4']; echo number_format($t4,0); ?></td>
	<td class="shd right" ><?php $t5=&$rows[$i]['t5']; echo number_format($t5,0); ?></td>
	<td class="shd right" ><?php $t6=&$rows[$i]['t6']; echo number_format($t6,0); ?></td>
	
	
</tr>

<?php endfor; ?>
</table>