<?php



?>


<form method="GET" >

<div class="screen" style="width:40%;float:left;" >
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

	<tr><th>Search</th><td>
		<input class="pdl05 vc80" id="part" autofocus placeholder="Search" />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />		
	</td></tr>
	<tr><th>Contact ID</th><td>
		<input class="pdl05 vc50" name="ucid" id="ucid" placeholder="Contact"
			value="<?php echo (isset($_POST['ccid']))? $_POST['ccid']:NULL; ?>" />				
	</td></tr>

<tr><th>Level</th><td>
<select id="level" name="lvl" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['level']) && ($get['level']==$sel['id']))? 'selected':NULL; ?>		
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>

</tr>

<tr><th>Classroom</th><td>
<select id="classroom" name="crid" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['classroom']) && ($get['classroom']==$sel['id']))? 'selected':NULL; ?>
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
</tr>
		
</table>
<br />
</div>






<div class="screen" style="float:left;width:25%" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'p.date','value'=>'Date'),
	array('key'=>'p.timein','value'=>'Timein'),
	array('key'=>'p.timeout','value'=>'Timeout'),
	array('key'=>'c.name','value'=>'Name'),
	array('key'=>'cr.level_id','value'=>'Level'),
	array('key'=>'cr.name','value'=>'Classroom'),

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
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:'100'; ?>" />
		<input id="page" class="pdl05 vc50" type="number" name="page" 	
				value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/>		
		<button onclick="zeroOut('limits');return false;" >All</button></td>
	</tr>
			

</table>
</div>

<div class="clear" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

<?php

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
?>


<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";


var day_id = "<?php echo $day_id; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";


$(function(){
	hd();
})

function redirContact(ucid){
	$('#ucid').val(ucid);
}	/* fxn */


</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
