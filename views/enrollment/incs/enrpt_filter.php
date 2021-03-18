
<div class="screen" >
<form method="GET" >

<table class="gis-table-bordered" >
<tr>
<th>SY</th>
<td><input class="pdl05 vc100" type="number" id="sy" name="sy" 
	value="<?php echo (isset($_GET['sy']))? $_GET['sy']:$sy; ?>" /></td>
</tr>

<tr>
<th>Date From</th>
<td><input class="pdl05" type="date" id="beg" name="beg"
	value="<?php echo (isset($_GET['beg']))? $_GET['beg']:$today; ?>" /></td>
</tr>

<tr>
<th>Date To</th>
<td><input class="pdl05" type="date" id="end" name="end"
	value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>	
</tr>

	
<tr><th>With Parents?</th>
<td>
	<select name="parents" >
		<option value="0" >No</option>
		<option value="1" >Yes</option>
	</select>
</td>
</tr>	
	
	
<tr><th>Level From</th>
<td>
	<select name="lvlbeg" >
		<option value="0" >Choose One</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Level To</th>
<td>
	<select name="lvlend" >
		<option value="0" >Choose One</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Paymode</th>
<td>
	<select name="mode" >
		<option value="0" >All</option>
		<?php foreach($paymodes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Payments</th>
<?php $pointers = array(
	array('id'=>'0','name'=>'Reservation'),			
	array('id'=>'1','name'=>'First'),			
	array('id'=>'2','name'=>'Second'),			
	array('id'=>'3','name'=>'Third'),			
	array('id'=>'4','name'=>'Fourth'),			
	array('id'=>'10','name'=>'All'),			

); ?>


<td>
	<select name="ptr" >
		<option value="8" >Upto</option>
		<?php foreach($pointers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Scope</th>
<td>
	<select name="scope" >
		<option value="1" >Inclusive</option>
		<option value="0" >Exclusive</option>

	</select>
</td>
</tr>
<tr>

<tr>
<th>Clsrm Num</th>
<td><input class="pdl05 vc100" type="number" id="num" name="num" 
	value="<?php echo (isset($_GET['num']))? $_GET['num']:null; ?>" /></td>
</tr>

<tr>
<th>Sort</th>
<td><?php $sorts = array(
	array('key'=>'c.name,p.date DESC','value'=>'Student'),			
	array('key'=>'l.id,c.name,p.date DESC','value'=>'Level'),			
	array('key'=>"p.date DESC,l.id,cr.id,c.name",'value'=>'Date'),		
); ?>	
<select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>"  ><?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

</td>
</tr>


<tr><td colspan="2" ><input type="submit" name="filter" value="Filter" /></td></tr>

</table>

</form>
</div>
