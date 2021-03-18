<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/college/blank.css" />


<h5 class="screen" >
	College Report Cards | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php 
debug($data);

?>

<?php for($s=0;$s<$count;$s++): ?>	<!-- students loop -->
<div class="rcard" >

<table class="gis-table-bordered" >
<tr><th class="" >Student</th><td><span class="" ><?php echo $students[$s]['name']; ?></span></td></tr>
<tr><th>Classroom</th><td><?php echo $students[$s]['classroom']; ?></td></tr>
</table><br />

<table class="gis-table-bordered" >
<tr>
	<th>Subject</th>
	<th>Grade</th>
</tr>
<?php $grades=$studgrades[$s]; ?>
<?php foreach($grades AS $grade): ?>
<tr>
	<td><?php echo $grade['course']; ?></td>
	<td><?php echo $grade['grade']; ?></td>
</tr>
<?php endforeach; ?>
</table>




</div>	<!-- rcard -->
<p class="pagebreak" ></p>
<?php endfor; ?>	<!-- students loop -->