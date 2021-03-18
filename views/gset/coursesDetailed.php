<?php 

// pr($courses[0]['crstype']);
// pr($courses);
// pr($courses[2]);
// pr($courses[2][0]);

$srid = $_SESSION['srid'];

?>

<h5>
 
	<span ondblclick="tracehd();" > <?php echo $level['name']; ?> Courses </span>
<span class="screen" >	
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."data/courses/$lid/$sy"; ?>'>Simple</a>
</span>

</h5>

<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<?php for($c=0;$c<$numrows;$c++): ?>
<?php $hidden = ($classrooms[$c]['section_code']=='TMP')? true:false; ?>
	<h4 class="<?php echo ($hidden)? 'hd':NULL; ?>" > 			
			<?php echo $classrooms[$c]['name']; 		
		echo ' &nbsp; ('.$numcourses[$c].')'; ?> 
		<?php if($srid==RMIS): ?>
			- <a href='<?php echo URL."mis/clscrs/".$classrooms[$c]['crid']; ?>' >Config</a>
		<?php endif; ?>		
	</h4>
	<table class="gis-table-bordered table-fx table-altrow <?php echo ($hidden)? 'hd':NULL; ?>" >
		<tr class="headrow"  >
			<th class="vc50" >#</th>
			<th class="vc50" >ID</th>
			<th class="vc80" >Type</th>
			<th class="vc30" >Sem</th>
			<th class="vc30" >Pos</th>
			<th class="vc200" >Subject</th>
			<th class="vc200" >Label</th>
			<th class="vc50" >Displ</th>
			<th class="vc200" > Loads </th>
			<th class="hd" >Sub#</th>
		</tr>
		<?php $i=1; ?>
		<?php $numdispl = 0; ?>
		<?php foreach($courses[$c] AS $row): ?>
			<?php if($row['is_displayed']==1){ $numdispl+=1; } ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['course_id']; ?></td>
				<td><?php echo $row['crstype']; ?></td>
				<td><?php echo $row['semester']; ?></td>
				<td><?php echo $row['position']; ?></td>
				<td><?php echo $row['subject']; ?></td>
				<td><?php echo $row['label']; ?></td>
				<td><?php echo $row['is_displayed']; ?></td>
				<td><a href='<?php echo URL."loads/teacher/".$row['tcid']; ?>' ><?php echo $row['teacher']; ?></a></td>
				<td class="" ><?php echo $row['subject_id']; ?></td>				
			</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
			<tr><td colspan="8">&nbsp;</td><td><?php echo $numdispl; ?></td><td>&nbsp;</td></tr>
	</table>
	<br />
<?php endfor; ?>

<!------------------------------------------------------------>

<script>

$(function(){
	// hd();
	
})

</script>