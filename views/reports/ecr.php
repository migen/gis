



<?php 

$cr = $data['classroom'];
$qtr = $data['qtr'];

// pr($data);
// pr($courses[0]);
// pr($grades[0][0]);
	
	

?>



<h5>
	<span ondblclick="tracehd();"  >Edit Class Records</span>
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'classlists/classroom/'.$data['classroom']['id'].DS.$sy; ?>" />Classlist</a>	
	| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy; ?>" />Attendance</a>	
	| <a href="<?php echo URL.'rcards/crid/'.$data['classroom']['id'].DS.$sy; ?>" />Rpt Cards</a>	
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'mis/classroomsManager'; ?>" />Manager</a>		
	<?php endif; ?>
	<?php if($_SESSION['srid']!=RTEAC): ?>
		| <a href="<?php echo URL.'matrix/grades/'.$data['classroom']['id'].DS.$sy; ?>" />Matrix</a>	
		| <a href="<?php echo URL.'reports/ccr/'.$data['classroom']['id'].DS.$sy; ?>" />CCR</a>	
	<?php endif; ?>
</h5>

<!------------------------------------------------------------------------------->


<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom</th><td class="vc150" ><?php echo $cr['level'].' - '.$cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Class Size</th><td><?php echo $num_students; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr>
</table>


<!------------------------------------------------------------------------------->

<?php if(($_SESSION['qtr'] == 1) && ($classroom['is_init_grades']==0)): ?>
	<h4> Please ask MIS to setup Sync Grades. </h4>
<?php exit; endif; ?>

<!------------------------------------------------------------------------------->


<br />

<table class='gis-table-bordered table-fx table-center'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="" >SCID</th>
	<th>ID Number</th>
	<th class="" >Student</th>
	<!-- left to right,iterate thru subjects -->
	<?php $s=0; ?>
	<?php foreach($courses AS $row): ?>	
		<?php $s++; ?>
		<th class='center'>
			<?php echo $s."<br />(".$row['course_id'].")";  ?>
				<?php // pr($row); ?>
				<?php $axn = ($row['with_scores']==1)? 'scores':'grades'; echo $axn."<br />"; ?>
				<a href='<?php echo URL."teachers/$axn/".$row['course_id']."/$sy/$qtr"; ?>' ><?php echo $row['course_code']; ?></a>
					<br />
				<?php if($row['supsubject_id']!=0): ?>
					<?php echo $row['course_weight'].'%'; ?>
				<?php endif; ?>			
	
	<span class="hd" ><a onclick="return confirm('Dangerous! Proceed?');" 
		href='<?php echo URL."delgrades/delSxnGrades/".$row['course_id']; ?>' >DEL!</a></span>
<?php if($row['is_aggregate']==1): ?>	
	<a href='<?php echo URL."aggregates/tally/$crid/".$row['course_id'].DS.$row['subject_id']."/$sy/$qtr"; ?>' >Tally</a>
<?php endif; ?>			
		</th>
	<?php endforeach; ?>
</tr>

<?php $num_students = $data['num_students']; ?>		

<?php $courses = $data['courses']; ?>

<?php for($is=0;$is<$num_students;$is++): ?> 	<!-- loop thru num_students,top down -->

<?php $nb = count($grades[$is]); ?>
<?php if($nb == $num_courses): ?>
<form method="POST" >
<tr>
	<td><?php echo $is+1; ?></td>
	<td class="" ><?php echo $students[$is]['scid']; ?></td>
	<td><?php echo $students[$is]['student_code']; ?></td>
	<td><?php echo $students[$is]['student']; ?>
	</td>
	
	<?php for($ic=0;$ic<$num_courses;$ic++): ?> 	<!-- loop thru num_courses -->
		<td class='center' style='vertical-align:middle;'>			
			<?php $qx = number_format($grades[$is][$ic]['q'.$qtr],2); ?>
			<input class="vc50" type="hidden" name="g[<?php echo $ic; ?>][gid]" value="<?php echo $grades[$is][$ic]['gid']; ?>" />
			<input class="vc50" name="g[<?php echo $ic; ?>][gx]" value="<?php echo $qx; ?>" />
			<?php $dgx = rating($qx,$ratings); ?>
			<?php echo $grades[$is][$ic]['dg'.$qtr]; ?>
			<input class="vc30 <?php echo ($dgx!=$grades[$is][$ic]['dg'.$qtr])? 'bg-pink':NULL; ?>" 
				name="g[<?php echo $ic; ?>][dgx]" value="<?php echo $dgx; ?>" readonly />
			
		</td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
	<td class="vcenter" ><input onclick="" type="submit" name="save" value="Save (2x)" ></td>
<td class="vcenter" ><a href='<?php echo URL."summarizers/student/".$students[$is]['scid']."/$sy/$qtr"; ?>' >Summarizer</a></td>
<td class="vcenter" ><a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid'].DS.$sy.DS.$qtr; ?>' >Grades</a></td>
<td class="vcenter" ><a href="<?php echo URL.'registrars/editStudentGrades/'.$students[$is]['scid'].DS.$sy.DS.$qtr; ?>" >Edit</a></td>
<td class="vcenter" ><a href="<?php echo URL.'rcards/scid/'.$students[$is]['scid'].DS.$sy.DS.$qtr; ?>" >RptCard</a></td>
<td class="vcenter" ><?php echo $students[$is]['student']; ?></td>

</tr>

</form>

<?php else: ?>
<tr><td class="red" colspan="<?php echo $num_courses+5; ?>" > Please check with Registrars / MIS to update 
		<a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid'].DS.$sy.DS.$qtr; ?>' >Grades</a> of 
		<?php echo $students[$is]['student'].' with ID # '.$students[$is]['student_code']; ?> 
	
	</td></tr>
<?php endif; ?>

<?php endfor; ?>								<!-- endloop row num_students -->

<tr class='bg-blue2'>
	<th>#</th>
	<th class="" >SCID</th>
	<th>ID Number</th>
	<th class="" >Student</th>
	<!-- left to right,iterate thru subjects -->
	<?php $s=0; ?>
	<?php foreach($courses AS $row): ?>	
		<?php $s++; ?>
		<th class='center'>
			<?php echo $s; echo '<br />'.$row['course_code']; ?><br />
			<span class="hd" ><a href='' ><?php echo $row['tlogin'].'-'.$row['tpass'].'-'.$row['tcid']; ?></a></span>
		</th>
	<?php endforeach; ?>
</tr>

</table>

</div>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<button onclick="tracepass();" >Manage</button>
	<p> <?php $this->shovel('hdpdiv'); ?> </p>

<!------------------------------------------------------------------------------------------------------->

<script>

var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();
	selectFocused();
	
})

</script>