<h5>
	Ctypes (CrsTypes)
	
	
</h5>

<table id="tblExport" class="gis-table-bordered table-altrow"  >
<tr><th>ID</th><th>Code</th><th>Name</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><input class="cc" value="<?php echo $rows[$i]['code']; ?>" ></td>
	<td><input class="ct" value="<?php echo $rows[$i]['name']; ?>" ></td>
</tr>
<?php endfor; ?>
</table>


<script>
$(function(){ 
	tabEnter('cc');
	// nextViaEnter();
	
})




</script>



