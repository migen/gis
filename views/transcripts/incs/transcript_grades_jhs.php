

<table  class="gis-table-bordered" >
<tr>
	<th>Course</th>
	<th>Subject</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
	<th>Final<br />Grade</th>
	<th>Action<br />Taken</th>
	<th>Summer<br />Subject</th>
	<th>Final<br />Grade</th>
</tr>
<?php foreach($arrgrades AS $grade): ?>
	<tr>
		<td><?php echo $grade['course']; ?></td>
		<td><?php echo $grade['label']; ?></td>
		<td><?php echo number_format($grade['q1'],$decicard); ?></td>
		<td><?php echo number_format($grade['q2'],$decicard); ?></td>
		<td><?php echo number_format($grade['q3'],$decicard); ?></td>
		<td><?php echo number_format($grade['q4'],$decicard); ?></td>
		<td><?php echo number_format($grade['q5'],$decicard); ?></td>
		<td><?php echo ($grade['q5']>75)? 'Passed':'Failed'; ?></td>		
		<td></td>
		<td></td>
	</tr>
<?php endforeach; ?>
</table>