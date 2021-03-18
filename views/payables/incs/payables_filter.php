<?php
// pr($employees);
?>


<form method="GET" >

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >

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

	<tr><th>SY</th><td>
		<select class="full" name="sy" >		
			<option value="<?php echo DBYR; ?>" 
				<?php echo ($sy==(DBYR))? '':NULL; ?>
			><?php echo DBYR; ?></option>
			<?php if($_SESSION['settings']['sy_enrollment']>DBYR): ?>
				<option value="<?php echo (DBYR+1); ?>" 
					<?php echo ($sy==(DBYR+1))? 'selected':NULL; ?>
				><?php echo (DBYR+1); ?></option>			
			<?php endif; ?>			
			<option value="" <?php echo (!isset($_GET['sy']))? 'selected':NULL; ?> >All school years</option>			
		</select>	
	</td></tr>	

	
</table>
</div>



<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'p.feetype_id','value'=>'Feetype'),
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

