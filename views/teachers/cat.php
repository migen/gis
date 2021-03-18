

<?php 

// pr($data);

$qtr = $qtr = $data['qtr'];
$num_students = $data['num_students'];
$qqtr = 'q'.$qtr;
$dgqtr = 'dg'.$qtr;
$is_locked = $data['is_locked'];
$course = $crs = $data['course'];


?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<h2 class='darkgray'> CAT <?php if($qtr < 5): ?> - qtr <?php echo $qtr; ?> <?php endif; ?></h2>

<div>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white bg-blue2'>Level</th><td><?php echo $course['level']; ?></td></tr>
	<tr><th class='white bg-blue2'>Section</th><td><?php echo $course['section']; ?></td></tr>
	<tr><th class='white bg-blue2'>Subject</th><td><?php echo $course['label']; ?></td></tr>
<?php if($qtr < 5): ?> <tr><th class='white bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($data['is_locked'] == 1)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	
</table>


<br />
<br />

<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr class="bg-blue2" >
	<td>#</td>
	<td>ID Number</td>
	<td>Student</td>
	<td class="vc50 center" >1-Pass<br />0-Fail</td>
</tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $cats[$i]['student_code']; ?></td>
	<td><?php echo $cats[$i]['student']; ?></td>
	<td><input class="vc50 center" type="text" name="data[cat][<?php echo $i; ?>][<?php echo $dgqtr; ?>]" value="<?php echo $cats[$i]['dg'.$qtr]; ?>"  <?php echo ($is_locked)? 'readonly' : null; ?>  /></td>
		<input type="hidden" name="data[cat][<?php echo $i; ?>][gid]" value="<?php echo $cats[$i]['gid']; ?>" />			
</tr>
<?php endfor; ?>
</table>

<br />

<?php if(!$is_locked): ?>
	<input type="hidden" name="dgqtr" value="dg<?php echo $qtr; ?>" />
	<input type="submit" name="submit" value="Update" />
<?php endif; ?>	
</form>


<script>
	$(function(){	nextViaEnter();		});

</script>
