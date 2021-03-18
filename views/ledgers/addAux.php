<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";


$(function(){
	hd();
})

function auxThis(id){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&id='+id+'&sy='+sy,				
		async: true,
		success: function(s) { 			
			$('#amount0').val(s.amount);
			$('#is_discount0').val(s.is_discount);
		}		  
    });				
	
	
}	/* fxn */


</script>


<?php 


// pr($_SESSION['q']);

// pr($_SESSION['auxtypes'][1]);
$numatypes = count($_SESSION['auxtypes']);

?>


<h5>
	Add Aux <span class="hd" >HD</span>
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th>Student</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Type</th><td>
<select name="auxtype_id" onchange="auxThis(this.value);return false;" >
	<option value="0" >Choose</option>
	<?php foreach($auxtypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>	
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Amount</th><td><input id="amount0" name="amount" /></td></tr>
<tr><th>Is Discount</th><td><input id="is_discount0" name="is_discount" readonly /></td></tr>


</table>

<p>
	<input type="submit" name="submit" value="Submit"  />
</p>
</form>

