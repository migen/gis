<?php 

// pr($arrgradesS1[0]);

?>


<table  class="gis-table-bordered" >
<tr>
	<th>Course</th>
	<th>Subject</th>
	<th>Q5</th>
	<th>Remarks</th>
</tr>
<?php foreach($arrgradesSem1 AS $grade): ?>
	<tr>
		<td class="" ><?php echo $grade['course']; ?></td>
		<td class="vc300" ><?php echo $grade['label']; ?></td>
		<td><?php echo number_format($grade['q5'],$decicard); ?></td>
	</tr>
<?php endforeach; ?>
</table>

<br />
<br />


<table  class="gis-table-bordered" >
<tr>
	<th>Course</th>
	<th>Subject</th>
	<th>Q6</th>
	<th>Remarks</th>
</tr>
<?php foreach($arrgradesSem2 AS $grade): ?>
	<tr>
 		<td class="" ><?php echo $grade['course']; ?></td>
		<td class="vc300" ><?php echo $grade['label']; ?></td>
		<td><?php echo number_format($grade['q6'],$decicard); ?></td>
	</tr>
<?php endforeach; ?>
</table>
