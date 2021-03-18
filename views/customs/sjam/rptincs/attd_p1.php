<?php 

// pr($months);
// pr($attendance);

/* year total */
$attdyt1=$months['q1_days_total']+$months['q2_days_total'];
$attdyt2=$months['q3_days_total']+$months['q4_days_total'];

/* student present */
$attdsp1=$attendance['q1_days_present']+$attendance['q2_days_present'];
$attdsp2=$attendance['q3_days_present']+$attendance['q4_days_present'];

/* student tardy */
$attdst1=$attendance['q1_days_tardy']+$attendance['q2_days_tardy'];
$attdst2=$attendance['q3_days_tardy']+$attendance['q4_days_tardy'];


?>

<style>

.attdtxt{ width:420px; }
.attdnum{ width:60px;text-align:center; }

</style>

<p>&nbsp;</p>
<table class="" >
<tr><th class="center" colspan=3>ATTENDANCE RECORD</th></tr>
</table>

<table class="gis-table-bordered" style="width:<?php echo $tbl_width; ?>;" >
<tr><td class="attdtxt" >Number of School Days</td>
	<td  class="attdnum" ><?php echo $attdyt1; ?></td>
	<td  class="attdnum" ><?php echo $attdyt2; ?></td>
<tr><td>Number of Days Present</td>
	<td  class="attdnum" ><?php echo $attdsp1; ?></td>
	<td  class="attdnum" ><?php echo $attdsp2; ?></td>
</tr>
<tr><td>Times Tardy</td>
	<td  class="attdnum" ><?php echo $attdst1; ?></td>
	<td  class="attdnum" ><?php echo $attdst2; ?></td>
</tr>
</table>
