<h5>
	Purge CIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if(isset($_GET['all'])): ?>
		| <a href="<?php echo URL.'purge'; ?>" >Regular</a>
	<?php else: ?>
		| <a href="<?php echo URL.'purge?all'; ?>" >All</a>
	<?php endif; ?>
	| <a href="<?php echo URL.'purge/one'; ?>" >One</a>
	| <a href="<?php echo URL.'purge/contacts'; ?>" >Contacts</a>
	| <a href="<?php echo URL.'purge/employees'; ?>" >Employees</a>	
	
</h5>


<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
<th>Crid</th>
<th class="" >Classroom</th>
<th>1) Goto</th>
<th>2) Goto</th>
<th>3) Crs & Grades</th>
<th>4) Cr & Sxn</th>
</tr>
<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><a href="<?php echo URL.'purge/clscrs/'.$row['id']; ?>" >Crs</a></td>
	<td><a href="<?php echo URL.'purge/classlist/'.$row['id']; ?>" >Classlist</a></td>	
	<td><a href='<?php echo URL."purge/classroomCourses/".$row['id']; ?>' 
		onclick="return confirm('Del Crs & Grades. Sure?');"  >Crs & Grades</a></td>
	<td><a href='<?php echo URL."purge/crSxn/".$row['id']; ?>' 
		onclick="return confirm('Del Cr,Sxn,Grades,Scores! Sure?');"  >Cr & Sxn</a></td>		
</tr>
<?php endforeach; ?>
</table>