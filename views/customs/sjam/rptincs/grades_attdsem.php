<?php 
// pr($grades[13]); 

$attendance = $students[$i]['attendance'];  
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


<tr><td class="left b" >Number of School Days</td>
<td><?php echo ($months['q1_days_total']+0)+($months['q2_days_total']+0); ?></td>
<td><?php echo ($qtr>3)? ($months['q3_days_total']+0)+($months['q4_days_total']+0):NULL; ?></td>
</tr>

<tr><th class="left" >Days Present</th>
<td><?php echo ($attdsp1+0); ?></td>
<td><?php echo ($qtr>3)? ($attdsp2+0):NULL; ?></td>
</tr>

<tr><th class="left" >Times Tardy</th>
<td><?php echo ($attdst1+0); ?></td>
<td><?php echo ($qtr>3)? ($attdst2+0):NULL; ?></td>
</tr>


</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

