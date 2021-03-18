<?php
// pr($employees);
?>


<form method="POST" >

<div class="screen" style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
		| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>		
		| <a class="txt-blue underline" onclick="fbdate();return false;" >Date</a>		
	</th></tr>
	
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_POST['start']))? $_POST['start']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_POST['end']))? $_POST['end']:$_SESSION['today']; ?>" /></td></tr>			
	<tr><th>SY</th><td><input id="sy" class="pdl05 " type="number" name="sy" 
		value="<?php echo (isset($_POST['sy']))? $_POST['sy']:DBYR; ?>" /></td></tr>

				
<tr>
	<th>Returns</th>
	<td>
		<input type="radio" name="is_return" value="1" 
<?php echo ((isset($params['is_return'])) && ($params['is_return']==1))? 'checked':NULL; ?>		
		/>Returns
		<input type="radio" name="is_return" value="0" 
			<?php echo (!isset($params))? 'checked':NULL; ?>
		<?php echo ((isset($params['is_return'])) && ($params['is_return']==0))? 'checked':NULL; ?>					
		/>All
	</td>
</tr>	
		
</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >

<tr>
<th>Commodity</th>
<td>
	<select class="vc200" name="comm" >
		<option value="0" >Choose</option>
		<?php foreach($comm AS $sel): ?>
			<option value="<?php echo $sel['code']; ?>" 
			<?php echo ((isset($_POST['comm'])) && ($sel['code']==$_POST['comm']))? 'selected':NULL; ?> >
				<?php echo $sel['code'].' - '.$sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


	<tr><th>Category</th><td>
		<select name="prodtag_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodtags AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
<?php echo ((isset($params['prodtag_id'])) && ($sel['id']==$params['prodtag_id']))? 'selected':NULL; ?> 
				><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	<tr><th>Type</th><td>
		<select name="prodtype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
<?php echo ((isset($params['prodtype_id'])) && ($sel['id']==$params['prodtype_id']))? 'selected':NULL; ?> 				
				><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	<tr><th>Group</th><td>
		<select name="prodsubtype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodsubtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
<?php echo ((isset($params['prodsubtype_id'])) && ($sel['id']==$params['prodsubtype_id']))? 'selected':NULL; ?>			
				><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />			
		<input type="submit" name="auto" value="Customer" onclick="xgetContactsByPart();return false;" />		
	</td></tr>
	<tr><th>Product</th><td>		
		<input class="pdl05 vc50" name="product_id" id="prid" 
			value="<?php echo (isset($_POST['product_id']))? $_POST['product_id']:NULL; ?>" />
<input id="barcode" class="pdl05 vc100" onchange="xgetProductByBarcode();return false;" placeholder="Barcode" />			
	</td></tr>
	<tr><th>Contacts</th><td>
		<input class="pdl05 vc50" name="ccid" id="ccid" placeholder="Cust"
			value="<?php echo (isset($_POST['ccid']))? $_POST['ccid']:NULL; ?>" />			
		<input class="pdl05 vc50" name="ecid" id="ecid" placeholder="Empl" 
			value="<?php echo (isset($_POST['ecid']))? $_POST['ecid']:NULL; ?>" />
	
		<select class="vc100" onchange="getContactID('ecid',this.value);return false;" >
			<option value="" >Employee</option>
			<?php foreach($employees AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>			
	</td></tr>


	
</table>

</div>




<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'product','value'=>'Product'),
	array('key'=>'sold','value'=>'Sold Qty'),
	array('key'=>'revenues','value'=>'Revenues'),
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" class="vc80" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'p.datetime'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_POST['order']) && $_POST['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>
	<tr><th>Count | Page </th><td><input id="limits" class="pdl05 vc80" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:'0'; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="zeroOut('limits');return false;" >All</button></td>
	</tr>
		
	<tr><th>Terminal</th><td><input class="pdl05 vc50" id="terminal" name="terminal" 
		value="<?php echo (isset($_POST['terminal']))? $_POST['terminal']:'0'; ?>" />
		<button onclick="zeroOut('terminal');return false;" >All</button>
		</td></tr>

<?php if($_SESSION['srid']==RMIS): ?>
	<tr><th>Debug</th><td><input class="pdl05 vc50" name="debug" type="number"
		value="<?php echo (isset($_POST['debug']))? $_POST['debug']:'0'; ?>" /></td></tr>
<?php endif; ?>
		

</table>
</div>

<div class="clear screen" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

