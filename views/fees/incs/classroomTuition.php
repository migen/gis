<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-fx" >
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Balance</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>&nbsp;</td>
</tr>
<?php endfor; ?>
</table>
</form>
