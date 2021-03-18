<?php 

// pr($rows[0]);
// pr($rows[1]);

$final=isset($_GET['final'])? 'final':false;

?>

<h5 class="screen" >
	SJAM 1) <?php echo $lrow['name']; ?> Honors (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($final): ?>		
		| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl; ?>" >1) Honors</a>	
	<?php endif; ?>	
	| <span onclick="pclass('shd');" >SHD</span>
	| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=acad'; ?>" >2a) Acad</a>
	| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=cond'; ?>" >2b) Cond</a>
	| <a href="<?php echo URL.'sjam/gradWTD/'.$lvl; ?>" >3) WTD</a>
	
	| <a href="<?php echo URL.'sjam/sirGradTotal/'.$lvl; ?>" >4) Overall</a>

	| <a href="<?php echo URL.'sjam/sirGradTotal/'.$lvl.'?final'; ?>" >5) FinalRanks </a>
	| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl.'?final'; ?>" >5) FinalRemarks</a>
	| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl.'?final&print'; ?>" >Print</a>
	| <a class="u" id="btnExport" >Excel</a> 
	
	
</h5>


<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="shd" >Scid</th>
	<th>Classroom</th>
	<th>Name</th>
	<th>Prev<br />Acad<br />(30%)</th>
	<th>Curr<br />Acad<br />(70%)</th>
	<th>Total<br />Acad<br />(100%)</th>
	<th>Rank<br />Acad</th>
	<th class="center" >WTD<br />Acad<br />8</th>
	<th>Prev<br />Cond<br />(30%)</th>
	<th>Curr<br />Cond<br />(70%)</th>	
	<th>Total<br />Cond<br />(100%)</th>	
	<th>Rank<br />Cond</th>
	<th class="center" >WTD<br />Cond<br />2</th>	
	<th class="right" >WTD<br />Total<br /></th>	
	<th class="center" >Over<br />all<br />Total</th>	
	<th>Over<br />all<br />Rank</th>	
	<?php if($final): ?>
		<th>Over<br />all<br />Place</th>	
	<?php endif; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $scid=$rows[$i]['scid']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php $scid=$rows[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php $prev_acad=$rows[$i]['prev_acad']; echo $prev_acad; ?> </td>
	<td><?php $curr_acad=$rows[$i]['curr_acad']; echo $curr_acad; ?></td>
	<td><?php 	$total_acad=($prev_acad*.3)+($curr_acad*0.7); 
				echo $rows[$i]['total_acad']; ?></td>
	<td class="center" ><?php echo $rows[$i]['rank_acad']+0; ?></td>	
	<td class="center" ><?php echo $rows[$i]['wtd_acad']+0; ?></td>	

	<td><?php $prev_cond=$rows[$i]['prev_cond']; echo $prev_cond; ?> </td>
	<td><?php $curr_cond=$rows[$i]['curr_cond']; echo $curr_cond; ?></td>	
	<td><?php echo $rows[$i]['total_cond']; ?></td>
	<td class="center" ><?php echo $rows[$i]['rank_cond']+0; ?></td>	
	<td class="center" ><?php echo $rows[$i]['wtd_cond']+0; ?></td>	
	<td class="center" ><?php echo $rows[$i]['total_wtd']+0; ?></td>	
	<td><?php echo $rows[$i]['overall_total']; ?></td>	
	<td class="center" ><?php echo $rows[$i]['overall_rank']+0; ?></td>	
	<?php if($final): ?>
		<td><?php echo $rows[$i]['overall_place']; ?></td>
	<?php endif; ?>
	
	<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>" >	
	
</tr>
<?php endfor; ?>
</table>

</form>

<div class="ht50" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>

$(function(){
	shd();
	excel();
	nextViaEnter();
	
})


</script>

