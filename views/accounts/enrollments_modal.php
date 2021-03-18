<h5>
	Classroom Enrollments Summary
	| <a href="<?php echo URL; ?>" > Home </a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<?php 


// pr($data);
// pr($students[0]);
// pr($num_students);
// pr($classlist);
// pr($num_classlist);

?>

<!------------------------------------------------------------------->

<p>
<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-blue2 white vc150" >Level</th><td class="vc200" ><?php echo $classroom['level']; ?></td></tr>
<tr><th class="bg-blue2 white vc150" >Section</th><td class="vc200" ><?php echo $classroom['section']; ?></td></tr>
<tr><th class="bg-blue2 white vc150" >Adviser</th><td class="vc200" ><?php echo $classroom['adviser']; ?></td></tr>
<tr><th class="bg-blue2 white vc150" >Assessed Amount</th><td class="vc200" ><?php echo $tuition['total']; ?></td></tr>


</table>
</p>


<!------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Updated</th>
	<th>ID</th>
	<th>Student</th>
	<th>Paid</th>
	<th>Outstanding</th>
	<th>Manage</th>
</tr>

<!------------------------------------------------------------------->

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M-d-Y',strtotime($students[$i]['date'])); ?></td>
	<td><?php echo $students[$i]['code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td class="right" ><?php echo $students[$i]['paid']; ?></td>
	<td class="right" ><?php echo $students[$i]['tout']; ?></td>
	<td class="" >
		<a class="u" style="color:blue;" id="<?php echo $i; ?>" onclick="modalShow(this.id);return false;">More</a> 	
		| <a href="<?php echo URL.'accounts/enrollment/'.$sy.DS.$students[$i]['scid']; ?>"  >Details</a>
	
	</td>
</tr>

<div class="hide hd hd<?php echo $i; ?>"><p>Previous Outstanding: P<?php echo $students[$i]['prevout']; ?></p></div>
<div class="hide hd hd<?php echo $i; ?>"><p>Academic Final Grade: <?php echo $students[$i]['afg']; ?></p></div>


<?php endfor; ?>
</table>



<!----------------------------------------------------------------->






<div class="modal hide" id="modalDiv" >

</div>

<!----------------------------------------------------------------->

<script>

$(function(){
	hd();

})

</script>