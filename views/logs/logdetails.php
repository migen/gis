<h5>
	View Log Details
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>

<?php 

?>


<table class="gis-table-bordered" >
	<tr><th>ID</th><td><?php echo $row['logid']; ?></td></tr>
	<tr><th>Datetime</th><td><?php echo $row['datetime']; ?></td></tr>
	<tr><th>Module</th><td><?php echo $row['module']; ?></td></tr>
	<tr><th>User</th><td><?php echo $row['user']; ?></td></tr>
	<tr><th>Action</th><td><?php echo $row['action']; ?></td></tr>
	<tr><th>Employee</th><td><?php echo $row['employee']; ?></td></tr>
	<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
	<tr><th>Qtr</th><td><?php echo $row['qtr']; ?></td></tr>
	<tr><th>Course</th><td><?php echo $row['course']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
	<tr><th>Fee</th><td><?php echo $row['fee']; ?></td></tr>
	<tr><th>Amount</th><td><?php echo $row['amount']; ?></td></tr>
	<tr><th>Orno</th><td><?php echo $row['orno']; ?></td></tr>
	<tr><th>Details</th><td><?php echo $row['details']; ?></td></tr>
</table>
