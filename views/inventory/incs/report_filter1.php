<?php

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));


?>


<form method="GET" >

<div class="screen" style="width:35%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr>
		<th colspan=4 >
			<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
			| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
			| <a class="txt-blue underline" onclick="fbtoday();return false;" >Today</a>			
			| <a class="txt-blue underline" onclick="fbdate();return false;" >Date</a>			
			<input class="vc120" type="date" id="date" value="<?php echo $today; ?>" /> 
		</th>
	</tr>
	<tr>
		<th>Start</th>
		<td><input id="start" class="pdl05 " type="date" name="start" 
			value="<?php echo (isset($_GET['start']))? $_GET['start']:$_SESSION['today']; ?>" />
		</td>
		<th>Supplier</th>
		<td>
			<select class="vc150" name="suppid" >
				<?php foreach($suppliers AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" 
						<?php echo (isset($_GET['suppid']) && $_GET['suppid']==$sel['id'])? 'selected':NULL; ?>
					><?php echo $sel['name'].' #'.$sel['id']; ?></option>
				<?php endforeach; ?>
			</select>					
		</td>							
			
	</tr>
	<tr>
		<th>End</th>
		<td><input id="end" class="pdl05 " type="date" name="end" 
			value="<?php echo (isset($_GET['end']))? $_GET['end']:$_SESSION['today']; ?>" />
		</td>
		<th colspan="2" ></th>		
	</tr>			

</table>
<br />
</div>







<div class="clear screen" >
	<input type="submit" name="submit" value="Filter" accesskey="g" />	
	<input type="submit" name="cancel" value="Clear" />					
</div>

</form>

<div class="hd" id="names" >names</div>

<script>
var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var today  = "<?php echo $today; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";

$(function(){
	hd();
	// alert(tomorrow);
})


function fbtoday(){
	$('#start').val(today);
	$('#end').val(today);
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/reports.js"; ?>' ></script>
