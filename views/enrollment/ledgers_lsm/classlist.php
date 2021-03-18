<script>
	$(function(){
		excel();
	})

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<h5>
	MIS Classlist
	| <a class="u" id="btnExport" >Excel</a> 
	
</h5>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>
