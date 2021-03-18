<style>

.tbp th, .tbp td  { padding:1px 2px;}


</style>


<?php 


$fqtr=($sem==1)? 5:6;

$odd=(($qtr%2)==1)? true:false;
if($qtr>2){
	$sqa="q3";$sqb="q4";
} else {
	$sqa="q1";$sqb="q2";
}



?>


<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th style="width:300px;" class="left" >Core Subjects</th>
<th><?php echo "1st"; ?></th>
<th><?php echo "2nd"; ?></th>
</tr>


<?php 

$failedsub = ""; 
for($g=0;$g<$numones;$g++): 
$child=($grades[$g]['supsubject_id']>0)? true:false; 

?>


<?php $child=($grades[$g]['supsubject_id']>0)? true:false; ?>
<tr class="" >		
	<?php $indent=$grades[$g]['indent']; ?>
	<td style="padding-left:<?php echo ($child)? $indent:'5'; ?>px;text-align:left;" >
		<?php echo $grades[$g]['subject']; ?>
	</td>
			
<?php if($grades[$g]['is_num']): ?>	
	<td><?php $g1=number_format($grades[$g]['q5'],$decicard); echo $g1; ?></td>
	<td></td>

<?php else: ?>	
	<td><?php $g1=$grades[$g]['dg5']; echo $g1; ?></td>
	<td></td>
	<td><?php if(!$qodd){ $fg=$grades[$g]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>						
<?php endif; ?>
		
</tr>

<?php endfor; ?>

<?php 

for($g=$numones;$g<$numgrades;$g++): 
$child=($grades[$g]['supsubject_id']>0)? true:false; 

?>


<?php $child=($grades[$g]['supsubject_id']>0)? true:false; ?>
<tr class="" >		
	<?php $indent=$grades[$g]['indent']; ?>
	<td style="padding-left:<?php echo ($child)? $indent:'5'; ?>px;text-align:left;" >
		<?php echo $grades[$g]['subject']; ?>
	</td>
			
<?php if($grades[$g]['is_num']): ?>	
	<td></td>
	<td><?php $g2=number_format($grades[$g]['q6'],$decicard); echo $g2; ?></td>
<?php else: ?>	
	<td></td>
	<td><?php $g2=$grades[$g]['dg6']; echo $g2; ?></td>

<?php endif; ?>
		
</tr>

<?php endfor; ?>


<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td></tr>



<!-- secondary or specialized subjects -->
<tr class="<?php echo $blankfont; ?>" > <th colspan=1 class="left" >General Average</th>
	<?php 
		$genave1=$student['summary']['ave_'.$sqa];
		$genave2=$student['summary']['ave_'.$sqb];
		$genave_sem=($genave1+$genave2)/2; 		
	?>
	<?php if(isset($_GET['showgenave'])): ?>
		<th><?php echo $genave1; ?></th>
		<th><?php echo $genave2; ?></th>
	<?php else: ?>
		</th>
	<?php endif; ?>
		
	<th><?php $genave_sem1=$student['summary']['ave_q5']; echo number_format($genave_sem1,$decigenave); ?></th>
	<th><?php $genave_sem2=$student['summary']['ave_q6']; echo number_format($genave_sem2,$decigenave); ?></th>
</tr>



<!-- attd attendance -->

<?php 
$attendance = $students[$i]['attendance'];  
/* student present */
$attdsp1=$attendance['q1_days_present']+$attendance['q2_days_present'];
$attdsp2=$attendance['q3_days_present']+$attendance['q4_days_present'];

/* student tardy */
$attdst1=$attendance['q1_days_tardy']+$attendance['q2_days_tardy'];
$attdst2=$attendance['q3_days_tardy']+$attendance['q4_days_tardy'];

?>
<tr class="<?php echo $headrowfont; ?>" >
	<th><div class="left vc300" >NUMBER OF SCHOOL DAYS</div></th>
	<td><?php $attd_total_sem1=$months['q1_days_total']+$months['q2_days_total']; 
		echo  $attd_total_sem1; ?></td>
	<td><?php $attd_total_sem2=$months['q3_days_total']+$months['q4_days_total']; 
		echo  $attd_total_sem2; ?></td>	
</tr>

<tr>
	<th class="left" >Days Present</th>
	<td><?php $attd_total_sem1=$attendance['q1_days_present']+$attendance['q2_days_present']; echo $attd_total_sem1; ?></td>	<td><?php $attd_total_sem2=$attendance['q3_days_present']+$attendance['q4_days_present']; echo $attd_total_sem2; ?></td>
		
</tr>

<tr>
	<th class="left" >Times Tardy</th>
	<td><?php $attd_total_sem1=$attendance['q1_days_tardy']+$attendance['q2_days_tardy']; echo $attd_total_sem1; ?></td>	
	<td><?php $attd_total_sem2=$attendance['q3_days_tardy']+$attendance['q4_days_tardy']; echo $attd_total_sem2; ?></td>
	
</tr>




</table>

<?php if($qtr<4): ?>
	<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont; ?>" >
		<tr class="left" ><td class="" colspan="2" >NOT VALID AS TRANSFER CREDENTIAL</td></tr>
	</table>
<?php endif; ?>

