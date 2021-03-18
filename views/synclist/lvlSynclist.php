<?php 

// pr($classroom);

?>

<h3>
	Synclist Level (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <?php include_once('links_synclist.php'); ?>



</h3>

<h5>
Contacts - Enrollments - Summaries - Summext - CTP - Attd - Profiles
</h5>

<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'synclist/lvl/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> &nbsp;&nbsp; 
	<?php endforeach; ?>
</p>


<table class="gis-table-bordered table-altrow table-fx" >

<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Name</th>
	<th>Role</th>
	<th>Ucid</th>
	<th>Pcid</th>
	<th>En<br />Scid</th>
	<th>Summ<br />Scid</th>
	<th>Prof<br />Scid</th>
	<th>Sumx<br />Scid</th>
	<th>Attd<br />Scid</th>
	<th>Ctp<br />Scid</th>
	<th>Photo<br />Scid</th>
	<th>Actv</th>
	<th>M/	F</th>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['crid'].' - '.$rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['role_id']; ?></td>
	<td><?php echo $rows[$i]['ucid']; ?></td>
	<td class="<?php echo ($rows[$i]['ucid']!=$rows[$i]['pcid'])? "red":NULL; ?>" ><?php echo $rows[$i]['pcid']; ?></td>
	<td><?php echo $rows[$i]['enscid']; ?></td>
	<td><?php echo $rows[$i]['summscid']; ?></td>
	<td><?php echo $rows[$i]['profscid']; ?></td>
	<td><?php echo $rows[$i]['sumxscid']; ?></td>
	<td><?php echo $rows[$i]['attdscid']; ?></td>
	<td><?php echo $rows[$i]['ctpscid']; ?></td>
	<td><?php echo $rows[$i]['phscid']; ?></td>
	<td><?php echo ($rows[$i]['is_active']==1)? "Y":"N"; ?></td>
	<td><?php echo ($rows[$i]['is_male']==1)? "M":"F"; ?></td>	
	<td><a href="<?php echo URL.'contacts/ucis/'.$rows[$i]['ucid']; ?>" >Edit</a></td>
	<td><a href="<?php echo URL.'synclist/scid/'.$rows[$i]['ucid']; ?>" >Sync</a></td>
	
	
</tr>
<?php endfor; ?>
</table>

<div class="ht100 " >&nbsp;</div>
