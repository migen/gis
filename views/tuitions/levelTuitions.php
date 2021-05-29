<style>

.indented{ text-indent:20px; }
.indented-5{ text-indent:5px; }
.indented-10{ text-indent:10px; }
.indented-20{ text-indent:20px; }
.indented-30{ text-indent:30px; }
.indented-40{ text-indent:40px; }
.indented-50{ text-indent:50px; }

</style>



<h3>

	SY<?php echo $sy; ?> Level Tuition Fees | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tuitions/table/$sy"; ?>' >Table</a>
	
	<?php if(($_SESSION['srid']==RMIS) || ($level['is_finalized']==0)): ?>
		| <a href='<?php echo URL."tuitions/level/$lvl/$sy?edit"; ?>' >Edit</a>
	<?php endif; ?>
	| <a href="<?php echo URL.'tfeetypes/table'; ?>">Fees</a>



<?php if($lvl>13): ?>	
	| <span>&num= (SHAG)</span>
<?php endif; ?>	
</h3>

<?php 

// pr($data);

// pr($_SERVER);
// pr($level);

// pr($levels);

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
	<th>FeeID</th>
	<th class="vc200" >Detail</th>
	<th>Disp</th>
	<th>Amount</th>
	<th>Indent</th>
	<th>Pos</th>
	<th>Hd<br />Amt</th>
	<th class="center" >In<br />Total</th>
</tr>
<?php $total=0; ?>
<?php $total_tuition=0; ?>
<?php $total_nontuition=0; ?>

<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<?php $total_tuition+=($rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>
<?php $total_nontuition+=(!$rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>


<?php $is_child=($rows[$i]['parent_id']>0)? true:false; ?>
<?php $is_indented=($rows[$i]['indent']>0)? true:false; ?>
<?php $indent=$rows[$i]['indent']; ?>


<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['feetype_id']; ?></td>
	<td class="<?php echo ($is_indented)? "indented":NULL;  ?>" >
		<?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo ($rows[$i]['is_displayed']==1)? 'Y':''; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo $rows[$i]['indent']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><?php echo ($rows[$i]['amount_hidden']==1)? 'Y':''; ?></td>
	<td class="center" ><?php echo ($rows[$i]['in_total']==1)? 'Y':''; ?></td>
</tr>
<?php endfor; ?>


<tr><th colspan=8>&nbsp;</th></tr>

<tr>
	<th colspan=4>Total Tuition</th>
	<th class="right" ><?php echo number_format($total_tuition,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>

<tr>
	<th colspan=4>Total Non-Tuition</th>
	<th class="right" ><?php echo number_format($total_nontuition,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>


<tr>
	<th colspan=4>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th colspan=5 class="shd" ></th>
</tr>


</table>
