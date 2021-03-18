<h2 class='brown'>PSMapehs - qtr <?php echo $data['advisory_qtr']; ?> ~
<?php echo $data['class_details']['level'].' - '.$data['class_details']['section']; ?>
</h2>



<?php 


	// $params = $data['params'];

	// pr($data);

	$cols = $data['level_psmapehs'];
	$num_cols = count($cols);	
	$studs = $data['students'];	
	$rows = $data['psmapehs'];	
	$num_rows = count($rows);
	
	
?>

<h5>
	<a href="<?php echo URL; ?>teachers/dashboard">Dashboard</a> || 
	<a href="<?php echo URL; ?>teachers/view">Courses</a> || 
	<a href="<?php echo URL; ?>teachers/classrooms">Classrooms</a> || 	
	<a href="<?php echo URL.'teachers/psmapehs/'.$params['crid'].DS.$params['level_id'].DS.$params['section_id']; ?>" />Cancel</a>	
</h5>


<?php 

	$qtr_num = isset($data['advisory_qtr'])? $data['advisory_qtr'] : Session::get('qtr');
	$qtr = 'q'.$qtr_num;

	
?>

<form method='post'>

<table class='gis-table-bordered table-fx'>
<tr class='bg-lightgreen'>
	<th>ID</th>
	<th>Code</th>
	<th>Student</th>
	<?php for($i=0;$i<$num_cols;$i++): ?>
		<th>
			<?php echo $cols[$i]['psmapeh']; ?>
		</th>	
	<?php endfor; ?>
</tr>

<!-- populate rows by num_students -->
<?php
	$qtr_num = isset($data['advisory_qtr'])? $data['advisory_qtr'] : Session::get('qtr');
	$index_qtr = 'q'.$qtr_num; 
	// echo "index_qtr: $index_qtr <br />";
?>


<?php $k = 100; ?>
<?php for($i=0;$i<$num_rows;$i++): ?>
<tr>
	<td><?php echo $studs[$i]['student_id']; ?></td>
	<td><?php echo $studs[$i]['student_code']; ?></td>
	<td><?php echo $studs[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_cols;$j++): ?>
		<?php $k++; ?>
		<td class='center' style='vertical-align:middle;'>
			<input type='text' name="data[Psmapeh][<?php echo $k; ?>][<?php echo $index_qtr; ?>]" value="<?php echo number_format($psmapehs[$i][$j][$qtr],2); ?>" >								
			<input type='hidden' name="data[Psmapeh][<?php echo $k; ?>][id]" value="<?php echo $psmapehs[$i][$j]['row_id']; ?>" >
		</td>
	<?php endfor; ?>	
	
		
</tr>
<?php endfor; ?>

</table>

<input type='hidden' name='qtr' value="<?php echo $index_qtr; ?>" >


<input type='submit' name='submit' value='Update' >

</form>


