<h3>
	Enrolled Summary (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'tsum/sync'; ?>" >Tsum</a>
	| <a href="<?php echo URL.'abc/syncLevelTsumDetails&num='.$num; ?>" >Update</a>
	<?php if($num==1): ?>
		| <a href="<?php echo URL.'abc/enrolled/'.$lvl.'&num=2'; ?>" >EC</a>
	<?php else: ?>
		| <a href="<?php echo URL.'abc/enrolled/'.$lvl.'&num=1'; ?>" >Regular</a>
	<?php endif; ?>

</h3>


<table class="gis-table-bordered" >
<tr>
	<th>Tuition Amount</th><th class="right" ><?php echo number_format($tuition['tuition_amount'],2); ?></th>
	<th>Total Amount</th><th class="right" ><?php echo number_format($tuition['total_amount'],2); ?></th>
</tr>

</table>
<br />

<table class="gis-table-bordered" >
<tr>
	<th>Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>Paymode</th>
	<th>Enrolled<br />Amount</th>
	<th>Paid<br />Amount</th>
	<th>Balance</th>
	<th>Status</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php extract($rows[$i]); ?>
<?php // $balance=$enrolled_amount-$tfee_paid; ?>
<tr>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td class="right" ><?php echo number_format($enrolled_amount,2); ?></td>
	<td class="right" ><?php echo number_format($tfee_paid,2); ?></td>
	<td class="right" ><?php echo number_format($enrolled_balance,2); ?></td>
	<td><?php echo ($enrolled_balance<=0)? 'Enrolled':'-'; ?></td>

</tr>
<?php endfor; ?>
</table>
