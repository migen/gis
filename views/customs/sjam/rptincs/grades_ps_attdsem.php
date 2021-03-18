<?php 
// pr($grades[13]); 

$attendance = $students[$i]['attendance'];  
$summary = $students[$i]['summary'];  

/* student present */
$attdsp1=$attendance['q1_days_present']+$attendance['q2_days_present'];
$attdsp2=$attendance['q3_days_present']+$attendance['q4_days_present'];

/* student tardy */
$attdst1=$attendance['q1_days_tardy']+$attendance['q2_days_tardy'];
$attdst2=$attendance['q3_days_tardy']+$attendance['q4_days_tardy'];

?>



<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th class="<?php echo $subwidth; ?>" >SUBJECTS</th><th>1st</th><th>2nd</th></tr>


<?php $failedsub = ""; ?>
<?php for($g=0;$g<$numacad;$g++): ?>
<?php if($g<$numacad): ?>

<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>

<tr class="" >
<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>	
</td>

<?php if($grades[$g]['is_num']==1): ?>
	<td><?php $g5=($grades[$g]['q5']!=0)? number_format($grades[$g]['q5'],$decicard) : ''; echo $g5; ?></td>			
	<td><?php $g6=((number_format($grades[$g]['q3'],$decicard)+number_format($grades[$g]['q4'],$decicard))/2);
		echo ($qtr>3)? number_format($g6,$decicard):NULL; ?></td>	
<?php else: ?>
	<td><?php $dg5=&$grades[$g]['dg5']; echo $dg5; ?></td>			
	<td><?php $dg6=&$grades[$g]['dg6']; echo ($qtr>3)? $dg6:NULL; ?></td>			
<?php endif; ?>
		
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td>
		
</tr>
<?php endif; ?>	
<?php endfor; ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td>

</tr>

<?php if(isset($_GET['genave'])): ?>
	<tr><th style="text-align:left;" class="b" >GENERAL AVERAGE</th>
	<?php 
		$ave_q1=number_format($summary['ave_q1'],$decigenave);
		$ave_q2=number_format($summary['ave_q2'],$decigenave);
		$ave_q5=($ave_q1+$ave_q2)/2;
		
		$ave_q3=number_format($summary['ave_q3'],$decigenave);
		$ave_q4=number_format($summary['ave_q4'],$decigenave);
		$ave_q6=($ave_q3+$ave_q4)/2;
		
		
	 ?>
	<th><?php $ave_q5=number_format($ave_q5,$decigenave); echo ($qtr>1)? $ave_q5:NULL; ?></th>
	<th><?php $ave_q6=number_format($ave_q6,$decigenave); echo ($qtr>3)? $ave_q6:NULL; ?></th>
	</tr>
<?php endif; ?>

<tr><td style="text-align:left;" class="b" >Number of School Days</td>
<td><?php echo ($months['q1_days_total']+0)+($months['q2_days_total']+0); ?></td>
<td><?php echo ($qtr>3)? ($months['q3_days_total']+0)+($months['q4_days_total']+0):NULL; ?></td>
</tr>

<tr><th style="text-align:left;" >Days Present</th>
<td><?php echo ($attdsp1+0); ?></td>
<td><?php echo ($qtr>3)? ($attdsp2+0):NULL; ?></td>
</tr>

<tr><th style="text-align:left;" >Times Tardy</th>
<td><?php echo ($attdst1+0); ?></td>
<td><?php echo ($qtr>3)? ($attdst2+0):NULL; ?></td>
</tr>


</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

