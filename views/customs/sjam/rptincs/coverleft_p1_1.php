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
		<div class="divrmks" ><span class="b" >First Quarter (Weeks 1-10)</span>
			<br /><span class="" ><?php echo $remarks[$i]['q1']; ?></span>			
			<?php echo $pgsign; ?>
		</div>
	</td>	
	<td class="tdrmks" >
		<div class="divrmks" ><span class="b" >Second Quarter (Weeks 11-20)</span>
			<?php if($qtr>1): ?><br /><span class="" ><?php echo $remarks[$i]['q2']; ?></span><?php endif; ?>
			<?php echo $pgsign; ?>
		</div>
	</td>			

</tr>

<tr>
	<td class="tdrmks" >
		<div class="divrmks" ><span class="b" >Third Quarter (Weeks 21-30)</span>
			<?php if($qtr>2): ?><br /><span class="" ><?php echo $remarks[$i]['q3']; ?></span><?php endif; ?>			
			<?php echo $pgsign; ?>
		</div>
	</td>	
	<td class="tdrmks" >
		<div class="divrmks" ><span class="b" >Fourth Quarter (Weeks 31-40)</span>
			<?php if($qtr>3): ?><br /><span class="" ><?php echo $remarks[$i]['q4']; ?></span><?php endif; ?>			
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
	<th>____________________________</th>
	<th class="vc30" >&nbsp;</th>
	<th>____________________________</th>
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
