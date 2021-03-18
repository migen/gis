<?php 



?>

<form method="GET" >
<p>
<table class="screen gis-table-bordered" >
<tr>
	<th>Start</th>
	<td><input class="pdl05" type="date" id="start" name="start"
		value="<?php echo (isset($_GET['start']))? $_GET['start']:$today; ?>" /></td>
	<th>End</th>
	<td><input class="pdl05" type="date" id="end" name="end"
		value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>	

<th>Fee</th>		
<td>
<select name="fee" class="vc100" >
	<option value="0" >All</option>
	<?php foreach($feetypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>	
</select>
</td>	

<th>Type</th>		
<td>
<select name="paytype" class="vc100" >
	<option value="0" >All</option>
	<?php foreach($paytypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>	
</select>
</td>	
	
<th>Page | Count</th><th>
	<input class="vc40" id="page" name="page" value="<?php echo $page; ?>"  />
	<input class="vc40" id="limits" name="limits" 
		value="<?php echo (isset($_GET['limits']))? $_GET['limits']:$limits; ?>"  />
<button onclick="nolimits();return false;" >All</button>
</th>
<td><input type="submit" name="filter" value="Filter"  /></td>	
	
</tr>
</table>
</p>
</form>




<!-------------------------------------------------------------->
<script>
var gurl = 'http://<?php echo GURL; ?>';

$(function(){

})




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>