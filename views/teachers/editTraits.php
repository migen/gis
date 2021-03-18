<?php 


// pr($data); 
// pr($data); exit;

$course 	  	= $data['course'];
$criteria 	= $data['criteria'];
$students 	= $data['students'];
$scores 	= $data['scores'];
$qtr	= $data['qtr'];
$is_locked = $data['course']['is_finalized_q'.$qtr];

	
$num_criteria 	= count($criteria);
$num_students 	= count($students);




?>

<h5>
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'teachers/traits/'.$course['course_id'].DS.$qtr; ?>" />Cancel</a>	
</h5>


<form method="POST">

<table class="gis-table-bordered table-fx" >
<tr class="bg-blue2" >
	<td>#</td>
	<td>ID Number</td>
	<td class="vc80">Student</td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<td><?php echo $criteria[$j]['criteria']; ?></td>
	<?php endfor; ?>
	<td class="vc100">Student</td>	
	<td>
		<input class="vc50" type="text" id="vall" />
		<button onclick="populateAll('vall');return false;">All</button>
	</td>	
</tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<tr id="row<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<td><input id="<?php echo $scores[$i][$j]['gid']; ?>" name="data[<?php echo $scores[$i][$j]['gid']; ?>]" class="center vc80" type="text" value="<?php $ts = $scores[$i][$j]['q'.$qtr]; echo number_format($ts,2); ?>" onchange="xeditTrait(this.id,this.value,<?php echo $qtr; ?>);"; <?php echo ($is_locked)? 'readonly' : null; ?> /></td>		
	<?php endfor; ?>	
	<td><?php echo $students[$i]['student']; ?></td>	
	<td><input class="vc50" type="text" id="row<?php echo $i; ?>" onchange="populateRow(this.id,this.value);return false;" /></td>	
	
</tr>
<?php endfor; ?>
</table>
<br />
<input type="hidden" name="qqtr" value="q<?php echo $qtr; ?>" />
<input type="submit" name="confirm_submit" value="Update All" onclick="return confirm('Warning!');return false;" />
</form>


<script>
$(function(){	nextViaEnter();		});


// IMPT: for update all feature
function populateRow(inRow,inVal){	
	var vr = '#'+inRow;
	$(vr+' td input').val(inVal);
}

function populateAll(intag){
	var inval = $('#'+intag).val();
	$('input:text').val(inval);
}


</script>


