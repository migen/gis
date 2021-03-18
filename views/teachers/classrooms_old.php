
<?php 
	// pr($data); 
?>

<h5>
	Advisory Class/es </a> | 
	<a href="<?php echo URL; ?>teachers">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>



<table class='gis-table-bordered table-fx'>
<thead>
<tr class='headrow1'>
	<th colspan=4>&nbsp;</th>
	<th colspan=4 class='center'>Advisory</th>
</tr>
<tr class='headrow2'>
	<th>ID</th>
	<th>Level</th>
	<th>Classroom</th>
	<th>Adviser</th>
	<th class='center'>Grades</th>
	<th class='center'>Bonuses</th>
	<th class='center'>Attendance</th>
	<th class='center'>Conduct</th>
</tr>
</thead>
<tbody>

<?php foreach($data['classrooms'] AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['level']; ?></td>
	<td>
		<a href="<?php echo URL; ?>teachers/classroom/<?php echo $row['id']; ?>">
			<?php echo $row['classroom']; ?>		
		</a>
	</td>
	<td><?php echo $row['adviser']; ?></td>
	<td class='center'>
		<?php if($row['acid'] == $contact_id): ?>			
			<a href="<?php echo URL.'teachers/mcr/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >Grades</a>		
		<?php else: ?>
			- - - - -
		<?php endif; ?>
	</td>	
	<td class='center'>
		<?php if($row['acid'] == $contact_id): ?>			
			<a href="<?php echo URL.'teachers/bonuses/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >Bonuses</a>		
		<?php else: ?>
			- - - - -
		<?php endif; ?>
	</td>	
	<td class='center'>
		<?php if($row['acid'] == $contact_id): ?>			
			<a href="<?php echo URL.'teachers/attendance/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >Attendance</a>		
		<?php else: ?>
			- - - - -
		<?php endif; ?>
	</td>
	<td class='center'>
		<?php if($row['acid'] == $contact_id): ?>			
			<?php if(($row['is_k12'] == 1) && ($row['is_hs'] == 1) ): ?> 
				<!-- Gr7,8,tid#67 -->
				<a href="<?php echo URL.'teachers/traits/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >K12 HS Traits</a>		
			<?php elseif(($row['is_k12'] == 1) && ($row['is_hs'] != 1) && ($row['is_ps'] != 1)): ?>
				<!-- Gr1,2,tid#16 -->
				<a href="<?php echo URL.'teachers/traits/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >K12 GS Traits</a>		
			<?php elseif(($row['is_ps'] == 1)): ?>
				<!-- PS,Nursery,Kg,tid#001  -->
				<a href="<?php echo URL.'teachers/traits/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>" >K12 PS Traits</a> ||		
				<a href="<?php echo URL.'teachers/psmapehs/'.$row['id'].DS.$row['level_id'].DS.$row['section_id']; ?>">PS Mapeh</a>						
			<?php else: ?>
				<!-- Regular Conduct Behavior like Grades,tid#022,056 -->
				<a href="<?php echo URL.'teachers/gotoConduct/'.$row['id']; ?>">Conduct</a>							
			<?php endif; ?>
		<?php else: ?>
			- - - - -			
		<?php endif; ?>			
	</td>	

	
</tr>
<?php endforeach; ?>
</tbody>
</table>
