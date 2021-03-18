<h5>
	Ctypes (CrsTypes)
	| <a class="u" id="btnExport" >Excel<span>
	
	
</h5>

<table id="tblExport" class="gis-table-bordered table-altrow"  >
<tr><th>ID</th><th>Name</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>


<script>
$(function(){ excel(); })


</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>




