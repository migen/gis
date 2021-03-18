<?php 
$srid=$_SESSION['srid'];

?>

<h5>
	Classlist <?php echo $cr['classroom']; ?>
	
	<?php if($srid==RMIS): ?>
		| <a href="<?php echo URL.'uniregister/student'; ?>" >Register</a>
		| <a href="<?php echo URL.'unisync/crid/'; ?>" >Sync</a>
	<?php endif; ?>
	
	
</h5>

<?php 
// pr($data);
// pr($rows[0]);
// debug($rows[0]);
if(!empty($rows)){ debug($rows[0]); }



?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="" >Scid</th>
	<th class="" >Lvl</th>
	<th class="vc200" >Student</th>
	<th class="" >Courses</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
$scid=$rows[$i]['scid'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><a href="<?php echo URL.'unistudents/courses/'.$scid; ?>" >Courses</a></td>
</tr>
<?php endfor; ?>
</table>
