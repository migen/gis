<h5>
	Criteria (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'criteria/editable'; ?>" >Editable</a>
	| <a href="<?php echo URL.'critypes'; ?>" >Critypes</a>
	| <a href="<?php echo URL.'criteria/add'; ?>" >Add</a>

<span> | (0) Pct (1) Raw (2) Trns </span>
	

</h5>

<?php 

// pr($rows[0]);

?>


<table class="gis-table-bordered table-altrow" >
<tr class='headrow'>
	<th></th>
	<th>ID</th>
	<th>Comp</th>	
	<th>Crs<br />Type</th>	
	<th>Code</th>	
	<th>Cri<br />Type</th>	
	<th>Criteria</th>
	<th>Pos</th>	
	<th>Actv</th>	
	<th>List</th>	
	<th>
		(0) Raw<br />
		(1) Pct<br />
		(2) Trns</th>	
	<th>Edit</th>
	<th class="hd" >DEL</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><a href="<?php echo URL.'components/filter?filter&criteria_id='.$rows[$i]['id']; ?>" >Comp</a></td>
	<td><?php echo $rows[$i]['crstype_id']; ?></td>	
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['critype_id']; ?></td>
	<td class="vc500" ><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><?php echo $rows[$i]['is_active']; ?></td>
	<td><?php echo $rows[$i]['is_kpup_list']; ?></td>
	<td><?php echo $rows[$i]['is_raw']; ?></td>
	<td><a href="<?php echo URL.'criteria/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
	<td><a href="<?php echo URL.'criteria/delete/'.$rows[$i]['id']; ?>" onclick="return confirm('Sure?');" >Delete</a></td>
</tr>
<?php endfor; ?>

</table>

<div class="ht50" ></div>

