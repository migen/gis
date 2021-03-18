<?php 

// pr($club_id);
// exit;

?>

<h5>
Club Students 
<?php // pr($club); ?>
<?php $this->shovel('homelinks'); ?>

<?php if($_SESSION['srid']==RMIS): ?>
	| <a href="<?php echo URL.'clubs/batch/'.$club_id; ?>" >Enrol</a>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Grades</a>
<?php endif; ?>


</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Scid</th>
<th>ID No.</th>
<th>Student</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>
