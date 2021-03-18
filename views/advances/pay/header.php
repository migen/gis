<?php 
	// pr($student);
	
	// pr($data);
	
	
?>


<div style="float:left;width:55%;" >
<table class="gis-table-bordered" >
	<tr><th class="vc80" >ID No</th><td><?php echo $student['idno']; ?></td></tr>
	<tr><th>Student</th><td class="vc200" ><?php echo $student['fullname']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
	<tr><th>Mode</th><td class="vc120" ><?php echo $student['paymode']; ?></td></tr>	
</table>

</div>

<div style="float:left;width:5%;min-height:50px;" ></div>


<div style="float:left;width:30%;" >
<table class="gis-table-bordered" >
	<tr><th>Next SY</th><td class="right vc120" ><?php echo $advtuit['label']; ?></td></tr>
	<tr><th>Assessed</th><td class="right vc120" ><?php echo number_format($advtuit['total'],2); ?></td></tr>
	<tr><th>Discounts</th><td class="right" ><?php $disc = round($student['discounts'],2); 
			echo number_format($disc,2); ?></td></tr>
	<tr><th>Adjusted</th><td class="right" ><?php echo number_format($adjusted,2); ?></td></tr>
	<?php $total_payables=$adjusted+$tadds; ?>
	<tr><th>Addons</th><td class="right" ><?php echo number_format($tadds,2); ?></td></tr>
	<tr><th>Total</th><td class="right" ><?php echo number_format($total_payables,2); ?></td></tr>
</table>

</div>

<div class="clear" ></div>



<script>

$(function(){


})

</script>