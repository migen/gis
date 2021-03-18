<?php 	$attendance = $students[$i]['attendance'];  ?>



<br />

<!----------------------------------------------->

<table style="font-size:0.9em;width:<?php echo $ftw; ?>;" class="gis-table-bordered-print tbp-left table-center table-vcenter" >
<tr><td style="width:<?php echo $subw; ?>;" 
	class="left b">Number of School Days</td>
<td><?php echo ($months['q1_days_total']+0); ?></td>
<td><?php echo ($qtr>1)? ($months['q2_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($months['q3_days_total']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($months['q4_days_total']+0):NULL; ?></td>
</tr>
<tr><th class="left" >Days Present</th>
<td><?php echo ($attendance['q1_days_present']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_present']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_present']+0):NULL; ?></td>
</tr>

<tr><th class="left" >Times Tardy</th>
<td><?php echo ($attendance['q1_days_tardy']+0); ?></td>
<td><?php echo ($qtr>1)? ($attendance['q2_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>2)? ($attendance['q3_days_tardy']+0):NULL; ?></td>
<td><?php echo ($qtr>3)? ($attendance['q4_days_tardy']+0):NULL; ?></td>
</tr>


</table>