<h3>
	<?php echo $level['name']; ?>	
	<?php echo "#{$lvl}"; ?> SY<?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>

</h3>

<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'classfees/level/'.$sel['id'].DS.$sy; ?>" ><?php echo $sel['code']; ?></a> | 
	<?php endforeach; ?>

</p>



<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Feetype</th>
	<th>Label</th>
	<th>Amount</th>
	<th>Edit</th>
	<th>Sync</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['feetype'].' #'.$rows[$i]['feetype_id']; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td>Edit</td>
	<td><a href='<?php echo URL."syncs/payables/$sy/$lvl&submit"; ?>' >Sync</a></td>
</tr>
<?php endfor; ?>
</table>
