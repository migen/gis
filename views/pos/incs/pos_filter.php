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
	</th></tr>
	
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_POST['start']))? $_POST['start']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_POST['end']))? $_POST['end']:$_SESSION['today']; ?>" /></td></tr>	

<tr>
<th>Type</th>
<td>
<input type="radio" name="is_sales" value="1" checked
<?php echo ((isset($params['is_sales'])) && ($params['is_sales']==1))? 'checked':NULL; ?> >Sales
<input type="radio" name="is_sales" value="0" 
<?php echo ((isset($params['is_sales'])) && ($params['is_sales']==0))? 'checked':NULL; ?>>Inventory
</td>
</tr>	
				
		
<tr>
<th>Format</th>
<td>
<input type="radio" name="is_summary" value="1" checked
<?php echo ((isset($params['is_summary'])) && ($params['is_summary']==1))? 'checked':NULL; ?> >Summary
<input type="radio" name="is_summary" value="0" 
<?php echo ((isset($params['is_summary'])) && ($params['is_summary']==0))? 'checked':NULL; ?>>Itemized
</td>
</tr>	
		

</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th>Category</th><td>
		<select name="prodtag_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodtags AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	<tr><th>Type</th><td>
		<select name="prodtype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	<tr><th>Group</th><td>
		<select name="prodsubtype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($prodsubtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
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
	
		<select class="vc100" onchange="getContactID('ecid');return false;" >
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
	array('key'=>'p.datetime','value'=>'Datetime'),
	array('key'=>'p.total','value'=>'Total'),
	array('key'=>'cc.name','value'=>'Customer'),			
	array('key'=>'p.terminal','value'=>'Terminal'),			
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
	<tr><th>Count | Page </th><td><input id="limits" class="vc80" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:LIMITS; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="nolimits();return false;" >All</button></td>
	</tr>
	
	<tr><th>Credit</th><td>
		<input type="radio" name="is_credit" value="1" accesskey="c" ><span class="b u" >C</span>redit
		<input type="radio" name="is_credit" value="0" ><span class="" >Cancel</span>
	</td></tr>
	
	<tr><th>Return</th><td>
		<input type="radio" name="is_return" value="1" accesskey="r" ><span class="b u" >R</span>eturn
		<input type="radio" name="is_return" value="0" >Cancel
	</td></tr>		
	
	<tr><th>Terminal</th><td><input class="pdl05 vc50" type="text" name="terminal" 
		value="<?php echo (isset($_POST['terminal']))? $_POST['terminal']:NULL; ?>" /></td></tr>
	

</table>
</div>

<div class="clear" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

