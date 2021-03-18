<?php

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

	

?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/filters.js"></script>


<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var day_id = "<?php echo $day_id; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";

var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";

$(function(){
	hd();
	$('#hdpdiv').hide();
	excel();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
	

})


function redirContact(ucid){	
	$('#ucid').val(ucid);
}	/* fxn */


</script>

<form method="GET" >


<div class="screen" style="width:35%;float:left;" >

<table class="gis-table-bordered" >
<tr><th class="vc150" >Date</th>
<td><input type="date" id="date" value="<?php echo (isset($params['start']))? $params['start']:$today; ?>" /></td>
</tr>
</table>
<br />

<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
		| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>
		| <a class="txt-blue underline" onclick="fbdate();return false;" >Date</a>
	</th></tr>
	
	<tr><th class="vc150" >Start</th><td><input id="start" class="pdl05" type="date" name="dateone" 
		value="<?php echo (isset($_POST['start']))? $_POST['start']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="datetwo" 
		value="<?php echo (isset($_POST['end']))? $_POST['end']:$_SESSION['today']; ?>" /></td></tr>	

	<tr><th>Module</th><td>
		<select name="module"  >
			<option value="0" >Select</option>
			<?php foreach($modules AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	
	<tr><th>Action</th><td>
		<select name="action"  >
			<option value="0" >Select</option>
			<?php foreach($axn AS $k => $v): ?>
				<option value="<?php echo $v; ?>" >
					<?php echo $k; ?></option>
			<?php endforeach; ?>
		</select>				
	</td></tr>
	
	<tr><th>Classroom</th><td>
		<select name="crid"  >
			<option value="0" >Select</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>					
	</td></tr>	

	<tr><th>Course</th><td>
		<select name="crsid"  >
			<option value="0" >Select</option>
			<?php foreach($courses AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>					
	</td></tr>		
	
	<tr>
		<th><span class="u b" >C</span>ontact</th>
		<td>
			<input style="padding-left:5px;width:100px;" id="part" accesskey="c" />		
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />		
		</td>
	</tr>
		
	<tr><th>UC | SC | EC</th><td>
		<input name="ucid" id="ucid" class="vc50"  />
		<input name="scid" id="scid" class="vc50"  />
		<input name="ecid" id="ecid" class="vc50"  />
	</td></tr>

	<tr><th>OR No</th><td><input name="orno" id="orno" class="vc200"  /></td></tr>
	<tr><th>Details</th><td><input name="details" id="details" class="vc200"  /></td></tr>
		
</table>
</div>

<div class="half screen" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'l.datetime','value'=>'Datetime'),
	array('key'=>'c.name','value'=>'User'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'l.datetime'; ?>
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
	<tr><th>Records / Page </th><td><input class="pdl05" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:LIMITS; ?>" /></td></tr>
	<tr><th>Page</th><td><input class="pdl05" type="number" name="page" 
		value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/></td></tr>
		
		
	<tr><th colspan=2 >
		<input type="submit" name="filter" value="Generate" accesskey="g" />	
		<input type="submit" name="cancel" value="Clear" />					
	</th></tr>


</table>
</div>


</form>


<div class="hd" id="names" >names</div>