
<?php 

	// pr($data);
	$readonly = ($_SESSION['user']['role_id']==5)? '':'readonly';
	
?>

<h5>
	Change Login Account |
	<a href="<?php echo URL; ?>">Home</a> | 
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
</h5> <br />

<form method="POST">

<table class="gis-table-bordered table-fx">

<tr>
	<th>Fullname</th>
	<td><input class="pdl05" name="name" value="<?php echo $row['name']; ?>" /></td>
</tr>


<tr>
	<th>Old Username</th>
	<td><?php echo $row['account']; ?></td>
</tr>

<tr>
	<th>New Username</th>
	<td><input class="pdl05" name="account" value="<?php echo $row['account']; ?>" /></td>
</tr>


<tr>
	<td colspan="2" class="right" >
		<input class="vc150" type="submit" name="submit" value="Submit">
	</td>
</tr>

</table>


</form>
