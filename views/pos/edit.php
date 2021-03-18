<?php 

// pr($data);

$this->shovel('selectPos'); 
$row = '';

$products 		=& $selects['products'];
$prodcategories =& $selects['prodcategories'];

// pr($positems);

?>
<script>
var gurl 	= 'http://<?php echo GURL; ?>';
var numrows = "<?php echo $numrows; ?>";	
var limits = "<?php echo $limits; ?>";
var hdpass 	= '<?php echo HDPASS; ?>';



$(function(){
	hd();
	$('#hdpdiv').hide();
	itago('more');	
	$('html').live('click',function(){ $('#names').hide(); });


})






function redirContact(ucid){	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetContactByID";	
		
	$.post(vurl,{task:task,pcid:ucid},function(s){		
		$('#part').val(s.name);		
		$('#custpcid').val(s.parent_id);		
		tabEnter('bc');				
	},'json');	
}	/* fxn */






</script>


<h5>
	Edit Sale
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."opos"; ?>' >POS</a>	
	| <a href='<?php echo URL."npos/view/".$pos_id; ?>' >View</a>	
	| <a href='<?php echo URL."pos/delete/".$pos_id; ?>' onclick="return confirm('Sure?');" >Delete</a>	
	| <a href='<?php echo URL."invoices/orno"; ?>' >OR NO</a>	
	| <span class="u" onclick="ilabas('more');" >More</span>
	
	
</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>


<form id="posform" method="POST" >

<?php 

$incs="incs/pos_head_edit.php";
include_once($incs);

?>



<div class="clear" >&nbsp;</div>

<!-- positems below -->

<table class="gis-table-bordered table-fx table-altrow" >
<thead><tr class="bg-blue2" >
	<th class="vc50" >DEL</th>
	<th class="vc20" >#</th>
	<th class="" ><span class="u b" >B</span>arcode</th>
	<th class="vc200">Product</th>		
	<th class="right" >Price</th>
	<th class="right" >Qty</th>
	<th class="right" >Amount</th>
	<th class="right" >Find</th>
	<th class="right" >Combo</th>
	<th class="right" >IO</th>
	
</tr></thead>
<tbody class='children'> <!-- needed for addRow -->

<?php $i=0; ?>
<?php foreach($positems AS $row): ?>

<tr id="trow<?php echo $i; ?>" rel="<?php echo isset($row['id'])? $row['id']:''; ?>">

	<td><u onclick="deltrow(<?php echo $i; ?>);" class='blue' rel="<?php echo isset($row['id'])? $row['id']:''; ?>"></u></td>
	<td><?php echo isset($row['id'])? $row['id']:$i+1; ?></td>

	<td class="vc100" >
		<input type="text" class="full pdl05 bc" tabindex="<?php echo $i+1; ?>" id="barcode<?php echo $i; ?>" 
			  value="<?php echo $row['barcode'] ?>" onchange="xgetProductByBarcode(<?php echo $i; ?>);return false;"  />		
	</td>

	<td id="tdproduct<?php echo $i; ?>" ><input class="full" id="prod<?php echo $i; ?>" 
		value="<?php echo $row['product'] ?>" readonly /></td>	


	<td class="vc50" ><input id="<?php echo $i; ?>" class="right full pdr05" name='positems[<?php echo $i; ?>][price]' 
		value="<?php echo isset($row['price'])? $row['price']:null; ?>" /></td>
		
	<td class="vc50" ><input id='<?php echo $i; ?>' class="right full pdr05" name='positems[<?php echo $i; ?>][qty]' 
		type="number" onchange="amt(this.id);return false;"  value="<?php echo isset($row['qty'])? $row['qty']:0; ?>" /></td>

	<td class="vc50" ><input class="subtotal full right pdr05" type="text" name='positems[<?php echo $i; ?>][amount]' 
		value="<?php $amt = isset($row['amount'])? $row['amount']:0; echo $amt; ?>" /></td>
		
	<td class="vc50" >
		<input class="full pdl05" id="product<?php echo $i; ?>"  />		
		<input type="submit" name="auto" value="Filter" onclick="xposProductsByPart(<?php echo $i; ?>);return false;" />		
	</td>
	
	<td class="vc50" ><input class="combo full pdl05" type="text" name='positems[<?php echo $i; ?>][combo]' 
		value="<?php $combo = isset($row['combo'])? $row['combo']:0; echo $combo; ?>" readonly />
		<input class="full" name="positems[<?php echo $i; ?>][product_id]" 
			value="<?php echo $row['product_id']; ?>" />							
	</td>	
		
	<td class="vc20" >
		<input type="text" class="full pdl05" name="positems[<?php echo $i; ?>][io]" value="1" />		
	</td>		

<td class="hd" >
id	<input class="vc30" type='' name='positems[<?php echo $i; ?>][id]' value="<?php echo isset($row['id'])? $row['id']:null; ?>" readonly />
oq	<input class="vc30" type="" name="positems[<?php echo $i; ?>][oldqty]" value="<?php echo $row['qty'];?>" readonly />
opr	<input class="vc30" type="" name="positems[<?php echo $i; ?>][oldprid]" value="<?php echo $row['product_id'];?>" readonly />
ocbo <input class="vc30" type="" name="positems[<?php echo $i; ?>][oldcombo]" value="<?php echo $row['combo'];?>" readonly />

</td>	
	
	
</tr>
		
<?php $i++; ?>
<?php endforeach; ?>

</tbody></table>



<!----------------------------------------------------------------------------------------->

<p>

<?php $posconfirm = ($_SESSION['settings']['posconfirm']==1)? "return confirm('Sure?');":null; ?>
	<input onclick="<?php echo $posconfirm; ?>" type='submit' name='submit' value='Submit' />
	<input type="button" value="Cancel" onclick="jsredirect('pos/view/'+<?php echo $pos['id']; ?>);" />
</form>

	


</div> <!-- pos screen -->

<!--------------------------------------------------------------------------------------------------------------->


<div class="hd" id="names" > names </div>


<!--------------------------------------------------------------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


