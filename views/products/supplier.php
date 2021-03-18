<h5>
	Supplier Details
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
		
</h5>

<?php 
$numterminals = $_SESSION['settings']['numterminals'];
?>

<table class="gis-table-bordered table-fx table-altrow" >

<tr><th>UCID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>PCID</th><td><?php echo $row['parent_id']; ?></td></tr>
<tr><th>Supplier</th><td><?php echo $row['name']; ?></td></tr>
 
</table>

<h4>Products (<?php echo $count; ?>)</h4>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ProdID</th>
	<th>Product</th>
	<th>Cost</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $rows[$i]['prodid']; ?></td>
		<td><?php echo $rows[$i]['product']; ?></td>
		<td class="right" ><?php echo $rows[$i]['cost']; ?></td>
	</tr>
<?php endfor; ?>
</table>