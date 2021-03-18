<?php $row=$profile; ?>

<table class="gis-table-bordered" >
<tr><th>Scid</th><td><?php echo $scid; ?></td></tr>
<?php foreach($row AS $k=>$v): ?>
<tr>
	<th><?php echo ucfirst($k); ?></th>
	<td><?php echo $v; ?></td>
</tr>
<?php endforeach; ?>
</table>