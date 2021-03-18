<?php 


$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
$nsy = $sy+1;

$numrows = 14;	/* fixed rows in report card */


// pr($numacad);

// pr($students[0]['conducts']);

// pr($legendcrs);
// pr($legendctr);

// pr($classroom);


// pr($students[0]);
// pr($students[0]['summary']);
// pr($students[0]['grades'][0]);



?>





<!-- sasm rcard -->

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />

<?php // $traits = true; ?>
<?php $traits = false; ?>

<style>
	<?php if($traits): ?> @media print{@page{size:landscape}} <?php endif; ?>

@media print{
	.screen, #sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:12pt;}	
}

	
</style>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();

})

</script>


<?php 
/*  armcontroller-gradebook */
// pr($classroom);




$passing        = $_SESSION['settings']['passing_grade'];
$rcardteac      = $_SESSION['settings']['rcardteac'];
$deciatt    	= $_SESSION['settings']['deciatt'];
$decifg    	    = $_SESSION['settings']['decifg'];
$decicard       = $_SESSION['settings']['decicard'];
$deciranks      = $_SESSION['settings']['deciranks'];
$deciconducts   = $_SESSION['settings']['deciconducts'];
$decifconducts  = $_SESSION['settings']['decifconducts'];
$decigenave     = $_SESSION['settings']['decigenave'];
$decifgenave    = $_SESSION['settings']['decifgenave'];


?>


<?php




?>




<!------------------------------------------------------------------------------------->


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

?>

<div class="page clear center" > <!-- student start -->


<?php if(!$is_locked): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
<?php endif; ?>



<div class="center" > 
	<table class="no-gis-table-bordered-print tf14 center vc600" >
		<tr><td rowspan="4" ><img src='<?php echo $logo_src; ?>' alt="logo" height="108" width="108"></td>
			<td class="b f18" >ST. ANTHONY SCHOOL</td>
			<td class="right tf10"  >FORM 138</td>
		</tr>
		<tr><td colspan="" >Singalong, Manila</td></tr>
		<tr><td colspan="" class="i" >PAASCU ACCREDITED</td></tr>
		<tr><td colspan="" class="" ><?php echo $classroom['department']; // pr($classroom); ?></td></tr>
		<tr><td></td><td colspan="" class="f20 b" >PROGRESS REPORT CARD</td></tr>		
	</table>
	
</div>

<div class="vc800 clear" ><hr /></div>


<div class="center full" >

<table class='no-gis-table-bordered-print tf18 vc800'>
	<tr><td class="center" colspan="5" class=''><?php echo $student['student']; ?> </td></tr>
	<tr>
		<td class="" >ID Number</td><td class="" ><?php echo $student['student_code']; ?></td>
		<td class="vc80" ></td>
		<td class="" >School Year</td><td class="" ><?php echo $sy.' - '.$nsy; ?></td>		
	</tr>

	<tr>
		<td class="" >Grade/Level</td><td class="" ><?php echo $classroom['level']; ?></td>
		<td class="vc80" ></td>
		<td class="" >Section</td><td class="" ><?php echo $classroom['section']; ?></td>		
	</tr>

	<tr>
		<td class="" >Adviser</td><td colspan="4" ><?php echo $classroom['adviser']; ?></td>
	</tr>
</table><br />

<table class='gis-table-bordered-print table-center table-vcenter tf16 vc800'>

<tr class="bg-gray2" ><th class="vc300" >SUBJECTS</th><th>1st</th><th>2nd</th>
<th>3rd</th><th>4th</th><th>FINAL</th><th>REMARKS</th></tr>


<?php $etcgrades = array(); ?>

<?php 

	for($r=0;$r<$numrows;$r++):
	$grade = ($r<$numacad)? $grades[$r]:NULL;	
	if(!empty($grade)):

	if($grade['position']>100){
		$etcgrades[] = $grade;
		continue;
	} 
	

?>

<?php $alert = $grade['tcid'].CS.$grade['teacher_code'].CS.$grade['teacher'].' | GID:'.$grade['gid'].' | CRS: '.$grade['course_id'];  ?>
<?php $child 	= ($grade['supsubject_id']>0)? true:false; ?>
<?php $apo 		= ($grade['is_apo']==1)? true:false; ?>

<tr class="" ><td style="<?php echo ($child)? 'font-size:14px;':NULL; ?>" class="left" id="<?php echo $alert; ?>" 
	ondblclick="alert(this.id);" >
	<?php 
		if($child){
			echo "&nbsp;&nbsp;&nbsp;";
			if($apo){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";			
			}
		}
	
	?>
	<?php echo $grade['subject']; ?>
	
</td>
	<td><?php echo ($grade['q1'] != 0)? number_format($grade['q1'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q2'] != 0)? number_format($grade['q2'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q3'] != 0)? number_format($grade['q3'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q4'] != 0)? number_format($grade['q4'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q5'] != 0)? number_format($grade['q5'],$decifg) : ' ' ; ?></td>
	<td><?php echo ($grade['q5']<$passing)?'Failed':'Passed'; ?></td>	
</tr>

<?php else: ?>
<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
<?php endif; ?>
<?php endfor; ?>


<?php foreach($etcgrades as $grade): ?>
<tr class="" >
	<td class="left" ><?php echo $grade['subject']; ?></td>
	<td><?php echo ($grade['q1'] != 0)? number_format($grade['q1'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q2'] != 0)? number_format($grade['q2'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q3'] != 0)? number_format($grade['q3'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q4'] != 0)? number_format($grade['q4'],$decicard) : ' ' ; ?></td>
	<td><?php echo ($grade['q5'] != 0)? number_format($grade['q5'],$decifg) : ' ' ; ?></td>
	<td><?php echo ($grade['q5']<$passing)?'Failed':'Passed'; ?></td>	
</tr>
<?php endforeach; ?>

<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>

<tr class="" >
	<th class="left" >GENERAL AVERAGE</th>
	<th><?php echo number_format($students[$i]['summary']['ave_q1'],$decifgenave); ?></th>
	<th><?php echo number_format($students[$i]['summary']['ave_q2'],$decifgenave); ?></th>
	<th><?php echo number_format($students[$i]['summary']['ave_q3'],$decifgenave); ?></th>
	<th><?php echo number_format($students[$i]['summary']['ave_q4'],$decifgenave); ?></th>
	<th><?php echo number_format($students[$i]['summary']['q5'],$decifgenave); ?></th>
	<th><?php echo ($students[$i]['summary']['q5']<$passing)?'Failed':'Passed'; ?></th>	
</tr>
</table>

<table class='no-gis-table-bordered table-center table-vcenter tf14 vc800'>
	<tr class="left tf12" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

<table class='gis-table-bordered table-center table-vcenter tf12 vc800'>
<tr>
	<?php foreach($legendcrs AS $row): ?>
			<td class="vc100" ><?php echo $row['description'].'<br />'.$row['rating']; ?></td>
	<?php endforeach; ?>
</tr>

<tr>
	<?php foreach($legendcrs AS $row): ?>
		<td><?php echo round($row['grade_floor']).' - '.floor($row['grade_ceiling']).'%'; ?></td>
	<?php endforeach; ?>
</tr>
</table>
<br />


<?php 	$attendance = $students[$i]['attendance'];  ?>
<?php // $num_months = count($month_names); ?>

<table class='gis-table-bordered table-center table-vcenter tf14 vc800'>

<tr class="padding02 bg-gray2" > 
	<th>&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th class="" ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
</tr>

<tr>
	<th class="left" >Days of School</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
			<td><?php echo round($data['months'][$month_code.'_days_total']); ?></td>		
	<?php endfor; ?>
</tr>

<tr class="no-padding" >
	<th class="left" style="padding-left:6px;" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo number_format($attendance[$month_code.'_days_present'],$deciatt); ?></td>
	<?php endfor; ?>	
</tr>

<tr>
	<th class="left" >Times Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo round($attendance[$month_code.'_days_tardy']); ?></td>
	<?php endfor; ?>	
</tr>
</table>

<div class="vc800 clear" ><hr /></div>


<table class='no-gis-table-bordered table-center table-vcenter tf14 vc800'>

<tr class="left tf12" ><td class="left" colspan="2" >Lacks units in: </td></tr>


<tr><td colspan="2" >Eligible for transfer and admission to _________________ Date Issued: _________________</td></tr>
<tr><td>________________________________</td><td>________________________________</td></tr>
<tr class="center" ><td><?php print($classroom['adviser']); ?></td><td>Susan S. Canlas</td></tr>

<tr class="center" >
	<td>Class Adviser <span class="vc30"> &nbsp; </span> </td>
	<td>Principal</td>
</tr>


<tr class="left" ><td colspan="2" >CANCELLATION OF ELIGIBILITY TO TRANSFER</td></tr>
<tr class="left" ><td colspan="2" >Has been admitted to: ____________________________________</td></tr>

<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="center" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Director/Principal <span class="vc10"> &nbsp; </span> </td>
	<td>Date Received</td>
</tr>

</table>

</div>	<!-- rcardhalfLeft-->






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

 
for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;

}	
 

?>


