

<?php 

// pr($student);

?>

<!-- ------------------------------------------------------------------------------------  -->

<h5>
	Assessment
	<span class="screen" >
		| <a href="<?php echo URL.$home; ?>">Home</a>
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
		| <a href="<?php echo URL.'registrars/registration'; ?>">Registration</a>
	</span>
</h5>


<!-- ================ page details ============================================== -->

<table class="gis-table-bordered table-fx" >
<tr><th class="vc150 white headrow">ID Number</th><td class="vc300" ><?php echo $student['student_code']; ?></td></tr>
<tr><th class="white headrow">Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class="white headrow">Gender</th><td><?php echo ($student['is_male'])? 'Male':'Female'; ?></td></tr>
<tr><th class='white headrow'>Level</th><td><?php echo $tuition['level']; ?></td></tr>
<tr><th class="white headrow">Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
<tr><th class="white headrow">School Year</th><td><?php echo $sy.' - '.$next_sy; ?></td></tr>

</table>


<!-- ------------------------------------------------------------------------------------  -->

<?php 
	$d['fees'] 		= $fees;
	$d['num_fees'] 	= $num_fees;
	$this->shovel('fees',$d);

?>
