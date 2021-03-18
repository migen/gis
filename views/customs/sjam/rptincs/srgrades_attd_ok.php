<style>

.tbp th, .tbp td  { padding:1px 2px;}


</style>





<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" >
<th style="width:300px;text-align:left;" class="" >Core Subjects</th>
<th><?php echo "1st"; ?></th>
<th><?php echo "2nd"; ?></th>
<th class="" >Final Grade</th>
<th class="" >Action Taken</th>
</tr>


<?php 

$failedsub = ""; 
$sgrades = array(); 	/* secondary */
for($g=0;$g<$numacad;$g++): 
$child=($grades[$g]['supsubject_id']>0)? true:false; 

if($grades[$g]['position']>100){
	$sgrades[] = $grades[$g];
	continue;
} 

?>


<?php $child=($grades[$g]['supsubject_id']>0)? true:false; ?>
<tr class="" >		
	<?php $indent=$grades[$g]['indent']; ?>
	<td style="padding-left:<?php echo ($child)? $indent:'5'; ?>px;text-align:left;" >
		<?php echo $grades[$g]['subject']; ?>
	</td>
		
<?php if($grades[$g]['is_num']): ?>	
	<td><?php $g1 = ($grades[$g][$sq1] != 0)? number_format($grades[$g][$sq1],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($grades[$g][$sq2] != 0)? number_format($grades[$g][$sq2],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=number_format($grades[$g]['q'.$fqtr],$deciave); echo $fg; } ?></td>
	<td><?php if(!$qodd){ $pf=($fg<75)?'Failed':'Passed'; echo $pf; } ?></td>
<?php else: ?>	
	<td><?php $sg1 = $grades[$g]['dg'.$dsq1]; echo $sg1; ?></td>
	<td><?php $sg2 = $grades[$g]['dg'.$dsq2];  echo (!$qodd)? $sg2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=$grades[$g]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>						
<?php endif; ?>
	
	
	
</tr>

<?php endfor; ?>

<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>

<!-- secondary specialized subjects -->
<tr><th colspan="5" style="text-align:left;" >Applied & Specialized Subjects</th></tr>

<?php $numsgrades = count($sgrades); ?>
<?php for($ig=0;$ig<$numsgrades;$ig++): ?>

<tr>
	<td style="text-align:left;" ><?php echo $sgrades[$ig]['subject']; // pr($sgrades[$ig]);  ?></td>	
<?php if($sgrades[$ig]['is_num']): ?>	
	<td><?php $g1 = ($sgrades[$ig][$sq1] != 0)? number_format($sgrades[$ig][$sq1],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($sgrades[$ig][$sq2] != 0)? number_format($sgrades[$ig][$sq2],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=number_format($sgrades[$ig]['q'.$fqtr],$deciave); echo $fg; } ?></td>
	<td><?php if(!$qodd){ $pf=($fg<75)?'Failed':'Passed'; echo $pf; } ?></td>
<?php else: ?>	
	<td><?php $sg1 = $sgrades[$ig]['dg'.$dsq1]; echo $sg1; ?></td>
	<td><?php $sg2 = $sgrades[$ig]['dg'.$dsq2];  echo (!$qodd)? $sg2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=$sgrades[$ig]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>						
<?php endif; ?>

</tr>

<?php endfor; ?>

<!-- secondary or specialized subjects -->
<tr class="<?php echo $blankfont; ?>" > <th colspan=1 style="text-align:left;" >General Average</th>
	<?php 
		$genave1=$student['summary']['ave_'.$sqa];
		$genave2=$student['summary']['ave_'.$sqb];
		$genave_sem=($genave1+$genave2)/2; 		
	?>
	<?php if(isset($_GET['showgenave'])): ?>
		<th><?php echo $genave1; ?></th>
		<th><?php echo $genave2; ?></th>
	<?php else: ?>
		<th></th><th></th>
	<?php endif; ?>
		
	<th><?php echo ($qtr%2)? '':number_format($genave_sem,$decigenave); // echo $student['summary']['ave_q'.$fqtr]; ?></th>
	<td></td>
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
	<th><div class="vc300" style="text-align:left;" >NUMBER OF SCHOOL DAYS</div></th>
	<td><?php echo ($months[$sqa.'_days_total']+0);  ; ?></td>
	<td><?php echo (!$odd)? ($months[$sqb.'_days_total']+0):NULL; ?></td>
	<th></th><td></td>
</tr>

<tr>
	<th style="text-align:left;" >Days Present</th>
	<td><?php echo ($attendance[$sqa.'_days_present']+0);  ; ?></td>
	<td><?php echo (!$odd)? ($attendance[$sqb.'_days_present']+0):NULL; ?></td>	
	<th></th><td></td>
</tr>

<tr>
	<th style="text-align:left;" >Times Tardy</th>
	<td><?php echo ($attendance[$sqa.'_days_tardy']+0);  ; ?></td>
	<td><?php echo (!$odd)? ($attendance[$sqb.'_days_tardy']+0):NULL; ?></td>
	<th></th><td></td>
</tr>




</table>

<?php if($qtr<4): ?>
	<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont; ?>" >
		<tr class="left" ><td class="" colspan="2" >NOT VALID AS TRANSFER CREDENTIAL</td></tr>
	</table>
<?php endif; ?>
