<?php 
// pr($grades[13]); 
// pr($subfont);



?>

<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th class="<?php echo $subwidth; ?>" >SUBJECTS</th><th>1st</th><th>2nd</th>
<th>3rd</th><th>4th</th>
	<th class="vc60" >FINAL</th>
	<th class="vc100 " >REMARKS</th>
</tr>


<?php $failedsub = ""; ?>
<?php for($g=0;$g<$numacad;$g++): ?>
<?php if($g<$numacad): ?>

<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>

<tr class="" >
<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>	
</td>

<?php if($grades[$g]['is_num']==1): ?>
	<td><?php $g1 = ($grades[$g]['q1'] != 0)? number_format($grades[$g]['q1'],$decicard) : ''; echo $g1; ?></td>			
	<td><?php $g2 = ($grades[$g]['q2'] != 0)? number_format($grades[$g]['q2'],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td><?php $g3 = ($grades[$g]['q3'] != 0)? number_format($grades[$g]['q3'],$decicard) : ''; echo ($qtr>2 )? $g3:NULL; ?></td>
	<td><?php $g4 = ($grades[$g]['q4'] != 0)? number_format($grades[$g]['q4'],$decicard) : ''; echo ($qtr>3 )? $g4:NULL; ?></td>
	<td><?php $g5 = ($grades[$g]['q5'] != 0)? number_format($grades[$g]['q5'],$deciave) : ''; echo ($qtr>3 )? $g5:NULL; ?></td>
	<?php 
		if($grades[$g]['q5']<$passing){
			$pf = "Failed";
			$failedsub .= $grades[$g]['subject'].", ";
		} else {
			$pf = "Passed";		
		}		
	?>		
	<td class="" ><?php echo ($qtr>3)? $pf:NULL; ?></td>	
	
<?php else: ?>
	<td><?php echo $grades[$g]['dg1']; ?></td>
	<td><?php echo ($qtr>1)? $grades[$g]['dg2']:NULL; ?></td>
	<td><?php echo ($qtr>2)? $grades[$g]['dg3']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $grades[$g]['dg4']:NULL; ?></td>
	<td><?php echo ($qtr>3)? $grades[$g]['dg5']:NULL; ?></td>
	<td></td>
<?php endif; ?>
	
	
</tr>

<?php else: ?>
<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td>
		<td></td><td class="" ></td>
</tr>
<?php endif; ?>	
<?php endfor; ?>



<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td><td></td>
		<td></td><td class="" ></td>
</tr>
<tr class="" >
	<th style="text-align:left;" >GENERAL AVERAGE</th>
	<th><?php $s1 = number_format($students[$i]['summary']['ave_q1'],$decifgenave); echo $s1; ?></th>
	<th><?php $s2 = number_format($students[$i]['summary']['ave_q2'],$decifgenave); echo ($qtr>1 )? $s2:NULL; ?></th>
	<th><?php $s3 = number_format($students[$i]['summary']['ave_q3'],$decifgenave); echo ($qtr>2 )? $s3:NULL; ?></th>
	<th><?php $s4 = number_format($students[$i]['summary']['ave_q4'],$decifgenave); echo ($qtr>3 )? $s4:NULL; ?></th>
	<th><?php $s5 = number_format($students[$i]['summary']['ave_q5'],$decifgenave); echo ($qtr>3 )? $s5:NULL; ?></th>
	<th class="" >
		<?php $spf = ($students[$i]['summary']['ave_q5']<$passing)?'Failed':'Passed'; echo ($qtr>3 )? $spf:NULL; ?></th>	
</tr>
</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

