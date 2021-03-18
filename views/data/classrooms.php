<?php // pr($classrooms[5]); ?>

<h5>

	Classrooms
<span class="screen" >			
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href="<?php echo URL.'info'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</span>
</h5>

<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th>#</th>
<th>Level</th>
<th class="vc150" >Section - Courses</th>
<th class="vc200" >Adviser - Loads</th>
</tr>
<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $classrooms[$i]['level']; ?></td>
		<td><a href="<?php echo URL.'data/classroom/'.$classrooms[$i]['id'].DS.$sy; ?>"> <?php echo $classrooms[$i]['section']; ?> </td>	
		<td><a href="<?php echo URL.'loads/teacher/'.$classrooms[$i]['acid'].DS.$sy; ?>"> <?php echo $classrooms[$i]['adviser']; ?> </td>	
	</tr>
<?php endfor; ?>
</table>