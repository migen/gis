<h5>
	Student Requirements
	| <?php $this->shovel('homelinks'); ?>

	
</h5>

<?php

// pr($data);

debug($rows[0]);

?>

<h4>
<?php echo 
	$crsRow['classroom'].' - ' .$crsRow['label']; 

?>
</h4>

<p class="brown" >* Only score of zero will appear.</p>


<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Criteria</th>
<th>Wt</th>
<th>Activity</th>
<th>Activity<br />date</th>
<th>Max<br />score</th>
<th>Score</th>
<?php if(isset($_GET['debug'])): ?>
	<th>AID</th>
	<th>is_raw</th>
	<th>criteria_id</th>
	<th>criteria_code</th>
<?php endif; ?>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?php echo $i+1; ?></td>
<td><?php echo $rows[$i]['criteria']; ?></td>
<td><?php echo $rows[$i]['weight']+0; echo "%"; ?></td>
<td><?php echo $rows[$i]['activity']; ?></td>
<td><?php echo $rows[$i]['activity_date']; ?></td>
<td><?php echo $rows[$i]['max_score']+0; ?></td>
<td class="center" ><?php $score=($rows[$i]['score']); echo ($score==0) && ($rows[$i]['is_valid'])? "0":NULL; ?></td>

<?php if(isset($_GET['debug'])): ?>
	<td><?php echo $rows[$i]['activity_id']; ?></td>
	<td><?php echo $rows[$i]['is_raw']; ?></td>
	<td><?php echo $rows[$i]['criteria_id']; ?></td>
	<td><?php echo $rows[$i]['criteria_code']; ?></td>
<?php endif; ?>
</tr>
<?php endfor; ?>
</table>
