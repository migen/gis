<?php 
// pr($rows[0]);
?>

<table id="tblExport" class="gis-table-bordered table-fx" >
<tr><th>#</th><th>Date</th><th>Comm</th><th>Code</th><th>Product</th><th>Trml</th><th>In/Out</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?php echo $i+1; ?></td>
<td><?php echo $rows[$i]['date']; ?></td>
<td><?php echo $rows[$i]['comm']; ?></td>
<td><?php echo $rows[$i]['code']; ?></td>
<td><?php echo $rows[$i]['product']; ?></td>
<td><?php echo $rows[$i]['terminal']; ?></td>
<td><?php echo $rows[$i]['io']; ?></td>
</tr>
<?php endfor; ?>
</table>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<script>
var gurl     = "http://<?php echo GURL; ?>";
$(function(){
	excel();
})



</script>




