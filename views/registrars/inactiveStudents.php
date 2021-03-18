<h5>Inactive Students - <?php echo $sy; ?> </h5>

<table class="gis-table-bordered"  >


<tr class="headrow" >
	<th>SCID</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Status</th>
	<th>Remarks</th>
</tr>

<?php foreach($dropouts AS $row): ?>
<tr>
	<td><?php echo $row['scid']; ?></td>
	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>
	<td><button><a class="black no-underline" href="<?php echo URL.'registrars/statuses/'.$row['scid']; ?>" >Statuses</a></button></td>
	<td><?php echo $row['remarks']; ?></td>
</tr>

<?php endforeach; ?>

</table>

