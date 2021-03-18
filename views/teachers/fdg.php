<?php


$this->shovel('ratings',$ratings);

?>

<h5>
	Finalizer
	| <a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<!--  ==========================================================================================================  -->

<form method="POST" >

<table class="gis-table-bordered ">

<tr class="headrow" >
	<td>#</td>
	<td>GID</td>
	<td>CrsID</td>
	<td>CID</td>
	<td>Q1</td>
	<td>Q2</td>
	<td>Q3</td>
	<td>Q4</td>
	<td>TG</td>	
	<td>FG</td>
	<td>CDG</td>
	<td>DDG</td>
	<td>GID</td>
</tr>

<?php $num_diff = 0; ?>

<?php for($i=0;$i<$num_rows;$i++): ?>
<?php $tg = 0; ?>
<?php $atg = 0; ?>

<tr>
	<td> <?php echo $i+1; ?> </td>
	<td> <?php echo $grades[$i]['gid']; ?> </td>
	<td> <?php echo $grades[$i]['course_id']; ?> </td>
	<td> <?php echo $grades[$i]['scid']; ?> </td>
	<td> <?php $bq1 = $grades[$i]['q1'] + $grades[$i]['bonus_q1']; echo $bq1; ?> </td>
	<td> <?php $bq2 = $grades[$i]['q2'] + $grades[$i]['bonus_q2']; echo $bq2; ?> </td>
	<td> <?php $bq3 = $grades[$i]['q3'] + $grades[$i]['bonus_q3']; echo $bq3; ?> </td>
	<td> <?php $bq4 = $grades[$i]['q4'] + $grades[$i]['bonus_q4']; echo $bq4; ?> </td>
	
	<!-- g.q5 -->
	<?php $tg = $bq1 + $bq2 + $bq3 + $bq4; ?>
	<?php $atg = number_format($tg/4,2); ?>
	<td> <input class="vc50" type="text" name="gr[<?php echo $i; ?>][fg]" value="<?php echo $atg; ?>"  /> </td>	
	<td class="<?php echo ($atg != $grades[$i]['q5'])? 'red':null; ?>"  > <?php $fg  = $grades[$i]['q5']; echo $fg; ?> </td>
	<?php if($atg != $grades[$i]['q5']) { $num_diff++; }   ?>
	
	
	<!-- ===================== g.dg5 ===================== -->
	<?php $cdg = rating($atg,$ratings); ?>
	<td> <input class="vc50" type="text" name="gr[<?php echo $i; ?>][dgf]" value="<?php echo $cdg; ?>"  /> </td>	
	<td class="<?php echo ($cdg != $grades[$i]['dg5'])? 'red':null; ?>"  > <?php $ddg  = $grades[$i]['dg5']; echo $ddg; ?> </td>	
	<td> <input class="vc50" type="text" name="gr[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"  /> </td>	

	
</tr>
<?php endfor; ?>
</table>


<?php 
	echo "num_diff: $num_diff <br />";
?>

<?php if($num_diff): ?>
	<input type="submit" name="submit" value="Update"  />
<?php endif; ?>	
	
</form>