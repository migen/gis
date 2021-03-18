<?php 
// pr($clrow);
// pr($plrow);


$clname=$clrow['name'];
$plname=$plrow['name'];


?>

<h5>
	Yearend Honors
	
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr class="center" >
	<th rowspan=2>#</th>
	<th rowspan=2>Student</th>
	<th colspan=5>Scholastic</th>
	<th colspan=5>Conduct</th>
	<th rowspan=2>Total WTD Rank</th>
	<th rowspan=2>Overall Rank</th>
	<th rowspan=2>Overall Place</th>
</tr>

<tr class="center" >
	<th><?php echo $plname; ?><br />30%</th>
	<th><?php echo $clname; ?><br />70%</th>
	<th>Total</th>
	<th>Rank</th>
	<th>WTD Rank<br />8</th>
	
	<th><?php echo $plname; ?><br />30%</th>
	<th><?php echo $clname; ?><br />70%</th>
	<th>Total</th>
	<th>Rank</th>
	<th>WTD Rank<br />2</th>	
</tr>



</table>
</form>


