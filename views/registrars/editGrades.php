
<?php 

// pr($data['Grade']);

$course = $_SESSION['course'];
// pr($course);

?>

<h5>
	Edit Grades
	| <a href="<?php echo URL; ?>registrars">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>

<form method='POST' >
<!--  =================== course details  =============================  -->
<table class='gis-table-bordered table-fx'>
	</td></tr>
	<tr><th>Teacher</th><td><?php echo $course['teacher']; ?></td></tr>
	<tr><th>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th>Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th>Subject</th><td><?php echo $course['subject']; ?></td></tr>
	<tr><th>CrsID</th><td><input class="full pdl05" type="text" name="data[course_id]" value="<?php echo $course['id']; ?>"  readonly />	
</table>


<!--  =================== editable grades =============================  -->
<hr />

<table class="gis-table-bordered table-fx">

<?php // echo $this->shovel('gradesHeadrow'); ?>
<thead><tr class="bg-blue2">
	<th>GID</th>
	<th>CID</th>
	<th>ID Number</th>
	<th>Student</th>
	<th class="center" >Q1 / CC </th>
	<th class="center" >Q2 / CC</th>
	<th class="center" >Q3 / CC</th>
	<th class="center" >Q4 / CC</th>
	<th class="center" >FG</th>
	<th>Compute<br />FG</th>
<!--
	<th>Remarks</th>
-->	
</tr></thead>


<tbody id='tgrades'>
<?php $i=0; ?>
<?php foreach($data['Grade'] as $row): ?>
<tr>
	<td><?php echo $row['gid']; ?></td>
	<td><?php echo $row['scid']; ?></td>
	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>
	<td class="center" >
		<span id="<?php echo $i; ?>q1"  > <?php echo $row['q1']; ?> </span>
		<input id="<?php echo $i; ?>bq1" class="vc30 center" type="text" name="data[Grade][<?php echo $i; ?>][bq1]" value="<?php echo $row['bonus_q1']; ?>" AutoFocus />				
		<br /><input id="<?php echo $i; ?>tq1" class="vc50 center" type="text" name="data[Grade][<?php echo $i; ?>][tq1]"  value="<?php echo $row['q1']+$row['bonus_q1']; ?>" readonly />
	</td>
	<td class="center" >
		<span id="<?php echo $i; ?>q2"  > <?php echo $row['q2']; ?> </span>
		<input id="<?php echo $i; ?>bq2" class="vc30 center" type="text" name="data[Grade][<?php echo $i; ?>][bq2]" value="<?php echo $row['bonus_q2']; ?>" />				 
		<br /><input id="<?php echo $i; ?>tq2" class="vc50 center" type="text" name="data[Grade][<?php echo $i; ?>][tq2]"  value="<?php echo $row['q2']+$row['bonus_q2']; ?>" readonly />
	</td>
	<td class="center" >
		<span id="<?php echo $i; ?>q3"  > <?php echo $row['q3']; ?> </span>
		<input id="<?php echo $i; ?>bq3" class="vc30 center" type="text" name="data[Grade][<?php echo $i; ?>][bq3]" value="<?php echo $row['bonus_q3']; ?>" />				 
		<br /><input id="<?php echo $i; ?>tq3" class="vc50 center" type="text" name="data[Grade][<?php echo $i; ?>][tq3]"  value="<?php echo $row['q3']+$row['bonus_q3']; ?>" readonly />
	</td>
	<td class="center" >
		<span id="<?php echo $i; ?>q4"  > <?php echo $row['q4']; ?> </span>
		<input id="<?php echo $i; ?>bq4" class="vc30 center" type="text" name="data[Grade][<?php echo $i; ?>][bq4]" value="<?php echo $row['bonus_q4']; ?>" />				 
		<br /><input id="<?php echo $i; ?>tq4" class="vc50 center" type="text" name="data[Grade][<?php echo $i; ?>][tq4]"  value="<?php echo $row['q4']+$row['bonus_q4']; ?>" readonly />
	</td>
	<td><input id="<?php echo $i; ?>fgrade" class="vc50 center" type="text" name="data[Grade][<?php echo $i; ?>][final]" value="<?php echo $row['q5']; ?>" readonly /></td>
	<td><a id="<?php echo $i; ?>" onclick="refinalize(this.id);return false;" > <button> Tally </button></a></td>
	<input type="hidden" name="data[Grade][<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" /></td>
	<input type="hidden" name="data[Grade][<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>" /></td>
	<input type="hidden" name="data[Grade][<?php echo $i; ?>][sumid]" value="<?php echo $row['sumid']; ?>" /></td>
	<input type="hidden" name="data[Grade][<?php echo $i; ?>][sy]" value="<?php echo $row['sy']; ?>" /></td>
	
</tr>
<?php $i++; ?>			
<?php endforeach; ?>
</tbody></table>
<br />

<input type='submit' name='submit' value='Submit'> &nbsp; 
<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>


</form> <!-- editGradeForm -->


<!---------------------------------------------------------------------------------------------------->

<script>

$(function(){
	nextViaEnter();
})

function refinalize(i){
	var c = 0;
	var total = 0;
	var q1  = $('#'+i+'q1').text();
	var bq1  = $('#'+i+'bq1').val();
	var tq1  = parseFloat(q1)+parseFloat(bq1);	
	
	var q2  = $('#'+i+'q2').text();
	var bq2  = $('#'+i+'bq2').val();
	var tq2  = parseFloat(q2)+parseFloat(bq2);	

	var q3  = $('#'+i+'q3').text();
	var bq3  = $('#'+i+'bq3').val();
	var tq3  = parseFloat(q3)+parseFloat(bq3);	

	var q4  = $('#'+i+'q4').text();
	var bq4  = $('#'+i+'bq4').val();	
	var tq4  = parseFloat(q4)+parseFloat(bq4);	
		
	if(tq1>50) { c++; total += parseFloat(tq1); } else { $('#'+i+'q1').val(0); }
	if(tq2>50) { c++; total += parseFloat(tq2); } else { $('#'+i+'q2').val(0); }
	if(tq3>50) { c++; total += parseFloat(tq3); } else { $('#'+i+'q3').val(0); }
	if(tq4>50) { c++; total += parseFloat(tq4); } else { $('#'+i+'q4').val(0); }
						
	var fgrade = total / c;
	fgrade = fgrade.toFixed(2);
		
	$('#'+i+'tq1').val(tq1.toFixed(2));
	$('#'+i+'tq2').val(tq2.toFixed(2));
	$('#'+i+'tq3').val(tq3.toFixed(2));
	$('#'+i+'tq4').val(tq4.toFixed(2));
	$('#'+i+'fgrade').val(fgrade);
}

</script>
