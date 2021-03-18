<script>
	$(function(){
		excel();
	})



</script>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<div class="center" >
<?php 

// $inc = 'incs/sales_letterhead.php';include($inc); 
$page="Shrinkages Report";
$inc = SITE.'views/customs/'.VCFOLDER.'/incs/letterhead.php';include($inc); 

?>

</div>



<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="screen" ></th>
	<th>#</th>
	<th>Date</th>
	<th>Reference</th>
	<th>Type</th>
	<th>Code</th>
	<th>Prid</th>
	<th>Product</th>
	<th>Trml</th>
	<th>Qty</th>
	<th>Price</th>
	<th>Cost</th>
	<th>Manage</th>
	<th>ID</th>	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i; ?>]" 
		value="<?php echo $rows[$i]['skid']; ?>" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
	<td><?php echo $rows[$i]['sktype']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['terminal']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cost'],2); ?></td>
	<td>
		<a href="<?php echo URL.'shrinkages/edit/'.$rows[$i]['skid']; ?>" >Edit</a>
			| <a href="<?php echo URL.'shrinkages/delete/'.$rows[$i]['skid'].DS.$sy; ?>" 			
				onclick="return confirm('Sure?');" >Delete</a>
		<?php if($_SESSION['srid']==RMIS): ?><?php endif; ?>
	</td>
	<td><?php echo $rows[$i]['skid']; ?></td>
</tr>
<?php endfor; ?>
</table>


<p>	
<input onclick="return confirm('Sure?');" type='submit' name='batch' value='Edit' >
<?php // $this->shovel('boxes'); ?>

</p>

</form>