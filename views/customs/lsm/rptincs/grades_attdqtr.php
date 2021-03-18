<?php 
// pr($grades);

$rowspan=$numacad+4;



?>

<?php 	$attendance = $students[$i]['attendance'];  ?>


<table style="font-size:1em;width:<?php echo $ftw; ?>;" class="no-gis-table-bordered center" >	
	<tr><td class="b" >GRADING SYSTEM: AVERAGING</td></tr>
</table>


<table style="font-size:0.9em;width:<?php echo $ftw; ?>;" class="gis-table-bordered-print tbp-left table-center table-vcenter" >
<tr>
	<th style="" class="left" >Subjects</th>
	<th style="width:<?php echo $qw; ?>;" >1</th>
	<th style="width:<?php echo $qw; ?>;" >2</th>
	<th style="width:<?php echo $qw; ?>;" >3</th>
	<th style="width:<?php echo $qw; ?>;" >4</th>		
	<th style="width:0.4in;" >Final</th>
	<th style="width:<?php echo $frw; ?>;font-size:0.8em;" >Action<br />Taken</th>
</tr>



<?php 

$lettergrades = array(); 
$numlg=0;
$child 	= ($grades[0]['supsubject_id']>0)? true:false; 

?>




<tr>
<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[0]['subject']; ?>
</td>

	<td><?php $g1 = ($grades[0]['q1'] != 0)? number_format($grades[0]['q1'],$decicard) : ' ' ; echo $g1; ?></td>
	<td><?php if($qtr>1){ echo number_format($grades[0]['q2'],$decicard); } ?></td>
	<td><?php if($qtr>2){ echo number_format($grades[0]['q3'],$decicard); } ?></td>
	<td><?php if($qtr>3){ echo number_format($grades[0]['q4'],$decicard); } ?></td>
	<td><?php if($qtr>3){ echo number_format($grades[0]['q5'],$deciave); } ?></td>

	<td style="font-size:1.2em;padding-right:10px;min-height:200px;" class="b" rowspan="<?php echo $rowspan; ?>" >
		<span class="vertical full" >
	<?php if($classroom['department_id']==3): ?>
		<?php 
			if($qtr>3){ 
			echo ($students[$i]['summary']['is_promoted']==1)?'Passed':'Failed';
			echo $students[$i]['summary']['promlevel']; } 
		?>	
	<?php else: ?>	
		<?php 
			if($qtr>3){ 
			echo ($students[$i]['summary']['is_promoted']==1)?'Promoted to ':'Retained in ';
			echo $students[$i]['summary']['promlevel']; } 
		?>	
	<?php endif; ?>	
		</span>
	</td>		
</tr>



<?php
for($g=1;$g<$numacad;$g++): 

$is_numeric = ($grades[$g]['is_num']); 
$inga = ($grades[$g]['in_genave']); 
$child 	= ($grades[$g]['supsubject_id']>0)? true:false; 


if(($inga!=1) && (!$child)){
	$numlg+=1;
	$lettergrades[] = $grades[$g];
	continue;
} 




?>


<tr>
<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>
</td>

	<td><?php $g1 = ($grades[$g]['q1'] != 0)? number_format($grades[$g]['q1'],$decicard) : ' ' ; echo $g1; ?></td>
	<td><?php if($qtr>1){ echo number_format($grades[$g]['q2'],$decicard); } ?></td>
	<td><?php if($qtr>2){ echo number_format($grades[$g]['q3'],$decicard); } ?></td>
	<td><?php if($qtr>3){ echo number_format($grades[$g]['q4'],$decicard); } ?></td>
	<td><?php if(($qtr>3) && ($grades[$g]['supsubject_id']<1)) { echo number_format($grades[$g]['q5'],$deciave); } // pr($grades[$g]); ?></td>
</tr>

<?php endfor; ?>

<tr class="" >
	<th class="left" >GENERAL AVERAGE</th>
	<th style="padding:0;" ><?php echo number_format($students[$i]['summary']['ave_q1'],$decifgenave); ?></th>
	<th style="padding:0;"><?php echo ($qtr>1)? number_format($students[$i]['summary']['ave_q2'],$decifgenave):NULL; ?>
	</th>
	<th style="padding:0;"><?php echo ($qtr>2)? number_format($students[$i]['summary']['ave_q3'],$decifgenave):NULL; ?>
	</th>
	<th style="padding:0;" ><?php echo ($qtr>3)? number_format($students[$i]['summary']['ave_q4'],$decifgenave):NULL; ?>
	</th>
	<th style="padding:0;"><?php echo ($qtr>3)? number_format($students[$i]['summary']['ave_q5'],$decifgenave):NULL; ?>
	</th>
		
</tr>


<?php for($g=0;$g<$numlg;$g++): ?>
<tr>
	<td style="width:<?php echo $subw; ?>;text-align:left;" ><?php echo $lettergrades[$g]['subject']; ?></td>
	<?php 
		$is_num=$lettergrades[$g]['is_num'];
		if(!$is_num):
	?>
		<td><?php $g1 = $lettergrades[$g]['dg1']; echo $g1; ?></td>	
		<td><?php if($qtr>1){ echo $lettergrades[$g]['dg2']; } ?></td>
		<td><?php if($qtr>2){ echo $lettergrades[$g]['dg3']; } ?></td>
		<td><?php if($qtr>3){ echo $lettergrades[$g]['dg4']; } ?></td>
		<td><?php if($qtr>3){ echo $lettergrades[$g]['dg5']; } ?></td>

	<?php else: ?>
		<td><?php $g1 = $lettergrades[$g]['q1']; echo number_format($g1,$decicard); ?></td>	
		<td><?php if($qtr>1){ echo number_format($lettergrades[$g]['q2'],$decicard); } ?></td>
		<td><?php if($qtr>2){ echo number_format($lettergrades[$g]['q3'],$decicard); } ?></td>
		<td><?php if($qtr>3){ echo number_format($lettergrades[$g]['q4'],$decicard); } ?></td>
		<td><?php // if($qtr>3){ echo number_format($lettergrades[$g]['q5'],$deciave); } ?></td>
		
	<?php endif; ?>		

</tr>
<?php endfor; ?>

<tr><td class="left b" >Number of School Days</td>
<td><?php echo ($months['q1_days_total']+0); ?></td>
<td><?php echo ($qtr>1)? ($months['q2_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($months['q3_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($months['q4_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($months['year_days_total']+0):NULL; ?></td>
</tr>
<tr><th class="left" >Days Present</th>
<td><?php echo ($attendance['q1_days_present']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['total_days_present']+0):NULL; ?></td>

</tr>

<tr><th class="left" >Times Tardy</th>
<td><?php echo ($attendance['q1_days_tardy']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['total_days_tardy']+0):NULL; ?></td>
</tr>


</table>