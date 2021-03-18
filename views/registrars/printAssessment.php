<h5 class="screen" >
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>						
</h5>

<?php 

// pr($student);
$code 				= $student['code'];
$total_assessed 	= $student['total_assessed'];
$total 				= $student['total'];
unset($student['code']); 
unset($student['total']); 
unset($student['total_assessed']); 


?>


<?php for($num=0;$num<3;$num++): ?>

<h5> Student Assessment Form </h5>

<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 white" >ID Number</th><td class="vc500" ><?php echo $code; ?></td></tr>

<?php foreach($student AS $k => $v): ?>
<tr><th class="bg-blue2 white" ><?php echo ucfirst($k); ?></th><td><?php echo $v; ?></td></tr>
<?php endforeach; ?>

<tr><th class="bg-blue2 white" >Total Assessed Amount</th>
<td class="b" ><?php $total = isset($total_assessed)? $total_assessed:$total; echo number_format($total,2); ?></td></tr>
</table>

<p > <hr /> </p>

<?php endfor; ?>