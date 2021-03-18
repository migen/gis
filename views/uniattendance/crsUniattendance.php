<h5>
	Course Attendance | <?php $this->shovel('homelinks','College'); ?>


</h5>

<?php 
// pr($rows[0]);
?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Student</th>
	<th>Attd
		<br /><input id="ipre"  class="vc50 center" >
		<br /><button onclick="populateColumn('pre');return false;" >All</button>
	</th>
	<th>Late
		<br /><input id="itar"  class="vc50 center" >
		<br /><button onclick="populateColumn('tar');return false;" >All</button>	
	</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><input tabIndex=2 class="vc50 center pre" name="posts[<?php echo $i; ?>][days_present]" value="<?php echo $rows[$i]['days_present']; ?>" ></td>
	<td><input tabIndex=4 class="vc50 center tar" name="posts[<?php echo $i; ?>][days_tardy]" value="<?php echo $rows[$i]['days_tardy']; ?>" ></td>
		<input type="hidden" name="posts[<?php echo $i; ?>][attid]" value="<?php echo $rows[$i]['attid']; ?>" >
	
</tr>
<?php endfor; ?>
</table>

<br /><input type="submit" name="submit" value="Save" >

</form>
