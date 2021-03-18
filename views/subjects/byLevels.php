<h5>
	Subject Levels
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'misc/boss'; ?>">Subject Sections</a>
	
	
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Pos</th>
	<th>Sub</th>
	<th>Subject - Configure</th>
	<th>Levels - Subjects</th>
</tr>

<?php $i=0; ?>
<?php foreach($subjects AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['position']; ?></td>
	<td><?php echo $row['subject_id']; ?></td>
	<td class="vc150" ><a href='<?php echo URL."subjects/courses/".$row['subject_id']; ?>' ><?php echo $row['name']; ?></a></td>
	<td>
		<?php foreach($levels[$i] AS $lvl): ?>
			<a href='<?php echo URL."courses/config/".$lvl['level_id']; ?>' ><?php echo $lvl['level']; ?></a> &nbsp;&nbsp; 
		<?php endforeach; ?>
	</td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>