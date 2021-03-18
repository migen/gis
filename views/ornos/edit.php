<h5>
	Edit
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'ornos/view/'.$id; ?>">View</a>
	| <a href="<?php echo URL.'ornos/delete/'.$id; ?>">Delete</a>

</h5>


<form method="POST"  >
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Date</th><td><input type="date" name="date" value="<?php echo $row['date']; ?>" /></td></tr>
<tr><th>Void</th><td><input name="is_void" value="<?php echo $row['is_void']; ?>" /></td></tr>
<tr><th>Orno</th><td><input name="orno" value="<?php echo $row['orno']; ?>" /></td></tr>
<tr><th>Orno</th><td><input name="remarks" value="<?php echo $row['remarks']; ?>" /></td></tr>

<tr><th colspan="2" ><input type="submit" name="submit" value="Update" /></th></tr>

</table>
</form>