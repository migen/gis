<?php
// pr($employees);

// pr($_POST['ccid']);


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
	<tr><th>Supplier</th><td>
		<select class="vc150" name="suppid" >
			<option value="" >Supplier</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
					<?php echo (isset($_POST['suppid']) && $_POST['suppid']==$sel['id'])? 'selected':NULL; ?>
				><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>					
	</td></tr>			
	<tr><th>Comm </th><td><input name="comm" class="pdl05 vc150" 
	value="<?php echo (isset($_POST['comm']))? $_POST['comm']:NULL; ?>" /></td></tr>

</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="Customer" onclick="xgetContactsByPart();return false;" />		
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
<tr>
	<th>Report</th>
	<td><input type="radio" name="is_sales" value="1" checked />Sales</td>
</tr>					
		
<tr>
<th>Format</th>
<td>
<input type="radio" name="is_summary" value="1" checked
<?php echo ((isset($params['is_summary'])) && ($params['is_summary']==1))? 'checked':NULL; ?> >Summary
<input type="radio" name="is_summary" value="2" 
<?php echo ((isset($params['is_summary'])) && ($params['is_summary']==2))? 'checked':NULL; ?>>Itemized
</td>
</tr>	


	
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
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:'0'; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="zeroOut('limits');return false;" >All</button></td>
	</tr>
		
	<tr><th>Terminal</th><td><input class="pdl05 vc50" id="terminal" name="terminal" 
		value="<?php echo (isset($_POST['terminal']))? $_POST['terminal']:'0'; ?>" />
		<button onclick="zeroOut('terminal');return false;" >All</button>
		</td></tr>
	

</table>
</div>

<div class="clear screen" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

