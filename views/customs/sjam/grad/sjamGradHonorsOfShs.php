<?php 

// pr($rows[0]);
// pr($rows[1]);
$decigenave=$_SESSION['settings']['decigenave'];
// pr($decigenave);
// exit;


$final=isset($_GET['final'])? 'final':false;

?>

<h5>
	SJAM SHS Grad Honors 1) <?php echo $lrow['name']; ?> Honors (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'sjam/syncSjamGradHonors/'.$lvl; ?>" >Sync</a>		
	<?php if($final): ?>		
		| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl; ?>" >1) Honors</a>	
	<?php endif; ?>	
	| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=acad'; ?>" >2a) Acad</a>
	| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=cond'; ?>" >2b) Cond</a>
	| <a href="<?php echo URL.'sjam/gradWTD/'.$lvl; ?>" >3) WTD</a>
	
	| <a href="<?php echo URL.'sjam/sirGradTotal/'.$lvl; ?>" >4) Overall</a>
	| <a href="<?php echo URL.'sjam/sirGradTotal/'.$lvl.'?final'; ?>" >5) FinalRanks </a>
	| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl.'?final'; ?>" >5) FinalRemarks</a>
	| <a href="<?php echo URL.'sjam/gradHonors/'.$lvl.'?final&print'; ?>" >Print</a>
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th colspan=4></th>
	<th colspan=14 class="center" >Scholastic</th>
	<th colspan=14 class="center" >Conduct</th>
</tr>

<tr class="headrow" >
	<th>#</th>
	<th class="shd" >Scid</th>
	<th>Section</th>
	<th>Name</th>
	<th>G11<br />Sem1<br />Q1</th>
	<th>G11<br />Sem1<br />Q2</th>
	<th>G11<br />Sem1<br />Ave</th>
	<th>G11<br />Sem2<br />Q1</th>
	<th>G11<br />Sem2<br />Q2</th>
	<th>G11<br />Sem2<br />Ave</th>
	<th>G11<br />Final<br />Ave</th>

	<th>G12<br />Sem1<br />Q1</th>
	<th>G12<br />Sem1<br />Q2</th>
	<th>G12<br />Sem1<br />Ave</th>
	<th>G12<br />Sem2<br />Q1</th>
	<th>G12<br />Sem2<br />Q2</th>
	<th>G12<br />Sem2<br />Ave</th>	
	<th>G12<br />Final<br />Ave</th>	

	<th>G11<br />Sem1<br />Q1</th>
	<th>G11<br />Sem1<br />Q2</th>
	<th>G11<br />Sem1<br />Ave</th>
	<th>G11<br />Sem2<br />Q1</th>
	<th>G11<br />Sem2<br />Q2</th>
	<th>G11<br />Sem2<br />Ave</th>
	<th>G11<br />Final<br />Ave</th>

	<th>G12<br />Sem1<br />Q1</th>
	<th>G12<br />Sem1<br />Q2</th>
	<th>G12<br />Sem1<br />Ave</th>
	<th>G12<br />Sem2<br />Q1</th>
	<th>G12<br />Sem2<br />Q2</th>
	<th>G12<br />Sem2<br />Ave</th>	
	<th>G12<br />Final<br />Ave</th>	


</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $scid=$rows[$i]['scid']; ?>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php $scid=$rows[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>

	<td><?php $ave1=$rows[$i]['prev_q1']; echo number_format($ave1,$decigenave); ?></td>
	<td><?php $ave2=$rows[$i]['prev_q2']; echo number_format($ave2,$decigenave); ?></td>
	<td><?php $ave5=($ave1+$ave2)/2; echo number_format($ave5,$decigenave); ?></td>	
	<td><?php $ave3=$rows[$i]['prev_q3']; echo number_format($ave3,$decigenave); ?></td>
	<td><?php $ave4=$rows[$i]['prev_q4']; echo number_format($ave4,$decigenave); ?></td>
	<td><?php $ave6=($ave3+$ave4)/2; echo number_format($ave6,$decigenave); ?></td>
	<td><?php $ave7=($ave5+$ave6)/2; echo number_format($ave7,$decigenave); ?></td>
	
	<td><?php $ave1=$rows[$i]['curr_q1']; echo number_format($ave1,$decigenave); ?></td>
	<td><?php $ave2=$rows[$i]['curr_q2']; echo number_format($ave2,$decigenave); ?></td>
	<td><?php $ave5=($ave1+$ave2)/2; echo number_format($ave5,$decigenave); ?></td>	
	<td><?php $ave3=$rows[$i]['curr_q3']; echo number_format($ave3,$decigenave); ?></td>
	<td><?php $ave4=$rows[$i]['curr_q4']; echo number_format($ave4,$decigenave); ?></td>
	<td><?php $ave6=($ave3+$ave4)/2; echo number_format($ave6,$decigenave); ?></td>
	<td><?php $ave7=($ave5+$ave6)/2; echo number_format($ave7,$decigenave); ?></td>
	
	<td><?php $cond1=$rows[$i]['prev_cond_q1']; echo number_format($cond1,$decigenave); ?></td>
	<td><?php $cond2=$rows[$i]['prev_cond_q2']; echo number_format($cond2,$decigenave); ?></td>
	<td><?php $cond5=($cond1+$cond2)/2; echo number_format($cond5,$decigenave); ?></td>	
	<td><?php $cond3=$rows[$i]['prev_cond_q3']; echo number_format($cond3,$decigenave); ?></td>
	<td><?php $cond4=$rows[$i]['prev_cond_q4']; echo number_format($cond4,$decigenave); ?></td>
	<td><?php $cond6=($cond3+$cond4)/2; echo number_format($cond6,$decigenave); ?></td>
	<td><?php $cond7=($cond5+$cond6)/2; echo number_format($cond7,$decigenave); ?></td>

	<td><?php $cond1=$rows[$i]['curr_cond_q1']; echo number_format($cond1,$decigenave); ?></td>
	<td><?php $cond2=$rows[$i]['curr_cond_q2']; echo number_format($cond2,$decigenave); ?></td>
	<td><?php $cond5=($cond1+$cond2)/2; echo number_format($cond5,$decigenave); ?></td>	
	<td><?php $cond3=$rows[$i]['curr_cond_q3']; echo number_format($cond3,$decigenave); ?></td>
	<td><?php $cond4=$rows[$i]['curr_cond_q4']; echo number_format($cond4,$decigenave); ?></td>
	<td><?php $cond6=($cond3+$cond4)/2; echo number_format($cond6,$decigenave); ?></td>
	<td><?php $cond7=($cond5+$cond6)/2; echo number_format($cond7,$decigenave); ?></td>

		
</tr>
<?php endfor; ?>
</table>

<br /><p><input type="submit" name="submit" value="Update" ></p>
</form>

<div class="ht50" ></div>


<script>

$(function(){
	nextViaEnter();
	
})


</script>

