<h5>
	Edit Discount Type
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'fees/addDisctype'; ?>">Add</a>


</h5>

<form method="POST" >
<table class="gis-table-bordered" >

<tr><th>ID</th><td>
<input class="pdl05" type="text" name="ID" value="<?php echo $id; ?>" readonly />
</td></tr>


<tr><th>Name</th><td>
<input class="pdl05" type="text" name="name" value="<?php echo $row['name']; ?>" />
</td></tr>

<tr><th>Amount</th><td>
<input class="pdl05" type="number" name="amount" value="<?php echo $row['amount']; ?>" />
</td></tr>


<tr><td colspan="2" >
<input type="submit" name="submit" value="Save"  />
<button><a href='<?php echo URL."fees/disctypes"; ?>' class="txt-black no-underline" >Cancel</a></button>
</td></tr>

</table>


</form>


