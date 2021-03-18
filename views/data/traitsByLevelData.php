<h5>
	Traits 
	| <?php $this->shovel('homelinks'); ?>
	| <?php $this->shovel('links_gset'); ?>
	
	
</h5>

<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'data/traits/'.$sel['id'].DS.$sy; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>

<p>
	&order | &crstype_id
</p>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Subject</th>
	<th>Critype</th>
	<th>Criteria</th>
	<th>Weight</th>
	<th>Pos</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['subject_id'].' - '.$rows[$i]['subject']; ?></td>
	<td><?php echo '#'.$rows[$i]['critype_id'].' - '.$rows[$i]['critype']; ?></td>
	<td><?php echo '#'.$rows[$i]['criteria_id'].' - '.$rows[$i]['criteria']; ?></td>
	<td><?php echo $rows[$i]['weight']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td>
		<a href="<?php echo URL.'components/edit/'.$rows[$i]['pkid']; ?>" >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>
