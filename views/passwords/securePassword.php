
<?php 

	// pr($data);
	$readonly = ($_SESSION['user']['role_id']==5)? '':'readonly';
	
?>

<h5>
	Secure Password |
	<a href="<?php echo URL; ?>">Home</a> | 
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
</h5> <br />

<form method="POST">

<table class="gis-table-bordered table-fx">


<tr>
	<th>ID</th>
	<td><input class="pdl05" type="text" name="data[login]" value="<?php echo $data["login"]; ?>" <?php echo $readonly; ?> ></td>
</tr>

<tr>
	<th>Old Password</th>
	<td><input class="pdl05" type="password" name="data[oldpass]" placeholder="old" /></td>
</tr>

<tr>
	<th>New Password</th>
	<td><input class="pdl05" type="password" name="data[newpass]" placeholder="new" /></td>
</tr>

<tr>
	<th>Confirm New Password</th>
	<td><input class="pdl05" type="password" name="data[newpass2]" placeholder="confirm new" /></td>
</tr>

<tr>
	<td colspan="2" class="right" >
		<input class="vc150" type="submit" name="submit" value="Submit">
	</td>
</tr>

</table>


</form>
