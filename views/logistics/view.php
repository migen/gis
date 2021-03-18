<?php 
// pr($rows[0]);
?>


<h5 class="screen" >

	View <?php echo $smvid; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href="<?php echo URL.'logistics/edit/'.$smvid; ?>">Edit</a>	
	| <a href="<?php echo URL.'logistics/summary'; ?>">Summary</a>	
	| <a href="<?php echo URL.'logistics/move'; ?>">Move</a>	
	
</h5>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<table class="gis-table-bordered"  >
<tr><th>Src-Dest</th><td><?php echo 'T'.$smv['src'].' to '.'T'.$smv['dest']; ?></td>
<th>Date</th><td class="vc150" ><?php echo $smv['date']; ?></td>
</tr>
<tr><th>Reference</th><td class="vc150" ><?php echo $smv['reference']; ?></td>
<th>Status</th><td><?php echo $delivery_status; ?> Delivery</td>
</tr>
<tr><th>Comments</th><td colspan="3" class="vc300"  ><?php echo $smv['comments']; ?></td></tr>
</table>

<br />

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Product</th>
	<th>Order<br />Qty</th>
	<th>Rcvd<br />Qty</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['roqty']; ?></td>
	<td class="right" ><?php echo $rows[$i]['rxqty']; ?></td>
</tr>
<?php endfor; ?>
</table>
