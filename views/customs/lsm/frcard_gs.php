<h5 class="screen" >
LSM Front

</h5>

<?php

for($i=0;$i<$num_students;$i++): 	/* start classlist */
	$student = $students[$i];
	ob_start();	

?>


<div style="float:left;width:50%"  >	<!-- left -->

<table class="gis-table-bordered" >
<tr><td>Initial:</td></tr>
<tr><td><?php echo $student['initial']; ?></td></tr>

<tr><td>Final:</td></tr>
<tr><td><?php echo $student['final']; ?></td></tr>

</table>
</div>	<!-- left -->



<div style="float:left;width:50%"  >	<!-- right -->
	Right Side Fixed or constant content!
</div>	<!-- right -->

<p class='pagebreak'>&nbsp; </p>


<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();
?>	
	
<?php endfor; ?>		<!-- end classlist -->
