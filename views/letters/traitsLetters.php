<h5>
	Traits Letters (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks','Letters'); ?>
	
</h5>

<p><?php 

	// pr($ratings);

	$d['ctype']=2;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('legends_ctypes',$d); 
?></p>


<form method="POST" >

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>GID</th><th>Classroom</th><th>Criteria</th><th>Scid</th><th>Student</th><th>Grade</th><th>DB<br />Letter</th><th>Run<br />Ave</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['gid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['criteria_code']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['grade']; ?></td>
	<td><?php echo $rows[$i]['letter']; ?></td>

	<?php 
		$grade=&$rows[$i]['grade'];
		$dg = rating($grade,$ratings);
		$same = ($dg==$rows[$i]['letter']) ? true:false; 
		
	?>			
	<td class="<?php echo (!$same)? 'bg-red':NULL; ?>" >
		<?php if(!$same): ?>
			<input class="vc50 center" name="posts[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>" />
			<input type="hidden" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $rows[$i]['gid']; ?>" />
		<?php endif; ?>
		
	</td>
</tr>
<?php endfor; ?>

</table>

<p>
	<input type="submit" name="submit" value="Update"  />
</p>

</form>
