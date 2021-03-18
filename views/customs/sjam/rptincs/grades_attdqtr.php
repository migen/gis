

<?php 	

$attendance = $students[$i]['attendance'];  

?>


<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th><div class="vc300" >SUBJECTS</div></th>
	<th><div class="colQtr" >1st</div></th><th><div class="colQtr" >2nd</div></th><th><div class="colQtr" >3rd</div></th>
	<th><div class="colQtr" >4th</div></th><th class="vc60" >FINAL</th>
</tr>


<?php $failedsub = ""; ?>
<?php for($g=0;$g<$numacad;$g++): ?>
<?php if($g<$numacad): ?>

<?php 
	$child=($grades[$g]['supsubject_id']>0)? true:false; 
	$indent=$grades[$g]['indent'];	
?>

<tr class="" >
<td style="<?php echo ($child)? 'padding-left:'.$indent.'px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>
</td>


<?php if($grades[$g]['is_num']==1): ?>
	<?php 
		$g1=($grades[$g]['q1']!=0)? number_format($grades[$g]['q1'],$decicard):''; 
		$g2=($grades[$g]['q2']!=0)? number_format($grades[$g]['q2'],$decicard):''; 
		$g3=($grades[$g]['q3']!=0)? number_format($grades[$g]['q3'],$decicard):''; 
		$g4=($grades[$g]['q4']!=0)? number_format($grades[$g]['q4'],$decicard):''; 
		$g5=($grades[$g]['q5']!=0)? number_format($grades[$g]['q5'],$deciave):'';		
	?>
	<td><?php echo $g1; ?></td>			
	<td><?php echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php echo ($qtr>3 && $g4>0)? $g4:NULL; ?></td>
	<td><?php echo ($qtr>3 && $g5>0)? $g5:NULL; ?></td>
	
<?php else: ?>
	<td><?php echo $grades[$g]['dg1']; ?></td>
	<td><?php echo ($qtr>1)? $grades[$g]['dg2']:NULL; ?></td>
	<td><?php echo ($qtr>2)? $grades[$g]['dg3']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $grades[$g]['dg4']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $grades[$g]['dg5']:NULL; ?></td>
<?php endif; ?>
	
	
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
<?php endif; ?>	
<?php endfor; ?>



<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
<tr class="" >
	<th style="text-align:left;" >GENERAL AVERAGE</th>
	<th><?php $s1 = number_format($students[$i]['summary']['ave_q1'],$decigenave);  ?></th>
	<th><?php $s2 = number_format($students[$i]['summary']['ave_q2'],$decigenave);  ?></th>
	<th><?php $s3 = number_format($students[$i]['summary']['ave_q3'],$decigenave);  ?></th>
	<th><?php $s4 = number_format($students[$i]['summary']['ave_q4'],$decigenave);  ?></th>
	<th><?php $s5 = number_format($students[$i]['summary']['ave_q5'],$decigenave); echo ($qtr>3 )? $s5:NULL; ?></th>

</tr>

<tr><th style="text-align:left;" >Number of School Days</th>
<td><?php echo ($months['q1_days_total']+0); ?></td>
<td><?php echo ($qtr>1)? ($months['q2_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($months['q3_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($months['q4_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($months['year_days_total']+0):NULL; ?></td>
</tr>

<tr><th style="text-align:left;" >Days Present</th>
<td><?php echo ($attendance['q1_days_present']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['total_days_present']+0):NULL; ?></td>
</tr>

<tr><th style="text-align:left;" >Times Tardy</th>
<td><?php echo ($attendance['q1_days_tardy']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['total_days_tardy']+0):NULL; ?></td>
</tr>



</table>


<?php if($qtr<4): ?>
	<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont; ?>" >
		<tr class="left" ><td class="" colspan="2" >NOT VALID AS TRANSFER CREDENTIAL</td></tr>
	</table>
<?php endif; ?>
