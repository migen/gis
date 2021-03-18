<?php 


?>



<table class="gis-table-bordered table-altrow table-center" >
<tr><td style="text-align:left;" class="b subwidth" >Number of School Days</td>
	<td><?php echo $months['q1_days_total']+0; ?></td>
	<td><?php echo $months['q2_days_total']+0; ?></td>
	<td><?php echo $months['q3_days_total']+0; ?></td>
	<td><?php echo $months['q4_days_total']+0; ?></td>
	<td><?php echo $months['year_days_total']+0; ?></td>
</tr>
<tr><th style="text-align:left;" >Days Present</th>
	<td><?php echo $attendance['q1_days_present']+0; ?></td>
	<td><?php echo $attendance['q2_days_present']+0; ?></td>
	<td><?php echo $attendance['q3_days_present']+0; ?></td>
	<td><?php echo $attendance['q4_days_present']+0; ?></td>
	<td><?php echo $attendance['total_days_present']+0; ?></td>
</tr>
<tr><th style="text-align:left;" >Times Tardy</th>
	<td><?php echo $attendance['q1_days_tardy']+0; ?></td>
	<td><?php echo $attendance['q2_days_tardy']+0; ?></td>
	<td><?php echo $attendance['q3_days_tardy']+0; ?></td>
	<td><?php echo $attendance['q4_days_tardy']+0; ?></td>
	<td><?php echo $attendance['total_days_tardy']+0; ?></td>
</tr>
</table>
