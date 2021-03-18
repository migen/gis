
<!-- spas -->

<?php 

$q1months = array('jun','jul','aug');
$q2months = array('jun','jul','aug','sep','oct');
$q3months = array('jun','jul','aug','sep','oct','nov','dec');
$q4months = array('jun','jul','aug','sep','oct','nov','dec','jan','feb','mar');

$num_subjects = ($_SESSION['settings']['num_subjects']+1);
$num_legendtr 	= count($legendctr);
$num_legendcrs  = count($legendcrs);

$qtr_fg 	  = (4-1);
$qodd = ($qtr%2);
$level_shs = '13';  /* 14 is senior high school 1 */

$tblwidth = "vc470";
$tblrtwidth = "vc400";
$subwidth = "vc200";

$subfont = "tf11";
$childfont = "tf10";
$blankfont = "tf12";
$promofont = "tf11";
$avefont = "tf12";
$legendfont = "tf10";
$headfont = "tf12 bold";
$headrowfont = "tf12";
$attheadrowfont = "tf10";


$logo_src = URL."public/images/weblogo_{$sch}.png";

$decietc = '2';
$decietcave = '3';

$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";


?>

<h5 class="screen" >
	SHS REPORT CARD
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid; ?>">Matrix</a>

	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr/$half"; ?>'>Semestral</a>
	<?php include_once('incs/tpl_filter.php'); ?>
	
</h5>



<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />

<?php $traits = true; ?>

<style>

table{
    table-layout: fixed;
} 

div.rcard{
	width:1000px;
	min-height:500px;
	
}

	<?php if($traits): ?> @media print{@page{size:landscape}} <?php endif; ?>

@media print{
	.screen, #sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:8pt;}	
}



	
</style>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	// hd();

})

</script>


<?php 
/*  armcontroller-gradebook */
// pr($classroom);


$passing        = $_SESSION['settings']['passing_grade'];
$rcardteac      = $_SESSION['settings']['rcardteac'];
$deciatt    	= $_SESSION['settings']['deciatt'];
$deciave    	= $_SESSION['settings']['deciave'];
$decicard       = $_SESSION['settings']['decicard'];
$deciranks      = $_SESSION['settings']['deciranks'];
$deciconducts   = $_SESSION['settings']['deciconducts'];
$decifconducts  = $_SESSION['settings']['decifconducts'];
$decigenave     = $_SESSION['settings']['decigenave'];
$decifgenave    = $_SESSION['settings']['decifgenave'];



?>





<!------------------------------------------------------------------------------------->


<?php


for($i=0;$i<$num_students;$i++): 
	$student = $students[$i];
	$grades  = $students[$i]['grades'];
	ob_start();	

?>

<div class="clear rcard" > <!-- student start -->




<div class="clear" > &nbsp; </div>

<div class="rcardhalf" >
<table class="gis-table-bordered-no-print tf12 <?php echo $tblwidth; ?>" >
	<tr>
		<th><?php echo $student['student']; ?></th>
		<td><?php echo $student['lrn']; ?></td>
		<td><?php echo $classroom['name']; ?></td>	
	</tr>
</table>


<?php 
	$incs = 'incs/guardian.php';
	include_once($incs);
?>
</div>

<div class="rcardhalf" >

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $headfont.' '.$tblwidth; ?>" >	
	<tr><td class="b" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

<table class="clear gis-table-bordered-print table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " >
<tr class="<?php echo $headrowfont; ?>" >
	<th rowspan="2" class="<?php echo $subwidth; ?>" >Learning Areas</th>
	<th colspan="4">Quarter</th>
	<?php if($qtr>$qtr_fg): ?>
		<th rowspan="2" >FG</th>
		<th rowspan="2" class="f9" >Action</th>
	<?php endif; ?>	
</tr>

<tr class="<?php echo $headrowfont; ?>" >
	<th class="vc60" >1</th>
	<th class="vc60" >2</th>
	<th class="vc60" >3</th>
	<th class="vc60" >4</th>
</tr>
<!--------------------------------------------------------------------------------------------------->


<?php $cngrades = array(); ?>
<?php for($g=0;$g<$num_subjects;$g++): ?>
<?php if($g<$numacad): ?>

<?php $alert = $grades[$g]['teacher'].' | GID:'.$grades[$g]['gid'].' | CRS: '.$grades[$g]['course_id'];  ?>
<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>
<?php $apo 		= ($grades[$g]['is_apo']==1)? true:false; ?>


<tr class="" >
<td style="<?php echo ($child)? 'font-size:9px;':NULL; ?>" class="left <?php echo $subwidth; ?>" 
	id="<?php echo $alert; ?>" ondblclick="alert(this.id);" >
	<?php 
		if($child){
			for($s=0;$s<$grades[$g]['indent'];$s++){ echo '&nbsp;'; }			
		}	
		echo $grades[$g]['subject']; ?>
	
</td>

<?php
	$is_numeric = ($grades[$g]['is_num']);
	if($is_numeric): 
?>	
	<td><?php $g1 = ($grades[$g]['q1'] != 0)? number_format($grades[$g]['q1'],$decicard) : ' ' ; echo $g1; ?></td>
	<td><?php $g2 = ($grades[$g]['q2'] != 0)? number_format($grades[$g]['q2'],$decicard) : ' ' ; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php $g3 = ($grades[$g]['q3'] != 0)? number_format($grades[$g]['q3'],$decicard) : ' ' ; echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php $g4 = ($grades[$g]['q4'] != 0)? number_format($grades[$g]['q4'],$decicard) : ' ' ; echo ($qtr>3 )? $g4:NULL; ?></td>
	<?php if($qtr>$qtr_fg): ?>
		<td><?php $fg = ($grades[$g]['q5'] > 0)? number_format($grades[$g]['q5'],$decigenave) : NULL; echo $fg; ?></td>		
		<td class="f9" ><?php echo ($grades[$g]['q5']<$passing)?'Failed':'Passed'; ?></td>	
	<?php endif; ?>
<?php else: ?>	
	<td><?php $g1 = $grades[$g]['dg1']; echo $g1; ?></td>
	<td><?php $g2 = $grades[$g]['dg2']; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php $g3 = $grades[$g]['dg3']; echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php $g4 = $grades[$g]['dg4']; echo ($qtr>3 )? $g4:NULL; ?></td>
	<?php if($qtr>$qtr_fg): ?>
		<td><?php $fg = ($grades[$g]['q5'] > 0)? number_format($grades[$g]['q5'],$decigenave) : NULL; echo $fg; ?></td>		
		<td class="f9" ><?php echo ($grades[$g]['q5']<$passing)?'Failed':'Passed'; ?></td>	
	<?php endif; ?>
<?php endif; ?>	
	
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp; </td><td></td><td></td><td></td><td></td>
	<?php if($qtr>$qtr_fg): ?>
		<td></td><td></td>
	<?php endif; ?>
</tr>


<?php endif; ?>	

<?php endfor; ?>

<tr> <td>&nbsp; </td><td></td><td></td><td></td><td></td>
	<?php if($qtr>$qtr_fg): ?>
		<td></td><td></td>
	<?php endif; ?>
 </tr>

<!--------------------------------------------------------------------------------------------------->
<tr class="<?php echo $avefont; ?>" >
	<th class="left" >Average</th>
	<th><?php echo number_format($students[$i]['summary']['ave_q1'],$decifgenave); ?></th>
	<th><?php echo ($qtr>=2)? number_format($students[$i]['summary']['ave_q2'],$decifgenave):NULL; ?></th>
	<th><?php echo ($qtr>=3)? number_format($students[$i]['summary']['ave_q3'],$decifgenave):NULL; ?></th>
	<th><?php echo ($qtr>=4)? number_format($students[$i]['summary']['ave_q4'],$decifgenave):NULL; ?></th>
	<?php if($qtr>$qtr_fg): ?>	
		<th><?php echo number_format($students[$i]['summary']['ave_q5'],$decifgenave); ?></th>
		<th class="f10" ><?php echo ($students[$i]['summary']['ave_q5']<$passing)?'Failed':'Passed'; ?></th>	
	<?php endif; ?>
</tr>

<tr class="<?php echo $avefont; ?>" >
	<th class="left" >Class Rank</th>
	<th><?php $r1 = $students[$i]['summary']['rank_classroom_q1']+0; echo $r1; ?></th>
	<th><?php $r2 = $students[$i]['summary']['rank_classroom_q2']+0; echo ($qtr>1)? $r2:NULL; ?></th>
	<th><?php $r3 = $students[$i]['summary']['rank_classroom_q3']+0; echo ($qtr>2)? $r3:NULL; ?></th>
	<th><?php $r4 = $students[$i]['summary']['rank_classroom_q4']+0; echo ($qtr>3)? $r4:NULL; ?></th>
	
	<?php if($qtr>$qtr_fg): ?>
		<th><?php $rf = $students[$i]['summary']['rank_classroom_q5']+0; echo ($qtr>3)? $rf:NULL; ?></th>
		<th>&nbsp;</th>	
	<?php endif; ?>
</tr>

</table>



<!---------------------------------------------------------------------------------------------------------------->


<br />
<table class="gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" style="float:left;" >
<tr class="b <?php  ?>"  ><th class="vc100 b">Grading Code</th><th class="vc100" >Scale</th></tr>
	<?php $last_legendcrs = $num_legendcrs-1; ?>
<?php for($l=0;$l<$num_legendcrs;$l++): ?>
	<tr>
		<td ><?php echo $legendcrs[$l]['rating']; ?></td>
		<td><?php echo round($legendcrs[$l]['grade_floor']).' - '.floor($legendcrs[$l]['grade_ceiling']).'%'; ?>
	</tr>			
<?php endfor; ?>	
		
</table>


<table class="gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" style="float:left;" >
<tr class="b <?php  ?>"  ><th class="vc100 b">Marking Code</th><th class="vc100" >Scale</th></tr>
	<?php $last_legendtr = $num_legendtr-1; ?>
<?php for($l=0;$l<$num_legendtr;$l++): ?>
	<tr>
		<td ><?php echo $legendctr[$l]['rating']; ?></td>
		<td><?php echo round($legendctr[$l]['grade_floor']).' - '.floor($legendctr[$l]['grade_ceiling']).'%'; ?>
	</tr>			
<?php endfor; ?>	
</table>


</div>	<!-- rcardhalfLeft-->




<!--------------------------- attendance ------------------------------------------>


<div class="fifty" >	<!-- divhalfright -->



<?php 
	$num_conducts = count($students[$i]['conducts']); 
	$conducts 	  = $students[$i]['conducts'];
	
?>


<table class="no-gis-table-bordered table-center table-vcenter <?php echo $headfont.' '.$tblrtwidth; ?>" >	
	<tr><td class="b" >CHRISTIAN ATTITUDES AND VALUES</td></tr>
</table>

<table class="gis-table-bordered-print table-center table-vcenter <?php echo $subfont.' '.$tblrtwidth; ?>" >

<tr class="<?php echo $headrowfont; ?>" >
<th class="vc200" rowspan="2"  ></th>
<th colspan="4" >Quarter</th></tr>
<tr class="<?php echo $headrowfont; ?>" >
<th>1</th><th>2</th><th>3</th><th>4</th></tr>


<?php for($ic=0;$ic<$num_conducts;$ic++): ?>
<tr>

	<td class="left" ><?php echo $conducts[$ic]['trait']; ?></td>
	<td><?php echo $conducts[$ic]['dg1']; ?></td>
	<td><?php echo $conducts[$ic]['dg2']; ?></td>
	<td><?php echo $conducts[$ic]['dg3']; ?></td>
	<td><?php echo $conducts[$ic]['dg4']; ?></td>
</tr>
<?php endfor; ?>
</tr>


</table>



<!---------------------------------------------------------------------->


<?php 	$attendance = $students[$i]['attendance'];  ?>
<table class="no-gis-table-bordered-print table-center table-vcenter <?php echo $headfont.' '.$tblrtwidth; ?>" >	
	<tr><td class="b" >ATTENDANCE REPORT</td></tr>
</table>

<table class="gis-table-bordered-print tf10 table-center table-vcenter <?php echo $tblrtwidth; ?>" >	
<tr class="padding02 <?php echo $attheadrowfont; ?>" > 
	<th class="vc100" >&nbsp;</th>	
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
			<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($data['months'][$month_code.'_days_total']) :''; ?></td>		
	<?php endfor; ?>
	<?php if($qtr>3): ?><td><?php echo ($months['year_days_total']+0); ?> </td><?php endif; ?>			
</tr>


<tr class="no-padding" >
	<th class="" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<?php $attdp = $attendance[$month_code.'_days_present']+0; ?>
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? $attdp:''; ?></td>
	<?php endfor; ?>	
	<?php if($qtr>3): ?><td><?php $attdp = $attendance['total_days_present']+0; echo $attdp; ?> </td><?php endif; ?>				
</tr>

<tr>
	<th class="" >Days Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($attendance[$month_code.'_days_tardy']):''; ?></td>
	<?php endfor; ?>	
	<?php if($qtr>3): ?><td><?php $attdl = $attendance['total_days_tardy']+0; echo $attdl; ?> </td><?php endif; ?>				
</tr>
</table>

<!---------------------------------------------------------------------->


<table class="no-gis-table-bordered <?php echo $promofont.' '.$tblrtwidth; ?>" >
<tr><td colspan="2" >&nbsp;</td></tr>
<tr>
	<td>Promoted to: _______________</td>
	<td>Retained in: _______________</td>
</tr>
<tr>
	<td></td>
	<td>Date Released: ____________</td>	
</tr>
</table>


<table class="no-gis-table-bordered <?php echo $promofont.' '.$tblrtwidth; ?>" >
<tr><td colspan="2" >&nbsp;</td></tr>

<tr class="" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>___________________________ </td>
</tr>
<tr class="center" >
	<td>Adviser<span class="vc30"> &nbsp; </span> </td>
	<td>Adviser</td>
</tr>
</table>

<table class="no-gis-table-bordered-print table-center table-vcenter <?php echo $headfont.' '.$tblrtwidth; ?>" >	
	<tr><td class="b" >CERTIFICATE OF TRANSFER</td></tr>
</table>

<table class="no-gis-table-bordered <?php echo $promofont.' '.$tblrtwidth; ?>" >
<tr>
	<td>Admitted to Grade: ________</td>
	<td>Section: _________ </td>
</tr>
<tr><td colspan="2" >Eligibility for Admission to Grade:____________</td></tr>
<tr>
	<td>Approved: </td>
	<td></td>	
</tr>
<tr class="" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Principal <span class="vc10"> &nbsp; </span> </td>
	<td>Teacher</td>
</tr>


</table>


<table class="no-gis-table-bordered <?php echo $promofont.' '.$tblrtwidth; ?>" >


<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="center" ><td colspan="2" >CANCELLATION OF ELIGIBILITY TO TRANSFER</td></tr>
<tr><td colspan="2" >&nbsp;</td></tr>
<tr class="center" ><td colspan="2" >Admitted in: ____________________________________</td></tr>

<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Principal <span class="vc10"> &nbsp; </span> </td>
	<td>Date</td>
</tr>

</table>

</div>	<!-- halfdiv right -->

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


