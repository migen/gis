<h5>
	DB Traits <?php echo $level; ?> (<?php echo $count; ?>) - Q<?php echo $qtr; ?>
	- <?php echo $cri_row['code'].'-'.$cri_row['name']; ?>
	<?php 
		// pr($levels[4]); 
		// pr($cri_row); 
		// pr($cri_array);
	?>
	
</h5>

<p><?php foreach($levels AS $row): ?>
<a href="<?php echo URL.'misc/dgtl/'.$row['id']; ?>" ><?php echo $row['code']; ?></a> 
&nbsp; &nbsp; 
<?php endforeach; ?></p>


<p><?php foreach($cri_array AS $row): ?>
<a href="<?php echo URL.'misc/dgtl/'.$lvl.DS.$row['criteria_id'] ?>" ><?php echo $row['code']; ?></a> 
&nbsp; &nbsp; 
<?php endforeach; ?></p>


<?php if($cri):  ?>

<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>#</th><th>Section</th><th>Student</th><th>Grade</th><th>DB</th><th>DG</th><th>GID</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<?php 
		$grade=$rows[$i]['grade']; 	
		$dgdb=$rows[$i]['dg']; 	
		$dg=rating($grade,$ratings)
	?>
	<td><?php echo $grade; ?></td>
	<td><?php echo $dgdb; ?></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>"  /></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $rows[$i]['gid']; ?>" readonly /></td>
</tr>
<?php endfor; ?>
<tr>
<td colspan="7" ><input type="submit" name="submit" value="Save"  /></td>
</tr>
</table>

</form>

<?php endif /* cri */ ?>
