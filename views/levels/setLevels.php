<h5>
	Levels Data Set (&order=<?php echo $order; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <?php $this->shovel('links_gset'); ?>
	
</h5>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Label</th>
	<th>Code</th>
	<th>Name</th>
	<th>Sub<br />Dept</th>
	<th>Dept</th>
	<th>W_C_DG</th>
	<th>Is<br />Equiv</th>
	<th>Is<br />Sem</th>
	<th>Is<br />Ps</th>
	<th>Is<br />Gs</th>
	<th>Is<br />Hs</th>
	<th>Is<br />Finalzd<br />Rankng</th>
	<th>Cdt<br />Affects<br />Rankng</th>
	<th>Cdt<br />Ctype</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['subdepartment_id']; ?></td>
	<td><?php echo $rows[$i]['department_id']; ?></td>
	<td><?php echo $rows[$i]['with_conduct_dg']; ?></td>
	<td><?php echo $rows[$i]['is_equiv']; ?></td>
	<td><?php echo $rows[$i]['is_sem']; ?></td>
	<td><?php echo $rows[$i]['is_ps']; ?></td>
	<td><?php echo $rows[$i]['is_gs']; ?></td>
	<td><?php echo $rows[$i]['is_hs']; ?></td>
	<td><?php echo $rows[$i]['is_finalized_ranking']; ?></td>
	<td><?php echo $rows[$i]['conduct_affects_ranking']; ?></td>
	<td><?php echo $rows[$i]['conduct_ctype_id']; ?></td>
	<?php if($sy==DBYR): ?>
		<td><a href="<?php echo URL.'levels/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>

