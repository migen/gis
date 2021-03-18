<?php 

// pr($data);

// exit;

/* year total */
$attdyt1=$months['q1_days_total']+$months['q2_days_total'];
$attdyt2=$months['q3_days_total']+$months['q4_days_total'];

/* student present */
$attdsp1=$attendance['q1_days_present']+$attendance['q2_days_present'];
$attdsp2=$attendance['q3_days_present']+$attendance['q4_days_present'];

// pr($attendance);

/* student tardy */
$attdst1=$attendance['q1_days_tardy']+$attendance['q2_days_tardy'];
$attdst2=$attendance['q3_days_tardy']+$attendance['q4_days_tardy'];

$pgsign="<div class='pgsign' >________________________<br />Parent's/Guardian's Signature</div>";




?>



<div class="divleft" >	<!-- divleft -->
<table class="attdfont tblwidth" >
<tr><th class="center" colspan=3>ATTENDANCE RECORD</th></tr>
</table>



<table class="gis-table-bordered tblattd tblwidth"  >
<tr>
	<td class="attdtxt" >Number of School Days
		<?php 
			// pr($sem);
		?>
	
	</td>
	<td  class="center" ><?php echo $attdyt1; ?></td>
	<td  class="center" ><?php echo ($qtr==4)? $attdyt2:NULL; ?></td>
</tr>
<tr>
	<td  class="" >Number of Days Present</td>
	<td  class="center" ><?php echo $attdsp1; ?></td>
	<td  class="center" ><?php echo ($qtr==4)? $attdsp2:NULL; ?></td>
</tr>
<tr>
	<td  class="" >Times Tardy</td>
	<td  class="center" ><?php echo $attdst1; ?></td>
	<td  class="center" ><?php echo ($qtr==4)? $attdst2:NULL; ?></td>
</tr>
</table>


<!-- remarks -->
<p>&nbsp;</p>
<table class="rmksfont tblwidth"  >
<tr><th class="center" colspan=3>TEACHER'S COMMENTS/REMARKS</th></tr>
</table>
<table class="nogis-table-bordered rmksfont tblwidth" >
<tr>
	<td class="tdrmks" >
		<br />
		<div class="divrmks center" ><span class="b" >First Semester </span>
			<br />
			<div class="left"style="padding: 25px;" ><?php echo $remarks[$i]['q2']; ?></div>			
			<?php echo $pgsign; ?>
		</div>
	</td>	
	<td class="tdrmks" >
		<br />
		<div class="divrmks center" ><span class="b" >Second Semester </span>
			<br />
			<?php if($qtr>1): ?><div class="xbordered left" style="padding: 25px;"><?php echo $remarks[$i]['q4']; ?></div><?php endif; ?>
			<?php echo $pgsign; ?>
		</div>
	</td>
</tr>


</table>


<!-- teacher signature -->
<p>&nbsp;</p>
<p>
<table class="tblwidth" >
<tr>
	<th class="center" >__________________________</th>
	<th class="vc30" >&nbsp;</th>
	<th class="center" >__________________________</th>
</tr>
<tr>
	<th class="center" >Teacher's Signature</th>
	<th></th>
	<th class="center" >Date</th>
</tr>

</table>
</p>
<p>&nbsp;</p>

<div class="center clear" ><?php include('legends_p1.php'); ?></div>
<p>&nbsp;</p>


</div>	<!-- divleft -->
