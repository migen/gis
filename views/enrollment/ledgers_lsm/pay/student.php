<?php 
	// pr($student);
	
?>



<table class="gis-table-bordered" >
	<tr><th>ID No</th><td><?php echo $student['idno']; ?></td></tr>
	<tr><th>Student</th><td><?php echo $student['fullname']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
	<tr><th>Mode</th><td><?php echo $student['paymode']; ?></td></tr>
	<tr><th>Assessed</th><td><?php echo $student['assessed']; ?></td></tr>
	<tr><th>Tuition Paid</th><td><?php echo $student['tpaid']; ?></td></tr>
	<tr><th>Total Paid</th><td><?php echo $student['paid']; ?></td></tr>
</table>

