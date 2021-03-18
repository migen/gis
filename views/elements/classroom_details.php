<?php 
$cr=$data;

?>

<p>
<table class="gis-table-bordered table-altrow" >
<tr>
	<th class="vc100" >Classroom</th>
	<td>ID#<?php echo $cr['id'].'-'.$cr['name']; ?></td>
	<th>Adviser</th>
	<td>ID#<?php echo $cr['acid'].'-'.$cr['adviser']; ?></td>
</tr>
</table>
</p>