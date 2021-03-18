<?php 

$q=(isset($courses[0]))? $courses[0]:NULL;	
debug($q);

?>

<table id="tblExport" class="gis-table-bordered table-altrow" >

<tr>
<th colspan=3></th>
<?php for($i=0;$i<$numcrs;$i++): ?>
	<?php $j=$i+1; ?>
	<?php if($courses[$i]['fdntype_id']!=@$courses[$j]['fdntype_id']): ?>
		<th class="center" colspan=3><?php echo $courses[$i]['foundation']; ?></th>
	<?php endif; ?>
<?php endfor; ?>
</tr>


<tr>
	<th>#</th>
	<th>Scid</th>	
	<th>Student</th>
	<?php $k=1; ?>
	<?php foreach($courses AS $row): ?>
		<th><?php echo $row['crscode'].'<br />#'.$row['crs']; ?></th>
	<?php if($k==2):$k=0; ?>
		<th>Ave</th>
	<?php endif; ?>
	<?php $k++; ?>	
	<?php endforeach; ?>
</tr>
<?php for($j=0;$j<$count;$j++): ?>
<tr>
	<td><?php echo $j+1; ?></td>
	<td><?php echo $students[$j]['scid']; ?></td>
	<td><?php echo $students[$j]['student']; ?></td>
	<?php $k=1;$sum=0; ?>
	<?php for($i=0;$i<$numcrs;$i++): ?>
		<td><?php $grade=$grades[$i][$j]['grade']; echo $grade; ?></td>
	<?php $sum+=$grade; ?>		
	<?php if($k==2):$k=0; ?>
		<?php $ave=$sum/2;$sum=0; ?>
		<td><?php echo number_format($ave,2); ?></td>
	<?php endif; ?>
	<?php $k++; ?>			
	<?php endfor; ?>
</tr>
<?php endfor; ?>
</table>
