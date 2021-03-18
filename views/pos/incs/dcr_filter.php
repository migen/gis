<?php

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));


?>


<form method="GET" >

<div class="screen" style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan="5" >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
		| <a class="txt-blue underline" onclick="dateToday(today);return false;" >Today</a>		
	</th></tr>
	
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="start" 
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$today; ?>" /></td>
		<th>End</th><td><input id="end" class="pdl05 " type="date" name="end" 
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>
		<td><input type="submit" name="filter" value="Filter" accesskey="f" /></td>
	</tr>		
</table>





<div class="clear" ></div>

</form>



<script>
var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var today  = "<?php echo $today; ?>";


</script>

<script type="text/javascript" src='<?php echo URL."views/js/reports.js"; ?>' ></script>
