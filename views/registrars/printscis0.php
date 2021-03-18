<h5 class="screen" >
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>						
</h5>

<?php 

pr($student);


?>


<?php for($num=0;$num<3;$num++): ?>

<h5> Student Assessment Form </h5>

<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 white" >ID Number</th><td class="vc500" ><?php echo $student['code']; ?></td></tr>
<tr><th class="bg-blue2 white" >Complete Name</th><td><?php echo $student['name']; ?></td></tr>
<tr><th class="bg-blue2 white" >Level</th><td><?php echo $student['level']; ?></td></tr>
<tr><th class="bg-blue2 white" >Section</th><td><?php echo $student['section']; ?></td></tr>
<tr><th class="bg-blue2 white" >Siblings</th><td><?php echo $student['siblings']; ?></td></tr>
<tr><th class="bg-blue2 white" >Honor/s Received</th><td><?php echo $student['honor_received']; ?></td></tr>
<tr><th class="bg-blue2 white" >Total Assessed Amount</th><td><?php $total = isset($student['total_assessed'])? $student['total_assessed']:$student['total']; echo number_format($total,2); ?></td></tr>
</table>

<p > <hr /> </p>

<?php endfor; ?>