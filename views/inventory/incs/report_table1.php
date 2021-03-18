<?php
// pr($rows);
// exit;

if(isset($_GET['debug'])){ pr($q); }

?>

<div class="center clear" >
<?php 
	$page="Master Inventory Report";
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
	<th>Received</th>
	<th>Rx/Shrinks</th>
	<th>Sold</th>
	<th>Level</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="shd" ><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['received']; ?></td>
	<td><?php echo $rows[$i]['shrinkages']; ?></td>
	<td><?php echo $rows[$i]['sold']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
</tr>

<?php endfor; ?>
</table>