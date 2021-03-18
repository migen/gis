<h5>

<?php 
	echo $row['student'].' | '.$row['course']; 

?>

| Edit Grade 




</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>Qtr</th><td><?php echo $qtr; ?></td></tr>
<tr><th>GID</th><td><?php echo $row['gid']; ?></td></tr>
<tr><th>Course</th><td><?php echo $row['course']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<?php for($i=1;$i<=$qtr;$i++): ?>
	<tr><th>Q<?php echo $i; ?></th><td><?php echo $row['q'.$i]; ?></td></tr>
<?php endfor; ?>
<tr><th>Ave</th><td><?php echo $row['q5']; ?></td></tr>

<?php if($row['semester']==2): ?>
	<tr><th>Ave Sem2</th><td><?php echo $row['q6']; ?></td></tr>
<?php endif; ?>
</table>


