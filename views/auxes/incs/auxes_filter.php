<?php
// pr($employees);
?>


<form method="POST" >

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="Customer" onclick="xgetContactsByPart();return false;" />		
	</td></tr>
	<tr><th>Student</th><td>
		<input class="pdl05 vc50" name="scid" id="ccid" placeholder="Cust"
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
	
	<tr>
	<th>Add/Disc</th>
	<td>
		<select name="auxtype" >
			<option value="0" >All</option>
			<option value="2" >Addons</option>
			<option value="1" >Discounts</option>			
		</select>
	</td>
	</tr>

	<tr><th>Fee Type</th><td>
		<select name="feetype_id" class="vc200" >
			<option value="0" >Select</option>
			<?php foreach($feetypes AS $sel): ?>
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
	array('key'=>'cr.level_id,cr.section_id','value'=>'Classroom'),
	array('key'=>'sc.name','value'=>'Student'),
	array('key'=>'ft.name','value'=>'Feetype'),
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

