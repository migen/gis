<?php


$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			


?>


<h5>
	Yearbook | 
	<a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>



<?php 

// pr($cr);

// =========== DEFINE VARS ===========





?>



<!-- ========================  page info / user info =================================-->
<table class='gis-table-bordered table-fx'>
<tr><th class="bg-blue2 vc100" >SY</th><td class="vc300" ><?php echo $sy.' - '.($sy+1); ?></td></tr>
<tr><th class="bg-blue2" >Level</th><td><?php echo $cr['level']; ?></td></tr>
<tr><th class="bg-blue2" >Section</th><td><?php echo $cr['section']; ?></td></tr>
	
</td></tr>
</table>
<br />



<!-- =================== BOYS ===================  -->

<table class="gis-table-bordered" >
<tr class="headrow" >
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Gender</th>
</tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td class="center" ><?php echo ($students[$i]['is_male'])? 'M':'F'; ?></td>
</tr>


<?php endfor; ?>

</table>



<!--  =================================================================================================================  -->
<script>

$(function(){
	hd();
})

</script>