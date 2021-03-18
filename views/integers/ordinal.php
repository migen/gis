<h3>
	Ordinal <?php $this->shovel('homelinks'); ?>
	
</h3>


<table class="gis-table-bordered" >
<tr>
	<th>Cardinal</th>
	<th>Ordinal Num</th>
	<th>Ordinal Word</th>
</tr>

<?php for($i=1;$i<21;$i++): ?>
<?php 
	$orr=getOrdinalArray($i);
	$num=$orr['num'];
	$word=$orr['word'];
?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $num; ?></td>
	<td><?php echo ucfirst($word); ?></td>
</tr>
<?php endfor; ?>
</table>
