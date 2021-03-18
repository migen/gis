<h5>
	Edit
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Dept</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>IP</th><td>
	<input type="text" name="ip" value="<?php echo $row['ip']; ?>" />
</td></tr>
<tr><td colspan="2" ><input type="submit" name="submit" value="Submit"  /></td></tr>
</table>
</form>



