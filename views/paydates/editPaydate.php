<h3>
	Edit Paydate
	
	
</h3>

<?php 

// pr($data);
extract($row);

?>


<form method="POST" >
	<table class="gis-table-bordered" >
	<tr><th>ID</th><td><?php echo $pkid; ?></td></tr>
	<tr><th>Paymode</th><td><?php echo $row['paymode']; ?></td></tr>
	<tr><th>Due Dates</th><td><?php echo $row['duedates']; ?></td></tr>
	<tr><th>Change (CSV)</th><td>
		<input class="vc500" name="post[duedates]" value="<?php echo $row['duedates']; ?>" >	
	</td></tr>
	
	<tr><th>Grace Period Dates</th><td><?php echo $row['grace_period']; ?></td></tr>
	<tr><th>Change (CSV)</th><td>
		<input class="vc500" name="post[grace_period]" value="<?php echo $row['grace_period']; ?>" >	
	</td></tr>
	
	<tr><th>Count</th><td>
		<input name="post[count]" value="<?php echo $row['count']; ?>" >	
	</td></tr>
	<tr><th>Position</th><td>
		<input name="post[position]" value="<?php echo $row['position']; ?>" >	
	</td></tr>
	<tr><th colspan=2><input type="submit" name="submit" value="Save" >
		<button><a href="<?php echo URL.'enrollment/paydates/'.$sy; ?>" >Cancel</a></button>
	</th></tr>

</table>
</form>

