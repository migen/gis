<?php 
	// pr($data);
	
$cr = $classrooms; 	
// pr($cr);
?>

<h5>
	Chinese Index

	
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Classroom</th>
	<th>Tally</th>
	<th>Rank</th>
	<th>Report</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $cr[$i]['crid']; ?></td>
	<td><?php echo $cr[$i]['classroom']; ?></td>
<td>
<?php if($cr[$i]['sem2']): ?>
<a href='<?php echo URL."aggregates/tally/".$cr[$i]['crid'].DS.$cr[$i]['crsid'].DS.$cr[$i]['subid']."/$sy/$qtr"; ?>' >
	Sem2</a>
<?php else: ?>	
<a href='<?php echo URL."aggregates/tally/".$cr[$i]['crid'].DS.$cr[$i]['crsid'].DS.$cr[$i]['subid']."/$sy/$qtr"; ?>' >
	Tally</a>
<?php endif; ?>	
</td>
<td><a href='<?php echo URL."alien/sumoRanking/".$classrooms[$i]['crid']."/$sy/$qtr"; ?>' >Rank</a></td>
<td><a href='<?php echo URL."rcards/crid/".$classrooms[$i]['crid']."/$sy/$qtr"; ?>' >Card</a></td>
</tr>
<?php endfor; ?>
</table>