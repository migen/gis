<h5>
	Classroom Enrollments Summary
	| <a href="<?php echo URL; ?>" > Home </a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<!------ tracelogin --->
<p><?php $this->shovel('hdpdiv'); ?></p>


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
<tr><th class="bg-blue2 white vc150" >Tuition Total</th><td class="vc200" ><?php echo $tuition['total']; ?></td></tr>


</table>
</p>


<!------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Updated</th>
	<th class="vc300" >Student</th>
	<th class="vc100 right " >Paid</th>
	<th class="vc100 right" >Outstanding</th>
	<th>Action</th>
</tr>

<!------------------------------------------------------------------->

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M d,Y',strtotime($students[$i]['date_lastpaid'])); ?></td>
	<td ondblclick="alert(this.id);" id="<?php echo $students[$i]['scid'].' : '.$students[$i]['code']; ?>" ><?php echo $students[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($students[$i]['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($students[$i]['outstanding'],2); ?></td>
	<td class="" > 
		<a href="<?php echo URL.'accounts/assessor/'.$students[$i]['scid'].DS.$sy; ?>"  >Details</a>	
		| <a href="<?php echo URL.'accounts/ehistory/'.$students[$i]['scid'].DS.$sy; ?>"  >History</a>	
	</td>
</tr>



<?php endfor; ?>
</table>







	
<!----------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	// hd();
	$('#hdpdiv').hide();


})

</script>