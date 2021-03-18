 <?php 


	
?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; 
	
	
?>


<script>
var gurl 	= 'http://<?php echo GURL; ?>';
var numrows = "<?php echo $numrows; ?>";	
var limits = "<?php echo $limits; ?>";


$(function(){
	hd();	
	nextViaEnter();		
	tabEnter('bc');			
	itago('more');
	itago('creditsales');
	itago('numrows');
	$('html').live('click',function(){
		$('#names').hide();
	});

	$( "#posform" ).submit(function( event ) {
		tallyTotal();
	});	
	
	
})	/* fxn */




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
	<?php echo ($npos)? 'N':NULL; ?>POS | Register Sale
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."invoices/orno"; ?>' >OR NO</a>	
	| <a href='<?php echo URL."opos"; ?>' >OPOS</a>	
	| <span class="u" onclick="ilabas('more');" >More</span>
	
	
	
</h5>

<?php include_once('incs/find_orno.php'); ?>

<div style="width:70%;float:left;" >		<!-- pos screen -->

<form id="posform" method="POST" >

<?php 
	$incs="incs/pos_head.php";include_once($incs);

?>

<div style="width:30px;height:60px;float:left;" >&nbsp;</div>
<div class="clear" >&nbsp;</div>

<!-- positems below -->
<table class="gis-table-bordered table-fx table-altrow" >
<thead><tr class="bg-blue2" >
	<th class="" >O</th>
	<th class="vc20" >#</th>
	<th class="" ><span class="u b" >B</span>arcode</th>
	<th class="vc200">Product</th>		
	<th class="right" >Price</th>
	<th class="right" >Qty</th>
	<th class="right" >Amount</th>
	<th class="right" >Find</th>
	<th class="right" >Combo</th>
	<th class="right" >IO</th>
	<th class="right" >Cost</th>
</tr></thead>
<tbody class='children'> <!-- needed for addRow -->

<?php for($i=0;$i<$numrows;$i++): ?>
<tr id="trow<?php echo $i; ?>" rel="<?php echo isset($row['id'])? $row['id']:''; ?>">

	<td><u onclick="deltrow(<?php echo $i; ?>);" class='blue' rel="<?php echo isset($row['id'])? $row['id']:''; ?>"></u></td>
	<td><?php echo isset($row['id'])? $row['id']:$i+1; ?></td>

	<td class="vc100" >
		<input type="text" class="full pdl05 bc" tabindex="<?php echo $i+1; ?>" id="barcode<?php echo $i; ?>" 
			  onchange="xgetProductByBarcode(<?php echo $i; ?>);return false;" accesskey="b" />		
	</td>

	<td id="tdproduct<?php echo $i; ?>" ><input class="full" id="prod<?php echo $i; ?>" readonly /></td>	
	
	<td class="vc50" ><input class="right full pdr05" name='positems[<?php echo $i; ?>][price]' 
		value="<?php echo isset($row['price'])? $row['price']:null; ?>" readonly /></td>
		
	<td class="vc50" ><input id="<?php echo $i; ?>" class="right full pdr05" type="number" 
		name='positems[<?php echo $i; ?>][qty]' onchange="amt(this.id);return false;"  value="<?php echo isset($row['qty'])? $row['qty']:0; ?>" /></td>

	<td class="vc50" ><input class="subtotal full right pdr05" type="text" name='positems[<?php echo $i; ?>][amount]' value="<?php $amt = isset($row['amount'])? $row['amount']:0; echo number_format($amt,2); ?>" readonly /></td>
		
	<td class="vc50" >
		<input class="full pdl05" id="product<?php echo $i; ?>"  />		
		<input type="submit" name="auto" value="Filter" onclick="xposProductsByPart(<?php echo $i; ?>);return false;" />
	</td>

	<td class="vc20" >
		<input type="text" class="full right" name="positems[<?php echo $i; ?>][combo]" 
			value="<?php echo isset($row['combo'])? $row['combo']:null; ?>" readonly />		
		<input class="full" name="positems[<?php echo $i; ?>][product_id]" readonly />					
	</td>
	
	<td class="vc20" >
		<input type="text" class="full pdl05" name="positems[<?php echo $i; ?>][io]" value="0" readonly />				
	</td>	
	
	<td class="vc50" ><input class="right full pdr05" name='positems[<?php echo $i; ?>][cost]' 
		value="<?php echo isset($row['cost'])? $row['cost']:null; ?>" readonly /></td>
	
</tr>

<?php endfor; ?>

</tbody></table>

<br />
<p>
<?php $posconfirm = ($_SESSION['settings']['posconfirm']==1)? "return confirm('Sure?');":null; ?>
	<input onclick="<?php echo $posconfirm; ?>" type='submit' name='submit' value='Submit' />
</form>


<span class="numrows" >
	<?php $this->shovel('numrows'); ?>
</span>


</div> <!-- pos screen -->



<div class="hd" id="names" >names</div>



