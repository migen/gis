<?php 

$st=array('STEM','HUMMS','ABM','GAS');


// pr($rows[26]);

?>



<h3>
	<?php echo ($is_conso)? 'Consolidated':'Level by Num'; ?> Enrollment (<?php echo ($lvl)? $count:0; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'tsum/sync'; ?>" >Tsum</a>
	| <span onclick="traceshd();" >SHD</span>
	
<?php if(!$is_conso): ?>	
		| <a href="<?php echo URL.'enrollment/conso/'.$lvl; ?>" >Consolidated</a>		
<?php else: ?>
		| <a href="<?php echo URL.'enrollment/level/'.$lvl; ?>" >Level by Num</a>		
<?php endif; ?>

<?php if($lvl): ?>	
		| <a href="<?php echo URL.'enrollment/syncLevelTsumDetails/'.$lvl; ?>" >Update</a>
		<?php if($num==1): ?>
			| <a href="<?php echo URL.'enrollment/level/'.$lvl.'&num=2'; ?>" >EC</a>
		<?php else: ?>
			| <a href="<?php echo URL.'enrollment/level/'.$lvl.'&num=1'; ?>" >Regular</a>
		<?php endif; ?>
	| <a class="u" id="btnExport" >Excel</a> 

	<?php if(!isset($_GET['all'])): ?>
		| <a href="<?php echo URL.'enrollment/level/'.$lvl.'&num='.$num.'&all'; ?>" >All</a>		
	<?php else: ?>
		| <a href="<?php echo URL.'enrollment/level/'.$lvl.'&num='.$num; ?>" >Enrolled</a>		
	<?php endif; ?>

	<?php if($lvl>13): ?>
		<?php for($i=0;$i<4;$i++): ?>
			| <a href="<?php echo URL.'enrollment/level/'.$lvl.'&num='.($num+1); ?>" ><?php echo $st[$i]; ?></a>		
		<?php endfor; ?>
	<?php endif; ?>


		
<?php endif; ?>




</h3>

<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'enrollment/level/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>



<?php if($lvl): ?>

<table class="gis-table-bordered" >
<tr>
	<th>Level </th><th class="right" ><?php echo $tuition['level']; ?></th>
	<th>Tuition Amount</th><th class="right" ><?php echo number_format($tuition['tuition_amount'],2); ?></th>
	<th>Total Amount</th><th class="right" ><?php echo number_format($tuition['total_amount'],2); ?></th>
</tr>

</table>
<br />


<?php // pr($ensy); ?>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th class="shd" >SY</th>
	<th>Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>Paymode</th>
	<th>Total<br />Fees</th>
	<th>Tuition<br />Amount</th>
	<th>Enrolled<br />Amount</th>
	<th>Paid<br />Amount</th>
	<th>Balance</th>
	<th>Payment<br />Status</th>
	<th>Student<br />Status</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php extract($rows[$i]); ?>
<?php // $balance=$enrolled_amount-$tfee_paid; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td class="shd"><a href="<?php echo URL.'contacts/sy/'.$scid; ?>" ><?php echo $rows[$i]['sy']; ?></a></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['paymode']; ?></td>
	<td class="right" ><?php echo number_format($total_fees,2); ?></td>
	<td class="right" ><?php echo number_format($tuition_amount,2); ?></td>
	<td class="right" ><?php echo number_format($enrolled_amount,2); ?></td>
	<td class="right" ><?php echo number_format($tfee_paid,2); ?></td>
	<td class="right" ><?php echo number_format($enrolled_balance,2); ?></td>
	<td><?php echo ($enrolled_balance<=0)? 'Enrolled':'-'; ?></td>
	<td><?php echo ($rows[$i]['sy']==$ensy)? 'New':'Old'; ?></td>

</tr>
<?php endfor; ?>
</table>

<?php endif; ?>		<!-- lvl -->

<div class="ht100" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();
	shd();

})

</script>
