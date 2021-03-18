<?php

// pr($_SESSION['q']);

?>

<h5>

	<?php // echo "REFNO: ".$refno; ?>

	Add Shrinkage
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'shrinkages/filter'; ?>">Filter</a>
	| <a href="<?php echo URL.'shrinkages/batch'; ?>">Batch</a>
	

</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Prid | Price | Cost</th><td>
	<input type="" name="post[prid]" value="" id="prid" class="vc50" readonly />
	<input type="type" name="post[price]" id="price" value="" class="vc50" readonly />
	<input type="type" name="post[cost]" id="cost" value="" class="vc50" readonly />
</td></tr>

<tr><th>SK Type</th><td>
<select name="post[sktype_id]" >
	<?php foreach($sktypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $today; ?>" />
</td></tr>
<tr><th>Product</th><td>
	<input class="vc300 pdl05" id="part" autofocus placeholder="Product or Supplier" />
	<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
</td></tr>

<tr><th>Qty</th><td><input type="number" name="post[qty]" value="" /></td></tr>
<tr><th>Terminal</th><td><input type="number" name="post[terminal]" value="1" /></td></tr>
<tr><th>Reference</th><td><input type="text" class="vc300" name="post[reference]" value="<?php echo $refno; ?>" /></td></tr>
<tr><th>Remarks</th><td><input type="text" class="vc300" name="post[remarks]" value="" /></td></tr>




<tr><td colspan="2" ><input type="submit" name="submit" value="Add" onclick="return confirm('Sure?');" /></td></tr>


</table>
</form>


<div id="names" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";


$(function(){
	$('html').live('click',function(){ $('#names').hide(); });

})






</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/shrinkages.js"; ?>' ></script>

