<h5>
	<?php echo $level['name']; ?> Students (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>


<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'levels/students/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> &nbsp;&nbsp; 
	<?php endforeach; ?>
</p>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>CT</th>
<th>ID No.</th>
<th>Student</th>
</tr>
<tr><th colspan=4><?php echo $rows[0]['classroom']; ?></th></tr>
<?php $k=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $k+=1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $k; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>

	<?php $j=$i+1; ?>
	<?php if($rows[$i]['sxn']!=@$rows[$j]['sxn']): ?>
	<?php $k=0; ?>
	<tr><th colspan=4><?php echo @$rows[$j]['classroom']; ?></th></tr>
	<?php endif; ?>

<?php endfor; ?>
</table>
