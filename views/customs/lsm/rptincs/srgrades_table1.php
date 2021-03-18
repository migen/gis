<?php
// pr($numacad);

// pr($grades);
// exit;
// pr(count($grades[0]));


	$sq1 = ($sem==1)? 'q1':'q3';
	$sq2 = ($sem==1)? 'q2':'q4';
	$dsq1 = ($sem==1)? '1':'3';
	$dsq2 = ($sem==1)? '2':'4';		

?>		


<table style="font-size:0.9em;width:<?php echo $ftw; ?>;" class="gis-table-bordered-print tbp-left table-center table-vcenter" >

<tr>
	<th rowspan="1" style="width:<?php echo $subw; ?>;" class="left" >Subjects</th>
	<th colspan="2" >Quarter</th>
	<th rowspan="2" >Final</th>
	<th rowspan="2" >Action<br />Taken</th>	
</tr>


<tr>
	<th class="left" >Core Subjects</th><th><?php echo $dsq1; ?></th><th><?php echo $dsq2; ?></th>
</tr>


<!--------------------------------------------------------------------------------------------------->


<?php 

$sgrades = array(); 	/* secondary */
for($g=0;$g<$numacad;$g++): 

$child 	= ($grades[$g]['supsubject_id']>0)? true:false; 

if($grades[$g]['position']>100){
	$sgrades[] = $grades[$g];
	continue;
} 

?>

<tr>
	<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
		<?php echo $grades[$g]['subject'];
			// echo ' - pos:'.($grades[$g]['position']); ?>	
	</td>	
<?php if($grades[$g]['is_num']): ?>	
	
	<td><?php $sg1 = ($grades[$g][$sq1] > 0)? number_format($grades[$g][$sq1],$decicard):NULL; 
		echo (!$blank)? $sg1:NULL; ?></td>
	<td><?php if(!$qodd && !$blank){ echo number_format($grades[$g][$sq2],$decicard); } ?></td>	
	<?php $fqtr = ($sem==1)? '5':'6'; ?>
	<td><?php if(!$qodd && !$blank){ $fg=number_format($grades[$g]['q'.$fqtr],$decicard); echo $fg; } ?></td>
	<td><?php if(!$qodd && !$blank){ echo ($fg<$passing)?'Failed':'Passed'; } ?></td>					
<?php else: ?>	

	<td><?php $sg1 = $grades[$g]['dg'.$dsq1];  echo (!$blank)? $sg1:NULL; ?></td>
	<td><?php $sg2 = $grades[$g]['dg'.$dsq2];  echo (!$qodd && !$blank)? $sg2:NULL; ?></td>
		
	<?php $fqtr = ($sem==1)? '5':'6'; ?>
	<td><?php if(!$qodd && !$blank){ $fg=$grades[$g]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>					
	
<?php endif; ?>
	
</tr>

<?php endfor; ?>

<tr><th colspan="5" class="left" >Applied & Specialized Subjects</th></tr>

<?php $numsgrades = count($sgrades); ?>
<?php for($ig=0;$ig<$numsgrades;$ig++): ?>

<tr>
	<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
		<?php echo $sgrades[$ig]['subject'];  ?>	

	</td>	
<?php if($sgrades[$ig]['is_num']): ?>	
	<td><?php $sg1 = ($sgrades[$ig][$sq1] > 0)? number_format($sgrades[$ig][$sq1],$decicard):NULL; 
		echo (!$blank)? $sg1:NULL; ?></td>
	<td><?php if(!$qodd && !$blank){ echo number_format($sgrades[$ig][$sq2],$decicard); } ?></td>	
	<?php $fqtr = ($sem==1)? '5':'6'; ?>
	<td><?php if(!$qodd && !$blank){ $fg=number_format($sgrades[$ig]['q'.$fqtr],$decicard); echo $fg; } ?></td>
	<td><?php if(!$qodd && !$blank){ echo ($fg<$passing)?'Failed':'Passed'; } ?></td>					
<?php else: ?>	
	<td><?php $sg1 = $sgrades[$ig]['dg'.$dsq1]; echo $sg1; ?></td>
	<td><?php $sg2 = $sgrades[$ig]['dg'.$dsq2];  echo (!$qodd && !$blank)? $sg2:NULL; ?></td>
	<?php $fqtr = ($sem==1)? '5':'6'; ?>
	<td><?php if(!$qodd && !$blank){ $fg=$sgrades[$ig]['dg'.$fqtr]; echo $fg; } ?></td>
	<td></td>					
	
<?php endif; ?>

</tr>

<?php endfor; ?>


<!-- average and ranking rows -->
<tr class="" >
	<th class="left" >Average</th>
	<th><?php $ga1 = number_format($students[$i]['summary']['ave_'.$sq1],$decifgenave); 
		echo ($blank)? NULL:$ga1; ?></th>
	<th><?php $ga2 = number_format($students[$i]['summary']['ave_'.$sq2],$decifgenave); 
		echo ($qodd)? NULL:$ga2; 
			// echo ($qodd)? 'odd':'NOT'; ?></th>
	<th><?php if(!$qodd && !$blank){ echo number_format($students[$i]['summary']['ave_q'.$fqtr],$decifgenave); } ?></th>
	<th><?php if(!$qodd && !$blank){ echo ($fg<$passing)?'Failed':'Passed'; } ?></th>	
	
</tr>


</table>