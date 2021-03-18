<h5>
	Flowchart - <?php echo $major['name'].' #'.$major['id']; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniflowcharts/batch/'.$major_id; ?>" >Create</a>
	| <a href="<?php echo URL.'uniflowcharts'; ?>" >Flowcharts</a>
	| <a href="<?php echo URL.'uniflowcharts/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniflowcharts/sync/'.$major_id; ?>" >Sync</a>
	
</h5>

<p>
Sxns: <?php foreach($crids_array AS $row): ?>
	<a href="<?php echo URL.'uniclassrooms/courses/'.$row['crid']; ?>" ><?php echo $row['sxncode']; ?></a>&nbsp;
<?php endforeach; ?>
| Majors: 
<?php foreach($majors AS $row): ?>
	<a href="<?php echo URL.'uniflowcharts/major/'.$row['id']; ?>" ><?php echo $row['code']; ?></a>&nbsp;
<?php endforeach; ?>

</p>

<?PHP
// pr($data);
 ?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Lvl</th>
	<th>Sem</th>
	<th>Subject</th>
	<th>Prerequisites</th>
	<td></td>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $id=$rows[$i]['fid']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="center" ><?php echo 'Y'.$rows[$i]['level_id']; ?></td>
	<td class="center" ><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['prerequisites']; ?></td>
	<td><a href='<?php echo URL."uniflowcharts/edit/$id"; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
