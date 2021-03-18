<?php 

	// pr($components[1]);
	// pr($data);

?>

<h5>
	<?php echo strtoupper(VCFOLDER); ?> Courses Settings - <?php echo $level['name']; echo " ({$num_subjects})"; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."courses/settings/$lvl?get"; ?>' />Get Subjects</a>  
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."courses/config/$lvl?subjects"; ?>' />Setup (MIS)</a>  		
	<?php endif; ?>
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."courses/settings/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<?php 
include_once('incs/notes_courses.php');
?>

<table class="gis-table-bordered" >
<tr>
<th>#</th>
<th>ID</th>
<th>Subject</th>
<th>Position</th>
<?php for($j=0;$j<$num_classrooms;$j++): ?>
	<th class="vc200" >
		<?php 
			echo $classrooms[$j]['classroom'].' #'.$classrooms[$j]['crid']; 
			$adviser = isset($classrooms[$j]['adviser'])? $classrooms[$j]['adviser']:'No adviser yet.'; 
			echo '<br />('.$adviser.')';
		?>
		<br />Teacher<br />
		Weight<br />
		Is Numeric<br />
		In Genave (InGA)<br />
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
			echo '<br />Label: '.$subjects[$i]['label'];
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
				echo ($courses[$j][$i]['course_weight']>0)? ' | Sup: #'.$courses[$j][$i]['supsubject_id'].'-'.$courses[$j][$i]['supsubject']:NULL;
				echo '<br />Num - '; echo ($courses[$j][$i]['is_num'])? 'Y':NULL;
				echo '<br />InGA - '; echo ($courses[$j][$i]['in_genave'])? 'Y':NULL;
				echo '<br />W/S - '; echo ($courses[$j][$i]['with_scores'])? 'Y':NULL;
				echo '<br />Aggre - '; echo ($courses[$j][$i]['is_aggregate'])? 'Y':NULL;
			?>			
		</td>
	<?php endfor; ?> 
	<td></td>
</tr>
<?php endfor; ?>



</table>


