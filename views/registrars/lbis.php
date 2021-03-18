<?php 

$decigrades = $_SESSION['settings']['decigrades'];

?>

<h5><?php echo $level['level']; ?> Best in Subjects - <?php echo ucfirst($fqtr); ?> 

| <?php 	$this->shovel('homelinks','registrars'); ?>
| <a href='<?php echo URL."registrars/Lbis/$lvl/$sy/$sqtr";?>' >Qtr</a>
| <a href='<?php echo URL."registrars/Lbis/$lvl/$sy/5";?>' >FG</a>

</h5>



<!----------------------------------------------------------------------------------------------------->

<?php 

// pr($data);
// pr($data['subjects']);
// pr($data['lbis']);

?>



<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="vc200" >Subject</th>
	<th class="vc150" >Section</th>
	<th class="vc300" >Student</th>
	<th class="vc100 right" >Grade</th>
<tr>


<?php for($i=0;$i<$num_subjects;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $lbis[$i]['subject']; ?></td>
	<td><?php echo $lbis[$i]['section']; ?></td>
	<td><?php echo $lbis[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($lbis[$i]['grade'],$decigrades); ?></td>
</tr>
<?php endfor; ?>

</table>









<!----------------------------------------------------------------------------------------------------->


