<?php 

	// pr($components[1]);

?>

<h5>
	<?php echo strtoupper(VCFOLDER); ?> Courses Setup - <?php echo $level['name']; echo " ({$num_subjects})"; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."courses/level/$lvl?get"; ?>' />Get Subjects</a>  
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."courses/level/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<p>
Notes<br />
1) Validate especially a) Teacher load assignment, b) Weight if child subject, c) Components. <br />
2) Blank Teacher means the course has not been assigned a teacher yet.<br />
3) Put desired "Label" under Subject to appear on the Report Card.<br />
4) Indicate parent subject and child subjects, i.e. MAPEH (Parent) with Children => Music (30%), Arts (30%), PE & Health (40%). <br />
5) Position on the report card Subject (Learning Areas) column (Top-down).<br />
6) For Traits - 100% meaning equal weight.<br />
7) Y means Yes or On, blank means No or None.<br />
8) With Scores if No - then no activities or components needed. Teacher will encode direct grades only.<br />
9) Other default settings a) On display = Y, b) In Genave = Y, c) Is Transmuted = Y (ex. Range 85.60 to 87.19 => 91).<br />
10) Course types are a) Academic (default), b) Traits, c) Conduct, d) Elective. Different types may have different descriptive grades lookup table (letter equivalent).<br />
11) Provide adviser if none assigned yet.<br />
12) Cross out subjects not applicable.<br />
13) Add subjects not in the list.<br />
14) Add remarks if necessary.<br />

</p>

<table class="gis-table-bordered" >
<tr>
<th>#</th>
<th>ID</th>
<th>Subject</th>
<th>Position</th>
<?php for($j=0;$j<$num_classrooms;$j++): ?>
	<th class="vc200" >
		<?php 
			echo $classrooms[$j]['classroom']; 
			$adviser = isset($classrooms[$j]['adviser'])? $classrooms[$j]['adviser']:'No adviser yet.'; 
			echo '<br />('.$adviser.')';
		?>
		<br />Teacher<br />
		Weight<br />
		Is Numeric<br />
		With Scores<br />
		Is Aggregate<br />
	</th>
<?php endfor; ?>
<th class="vc200" >Additional<br />Remarks</th>
</tr>

<?php for($i=0;$i<$num_subjects;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $subjects[$i]['sub']; ?></td>
	<td>
		<div style="min-height:120px;" >
		<?php 
			echo $subjects[$i]['subject'];  
			echo '<br />Label: ';
			echo '<hr />Components (%)';
			foreach($components[$i] AS $com){
				echo '<br />'.$com['cricode'].' - '.$com['weight'];
			}
		?>			
		</div>
	
	
	</td>
	<td><?php echo $subjects[$i]['position']; ?></td>
	
	
	</td>

	<?php for($j=0;$j<$num_classrooms;$j++): ?>
		<td>
			<?php 
				echo 'T - '.$courses[$j][$i]['teacher'];
				echo '<br />Wt - '; echo $courses[$j][$i]['course_weight'];
				echo ($courses[$j][$i]['course_weight']>0)? ' | Sup: '.$courses[$j][$i]['supsubject_id']:NULL;
				echo '<br />Num - '; echo ($courses[$j][$i]['is_num'])? 'Y':NULL;
				echo '<br />W/S - '; echo ($courses[$j][$i]['with_scores'])? 'Y':NULL;
				echo '<br />Aggre - '; echo ($courses[$j][$i]['is_aggregate'])? 'Y':NULL;
			?>			
		</td>
	<?php endfor; ?> 
	<td></td>
</tr>
<?php endfor; ?>



</table>


