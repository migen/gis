<?php
// pr($employees);

// pr($_GET['ccid']);


?>


<form method="GET" >

<div class="screen" style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
		| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>		
		| <a class="txt-blue underline" onclick="fbdate();return false;" >Date</a>		
	</th></tr>
	
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$_SESSION['today']; ?>" /></td></tr>

</table>
<br />
</div>

<div class="screen" style="width:30%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >

	<tr><th>Item/Remarks</th><td><input name="item" class="pdl05 full" 
		value="<?php echo (isset($_GET['item']))? $_GET['item']:NULL; ?>" /></td></tr>		
	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="User" onclick="xgetContactsByPart();return false;" />		
		<input class="pdl05 vc50" name="ucid" id="ucid" placeholder="UCID"
			value="<?php echo (isset($_GET['ucid']))? $_GET['ucid']:NULL; ?>" />					
	</td></tr>
	<tr>
		<th>Status</th>
		<td><select name="is_done" >
			<option value="0" >Pending</option>
			<option value="1" >Done</option>
			<option value="2" >All</option>
		</select></td>
	</tr>	
	
</table>

</div>




<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'t.date','value'=>'Datetime'),
	array('key'=>'t.is_done','value'=>'Status'),
	array('key'=>'c.name','value'=>'User'),
); ?>



<tr><th>Sort | Order</th><td>
	<select name="sort" class="vc80" >
		<?php $sort_key = (isset($_GET['sort']))? $_GET['sort']:'t.date'; ?>
		<?php foreach($sorts AS $sel): ?>
			<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
				<?php echo $sel['value']; ?></option>
		<?php endforeach; ?>	
	</select>

<select name="order" >
	<option value="DESC" <?php echo (isset($_GET['order']) && $_GET['order']=='DESC')? 'selected':NULL; ?>  >DESC</option>
	<option value="ASC">ASC</option>
</select>		
	</td></tr>
	<tr><th>Count | Page </th><td><input id="limits" class="vc80 pdl05" type="number" name="limits" 
		value="<?php echo (isset($_GET['limits']))? $_GET['limits']:$num_tasks; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_GET['page']))? $_GET['page']:1; ?>"	/>		
		<button onclick="zeroOut('limits');return false;" >All</button></td>
	</tr>
			

</table>
</div>

<div class="clear screen" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

