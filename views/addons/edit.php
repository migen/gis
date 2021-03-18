<?php 
// pr($tauxid);

?>

<h5>
	Edit Student Fee
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."ledgers/pay/$scid"; ?>'>Ledger</a>			
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			
	
	
</h5>


<form method="POST" >
<input name="url" value="<?php echo $url; ?>" type="hidden" />
<table class="gis-table-bordered table-altrow"  >
<tr>
	<th>Student</th>
	<td><?php echo $row['student']; ?></td>
</tr>

<tr>
	<th>Fee</th>
	<td>
		<select name="aux[feetype_id]" >
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['feetype_id'])? 'selected':NULL; ?>  >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr>
	<th>Amount</th>
	<td><input class="pdl05" name="aux[amount]" value="<?php echo $row['amount']; ?>"  /></td>
</tr>

<tr>
	<th>Due</th>
	<td><input class="pdl05" name="aux[due]" value="<?php echo $row['due']; ?>"  /></td>
</tr>

<tr>
	<th>Number</th>
	<td><input name="aux[num]" value="<?php echo $row['num']; ?>"  /></td>
</tr>


</table>


<p>
	<input type="submit" name="submit" value="Update" onclick="return confirm('Proceed?');" />
	<button><a href="<?php echo URL.'addons/delete/'.$tauxid.DS.$sy; ?>" class="txt-black no-underline"
		onclick="return confirm('Dangerous! Sure?');" >Delete</a></button>	
</p>

</form>