<?php 
	// echo "hidegenave $hidegenave <br />";
?>

<style>
	@media print {@page {size: portrait;}}
	table.vc700{width:600px;}
	.vc180{width:180px;}
	
div.card{ margin-right:20px; }
	
.gis-table-bordered-print { border: 1px solid #dddddd; border-left: 0; border-top: 0; }
.gis-table-bordered-print th, .gis-table-bordered-print td  { border-left: 1px solid #dddddd;  
border-top: 1px solid #dddddd; padding:1px 3px; color:;}
.gis-table-bordered-print th {color:#181818; }
	
</style>


<?php 

// pr($students[0]);

$num_subjects = ($_SESSION['settings']['num_subjects']+1);
$qtr_fg 	  = (4-1);

$tblwidth = "vc700";
$tblsubwidth = "vc500";
$subwidth = "vc200";
$subfont = "tf18";
$headfont = "tf18";
$childfont = "tf18";
$blankfont = "tf16";
$legendfont = "tf14";
$attfont = "tf14";
$attheadrowfont = "tf14";



$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
$nsy = $sy+1;




?>


<!-- sjsp rcard -->

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />




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

// pr($decicard);
?>


<?php




?>




<!------------------------------------------------------------------------------------->

<p class="screen red" > 
<?php if(!$is_locked): ?>
	Q<?php echo $qtr; ?> - NOT FINALIZED !
<?php endif; ?>
	<?php spacer(5); ?>
	<?php if($hidegenave): ?>
		<a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr"; ?>'>Show Genave</a>
	<?php else: ?>	
		<a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr?hidegenave"; ?>'>Hide Genave</a>
	<?php endif; ?>	
</p>


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

?>



<div class="page clear center card" > <!-- student start -->



<div class="center" > 
	<br />
	<br />
	<br />
	<table class="no-gis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr>
			<td class="vc20"></td>
			<td rowspan="1" class="center" >
				<span class="tf10 b" >DepEd Form 138-E</span><br />
				<img src='<?php echo $logo_src; ?>' alt="logo" height="96" width="96">
			</td>
			<td class="" >
				
					<span class="b f11" >Republic of the Philippines</span><br />
					<span class="b f11" >Department of Education</span><br />
					<span class="b f22" >St. Joseph School of Pandacan</span><br />
					<span class="f18" >Pandacan, Manila</span><br /><br />
					<span class="f18" >PAASCU</span> <span class="i" >Accredited</span><br />
					<span class="f14" ><?php echo $sy.' - '.$nsy; ?></span>
			
			</td>
			<td class="vc100" >&nbsp;</td>
		</tr>
	</table>
	
</div>



<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>

<div class="center full" >

<table class="no-gis-table-bordered-print <?php echo $subfont.' '.$tblwidth; ?>" >

	<tr>
		<td class="" >Name</td><td><?php echo $student['student']; ?></td>
	</tr>
	
	<tr>
		<td class="" >Level</td><td class="" ><?php echo $classroom['level']; ?>
		<?php spacer(10); ?>
		<?php echo 'Section'; spacer(8); echo $classroom['section']; ?></td>		
	</tr>

	<tr>
		<td class="" >Gender</td><td><?php echo ($student['is_male'])?'Male':'Female'; ?></td>
	</tr>
	
	<tr>
		<td class="" >Adviser</td><td><?php echo $classroom['adviser']; ?></td>
	</tr>
</table><br />

<table class="gis-table-bordered-print table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " >

<tr class="" ><th rowspan="2" class="<?php echo $subwidth; ?>" >LEARNING<br />AREAS</th>
<th colspan="4" >QUARTER</th>

	<th rowspan="2" >FINAL<br />GRADE</th>
	<th rowspan="2" >REMARKS</th>

</tr>

<tr class="" ><th>1st</th><th>2nd</th>
<th>3rd</th><th>4th</th></tr>

<!-------------------------------------------------------------------------->



<?php $etcgrades = array(); ?>
<?php for($g=0;$g<$num_subjects;$g++): ?>
<?php if($g<$numacad): ?>


<?php $alert = $grades[$g]['teacher'].' | GID:'.$grades[$g]['gid'].' | CRS: '.$grades[$g]['course_id'];  ?>
<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>
<?php $apo 		= ($grades[$g]['is_apo']==1)? true:false; ?>

<tr class="" ><td class="left <?php echo ($child)? $childfont:NULL; ?> " id="<?php echo $alert; ?>" 
	ondblclick="alert(this.id);" >
	<?php 
		if($child){
			for($s=0;$s<$grades[$g]['indent'];$s++){
				echo '&nbsp;';
			}			
		}

	
	?>
	<?php echo $grades[$g]['subject']; ?>
	
</td>
	<td><?php $g1 = ($grades[$g]['q1'] != 0)? number_format($grades[$g]['q1'],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($grades[$g]['q2'] != 0)? number_format($grades[$g]['q2'],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php $g3 = ($grades[$g]['q3'] != 0)? number_format($grades[$g]['q3'],$decicard) : ''; echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php $g4 = ($grades[$g]['q4'] != 0)? number_format($grades[$g]['q4'],$decicard) : ''; echo ($qtr>3 )? $g4:NULL; ?></td>
	<td><?php $g5 = ($grades[$g]['q5'] != 0)? number_format($grades[$g]['q5'],$decicard) : ''; echo ($qtr>3 )? $g5:NULL; ?></td>
	<td><?php $pf = (number_format($grades[$g]['q5'],$decicard)<$passing)?'Failed':'Passed'; echo ($qtr>3)? $pf:NULL; ?></td>	
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp; </td><td></td><td></td><td></td><td></td>
		<td></td><td></td>
</tr>
<?php endif; ?>	
<?php endfor; ?>


<?php foreach($etcgrades as $grade): ?>
<tr class="" >
	<td class="left" ><?php echo $grade['subject']; ?></td>

	<td><?php $g1 = ($grade['q1'] != 0)? number_format($grade['q1'],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($grade['q2'] != 0)? number_format($grade['q2'],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php $g3 = ($grade['q3'] != 0)? number_format($grade['q3'],$decicard) : ''; echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php $g4 = ($grade['q4'] != 0)? number_format($grade['q4'],$decicard) : ''; echo ($qtr>3 )? $g4:NULL; ?></td>
	<td><?php $g5 = ($grade['q5'] != 0)? number_format($grade['q5'],$decicard) : ''; echo ($qtr>3 )? $g5:NULL; ?></td>
	<td><?php echo (number_format($grades[$g]['q5'],$decicard)<$passing)?'Failed':'Passed'; ?></td>		
</tr>
<?php endforeach; ?>

<?php if(!$hidegenave): ?>
<tr class="" >
	<th class="left" >GENERAL AVERAGE</th>
	<th><?php $s1 = number_format($students[$i]['summary']['ave_q1'],$decifgenave); echo $s1; ?></th>
	<th><?php $s2 = number_format($students[$i]['summary']['ave_q2'],$decifgenave); echo ($qtr>1 )? $s2:NULL; ?></th>
	<th><?php $s3 = number_format($students[$i]['summary']['ave_q3'],$decifgenave); echo ($qtr>2 )? $s3:NULL; ?></th>
	<th><?php $s4 = number_format($students[$i]['summary']['ave_q4'],$decifgenave); echo ($qtr>3 )? $s4:NULL; ?></th>
	<th><?php $s5 = number_format($students[$i]['summary']['ave_q5'],$decifgenave); echo ($qtr>3 )? $s5:NULL; ?></th>
	<th><?php $spf = (number_format($students[$i]['summary']['ave_q5'],$decifgenave)<$passing)?'Failed':'Passed'; echo ($qtr>3 )? $spf:NULL; ?></th>	
</tr>
<?php endif; ?>	<!-- if showgenave -->

</table>


<br />
<table class="gis-table-bordered-print table-center table-vcenter <?php echo $legendfont.' '.$tblsubwidth; ?>" >
	<tr class="" ><th class="vc200 b center"> LEVEL OF PROFICIENCY </th>
	<th class="vc200 center" > RANGE OF NUMERICAL GRADE</th>
	<th class="vc150 center" > REMARKS </th></tr>
	<?php foreach($legendcrs AS $row): ?>
		<tr>
			<td><?php echo $row['description']; ?></td>
			<td><?php echo round($row['grade_floor']).' - '.floor($row['grade_ceiling']).'%'; ?>
			<td><?php echo $row['remarks']; ?></td>			
		</tr>
	<?php endforeach; ?>
</table>

<br />
<!---------------------------------------------------------------------------------------------------->



<?php 	$attendance = $students[$i]['attendance'];  ?>


<table class="gis-table-bordered-print table-center table-vcenter <?php echo $attfont.' '.$tblwidth; ?>" >	
<tr class="padding02 <?php echo $attheadrowfont; ?>" > 
	<th class="vc150" >&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th class="" ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
	<?php if($qtr>3): ?><th>Total</th><?php endif; ?>	
</tr>

<tr>
	<th class="" >Days of School</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>		
		<?php $month_code = $data['month_names'][$k]['code']; ?>		
			<td><?php $attdt = $data['months'][$month_code.'_days_total']+0; echo $attdt; ?> </td>		
		<?php endfor; ?>
	<?php if($qtr>3): ?><td><?php echo ($months['year_days_total']+0); ?> </td><?php endif; ?>					
</tr>


<tr class="no-padding" >
	<th class="" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<?php $attdp = $attendance[$month_code.'_days_present']+0; ?>
		<td><?php echo $attdp; ?></td>
	<?php endfor; ?>	
	<?php if($qtr>3): ?><td><?php $attdp = $attendance['total_days_present']+0; echo $attdp; ?> </td><?php endif; ?>	
</tr>

<tr>
	<th class="" >Times Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php $attdl = $attendance[$month_code.'_days_tardy']+0; echo $attdl; ?></td>
	<?php endfor; ?>	
	<?php if($qtr>3): ?><td><?php $attdl = $attendance['total_days_tardy']+0; echo $attdl; ?> </td><?php endif; ?>	
</tr>	
</table>



<div class="vc800 clear" ></div>




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


