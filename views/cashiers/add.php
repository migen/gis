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
<tr><th>Customer</th><td><input class="pdl05" id="customer" name="post[customer]" 
	placeholder="Name" /></td></tr>
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
