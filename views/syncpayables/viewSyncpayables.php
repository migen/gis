<h3>

	View Query (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	Payables - <a href="<?php echo URL.'syncPayables/batchUpdate'; ?>" >Update</a>

</h3>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Pkid</th>
	<th>SY</th>
	<th>Scid</th>
	<th>Lvl</th>
	<th>Crid</th>
	<th>Feetype</th>
	<th>Ptr</th>
	<th>Student</th>
	<th>Amount</th>
	<th></th>
</tr>
<?php foreach($rows AS $i => $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['pkid']; ?></td>
	<td><?php echo $row['sy']; ?></td>
	<td><?php echo $row['scid']; ?></td>
	<td><?php echo $row['level_id']; ?></td>
	<td><?php echo $row['crid']; ?></td>
	<td><?php echo $row['feetype'].' - #'.$row['feetype_id']; ?></td>
	<td><?php echo $row['ptr']; ?></td>
	<td><?php echo $row['student']; ?></td>
	<td><?php echo number_format($row['amount'],2); ?></td>
	<td>
		<a href="<?php echo URL.'students/links/'.$row['scid'].DS.$row['sy']; ?>">Links</a>
		| <a href="<?php echo URL.'enrollment/ledger/'.$row['scid'].DS.$row['sy']; ?>">Ledger</a>
	</td>
</tr>
<?php endforeach; ?>
</table>


<div class="ht100" ></div>