<?php 

// pr($prid);
// pr($prefix);

// pr($prodcategories);
// pr($_SESSION['q']);
	
?>

<h5> New Products 
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>

</h5>

<form method="GET" >
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr><th>Find</th>
		<td><input class="pdl05" id="part" autofocus  />
		<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPart();return false;" />
	</td></tr>
	<tr><th>Prefix</th>
		<td><input name="prefix" value="<?php echo $prefix; ?>" class="pdl05" />
		<input type="submit" name="submit" value="Prefix" />
	</td></tr>	
</table></p>
</form>

<div class="hd" id="names" >names</div>


<div style="width:60%;float:left;"  >
<form method="POST"  >
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th class="vc80" >ID</th>
	<th class="vc150" >	
		<select id="isubtype" class='full'>	
			<option>-SUBTYPE-</option>
			<?php foreach($prodsubtypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].'-'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('subtype');" >		
	</th>		
	<th class="vc150" >	
		<select id="isupp" class='full'>	
			<option>-SUPPLIER-</option>
			<?php foreach($suppliers as $sel): ?>
				<option value="<?php echo $sel['parent_id']; ?>"> <?php echo $sel['name'].'-'.$sel['parent_id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('supp');" >		
	</th>		
	<th class="vc50"  >UOM</th>
	<th class="vc50"  >Barcode</th>
	<th class="vc200"  >Name</th>
	<th class="vc100"  >Cost</th>
	<th class="vc100"  >Price</th>
	<th class="vc100"  >Level</th>
	<th class="vc100"  >Remarks</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<?php $id+=1; $prid++; ?>
<tr>
	<td><input id="id<?php echo $i; ?>" class="full" name="posts[<?php echo $i; ?>][id]" 
		tabindex="10" value="<?php echo $id; ?>" /></td>
	<td>
		<select id="subtype<?php echo $i; ?>" class="full subtype" tabindex="20" 
			name="posts[<?php echo $i; ?>][prodsubtype_id]"  >
			<?php	foreach($prodsubtypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name'].' - #'.$sel['id']; ?></option>
					<?php	endforeach; ?>				
		</select>
	</td>			

	<td>
		<select id="supp<?php echo $i; ?>" class="full supp" tabindex="30" 
			name="posts[<?php echo $i; ?>][suppid]"  >
			<?php	foreach($suppliers as $sel): ?>
				<option value="<?php echo $sel['parent_id']; ?>"><?php echo $sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>			

	<td><input id="uom<?php echo $i; ?>" class="full pdl05" type="text" name="posts[<?php echo $i; ?>][uom]" 
		tabindex="40" value="pc" /></td>
	
	<?php $barcode="{$prefix}{$prid}"; ?>
	<td><input id="code<?php echo $i; ?>" class="full pdl05" type="text" name="posts[<?php echo $i; ?>][barcode]" 
		tabindex="50" value="<?php echo $barcode; ?>" /></td>
		
	<td><input id="name<?php echo $i; ?>" class="full pdl05" type="text" name="posts[<?php echo $i; ?>][name]" 
		tabindex="60" /></td>
	
	<td><input id="cost<?php echo $i; ?>" class="full pdr05 right" type="text" name="posts[<?php echo $i; ?>][cost]" 
		tabindex="70" /></td>

	<td><input id="price<?php echo $i; ?>" class="full pdr05 right" type="text" name="posts[<?php echo $i; ?>][price]" 
		tabindex="80" /></td>
	
	
	<td><input id="level<?php echo $i; ?>" class="full pdr05 right" type="text" name="posts[<?php echo $i; ?>][level]" 
		tabindex="90"	/></td>
	
	<td><input id="remarks<?php echo $i; ?>" class="full pdr05 right" type="text" 
		name="posts[<?php echo $i; ?>][remarks]" tabindex="100" /></td>
</tr>

<?php endfor; ?>			
</table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'products'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->



</table>

<!------------------------------------------------------------------------->

<p><?php $this->shovel('numrows'); ?></p>

</div>	<!-- seventy left -->


<!--------------------------------------------------------------------------------------------->

<p class="smartboard" >
<select id="classbox" >
	<option value="id" >ID</option>
	<option value="subtype" >Type</option>
	<option value="supp" >Supplier</option>
	<option value="uom" >UOM</option>
	<option value="code" >Barcode</option>
	<option value="name" >Name</option>
	<option value="cost" >Cost</option>
	<option value="price" >Price</option>
	<option value="level" >Level</option>
	<option value="remarks" >Remarks</option>
</select>
</p>

<?php $d['width'] = '25'; ?>
<?php $this->shovel('smartboard',$d); ?>

<!--------------------------------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	itago('smartboard');
	nextViaEnter();
	selectFocused();
	hd();
	$('html').live('click',function(){
		$('#names').hide();
	});

})


function redirLookup(ucid){
	var url = gurl + '/students/sectioner/' + ucid;	
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
