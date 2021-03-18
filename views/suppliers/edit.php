<?php 

// pr($row);

?>

<h5>
	Edit Supplier Info - <?php echo $row['fullname']; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 		
	| <a href="<?php echo URL.'suppliers/view/'.$suppid; ?>">View</a>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered " >
<tr><th>Full Name</th><td><input value="<?php echo $row['fullname']; ?>" name="contact[fullname]" /></td></tr>
<tr><th>Comm Code</th><td><input value="<?php echo $row['code']; ?>" name="contact[code]" /></td></tr>
<tr><th>Contact Person</th><td><input value="<?php echo $row['contact_person']; ?>" name="post[contact_person]" /></td></tr>
<tr><th>Mobile</th><td><input value="<?php echo $row['mobile']; ?>" name="post[mobile]" /></td></tr>
<tr><th>Phone</th><td><input value="<?php echo $row['phone']; ?>" name="post[phone]" /></td></tr>
<tr><th>Email</th><td><input value="<?php echo $row['email']; ?>" name="post[email]" /></td></tr>
<tr><th>Address</th><td>
	<textarea name="post[address]" rows="3" cols="20" ><?php echo $row['address']; ?></textarea></td></tr>
<tr><th colspan="2" >
	<input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" /></th></tr>	
</table>
</form>
