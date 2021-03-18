<?php 
// sasm
$level_id = $classroom['level_id'];


// pr($classroom);
// pr($data);
// pr($students[0]);


// pr($levelnow);
// pr($levelnxt);

if($level_id==13){
	// echo " Rcard g10 exit; ";
	include_once('rcard_g10.php');
	exit;

}


?>


<style>
	@media print{@page {size: portrait;}}
	table.vc700{width:600px;}
	.vc180{width:180px;}

#watermark {
  color: #d0d0d0;
  font-size: 60pt;
  position: absolute;
  width: 100%;
  height: 100%;
  margin: 0;
  z-index: -1;
  left:650px;
  top:500px;
}
	
div.card{ margin-right:20px; }
table{ table-layout: fixed; } 
	
.gis-table-bordered-print { border: 1px solid #dddddd; border-left: 0; border-top: 0; }
.gis-table-bordered-print th, .gis-table-bordered-print td  { border-left: 1px solid #dddddd;  
border-top: 1px solid #dddddd; padding:1px 3px; color:;}
.gis-table-bordered-print th {color:#181818; }


hr.broken{
	background-color:#fff;
	border:#000 3px dotted;
	border-style: none none dotted;
	color:#fff;
	width:100%;
}

div#cutout{

}

	
</style>


<?php 

$num_subjects = ($_SESSION['settings']['num_subjects']+1);
$qtr_fg 	  = (4-1);

$tblwidth = "vc700";
$tblsubwidth = "vc500";
$subwidth = "vc200";
$subfont = "tf16";
$childfont = "tf16";
$blankfont = "tf16";
$legendfont = "tf14";
$attfont = "tf16";
$headrowfont = "tf16";
$attheadrowfont = "tf14";
$docfont = "tf14";
$headerfont = "tf18";
$headfont = "tf16";
$footfont = "tf12";



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
$deciave     = $_SESSION['settings']['deciave'];
$decigenave     = $_SESSION['settings']['decigenave'];
$decifgenave    = $_SESSION['settings']['decifgenave'];


?>


<?php


// pr($students[0]);

?>




<!------------------------------------------------------------------------------------->

<?php if(!$is_locked): ?>
<p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p>
<?php endif; ?>



<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

?>

<div id="watermark" ><?php echo ($student['is_active']==2)? 'Transferred':'Dropped'; ?></div>


<div class="page clear center card" > <!-- student start -->



<div class="center" > 
	<br />
	<br />
	<br />
	<table class="no-gis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr>
			<td class="vc100 right" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></td>
			<td>
				<span class="b f20" >ST. ANTHONY SCHOOL</span><br />
				<span class="" >Singalong, Manila</span><br />
				<span class="" >PAASCU</span> <span class="i" >Accredited</span><br />
				<span class="" ><?php echo $classroom['department']; ?><br /></span>				
				<span class="f20 b" >PROGRESS REPORT CARD</span>				
			</td>
			<td class="vc100 left" ><span class="f10" >FORM 138</span></td>
		</tr>
	</table>
	
</div>



<div class="<?php echo $tblwidth; ?> clear" ><hr /></div>

<div class="center full" >

<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr><td class="center" colspan="5" class=''><?php echo $student['student']; ?> </td></tr>
</table>

<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr>
		<td class="vc100" >LRN</td><td class="" ><?php echo $student['lrn']; ?></td>
		<td class="vc30" >&nbsp;</td>		
		<td class="" ></td><td class="" ></td>		
	</tr>
	
	<tr>
		<td class="vc100" >ID Number</td><td class="" ><?php echo $student['student_code']; ?></td>
		<td class="vc30" >&nbsp;</td>		
		<td class="" >School Year</td><td class="" ><?php echo $sy.' - '.$nsy; ?></td>		
	</tr>

	<tr>
		<td class="" >Grade/Level</td><td class="" ><?php echo $classroom['level']; ?></td>
		<td class="" ></td>	
		<td class="" >Section</td><td class="" ><?php echo $classroom['section']; ?></td>		
	</tr>

</table>

<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr>
		<td class="vc100" >Adviser</td><td colspan="4" ><?php echo $classroom['adviser']; ?></td>
	</tr>
</table>

<br />

<table class="gis-table-bordered-print table-center table-vcenter 
	<?php echo $subfont.' '.$tblwidth; ?> " style="border-top:4px solid black; " >

<tr class="<?php echo $headrowfont; ?>" ><th class="<?php echo $subwidth; ?>" >SUBJECTS</th><th>1st</th><th>2nd</th>
<th>3rd</th><th>4th</th>
<th class="vc60" >FINAL</th>
</tr>


<!-------------------------------------------------------------------------->



<?php $etcgrades = array(); ?>
<?php $failedsub = ""; ?>
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
	<td><?php $g5 = ($grades[$g]['q5'] != 0)? number_format($grades[$g]['q5'],$deciave) : ''; echo ($qtr>3 )? $g5:NULL; ?></td>
	
	
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td>
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
</tr>
<?php endforeach; ?>

<tr class="<?php echo $blankfont; ?>" > <td></td><td></td><td></td><td></td><td></td>
		<td></td>
</tr>
<tr class="" >
	<th class="left" >GENERAL AVERAGE</th>
	<th><?php $s1 = number_format($students[$i]['summary']['ave_q1'],$decifgenave); echo $s1; ?></th>
	<th><?php $s2 = number_format($students[$i]['summary']['ave_q2'],$decifgenave); echo ($qtr>1 )? $s2:NULL; ?></th>
	<th><?php $s3 = number_format($students[$i]['summary']['ave_q3'],$decifgenave); echo ($qtr>2 )? $s3:NULL; ?></th>
	<th><?php $s4 = number_format($students[$i]['summary']['ave_q4'],$decifgenave); echo ($qtr>3 )? $s4:NULL; ?></th>
	<th><?php $s5 = number_format($students[$i]['summary']['ave_q5'],$decifgenave); echo ($qtr>3 )? $s5:NULL; ?></th>
</tr>
</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>


<!---------------------------------------------------------------------------------------------------->



<?php 	$attendance = $students[$i]['attendance'];  ?>

<?php // pr($data['months']); ?>

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


<div id="cutout" class="center" >

<?php if($qtr<4): ?>	<!-- if qtr<4 -->
<div class="clear <?php echo $tblwidth; ?> clear" > <hr class="broken" /> </div>
<table  class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="left f12" ><td colspan="2" >I hereby acknowledge that I have received and read 
the QUARTERLY REPORT CARD of my son / daughter.
</td></tr>

<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="center" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Signature over printed name<span class="vc10"> &nbsp; </span> </td>
	<td>Date</td>
</tr>

</table>

<?php else: ?>	<!-- if qtr<4 -->
<table class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="left tf12" ><td class="left" colspan="2" >Lacks units in: <?php echo rtrim($failedsub,', '); ?> </td></tr>
<?php 
	
?>

<tr><td colspan="2" >
<?php if(empty($failedsub)): ?>	<!-- promotion failedsub -->
	Eligible for transfer and admission to <span class="u" ><?php echo $levelnxt; ?></span>
<?php else: ?>	<!-- promotion failedsub -->
	Retained in <span class="u" ><?php echo $levelnow; ?></span> 
<?php endif; ?>	<!-- promotion failedsub -->
Date Issued: <span class="u" ><?php $issued = $_SESSION['settings']['rcard_issued']; 
	echo date('F d, Y',strtotime($issued)); ?></span></td></tr>
<tr><th colspan="2" >&nbsp;</th></tr>
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
<?php endif; ?>	<!-- if qtr<4 -->
</div>	<!-- cutout -->





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


