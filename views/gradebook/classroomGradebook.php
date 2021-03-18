
<?php 

// pr($students[0]['grades']);



?>








<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />

<?php $traits = true; ?>

<style>
	<?php if($traits): ?> @media print{@page{size:landscape}} <?php endif; ?>

@media print{
	.screen, #sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:8pt;}	
}

	
</style>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = 'registrars';

$(function(){
	hd();	
})

</script>


<?php 
/*  armcontroller-gradebook */
// pr($classroom);




$rcardteac    = $_SESSION['settings']['rcardteac'];
$decicard     = $_SESSION['settings']['decicard'];
$deciconducts = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];
$decigenave    = $_SESSION['settings']['decigenave'];
$decifgenave   = $_SESSION['settings']['decifgenave'];


// pr($students[0]['summary']);
// pr($classroom);

?>


<?php




?>


<div id='hidden' class='invisible onscreen'>
<div class="" >
<h5> <span ondblclick="tracehd();" >Candy - Gradebook </span>
	&nbsp; &nbsp; 
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."submissions/view/$crid/$sy/$qtr"; ?>'  >Submissions</a> 
	| <a target="_blank" href='<?php echo URL."rcards/crid/$crid/$sy"; ?>'  >PRINT</a> 
		

	
</h5>





<!------------------------------------------------------------------------------------->


<table class="screen gis-table-bordered table-fx">
	<tr><th class="white bg-blue2" >Status</th><td>
	<?php 
		echo 'Q'.$qtr.' - ';
		echo ($is_locked)? "Locked":"Open: <span class='red'>DON'T</span> Print. Records <span class='red'>NOT FINALIZED</span>."; 
	?>
	</td></tr>
	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'gradebook';
		// pr($d);
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>


</div> 	

<!------------------------------------------------------------------------------------->
	

</div> <!-- navigation-hidden -->



<!------------------------------------------------------------------------------------->


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

?>

<div class="clear" > <!-- student start -->

<div id='printable'> <!-- 1 print -->
	
<div id='creport'>	<!-- @media_print #reportcard -->  <!-- 2 creport  -->



<h5>Gradebook</h5>

<div class="third" >
<table class='no-gis-table-bordered tf12'>
<tr><th class='vc150'>ID Number</th><td class="vc300" ><?php echo $student['student_code']; ?></td></tr>
<tr><th  class=''>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class=''>Level - Section </th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
<tr><th class=''>SY | Quarter</th><td><?php echo $sy.' - '.($sy+1); ?> | <?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Finalized':'Open'; ?></td></tr>
<tr><th class=''>Class Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
</table>
</div>

<?php if($_SESSION['settings']['show_photos']==1): ?>

<div class class="third" >
<?php if(isset($photos[$i]['photo'])): ?>
	<img src="data:image/jpeg;base64,<?php echo base64_encode($photos[$i]['photo']); ?>" width="120" border="0" />
<?php else: ?>
	<a href='<?php echo URL."photos/one/".$student['scid']; ?>' >Upload Photo</a>
<?php endif; ?>
</div>

<?php endif; ?>

<div class="clear" >&nbsp;</div>

<table class='gis-table-bordered tf12'>
<tr><th rowspan="2" class="vc200" >Learning<br />Areas</th><th colspan="4" class="center" >Grading Periods</th><th rowspan="2" >Final<br /> Rating</th>
	<?php if($rcardteac==1){ echo "<th rowspan='2'>Teacher</th>"; }  ?>
</tr>

<tr>
	<th class="center" >1</th><th class="center" >2</th>
	<th class="center" >3</th><th class="center" >4</th>
	<?php if($rcardteac==1): ?>
		<th></th>
	<?php endif; ?>
</tr>


<?php foreach($grades as $grade): ?>
<?php $alert = $grade['tcid'].CS.$grade['teacher_code'].CS.$grade['teacher'].' | GID:'.$grade['gid'].' | CRS: '.$grade['course_id'];  ?>

<?php if($grade['in_genave']==1): ?>
<tr><td id="<?php echo $alert; ?>" ondblclick="alert(this.id);" ><?php echo $grade['subject']; ?></td>
	<td class="center" ><?php echo ($grade['q1'] != 0)? number_format($grade['q1'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q2'] != 0)? number_format($grade['q2'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q3'] != 0)? number_format($grade['q3'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q4'] != 0)? number_format($grade['q4'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q5'] != 0)? number_format($grade['q5'],$decicard) : ' ' ; ?></td>
	<?php if($rcardteac==1): ?>
		<td><?php echo $grade['teacher']; ?></td>
	<?php endif; ?>
</tr>
<?php endif; ?>

<?php endforeach; ?>


<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td> </tr>
<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td> </tr>

<tr>
<th>General Average</th>
<th><?php $genave1 = number_format($students[$i]['summary']['ave_q1'],$decifgenave); echo $genave1+0; ?></th>
<th><?php $genave2 = number_format($students[$i]['summary']['ave_q2'],$decifgenave); echo $genave2+0; ?></th>
<th><?php $genave3 = number_format($students[$i]['summary']['ave_q3'],$decifgenave); echo $genave3+0; ?></th>
<th><?php $genave4 = number_format($students[$i]['summary']['ave_q4'],$decifgenave); ($genave4+0); ?></th>
<th><?php $genave5 = number_format($students[$i]['summary']['ave_q5'],$decifgenave); ?></th>
</tr>

<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td> </tr>

<?php foreach($grades as $grade): ?>
<?php if($grade['in_genave']!=1): ?>
<tr><td id="<?php echo $alert; ?>" ondblclick="alert(this.id);" ><?php echo $grade['subject']; ?></td>
	<td class="center" ><?php echo ($grade['q1'] != 0)? number_format($grade['q1'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q2'] != 0)? number_format($grade['q2'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q3'] != 0)? number_format($grade['q3'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q4'] != 0)? number_format($grade['q4'],$decicard) : ' ' ; ?></td>
	<td class="center" ><?php echo ($grade['q5'] != 0)? number_format($grade['q5'],$decicard) : ' ' ; ?></td>
	<?php if($rcardteac==1): ?>
		<td><?php echo $grade['teacher']; ?></td>
	<?php endif; ?>
</tr>
<?php endif; ?>

<?php endforeach; ?>



</table>

<!--------------------------- attendance ------------------------------------------>

<div id='attendance'>	<!-- 4 attendance  -->
<?php 	$attendance = $students[$i]['attendance'];  ?>
<h5 class='brown1'>Attendance</h5>

<?php $num_months = count($month_names); ?>

<!-- month_code attendance_column -->
<p><table class='gis-table-bordered tf12 table-center table-vcenter'>	
<tr class='' > 
	<th>&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th><?php echo '<br />'.strtoupper($month_code); ?></th>
	<?php endfor; ?>
</tr>

<tr>
	<th>Days Total</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
			<td><?php echo round($data['months'][$month_code.'_days_total']); ?></td>		
	<?php endfor; ?>
</tr>

<tr>
	<th>Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo round($attendance[$month_code.'_days_present']); ?></td>
	<?php endfor; ?>	
</tr>

<tr>
	<th>Days Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo round($attendance[$month_code.'_days_tardy']); ?></td>
	<?php endfor; ?>	
</tr>
</table></p>


<!--------------------------- traits & conducts ------------------------------------------>

<h5 class=''>Traits and Conduct</h5>

<?php 
	$num_conducts = count($students[$i]['conducts']); 
	$conducts 	  = $students[$i]['conducts'];
	
?>


<p><table class='gis-table-bordered table-fx tf12'>
<tr class=''>
	<th class="vc300" >Traits</th><th class="center" >Q1</th><th class="center" >Q2</th>
	<th class="center" >Q3</th><th class="center" >Q4</th><th class="center" >Final</th>
</tr>

<?php for($ic=0;$ic<$num_conducts;$ic++): ?>
<tr>

	<td class="vcenter" ><?php echo $conducts[$ic]['trait']; ?></td>
	<td class="center vcenter" ><?php echo number_format($conducts[$ic]['q1'],$deciconducts); ?></td>
	<td class="center vcenter" ><?php echo number_format($conducts[$ic]['q2'],$deciconducts); ?></td>
	<td class="center vcenter" ><?php echo number_format($conducts[$ic]['q3'],$deciconducts); ?></td>
	<td class="center vcenter" ><?php echo number_format($conducts[$ic]['q4'],$deciconducts); ?></td>
	<td class="center vcenter" ><?php echo number_format($conducts[$ic]['q5'],$decifconducts); ?></td>

</tr>
<?php endfor; ?>
</tr>

<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td> </tr>
<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td><td></td> </tr>

<tr>
<th>Conduct </th>
<th class="center vcenter" ><?php echo number_format($students[$i]['summary']['conduct_q1'],$decifconducts); ?></th>
<th class="center vcenter" ><?php echo number_format($students[$i]['summary']['conduct_q2'],$decifconducts); ?></th>
<th class="center vcenter" ><?php echo number_format($students[$i]['summary']['conduct_q3'],$decifconducts); ?></th>
<th class="center vcenter" ><?php echo number_format($students[$i]['summary']['conduct_q4'],$decifconducts); ?></th>
<th class="center vcenter" ><?php echo number_format($students[$i]['summary']['conduct_q5'],$decifconducts); ?></th>

</tr>

</table></p>

<!--------------------------- psmapehs ------------------------------------------>

<?php 

if(isset($data['students'][$i]['psmapehs'])):
	$psmapehs = $data['students'][$i]['psmapehs'];
	$num_psmapehs = count($psmapehs);
?>

	<h5 class='brown1'>PS Mapehs</h5>

	<table class='gis-table-bordered table-fx'>
	<tr class='headrow'>
		<th class="vc500" >Music,Arts,& PE</th>
		<th class="center" >Q1</th><th class="center" >Q2</th>
		<th class="center" >Q3</th><th class="center" >Q4</th><th class="center" >FG</th>
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

 
for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;
	echo "<hr />";

}	
 

?>


<br />
<br />

<div class='clear'>&nbsp;</div>


</div>   <!--   1 close printable  -->

<div class='invisible onscreen'>   <!-- 6   -->

<!--------------------------------------------------------------------------------------->




<!--------------------------------------------------------------------------------------->


</div> 	<!--  6 close classroom params post form -->

