<h3>
	Teacher's Courses
	| <?php $this->shovel('homelinks'); ?>

</h3>


<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Course</th>
	<th>Sem</th>
	<th>Grades</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$sem=$rows[$i]['semester'];
	$qnum=($sem==1)? 3 : 5; 
	
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td>	
	<?php for($q=1;$q<$qnum;$q++): ?>
		<?php if($sem==1 && $q==3){ continue; } ?>
		<?php if($sem==2 && $q<3){ continue; } ?>
			<a href="<?php echo URL.'teachers/grades/'.$rows[$i]['crs'].DS.$sy.DS.$q; ?>">Q<?php echo $q; ?></a> | 
	<?php endfor; ?>
	</td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>
