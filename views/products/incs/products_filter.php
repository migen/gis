<?php 

// pr($_POST['limits']);

?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>Find</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="Product or Supplier" />
		<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
		<input type="submit" name="auto" value="Supplier" onclick="xgetContactsByPart();return false;" />
		
	</td></tr>
	
</table></p>


<form method="POST" >
<div style="width:25%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >

<tr><th>Barcode</th><td><input name="barcode" class="pdl05"
	value="<?php echo (isset($_POST['barcode']) && ($_POST['barcode']))? $_POST['barcode']:NULL;  ?>" /></td></tr>
<tr><th>Code</th><td><input name="code" class="pdl05"
	value="<?php echo (isset($_POST['code']) && ($_POST['code']))? $_POST['code']:NULL;  ?>" /></td></tr>
<tr><th>Comm</th><td><input name="comm" class="pdl05"
	value="<?php echo (isset($_POST['comm']) && ($_POST['comm']))? $_POST['comm']:NULL;  ?>" /></td></tr>

<tr><th>Name</th><td><input name="name" class="pdl05"
	value="<?php echo (isset($_POST['name']) && ($_POST['name']))? $_POST['name']:NULL;  ?>" /></td></tr>

</table>
</div>

<!-------------------------------------------------->

<div style="width:30%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >

<tr>
<th>Supplier</th>
<td>
	<select class="vc200" name="supp" >
		<option value="0" >Choose</option>
		<?php foreach($suppliers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo ((isset($_POST['supp'])) && ($sel['id']==$_POST['supp']))? 'selected':NULL; ?> 
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


<tr>
<th>Category</th>
<td>
	<select class="vc200" name="cat" >
		<option value="0" >Choose</option>
		<?php foreach($prodtags AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_POST['cat'])) && ($sel['id']==$_POST['cat']))? 'selected':NULL; ?> >
				<?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr>
<th>Type</th>
<td>
	<select class="vc200" name="type" >
		<option value="0" >Choose</option>
		<?php foreach($prodtypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_POST['type'])) && ($sel['id']==$_POST['type']))? 'selected':NULL; ?> >			
		<?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr>
<th>Group</th>
<td>
	<select class="vc200" name="gid" >
		<option value="0" >Choose</option>
		<?php foreach($prodsubtypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_POST['gid'])) && ($sel['id']==$_POST['gid']))? 'selected':NULL; ?> >						
			<?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>






</table>
</div>


<!-------------------------------------------------->

<div class="third" >	<!--  left -->
<table class="gis-table-bordered table-fx" >
<tr>
<th colspan="" >Sort</th>
<td><?php $sorts = array(
	array('key'=>'p.id','value'=>'ID'),
	array('key'=>'p.name','value'=>'Name'),			
	array('key'=>'p.barcode','value'=>'Barcode'),			
	array('key'=>'p.comm','value'=>'Commodity Code'),			
	array('key'=>'p.code','value'=>'Code'),			
	array('key'=>'p.price','value'=>'Price'),			
	array('key'=>'p.level','value'=>'Level'),			
	array('key'=>'p.suppid,p.name','value'=>'Supplier'),			
); ?>	
<select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
			<?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

<select name="order" >
	<option value="DESC" <?php echo ($order=='DESC')? 'selected':NULL; ?> >DESC</option>
	<option value="ASC" <?php echo ($order=='ASC')? 'selected':NULL; ?> >ASC</option>
</select>		
</td>
</tr>

<tr>
<th>View</th>
<td>
	<select name="view" >
		<option value="xls" <?php echo ($view=='xls')? 'selected':NULL; ?> >Printable</option>
		<option value="index" <?php echo ($view=='index')? 'selected':NULL; ?> >Editable</option>		
	</select>		
</td>
</tr>


<tr><th>Page | Count</th><th>
	<input class="vc40" id="page" name="page" value="<?php echo $page; ?>"  />
	<input class="vc40" id="limits" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:0; ?>"  />
<button onclick="nolimits();return false;" >All</button>
</th></tr>		
<tr><th>Size | Color</th><th>
	<input class="vc40" id="size" name="size" type="number"
		value="<?php echo (isset($_POST['size']))? $_POST['size']:1; ?>"  />
	<input class="vc60" id="color" name="color" 
		value="<?php echo (isset($_POST['color']))? $_POST['color']:'black'; ?>"  />		
</th></tr>		



</table>
</div>

<div class="clear" >&nbsp;</div>


<p class="" >
	<input type="submit" name="filter" value="Filter"  />
</p>

</form>


<div class="hd" id="names" >names</div>

<!-------------------------------------------------------------------->

<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
			
$(function(){
	chkAllvar('a');
	hd();
	$('#hdpdiv').hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
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
	// var url = gurl + '/products/supplier/' + ucid;		
	var url = gurl + '/products/roster/' + ucid;		
	window.location = url;			
		
}




</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

