

<h5>
	Update Is Ernolled Status
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>

	
</h5>

<form method="POST" >

<table class="gis-table-bordered " >

<tr>
	<th>Amount</th>
	<td><input name="amount" value="5000"  /></td>
</tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Update"  /></td></tr>

</table>
</form>

