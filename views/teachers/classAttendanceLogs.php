
<?php 


// pr($data);

// pr($student);


// pr($_SERVER); for home link,used by registrar and teacher
$home = $_SESSION['home'];

// pr($attendances[0]);

?>



<h5>
	Class Attendance Logs
	| <?php $this->shovel('homelinks',$home); ?>
	
</h5>



<!-------------------------------------------------------------------------------------->

<!-- page info -->
<p><table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Date</th><td><?php echo date('M-d,Y,l',strtotime($date)); ?></td></tr>

</table></p>




<!-------------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc300" >Student Month Attendance</th>
	<th class="vc120" >Timein</th>
	<th class="vc120" >Timeout</th>
</tr>

<?php for($i=0;$i<$num_attendances;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href='<?php echo URL."teachers/attendanceLogs/$ssy/$month/".$attendances[$i]['id']; ?>' ><?php echo $attendances[$i]['student']; ?></a></td>
	<td><?php echo $attendances[$i]['timein']; ?></td>
	<td><?php echo $attendances[$i]['timeout']; ?></td>
</tr>
<?php endfor; ?>


</table>

<!--------------------------------------------------------------------------------->

<?php 

// pr($data);




?>



<!------------------------------------------------------------------------->


<!------------------------------------------------------------------------->








