<h2 class='brown'>Attendance - qtr <?php echo $data['advisory_qtr']; ?> ~
<?php echo $data['class_details']['level'].' - '.$data['class_details']['section']; ?>
</h2>



<?php 

	// pr($data);
	
	$mos = $data['month_names'];
	$num_months = count($mos);
	// pr($num_months);
	
	$mos_codes = array();
	foreach($mos AS $row){
		$mos_codes[] = $row['code'];
	}
	
	$studs = $data['students'];
	$num_students = count($studs);

	$attendance = $data['attendance'];
	// pr($attendance);
	$params = $data['params'];
	
	// pr($data);
?>

<h5>
	<a href="<?php echo URL; ?>teachers/dashboard">Dashboard</a> || 
	<a href="<?php echo URL; ?>teachers/view">Courses</a> || 
	<a href="<?php echo URL; ?>teachers/classrooms">Classrooms</a> || 	
	<a href="<?php echo URL.'teachers/editAttendance/'.$params['crid'].DS.$params['level_id'].DS.$params['section_id']; ?>" />Edit</a>	
</h5>


<?php 

	$qtr_num = isset($data['advisory_qtr'])? $data['advisory_qtr'] : Session::get('qtr');
	
?>

<form method='post'>

<table class='gis-table-bordered table-fx'>
<tr class='bg-lightgreen'>
	<th>ID</th>
	<th>Code</th>
	<th>Student</th>
	<th>Days</th>
	<?php for($i=0;$i<$num_months;$i++): ?>
		<?php $month_code = $data['month_names'][$i]['code']; ?>
			<th class='center vc50' >
				<?php 
					echo strtoupper($data['month_names'][$i]['code']).'<br />'; 
					echo round($data['months'][$month_code.'_days_total']); 
				?>
			</th>	
	<?php endfor; ?>
</tr>

<!-- populate rows by num_students -->
<?php $k = 100; ?>
<?php for($i=0;$i<$num_students;$i++): ?>
	<tr>
		<td><?php echo $studs[$i]['student_id']; ?></td>
		<td><?php echo $studs[$i]['student_code']; ?></td>
		<td><?php echo $studs[$i]['student']; ?></td>
		<td class='center' style='vertical-align:middle'>Present <br />Tardy</td>
		<?php for($j=0;$j<$num_months;$j++): ?>
			<?php $mon = $mos_codes[$j]; // echo "mon $mon "; ?>
			<?php $k++; ?>
			<td class='center' style='vertical-align:middle'>
				<input class='center' style='width:50px;' type='text' name="data[Attendance][<?php echo $i; ?>][<?php echo $mon; ?>_days_present]" value= "<?php echo $attendance[$i][$mon.'_days_present']; ?>"  ><br />
				<input class='center' style='width:50px;' type='text' name="data[Attendance][<?php echo $i; ?>][<?php echo $mon; ?>_days_tardy]"   value= "<?php echo $attendance[$i][$mon.'_days_tardy']; ?>"  >				
			</td>
		<?php endfor; ?>  <!-- months loop -->
		<td>
			<input type='text' name="data[Attendance][<?php echo $i; ?>][row_id]" value="<?php echo $attendance[$i]['att_id']; ?> " style='width:50' class='center' >
		</td>
	</tr>
	<!-- loop thru students_rows -->
<?php endfor; ?>
</table>


<input type='submit' name='submit' value='Update' >
<a href="<?php echo URL.'teachers/attendance/'.$params['crid'].DS.$params['level_id'].DS.$params['section_id']; ?>" />Cancel</a>	

</form>