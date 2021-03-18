<?php
// pr($employees);
?>


<form method="GET" >

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
				
				

</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="Customer" onclick="xgetContactsByPart();return false;" />		
	</td></tr>
	<tr><th>Student</th><td>
		<input class="pdl05 vc50" name="scid" id="ccid" placeholder="Cust"
			value="<?php echo (isset($_POST['ccid']))? $_POST['ccid']:NULL; ?>" />			
	
		<select id="ecid" name="ecid" class="vc100" onchange="getContactID('ecid');return false;" >
			<option value="" >Employee</option>
			<?php foreach($employees AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
				<?php echo (isset($_POST['ecid']) && ($sel['id']==$_POST['ecid']))? 'selected':NULL; ?> >
					<?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endforeach; ?>
		</select>			
	</td></tr>

	<tr><th>Fee Type</th><td>
		<select name="feetype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>

	<tr><th>Pay Type</th><td>
		<select name="paytype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>	
	
	<tr><th>Level</th><td>
		<select name="lvlid" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	
	<tr><th>Classroom</th><td>
		<select name="crid" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	
</table>
</div>



<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'p.orno','value'=>'OR Number'),
	array('key'=>'p.date','value'=>'Date'),
	array('key'=>'cr.level_id,cr.name','value'=>'Classroom'),
	array('key'=>'ft.name','value'=>'Feetype'),
	array('key'=>'cc.name','value'=>'Customer'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" class="vc80" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'p.orno'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="ASC">ASC</option>
			<option value="ASC" <?php echo (isset($_POST['order']) && $_POST['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
			<option value="DESC">DESC</option>
		</select>		
	</td></tr>
	<tr><th>Count | Page </th><td><input id="limits" class="vc80" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:0; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="nolimits();return false;" >All</button></td>
	</tr>
		

</table>
</div>

<div class="clear" >
	<input type="submit" name="filter" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

