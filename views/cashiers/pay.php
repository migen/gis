<h5>
	Cashiering


</h5>

<?php 
// pr($data);

// exit;
?>

<div id="names" >names</div>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Type</th>
<td>
	<input type="radio" value="1" name="payor" checked />Student<br />
	<input type="radio" value="3" name="payor" />Other
</td>
</tr>
<tr>
<th>Fee</th>
<td>
<select name="post[feetype_id]" >
<?php foreach($feetypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Customer</th><td><input class="pdl05" id="customer" name="post[customer]" 
	placeholder="Name" /></td></tr>
<tr><th>Tender</th><td><input id="tender" name="post[tender]" value="0.00" class="pdl05" 
onchange="lessAmount();return false;" /></td></tr>
<tr><th>Amount</th><td><input id="amount" name="post[amount]" value="0.00" class="pdl05" /></td></tr>
<tr><th>Change</th><td><input id="change" name="post[change]" value="0.00" class="pdl05" /></td></tr>
</table>

<p>
	<button onclick="lessAmount();return false;" >Change</button>
	<input type="submit" name="submit" value="Submit"  />

</p>

</form>


<script>

$(function(){


})

function lessAmount(){
	var a=$("#tender").val();
	var b=$("#amount").val();
	var c = parseInt(a)-parseInt(b);
	$("#change").val(c);
	
}	/* fxn */

</script>
