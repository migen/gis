<style>

.tbp th, .tbp td  { padding:1px 2px;}


</style>





<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" >
<th style="width:300px;text-align:left;" class="" >Core Subject</th>
<th><?php echo "1st"; ?></th>
<th><?php echo "2nd"; ?></th>
<th class="" >Final Grade</th>
<th class="" >Action Taken</th>
</tr>


<?php 



$failedsub = ""; 
$applgrades = array(); 	/* applied */
$specgrades = array(); 	/* specialized */
for($g=0;$g<$numacad;$g++): 
$child=($grades[$g]['supsubject_id']>0)? true:false; 

if($grades[$g]['position']>200){
	$specgrades[] = $grades[$g];
	continue;
} 

if($grades[$g]['position']>100){
	$applgrades[] = $grades[$g];
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


<?php if(count($applgrades)>0): ?>
	<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
	<!-- applied subjects -->
	<tr><th colspan="5" style="text-align:left;" >Applied Subject </th></tr>
<?php endif; ?>


<?php $num_applgrades = count($applgrades); ?>
<?php for($ig=0;$ig<$num_applgrades;$ig++): ?>
<tr>
	<td style="text-align:left;" ><?php echo $applgrades[$ig]['subject']; // pr($sgrades[$ig]);  ?></td>	
<?php if($applgrades[$ig]['is_num']): ?>	
	<td><?php $g1 = ($applgrades[$ig][$sq1] != 0)? number_format($applgrades[$ig][$sq1],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($applgrades[$ig][$sq2] != 0)? number_format($applgrades[$ig][$sq2],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=number_format($applgrades[$ig]['q'.$fqtr],$deciave); echo $fg; } ?></td>
	<td><?php if(!$qodd){ $pf=($fg<75)?'Failed':'Passed'; echo $pf; } ?></td>
<?php else: ?>	
	<td><?php $sg1 = $applgrades[$ig]['dg'.$dsq1]; echo $sg1; ?></td>
	<td><?php $sg2 = $applgrades[$ig]['dg'.$dsq2];  echo (!$qodd)? $sg2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=$applgrades[$ig]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>						
<?php endif; ?>
</tr>
<?php endfor; ?>
<!-- applied subjects -->
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>

<!-- specialized subjects -->
<tr><th colspan="5" style="text-align:left;" >Specialized Subject</th></tr>
<?php $num_specgrades = count($specgrades); ?>
<?php for($ig=0;$ig<$num_specgrades;$ig++): ?>
<tr>
	<td style="text-align:left;" ><?php echo $specgrades[$ig]['subject']; // pr($sgrades[$ig]);  ?></td>	
<?php if($specgrades[$ig]['is_num']): ?>	
	<td><?php $g1 = ($specgrades[$ig][$sq1] != 0)? number_format($specgrades[$ig][$sq1],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($specgrades[$ig][$sq2] != 0)? number_format($specgrades[$ig][$sq2],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=number_format($specgrades[$ig]['q'.$fqtr],$deciave); echo $fg; } ?></td>
	<td><?php if(!$qodd){ $pf=($fg<75)?'Failed':'Passed'; echo $pf; } ?></td>
<?php else: ?>	
	<td><?php $sg1 = $specgrades[$ig]['dg'.$dsq1]; echo $sg1; ?></td>
	<td><?php $sg2 = $specgrades[$ig]['dg'.$dsq2];  echo (!$qodd)? $sg2:NULL; ?></td>
	<td><?php if(!$qodd){ $fg=$specgrades[$ig]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>						
<?php endif; ?>
</tr>
<?php endfor; ?>
<!-- specialized subjects -->
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>

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
