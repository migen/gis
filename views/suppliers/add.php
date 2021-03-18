<h5>
	Add Supplier
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Full Name</th><td><input id="supplier" name="fullname"  /></td></tr>
<tr><th colspan="2" ><input type="submit" name="submit" onclick="return validateSupplier();" value="Add"  /></th></tr>
</table>
</form>



<script>

function validateSupplier(){
	var supplier = $('#supplier').val();
	var strlen = supplier.length;	
	if(strlen>3){ 
		return true;
	} else {
		alert('Must be over 3 characters.'); 
		return false;		
	}	
}	/* fxn */


</script>