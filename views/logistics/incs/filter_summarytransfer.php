<?php 
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$fdm = "$year-$month_id-01";
	$ldm  = date('Y-m-t');
	$today=$_SESSION['today'];

?>


<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<script>
var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";

function redirLookup(ucid){
	// var url = gurl + '/products/view/' + ucid;		
	$('#prid').val(ucid);
	// window.location = url;			
}



</script>


<div style="float:left;width:50%;"  >
<form id="form" method="GET" >
<table class="gis-table-bordered" >

<tr><th colspan="2" >
	<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
	| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
</th></tr>

<tr>
	<th>Supplier</th>
	<td>
		<select name="supplier" class="vc200" >
			<option value="0" >All</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>		
		</select>
	</td>
</tr>

<tr>
	<th>Product
		<input class="vc50" name="prid" value="0" id="prid" readonly /></th>
	<td>
		<input class="pdl05" id="part" autofocus placeholder="Product" />
		<input type="submit" name="auto" value="Filter" onclick="xgetProductsByPart();return false;" />		
	</td>

</tr>



<tr>
	<th>To Terminal</th>
	<td>
		<select name="terminal" class="vc60" >
			<option value="0" >All</option>
			<?php foreach($terminals AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo 'T'.$sel['id']; ?></option>
			<?php endforeach; ?>		
		</select>
	</td>
</tr>


<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="dateone" 
	value="<?php echo $today; ?>" /></td></tr>
<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="datetwo" 
	value="<?php echo $today; ?>" /></td></tr>	


<tr><th colspan=2 >
	<input type="submit" name="filter" value="Filter" accesskey="f" />	
	<input type="submit" name="cancel" value="Clear" onclick="$('#form')[0].reset();return false;" />					
</th></tr>
	
	
</table>

</form>
</div>

<div class="third" id="names" ></div>
