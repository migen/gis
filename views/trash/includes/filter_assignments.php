

<table class="gis-table-bordered " >
<tr class="bg-gray2" >
	<th>SY</th>
	<th>Cat</th>
	<th>Type</th>
	<th>Group</th>
	<th>Product</th>
	<th>Supplier</th>
</tr>
<tr>
	<td><input type="number" min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo DBYR; ?>" name="sy" 
		class="center" value="<?php echo $sy; ?>" /></td>
	<td>
		<select name="prodtag_id" >
			<option value="" >Cat</option>
			<?php foreach($prodtags AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>				
	<td>
		<select name="prodtype_id" >
			<option value="" >Type</option>
			<?php foreach($prodtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>		
	<td>
		<select name="prodsubtype_id" >
			<option value="" >Group</option>
			<?php foreach($prodsubtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td>
		<select name="product_id" >
			<option value="" >Product</option>
			<?php foreach($products AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td>
		<select name="suppid" >
			<option value="0" >Supplier</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>		
	
</tr>
</table>

<br />

<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'pr.name','value'=>'Product'),
	array('key'=>'pt.name','value'=>'Type'),
	array('key'=>'ps.suppid','value'=>'Supplier ID'),			
	array('key'=>'p.terminal','value'=>'Terminal'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_GET['sort']))? $_GET['sort']:'p.datetime'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>
	<tr><th>Records / Page </th><td><input class="pdl05" type="number" name="limits" 
		value="200<?php // echo (isset($_GET['limits']))? $_GET['limits']:LIMITS; ?>" /></td></tr>
	<tr><th>Page</th><td><input class="pdl05" type="number" name="page" 
		value="<?php echo (isset($_GET['page']))? $_GET['page']:1; ?>"	/></td></tr>

		
	<tr><th colspan=2 >
		<input type="submit" name="filter" value="Filter" accesskey="f" />	
		<input type="submit" name="cancel" value="Clear" />					
	</th></tr>


</table>

