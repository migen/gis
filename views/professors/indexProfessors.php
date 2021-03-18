<h5>
	Professor | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'professors/reset'; ?>" >Reset</a>
	
	
	
</h5>



<?php 
$prof=$_SESSION['professor'];

// vars=1) crids,numcrids,listcrids. 2) unipending,unisubmitted, num_unipending.., 3) unicourse_ids,unipending_ids,..


?>

<table class="accordion pending gis-table-bordered table-altrow" >
	<tr><th colspan=3 style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('pending');" >Pending</th></tr>
<?php $count=$prof['num_unipending'];?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $crs=$prof['unipending'][$i]['crs']; ?>
<?php $course=$prof['unipending'][$i]['course']; ?>
<tr><td><?php echo $i+1; ?></td>
	<td><?php echo $course; ?></td>
	<td><a href="<?php echo 'unigrades/crs/'.$crs; ?>" >Grades</a></td>
	<td>
		<?php $ws=$prof['unipending'][$i]['with_scores']; ?>
		<?php if($ws): ?>
			<a href="<?php echo 'uniscores/crs/'.$crs; ?>" >Scores</a>
		<?php endif; ?>
	</td>
	<td><a href="<?php echo 'uniattendance/crs/'.$crs; ?>" >Attendance</a></td>
</tr>
<?php endfor; ?>


</table>
<br />

<table class="accordion submitted gis-table-bordered table-altrow" >
	<tr><th colspan=3 style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('submitted');" >Submitted</th></tr>
<?php $count=$prof['num_unisubmitted'];?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $crs=$prof['unisubmitted'][$i]['crs']; ?>
<?php $course=$prof['unisubmitted'][$i]['course']; ?>
<tr><td><?php echo $i+1; ?></td>
	<td><?php echo $course; ?></td>
	<td><a href="<?php echo 'unigrades/crs/'.$crs; ?>" >Grades</a></td>
	<td>
		<?php $ws=$prof['unipending'][$i]['with_scores']; ?>
		<?php if($ws): ?>
			<a href="<?php echo 'uniscores/crs/'.$crs; ?>" >Scores</a>
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>

</table>
<br />

<?php 

	$advis=$_SESSION['professor']['advisories'];
	$count=$_SESSION['professor']['num_advisories'];
	$has_advis=($count>0)? true:false;
	// pr($advis);
?>

<?php if($has_advis): ?>
	<table class="accordion advisories gis-table-bordered table-altrow" >
		<tr><th colspan=3 style="height:50px;vertical-align:middle;" class="center headrow vc300" onclick="accordionTable('advisories');" >Advisories</th></tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php $crid=$advis[$i]['crid']; ?>
	<?php $classroom=$advis[$i]['classroom']; ?>
	<tr><td><?php echo $i+1; ?></td>
		<td><a href="<?php echo 'unicourses/crid/'.$crid; ?>" ><?php echo $classroom; ?></a></td>
	</tr>
	<?php endfor; ?>
	</table>
<?php endif; ?>	<!-- has_advis -->



<script>

$(function(){
	// $('.accordion tr').hide();
	// $('.accordion td').hide();
	
})

</script>
