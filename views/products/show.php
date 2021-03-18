<?php 

	// pr($rows[0]);
	// pr($prodcategories);
	// echo ($details)? "show details":"hide details";
	
?>

<h5>

<?php echo $sy; ?> Products (<?= $count; ?>)
	<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <a href="<?php echo URL.'products/types'; ?>" >Types</a>
	| <a href="<?php echo URL.'products/subtypes'; ?>" >Groups</a>
	| <a href="<?php echo URL.'products/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'products/assignments'; ?>" >Assignments</a>


<?php if($prodtype_id): ?>
	| <a href='<?php echo URL."products"; ?>' >All</a>
<?php endif; ?>


<?php if($details): ?>
	<?php $url = str_replace('details','',$_SESSION['url']); ?>
	| <a href='<?php echo URL.$url; ?>' >Hide details </a>
<?php else: ?>
	<?php $url = $_SESSION['url'].'&details'; ?>
	| <a href='<?php echo URL.$url; ?>' >Show details </a>
<?php endif; ?>

</h5>

<?php $this->shovel('hdpdiv'); ?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>Find</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="Product or Supplier" />
		<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
		<input type="submit" name="auto" value="Supplier" onclick="xgetContactsByPart();return false;" />
		
	</td></tr>
	
</table></p>

<div class="hd" id="names" >names</div>


<p>


<!-- filter and sort below -->
<table class="gis-table-bordered" >

<form method="GET" >

<tr class="headrow" >
	<th>SY</th>
	<th>Cat</th>
	<th>Type</th>
	<th>Group</th>
	<th>Sort</th>
	<th>Order</th>
	<th>Page</th>
	<th>Limits</th>
	<th>&nbsp;</th>
</tr>

<tr>
	<th><input type="number" min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo DBYR; ?>" name="sy" 
		class="center" value="<?php echo $sy; ?>" /></th>

	<th><select name="prodtag_id" >
		<option value="" >Cat</option>
		<?php foreach($prodtags AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$prodtag_id)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>					
</select></th>
		
	<th><select name="prodtype_id" >
		<option value="" >Type</option>
		<?php foreach($prodtypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$prodtype_id)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>					
</select></th>

	<th><select name="prodsubtype_id" >
		<option value="" >Group</option>
		<?php foreach($prodsubtypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$prodsubtype_id)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>					
	</select></th>


	<?php $sorts = array(
		array('key'=>'product','value'=>'Product'),
		array('key'=>'price','value'=>'Price'),			
	); ?>
	
	<?php // pr($sorts); ?>	
	<th><select class="vc100" name="sort" >
		<?php foreach($sorts AS $sel): ?>
			<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
				<?php echo $sel['value']; ?></option>
		<?php endforeach; ?>
	</select></th>
		
	<th><select name="order" >
		<option <?php echo ($order=='ASC')? 'selected':NULL; ?> >ASC</option>
		<option <?php echo ($order=='DESC')? 'selected':NULL; ?> >DESC</option>
	</select></th>		

	<th><input class="vc30 center" name="page" value="<?php echo $page; ?>"  /></th>	
	<th><input class="vc40 center" name="limits" value="<?php echo $limits; ?>"  /></th>		
	<th><input type="submit" name="submit" value="Filter" /></th>		
	</tr>
</table>	
</form>

</p>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>ID</th>
	<th>Group</th>
	<th>Barcode</th>
	<th>Product</th>
	<th>Price</th>
	<th>Level</th>	
	<th class="right" >UOM</th>	
	<th class="right" >Combo</th>	
<?php if($details): ?>
	<th>RO<br />Lvl</th>
	<th>RO<br />Qty</th>
	<th>Remarks</th>
	<?php for($i=0;$i<$numterminals;$i++): ?>
		<th class="vc30" >
			T<?php echo $i+1; ?><br />
			<?php echo $terminals[$i]['name']; ?>
		</th>		
	<?php endfor; ?>
	
<?php endif; ?>	

	<th>Axn</th>
	<th>#</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['level']<$rows[$i]['rolevel'])? 'red':NULL; ?>" >
	<td class="screen" ><input class="chka" type="checkbox" name="rows[<?php echo $rows[$i]['id']; ?>]" 
		value="<?php echo $rows[$i]['prid']; ?>" /></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['type']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['price']; ?></td>
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>	
	<td class="right" ><?php echo $rows[$i]['uom']; ?></td>
	<td class="right" ><?php echo $rows[$i]['combo']; ?></td>
<?php if($details): ?>
	<td><?php echo $rows[$i]['rolevel']; ?></td>
	<td><?php echo $rows[$i]['roqty']; ?></td>
	<td><?php echo $rows[$i]['remarks']; ?></td>
	
<?php for($t=1;$t<=$numterminals;$t++): ?>
	<td><?php echo $rows[$i]['t'.$t]; ?></td>
<?php endfor; ?>
	
	
<?php endif; ?>	
	<td>
		<a href="<?php echo URL.'products/edit/'.$rows[$i]['id']; ?>" >Edit</a>
		<?php if(strlen(trim($rows[$i]['combo']))!=0): ?>
			| <a href="<?php echo URL.'products/combo/'.$rows[$i]['id']; ?>" >Combo</a>		
		<?php endif; ?>	
		
		<?php if($_SESSION['srid']==RMIS): ?>
			<a class="hd" id="btn<?php echo $i; ?>" onclick="xdeleteProduct(<?php echo $rows[$i]['id'].','.$i; ?>);return false;" >Delete</a>
		<?php endif; ?>		
	</td>
	<td><?php echo $i+1; ?></td>
	
</tr>
<?php endfor; ?>
</table>

<p>	
	<input onclick="return confirm('Sure?');" type='submit' name='batch' value='Edit' >

</p>

</form>




<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';
			
$(function(){
	chkAllvar('a');
	hd();
	$('#hdpdiv').hide();
})


function xdeleteProduct(pid,i){
	if (confirm('Sure?')){
		var vurl = gurl+'/ajax/xproducts.php';		
		var task = "xdeleteProduct";			
		$.post(vurl,{task:task,pid:pid},function(){
			$('#btn'+i).hide();
		});		
	}
	return false;
	

}	/* fxn */



function redirLookup(ucid){
	var url = gurl + '/products/view/' + ucid;		
	window.location = url;			
}



function redirContact(ucid){
	var url = gurl + '/products/supplier/' + ucid;		
	window.location = url;			
		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
