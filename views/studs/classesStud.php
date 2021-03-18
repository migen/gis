<?php 

// pr($rows[0]);

?>

<h5>
	Student Classes
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Course</th>
	<th>Type</th>
	<th>Reqts</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
	<td><?php echo $rows[$i]['ctype']; ?></td>
	<?php $crs=$rows[$i]['crs']; ?>
	<td>
		<?php if((!$rows[$i]['is_aggregate']) && ($rows[$i]['ctype_id']==1) && ($rows[$i]['with_scores']==1)): ?>
			<a href='<?php echo URL."studs/reqts/$scid/$crs"; ?>' >Reqts</a>
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>

