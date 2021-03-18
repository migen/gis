<h3>
	Student Tuition Fees | <?php $this->shovel('homelinks'); ?>
	
</h3>

<?php 


?>

<table class="gis-table-bordered" >
	<tr><th>Level
		<?php echo ($num>1)? '-Num':NULL; ?>
	</th><td><?php echo $level['name'].' #'.$level['id']; ?>
		<?php echo ($num>1)? "-{$num}":NULL; ?>
	</td>
	<th>Assessed</th><th><?php echo number_format($level['amount'],2); ?></th>
	</tr>
</table><br />


<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'tuitions/level/'.$sel['id'].DS.$sy; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>

<br />
<br />


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th class="vc200" >Detail</th>
	<th>Disp</th>
	<th>Amount</th>
	<th>In<br />Total</th>
</tr>
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=($rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo ($rows[$i]['is_displayed']==1)? 'Y':''; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo ($rows[$i]['in_total']==1)? 'Y':''; ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th colspan=3>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th></th>
</tr>
</table>
