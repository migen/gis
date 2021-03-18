

<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>

<tr>
	<td class="vc20 right" ><?php echo $i+1; ?></td>
	<td class="vc20 right" ><?php echo $rows[$i]['id']; ?></td>
	<td class="vc150" ><?php echo $rows[$i]['code']; ?></td>
	<td class="vc300" ><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>			

</table>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



