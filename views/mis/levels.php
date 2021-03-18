<?php 
	// pr($data);
	// pr($levels[0]);

?>


<h5>
	<a href="<?php echo URL.'mis'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."setup/grading/".$sy;  ?>' > Setup</a>	
	| <a href='<?php echo URL."dashboard/mis/".$sy;  ?>' > Dashboard </a>	
		
</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th> # </th>
	<th>Classrooms</th>
	<th>Config</th>
	<th>Components</th>
	<th>Courses<br />Advisories</th>
	<th>Class Courses</th>
	<th>Code</th>
	<th> With<br /> Cond <br /> DG </th>
	<th> Cond<br />Affects<br />Ranks </th>
	<th> Cond <br />Ctype </th>
	<th> K12 </th>
	<th> Equiv </th>
	<th> Dept </th>	
	<th> Sem </th>	
	<th> PS </th>
	<th> GS </th>
	<th> HS </th>
	<th> Coll </th>
	<th> Edit </th>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td> 
		<a href="<?php echo URL.'classrooms/level/'.$levels[$i]['id'].DS.$sy; ?>" > <?php echo $levels[$i]['name']; ?> </a>
	 </td>
	
	<td class="u" > 
		<a href="<?php echo URL.'courses/config/'.$levels[$i]['id'].DS.$sy; ?>">Config</a> </td>
		
	<td class="u" > 
		<a href="<?php echo URL.'gset/components/'.$levels[$i]['id'].DS.$sy; ?>">Manage</a> </td>

	<td class="u" > 
		<a href="<?php echo URL.'mca/locking/'.$levels[$i]['id'].DS.$sy.DS.$qtr; ?>">Manage</a> </td>		
	
	<td>
		<?php foreach($sections[$i] AS $sxn): ?>
			<a href='<?php echo URL."classrooms/courses/".$sxn['crid']; ?>' ><?php echo $sxn['section']; ?></a> &nbsp;&nbsp; 
		<?php endforeach; ?>	
	</td>
	
	<td><?php echo $levels[$i]['code']; ?></td>
	<td><?php echo $levels[$i]['with_conduct_dg']; ?></td>
	<td><?php echo $levels[$i]['conduct_affects_ranking']; ?></td>
	<td><?php echo $levels[$i]['conduct_ctype_id']; ?></td>	
	<td><?php echo $levels[$i]['is_k12']; ?></td>
	<td><?php echo $levels[$i]['is_equiv']; ?></td>
	<td><?php echo $levels[$i]['department_id']; ?></td>
	<td><?php echo $levels[$i]['is_sem']; ?></td>
	<td><?php echo $levels[$i]['is_ps']; ?></td>
	<td><?php echo $levels[$i]['is_gs']; ?></td>
	<td><?php echo $levels[$i]['is_hs']; ?></td>
	<td><?php echo $levels[$i]['is_coll']; ?></td>
	<td><a href='<?php echo URL."levels/edit/".$levels[$i]['id'].DS.$sy; ?>' >Edit</a></td>
	
	 
</tr>
<?php endfor; ?>

</table>