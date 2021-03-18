<style>


</style>

<?php 

// pr($data);
// pr($student);
// pr($conducts);


if(empty($student)){ echo "<h4> No record found.</h4>"; exit;  }

$is_ps	= $student['is_ps'];
$is_hs	= $student['is_hs'];	// for ratings
$is_k12	= $student['is_k12'];
$is_k12 	= ($is_k12 && !$is_ps);
// echo ($is_k12)? 'yes bedk12' : 'not bedk12';


	
// =============== DEFINE VARS  =============== 	

$num_conducts = count($conducts);

$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

	
?>
<!-- ===================  =======================-->

<h5>
	Report Card
	|<?php $this->shovel('homelinks',$home); ?>
</h5>

<!-- ===================  user info =======================-->

<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-blue2" >ID Number</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class="bg-blue2" >Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class="bg-blue2" >Level</th><td><?php echo $student['level']; ?></td></tr>
<tr><th class="bg-blue2" >Section</th><td><?php echo $student['section']; ?></td></tr>
<tr><th class="bg-blue2" >School year</th><th><?php echo $sy; ?> - <?php echo $sy + 1; ?></th></tr>
</table>




<br /> 
<!-- =======================================  grades/bonuses =======================================================================   -->
<br />

<h5> Academic Report </h5>
<table class='gis-table-bordered table-fx table-altrow center'>
<tr class='bg-blue2'>
	<th>#</th><th class="left vc200" >Subject</th><th class=' center vc50'>Q1</th><th class='center vc50'>Q2</th><th class='center vc50'>Q3</th><th class='center vc50'>Q4</th>
	<?php $firstGrade = $grades[0]; ?>	
	<?php // if(!isZeroNullOrEmpty($firstGrade['q4'])): ?>	
		<th class='center vc50'>AVE</th>
	<?php // endif; ?>	
</tr>



<?php  $i = 1; ?>
<?php	foreach($grades as $grade): 	?>
<tr>
	<td><?php echo $i; ?></td>
	<td class="left" ><?php echo $grade['subject']; ?></td>
	<td>
		<?php echo isZeroNullOrEmpty($grade['q1'])? ' ' : number_format($grade['q1'],2); ?><br />
		<?php if($is_k12){ echo $grade['dg1']; }	?>	
	</td>
	
	
	<td>
		<?php echo isZeroNullOrEmpty($grade['q2'])? ' ' : number_format($grade['q2'],2); ?><br />
		<?php if($is_k12){ echo $grade['dg2']; }	?>	
	</td>

	<td>
		<?php echo isZeroNullOrEmpty($grade['q3'])? ' ' : number_format($grade['q3'],2); ?><br />
		<?php if($is_k12){ echo $grade['dg3']; }	?>	
	</td>

	<td>
		<?php echo isZeroNullOrEmpty($grade['q4'])? ' ' : number_format($grade['q4'],2); ?><br />
		<?php if($is_k12){ echo $grade['dg4']; }	?>	
	</td>	
	
	
	<?php // if(!isZeroNullOrEmpty($firstGrade['q4'])): ?>
		<td>
			<?php echo isZeroNullOrEmpty($grade['q5'])? ' - ' : number_format($grade['q5'],2); ?>
			<?php echo ($is_k12)? '<br />'.$grade['dg5'] : null; ?>
		</td>
	<?php // endif; ?>	
</tr>

<?php $i++; ?>
<?php endforeach; ?>
<tr>
	<td class="left" colspan="2"><b>General Average</b></td>
	<td><?php echo isset($student['ag1'])? $student['ag1'] : '&nbsp;'; ?>
			<?php 	if($is_k12){ echo isset($student['adg1'])? '<br/>'.$student['adg1'] : '&nbsp;'; } ?></td>
	<td><?php echo isset($student['ag2'])? $student['ag2'] : '&nbsp;'; ?>
			<?php 	if($is_k12){ echo isset($student['adg2'])? '<br/>'.$student['adg2'] : '&nbsp;'; } ?></td>	
	<td><?php echo isset($student['ag3'])? $student['ag3'] : '&nbsp;'; ?>
			<?php 	if($is_k12){ echo isset($student['adg3'])? '<br/>'.$student['adg3'] : '&nbsp;'; } ?></td>		
	<td><?php echo isset($student['ag4'])? $student['ag4'] : '&nbsp;'; ?>
			<?php 	if($is_k12){ echo isset($student['adg4'])? '<br/>'.$student['adg4'] : '&nbsp;'; } ?></td>		
	<td><?php echo isset($student['agf'])? $student['agf'] : '&nbsp;'; ?>
		<?php 	if($is_k12){ echo isset($student['adgf'])? '<br/>'.$student['adgf'] : '&nbsp;'; } ?></td>
</tr>

</table>



<br /> 
<!-- =======================================  traits & conduct =======================================================================   -->
<br />


<div>
<h5> Traits and Conduct </h5>
<table class='gis-table-bordered table-fx table-altrow'>
<tr class='bg-blue2'>
	<th class='vc400'>Conduct</th>
	<th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>
</tr>
<?php foreach($data['conducts'] AS $row): ?>


<tr>
	<td><?php echo $row['trait']; ?></td>
	<td><?php if($student['is_k12']){ echo $row['dg1']; } else { echo isZeroNullOrEmpty($row['q1'])? ' ' : number_format($row['q1'],2);  } 	?></td>
	<td><?php if($student['is_k12']){ echo $row['dg2']; } else { echo isZeroNullOrEmpty($row['q2'])? ' ' : number_format($row['q2'],2);  } 	?></td>
	<td class=' center'><?php if($student['is_k12']){ echo $row['dg3']; } else { echo isZeroNullOrEmpty($row['q3'])? ' ' : number_format($row['q3'],2);  } 	?></td>
	<td class=' center'><?php if($student['is_k12']){ echo $row['dg4']; } else { echo isZeroNullOrEmpty($row['q4'])? ' ' : number_format($row['q4'],2);  } 	?></td>
</tr>
<?php endforeach; ?>

<tr>
	<td class='b'>Average</td>

	<td class='center'><?php if($student['is_k12']){ echo $row['dg1']; } else { echo isZeroNullOrEmpty($row['q1'])? ' ' : number_format($row['q1'],2);  } 	?>	</td>
	<td class='center'><?php if($student['is_k12']){ echo $row['dg2']; } else { echo isZeroNullOrEmpty($row['q2'])? ' ' : number_format($row['q2'],2);  } 	?>	</td>
	<td class='center'><?php if($student['is_k12']){ echo $row['dg3']; } else { echo isZeroNullOrEmpty($row['q3'])? ' ' : number_format($row['q3'],2);  } 	?>	</td>
	<td class='center'><?php if($student['is_k12']){ echo $row['dg4']; } else { echo isZeroNullOrEmpty($row['q4'])? ' ' : number_format($row['q4'],2);  } 	?>	</td>

	
</tr>

</table>
</div>

<br /> 
<!-- =======================================  attendace  =======================================================================   -->
<br />


<h5> Attendance </h5>
<table class='gis-table-bordered table-fx right'>
<tr class='bg-blue2'>
	<th class="left" >Month</th>	
	<?php for($i=0;$i<$num_months;$i++): ?>
		<?php $month_code = ucfirst($month_codes[$i]); ?>	
		<th><?php echo $month_code; ?></th>
	<?php endfor; ?>
</tr>

<tr class='bg-gray3'>
	<th class="left" >Days Total</th>	
	<?php for($i=0;$i<$num_months;$i++): ?>
		<?php $month_code = $month_codes[$i]; ?>		
		<?php $days_total = $months[$month_code.'_days_total']; ?>
		<td><?php echo $days_total; ?></td>
	<?php endfor; ?>
</tr>

<tr>
	<th class="left" >Days Present</th>
	<?php for($i=0;$i<$num_months;$i++): ?>
		<?php $month_code = $month_codes[$i]; ?>	
		<td><?php echo !isNullOrEmpty($attendance[$month_code.'_days_present'])? $attendance[$month_code.'_days_present'] : ' '; ?></td>
	<?php endfor; ?>	
</tr>

<tr>
	<th class="left" >Days Tardy</th>
	<?php for($i=0;$i<$num_months;$i++): ?>
		<?php $month_code = $month_codes[$i]; ?>	
		<td><?php echo !isNullOrEmpty($attendance[$month_code.'_days_tardy'])? $attendance[$month_code.'_days_tardy'] : ' '; ?></td>
	<?php endfor; ?>
</tr>

</table>

<br /><br />

<!-- =======================================  psmapehs  =======================================================================   -->

<?php 

if(isset($data['psmapehs'])):
	$ip = count($psmapehs);

	
?>

	<h5>PS Mapehs</h5>

	<table class='gis-table-bordered table-fx'>
	<tr class='bg-blue2'>
		<th>Music,Arts,& PE</th>
		<th class='center vc50'>Q1</th>	<th class='center vc50'>Q2</th><th class='center vc50'>Q3</th><th class='center vc50'>Q4</th>	
	</tr>
		<?php for($m=0;$m<$ip;$m++): ?>	
		<?php 
			$ps_sum = 0;
			$ps_sum += $psmapehs[$m]['q1'] + $psmapehs[$m]['q2'] + $psmapehs[$m]['q3'] + $psmapehs[$m]['q4'];
		?>
	<tr>		
		<td><?php echo $psmapehs[$m]['psmapeh']; ?></td>
		<td class='center vc50'><?php echo isset($psmapehs[$m]['q1'])? number_format($psmapehs[$m]['q1'],2) : ' '; ?></td>
		<td class='center vc50'><?php echo isset($psmapehs[$m]['q2'])? number_format($psmapehs[$m]['q2'],2) : ' '; ?></td>
		<td class='center vc50'><?php echo isset($psmapehs[$m]['q3'])? number_format($psmapehs[$m]['q3'],2) : ' '; ?></td>
		<td class='center vc50'><?php echo isset($psmapehs[$m]['q4'])? number_format($psmapehs[$m]['q4'],2) : ' '; ?></td>
	</tr>
		<?php endfor; ?> 	<!--  psmapeh_loop  -->
		
<?php endif; ?> 	<!--  if_psmapehs -->

	</table>

<!--  psmapehs above  -->



<!----------------------------------------------------------------------->


<hr />
<h4>Legends:</h4>
<?php if($is_ps): ?>
<div class="third" >
<h4>Traits</h4>
<table class="f12 gis-table-bordered table-fx table-altrow right" >
<tr class="headrow" >
<th class="left" >Rating</th>
<th>From</th>
<th>To</th>
<?php foreach($ratings['traits'] AS $row): ?>
<tr>
	<td class="left" ><?php echo $row['rating']; ?></td>
	<td><?php echo $row['grade_floor']; ?></td>
	<td><?php echo $row['grade_ceiling']; ?></td>
</tr>
<?php endforeach; ?>
</tr>
</table>
</div>
<!----------------------------------------------------------------------->
<div class="third" >
<h4>PSMapeh</h4>
<table class="f12 gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th>Rating</th>
<th>From</th>
<th>To</th>
<?php foreach($ratings['psmapeh'] AS $row): ?>
<tr>
	<td><?php echo $row['rating']; ?></td>
	<td><?php echo $row['grade_floor']; ?></td>
	<td><?php echo $row['grade_ceiling']; ?></td>
</tr>
<?php endforeach; ?>
</tr>
</table>
</div>
<?php endif; ?>

<!----------------- bk bedk12,nonps-k12 ------------------------------------------------------>

<?php if($is_k12): ?>
<div class="third" >
<h4>Academics</h4>
<table class="f12 gis-table-bordered table-fx table-altrow right" >
<tr class="headrow" >
<th class="left" >Rating</th>
<th>From</th>
<th>To</th>
<?php foreach($ratings['acad'] AS $row): ?>
<tr>
	<td class="left" ><?php echo $row['rating']; ?></td>
	<td><?php echo $row['grade_floor']; ?></td>
	<td><?php echo $row['grade_ceiling']; ?></td>
</tr>
<?php endforeach; ?>
</tr>
</table>
</div>
<!----------------------------------------------------------------------->
<div class="third" >
<h4>Traits</h4>
<table class="f12 gis-table-bordered table-fx table-altrow right" >
<tr class="headrow" >
<th class="left" >Rating</th>
<th>From</th>
<th>To</th>
<?php foreach($ratings['traits'] AS $row): ?>
<tr>
	<td class="left" ><?php echo $row['rating']; ?></td>
	<td><?php echo $row['grade_floor']; ?></td>
	<td><?php echo $row['grade_ceiling']; ?></td>
</tr>
<?php endforeach; ?>
</tr>
</table>
</div>
<?php endif; ?>

<!----------------------------------------------------------------------->

<?php if(!$is_k12 && !$is_ps): ?>
<div class="third" >
<h4>Academics</h4>
<table class="f12 gis-table-bordered table-fx table-altrow right" >
<tr class="headrow" >
<th class="left" >Rating</th>
<th>From</th>
<th>To</th>
<?php foreach($ratings['acad'] AS $row): ?>
<tr>
	<td class="left" ><?php echo $row['rating']; ?></td>
	<td><?php echo $row['grade_floor']; ?></td>
	<td><?php echo $row['grade_ceiling']; ?></td>
</tr>
<?php endforeach; ?>
</tr>
</table>
</div>
<!----------------------------------------------------------------------->
	<?php if(!$is_hs): ?>
	<div class="third" >
		<h4>Conduct</h4>
		<table class="f12 gis-table-bordered table-fx table-altrow right" >
		<tr class="headrow" >
		<th class="left" >Rating</th>
		<th>From</th>
		<th>To</th>
		<?php foreach($ratings['conduct'] AS $row): ?>
		<tr>
			<td class="left" ><?php echo $row['rating']; ?></td>
			<td><?php echo $row['grade_floor']; ?></td>
			<td><?php echo $row['grade_ceiling']; ?></td>
		</tr>
		<?php endforeach; ?>
		</tr>
		</table>	
	</div>
	<?php endif; ?> <!-- not hs -->
<?php endif; ?> <!-- not bedk12 -->

<!----------------------------------------------------------------------->


