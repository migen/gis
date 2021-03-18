<script>
	$(function(){	nextViaEnter();		});
</script>

<h5>
	Edit Student TP |
	<?php 	$this->shovel('homelinks','teachers'); ?>	
	| <a href="<?php echo URL.'teachers/traits/'.$course_id.DS.$sy.DS.$qtr; ?>"> TP </a>

</h5>

<?php 

// pr($data);
// pr($course);
// pr($grades);



?>


<!---------------------------------------------------------------->

<h4>Details</h4>
<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>CrsId</th><td><?php echo $course['id']; ?></td></tr>
<tr><th class='bg-blue2'>Course</th><td><?php echo $course['name']; ?></td></tr>
<tr><th class='bg-blue2'>Scid</th><td><?php echo $student['scid']; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>
<br />
<!---------------------------------------------------------------->


<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr class="headrow" >
	<th class="hd" >GID</th>
	<th class="hd" >Cri</th>
	<th>#</th>
	<th>TP</th>
	<th>Grade</th>
</tr>

<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td class="hd" ><?php echo $grades[$i]['gid']; ?></td>
	<td class="hd" ><?php echo $grades[$i]['criteria_id']; ?></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $grades[$i]['criteria']; ?></td>
	<td><input onchange="tallyAve();" class="tp vc50 right" type="text" name="grades[<?php echo $i; ?>][grade]" value="<?php echo $grades[$i]['grade']; ?>"   /></td>

	<!------------------------->
	<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"   />

</tr>
<?php endfor; ?>

<tr><th class="hd" colspan="2" ></th><th> &nbsp; </th><th>Average</th><td><input id="tpave" class="vc50 right" type="text" name="summaries[grade]" readonly /></td></tr>

<input type="hidden" name="scid" value="<?php echo $scid; ?>"   />

</table>
<?php if(!$is_locked): ?>
	<p><input type="submit" name="edit" value="Edit" /></p>
<?php endif; ?>
</form>


<!-------------------------------------------------------------------->

<script>

// var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	nextViaEnter();
	tallyAve();
	
})


function tallyAve(){
// $('.'+cls).each(function(){
	var numtp = '<?php echo $num_grades; ?>';
	// alert(numtp);
	
	var tptotal = 0;
	var tpave   = 0;
	
	$('.tp').each(function(){
		tptotal += parseInt($(this).val());	
	})

	tpave = tptotal / numtp;
	// alert(tptotal);
	// tpave = tpave
	// $('.a'+cls).val(avecls.toFixed(2));	
	
	$('#tpave').val(tpave.toFixed(2));

}	// fxn


</script>
