<script>
	$(function(){
		excel();
	})



</script>


<?php 
// pr($data);


?>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>




<?php if(isset($_GET['debug'])){ pr($q); } ?>

<table id="tblExport" class="gis-table-bordered" >
<tr><th>Date Range</th><td><?php echo $_GET['dateone'].' - '.$_GET['datetwo']; ?></td></tr>
</table><br />


<table class="gis-table-bordered table-fx table-altrow" >

<tr>
	<th>#</th>
	<th>Supplier</th>
	<th>Amount</th>
	<th>Details</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['payments'],2); ?></td>
	<td><a href="<?php echo URL.'suppliers/payDetails/'.$rows[$i]['suppid'].DS.$_GET['dateone'].DS.$_GET['datetwo']; ?>" >Details</a></td>
</tr>
<?php endfor; ?>

</table>