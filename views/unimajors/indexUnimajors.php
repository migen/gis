<h5>
	College Majors | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'majors/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'majors/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'college'; ?>" >College</a>


</h5>

<?php 

debug($rows[0]);

?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="" >Code</th>
	<th class="" >Name</th>
	<th class="" >College</th>
	<th class="" >Years</th>
	<th class="" >Flowchart</th>
	<th class="" >Juxtapose</th>
	<th class="" >Crs</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['college_code']; ?></td>
	<td class="center" ><?php echo $rows[$i]['years']; ?></td>
	<td><a href="<?php echo URL.'uniflowcharts/major/'.$rows[$i]['id']; ?>" >Flowchart</a></td>
	<td><a href="<?php echo URL.'unicourses/juxtapose/'.$rows[$i]['id']; ?>" >Juxtapose</a></td>
	<td><a href="<?php echo URL.'uniflowcharts/sync/'.$rows[$i]['id']; ?>" >Sync</a></td>
	<td><a href="<?php echo URL.'majors/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
