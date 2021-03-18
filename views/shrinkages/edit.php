<?php

// pr($_SESSION['q']);
$terminal=$row['terminal'];
// pr($row);

// pr($row);

?>

<h5>
	Edit Shrinkage
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'shrinkages/filter'; ?>">Filter</a>
	| <a href="<?php echo URL.'products/view/'.$row['id']; ?>">Product</a>

</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>Trml <?php echo $row['terminal']; ?> | Lvl</th>
	<td><?php echo $row['t'.$terminal].' | '.$row['level']; ?></td>
</tr>
<tr><th>Prid | Price | Cost</th><td>
	<input type="" name="post[prid]" value="<?php echo $row['prid']; ?>" id="prid" class="vc50" readonly />
	<input type="type" name="post[price]" id="price" value="<?php echo $row['price']; ?>" class="vc50" readonly />
	<input type="type" name="post[cost]" id="cost" value="<?php echo $row['cost']; ?>" class="vc50" readonly />	
</td></tr>

<tr><th>Terminal</th><td><input class="vc100" name="post[terminal]" value="<?php echo $row['terminal']; ?>" /></td></tr>
<tr><th>Reference</th><td><input class="vc300" name="post[reference]" value="<?php echo $row['reference']; ?>" /></td></tr>

<tr><th>SK Type</th><td>
<select name="post[sktype_id]" >
	<?php foreach($sktypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo ($sel['id']==$row['sktype_id'])? 'selected':NULL; ?>
		><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Date</th><td><input type="date" name="post[date]" value="<?php echo $row['date']; ?>" />
</td></tr>


<tr><th>Product</th><td>
	<input class="vc300 pdl05" id="part" autofocus value="<?php echo $row['product']; ?>" />
	<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
</td></tr>


<tr><th>Qty</th><td>
	<input type="type" name="post[qty]" value="<?php echo $row['qty']; ?>" />
</td></tr>

<tr><th>Remarks</th><td><input class="vc300" type="text" name="post[remarks]" 
	value="<?php echo $row['skremarks']; ?>" /></td></tr>


<input type="type" name="orig[qty]" value="<?php echo $row['qty']; ?>" hidden />
<input type="type" name="orig[terminal]" value="<?php echo $row['terminal']; ?>" hidden />
<input type="type" name="orig[prid]" value="<?php echo $row['prid']; ?>" hidden />

	
	
<tr><td colspan="2" ><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" /></td></tr>




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

