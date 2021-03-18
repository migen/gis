
<?php 


// pr($data);

$coursetudents = $students;
$crid = $crid;

?>

<?php


$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			


?>


<div id='hidden' class='invisible onscreen'>



<h2>Candy Report</h2>
<?php $this->shovel('homelinks',$home); ?> | 

<!-- get all class students' data,since no more pagination

	<?php if($_SESSION['creports']['page'] != 0 ): ?>
		<a href="<?php echo URL.'registrars/creports/'.$_SESSION['creports']['crid'].DS.$first; ?>" >First</a> | 
		<a href="<?php echo URL.'registrars/creports/'.$_SESSION['creports']['crid'].DS.$previous; ?>" >Previous</a> | 	
	<?php endif; ?>	
	<?php if($_SESSION['creports']['page'] < $last): ?>
		<a href="<?php echo URL.'registrars/creports/'.$_SESSION['creports']['crid'].DS.$next; ?>" >Next</a> | 
		<a href="<?php echo URL.'registrars/creports/'.$_SESSION['creports']['crid'].DS.$last; ?>" >Last</a> |
	<?php endif; ?>	

-->


<button onClick="PrintElem('#printable');return false;">Web Print</button> 

<?php 		
	// $url = "";
	$row = $classroom;
	$off		= 1;	// official
	$suffix		= ($qtr == 4)? 'f' : null;
	$url 		= REPORT.'card_'.$row['level_id'].$suffix.'.rptdesign&level='.$row['level_id'].'&sct_id='.$row['section_id'].'&qtr='.$qtr.'&off='.$off.'&dbm='.DBG.'&dbg='.DBG.'&sy='.$sy.REPORT_PDF;		
?>
<button><a class="no-underline" target="_blank" href="<?php echo $url; ?>"> Print Card </a> </button>

<br /><br />
</div> 	<!-- navigation-hidden -->


<?php

for($i=0;$i<$num_students;$i++):			// per row or student in the class

	$student = $students[$i];
	$grades = $students[$i]['grades'];

	ob_start();	

?>

<div class="clear" > <!-- student start -->

<div id='printable'> <!-- 1 print -->
	
<div id='creport'>	<!-- @media_print #reportcard -->  <!-- 2 creport  -->



<h5>Report Card</h5>

<table class='gis-table-bordered table-fx'>
<tr><th class='headrow'>ID Number</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th  class='headrow'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='headrow'>Level</th><td><?php echo $classroom['level']; ?></td></tr>
<tr><th class='headrow'>Section</th><td><?php echo $classroom['section']; ?></td></tr>
</table>
<br />

<h5 class='brown1'>Academics</h5>
<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th class="vc200" >Subject</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>FG</th>
	<th>Teacher</th>
</tr>


<?php foreach($grades as $grade): ?>
<tr><td><?php echo $grade['subject']; ?></td>
	<td><?php echo ($grade['q1'] != 0)? $grade['q1'] : ' ' ; ?></td>
	<td><?php echo ($grade['q2'] != 0)? $grade['q2'] : ' ' ; ?></td>
	<td><?php echo ($grade['q3'] != 0)? $grade['q3'] : ' ' ; ?></td>
	<td><?php echo ($grade['q4'] != 0)? $grade['q4'] : ' ' ; ?></td>
	<td><?php echo ($grade['q5'] != 0)? $grade['q5'] : ' ' ; ?></td>
	<td><?php echo $grade['teacher']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<!-- attendance -->
<div id='attendance'>	<!-- 4 attendance  -->
<?php 	$attendance = $data['students'][$i]['attendance'];  ?>
<h5 class='brown1'>Attendance</h5>

<?php $num_months = count($data['month_names']); ?>

<table class='gis-table-bordered'>
<tr class='bg-blue1' >
	<th>Month</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; // ucfirst(strtolower ?>
		<th class='monthCode attendance_column' ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
</tr>

<tr class='bg-blue2'>
	<th>Days Total</th>	
	<?php // pr($data['months']); ?>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
			<th class='attendance_column' ><?php echo round($data['months'][$month_code.'_days_total']); ?></th>
		
	<?php endfor; ?>
</tr>

<tr>
	<th>Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<th class='attendance_column' ><?php echo round($attendance[$month_code.'_days_present']); ?></th>
	<?php endfor; ?>	
</tr>

<tr>
	<th>Days Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<th class='attendance_column' ><?php echo round($attendance[$month_code.'_days_tardy']); ?></th>
	<?php endfor; ?>	
</tr>
</table>

<!---------------------------------------------------------------------------------------------------------------------->



<h5 class='brown1'>Traits and Conduct</h5>

<?php 
	$num_conducts = count($data['students'][$i]['conducts']); 
	$conducts = $data['students'][$i]['conducts'];
	
?>

<!-- bonuses,conduct -->

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<td class="vc200" >Traits</td><td>Q1</td><td>Q2</td><td>Q3</td><td>Q4</td><td>FG</td>
</tr>

<?php for($ic=0;$ic<$num_conducts;$ic++): ?>
<tr>

	<td><?php echo $conducts[$ic]['trait']; ?></td>
	<td><?php echo $conducts[$ic]['q1']; ?></td>
	<td><?php echo $conducts[$ic]['q2']; ?></td>
	<td><?php echo $conducts[$ic]['q3']; ?></td>
	<td><?php echo $conducts[$ic]['q4']; ?></td>
	<td><?php echo $conducts[$ic]['q5']; ?></td>

</tr>
<?php endfor; ?>
</tr>

</table>

<!---------------------------------------------------------------------------------------------------------------------->



<!-- psmapehs -->

<?php 

if(isset($data['students'][$i]['psmapehs'])):
	$psmapehs = $data['students'][$i]['psmapehs'];
	$num_psmapehs = count($psmapehs);
?>

	<h5 class='brown1'>PS Mapehs</h5>

	<table class='gis-table-bordered table-fx'>
	<tr class='headrow'>
		<td class="vc200" >Music,Arts,& PE</td>
		<td>Q1</td>	<td>Q2</td><td>Q3</td><td>Q4</td><td>FG</td>	
	</tr>
		<?php for($m=0;$m<$num_psmapehs;$m++): ?>	
		<?php 
			$ps_sum = 0;
			$ps_sum += $psmapehs[$m]['q1'] + $psmapehs[$m]['q2'] + $psmapehs[$m]['q3'] + $psmapehs[$m]['q4'];
		?>
	<tr>		
		<td><?php echo $psmapehs[$m]['psmapeh']; ?></td>
		<td><?php echo $psmapehs[$m]['q1']; ?></td>
		<td><?php echo $psmapehs[$m]['q2']; ?></td>
		<td><?php echo $psmapehs[$m]['q3']; ?></td>
		<td><?php echo $psmapehs[$m]['q4']; ?></td>
		<td><?php echo $psmapehs[$m]['q5']; ?></td>
		<!--
			<td><?php echo $ps_sum; ?></td>		
		-->
	</tr>
		<?php endfor; ?> 	<!-- psmapeh_loop -->
		
<?php endif; ?> 	<!-- if_psmapehs-->

	</table>

<!-- psmapehs above -->

<!---------------------------------------------------------------------------------------------------------------------->



</div>	<!-- @media_print #reportcard 2 close creport -->

</div> 	<!-- per student wrapper -->

<!---------------------------------------------------------------------------------------------------------------->

<p class='pagebreak'>&nbsp; </p>

<!---------------------------------------------------------------------------------------------------------------->

<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();
?>	
	
<?php endfor; ?>		<!-- end of all students -->


<?php


/* 
if(Session::get('page') != NULL){
	$j = (Session::get('page') <= $last) ? Session::get('page') : 0;
	$ob = "ob$j";
	echo $$ob;
} else {
	for($j=0;$j<$num_students;$j++){
		$ob = "ob$j";
		echo $$ob;
	}	
}
 */
 
for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;
}	
 

?>


<br />
<br />

<div class='clear'>&nbsp;</div>


</div>   <!--   1 close printable  -->

<div class='invisible onscreen'>   <!-- 6   -->
<form method='post'>


<table class='gis-table-bordered table-fx'>
<tr>
	<td class='headrow' >Classroom</td>
	<td>
		<select name="classroom" class="full" >
			<?php	foreach($classrooms as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$_SESSION['creports']['crid'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>		
	</td>
</tr>
<tr>
	<td class='headrow' >School Year</td>
	<td><input class="pdl05" type="number" name="sy" value="<?php echo $sy; ?>"   />	</td>	
</tr>

<!-- ctlr for redirect -->

<input type="hidden" name="ctlr" value="<?php echo $home; ?>" />

<!--
	<tr>
		<td  class='headrow'>Record</td>
		<td><input type='text' name='page' value='0' class='vc50 center' /></td>
	</tr>

-->
<tr>
	<td class='headrow' colspan=2><input type='submit' name='submit' value='View' /></td>
</tr>
</table>
</form>

<button onClick="PrintElem('#printable');return false;">Print</button>

</div> 	<!--  6 close classroom params post form -->

