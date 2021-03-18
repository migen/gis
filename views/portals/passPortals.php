
<?php 

	$readonly = ($_SESSION['user']['role_id']==5)? '':'readonly';
	
?>

<h5>
	Secure Password |
	<a href="<?php echo URL; ?>">Home</a> | 
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
</h5>


<h4 class="brown" >
	*IMPT -  MIS can access your password, must not be similar to your personal / bank accounts. <br />
	*IMPT -  No special characters too. <br />
</h4>


<form method="POST">

<table class="gis-table-bordered table-fx">


<tr>
	<th>Username</th>
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
