<?php 
// pr($candidates[0]);

// pr($classroom);
$ifh = $classroom['is_finalized_honors'];
// echo "ifh: ".$classroom['is_finalized_honors']."<br />";


?>

<h5> 
	<span ondblclick="tracehd();" > Honors </span> |
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				


</h5>

<!---------------------------------------------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $classroom['crid']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $classroom['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $classroom['section']; ?></td></tr>
	<tr><th class='white headrow'>Qtr Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
	<tr><th class='white headrow'>Honor Status</th><td><?php echo ($ifh)? 'Closed' : 'Open' ; ?></td></tr>
</table> <br />


<!---------------------------------------------------------------------------------------------------------------->


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="hd" >SumID</th>
	<th class="hd" >CID</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>GevAve<br />Grade</th>
	<th>GenAve <br />Product<br /><?php echo '('.($_SESSION['settings']['factor_genave']*100).'%)'; ?></th>
	<th>Cocurrs<br />Grade</th>
	<th>Cocurrs <br /> Product<br /><?php echo '('.($_SESSION['settings']['factor_cocurrs']*100).'%)'; ?></th>
	<th>Honor<br />FG</th>	
	<th>Honor<br />Rank</th>	

</tr>
<?php $rank=1; ?>
<?php for($i=0;$i<$num_candidates;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $candidates[$i]['sumid']; ?></td>
	<td class="hd" ><?php echo $candidates[$i]['scid']; ?></td>
	<td><?php echo $candidates[$i]['student_code']; ?></td>
	<td><?php echo $candidates[$i]['student']; ?></td>
	<td class="right" ><?php echo $candidates[$i]['q5']; ?></td>
	<td class="right" ><?php $ga_prod = $candidates[$i]['q5'] * $_SESSION['settings']['factor_genave']; echo number_format($ga_prod,2); ?></td>
	<td><?php $ccf = (isZeroNullOrEmpty($candidates[$i]['cocurr_q5']))? 0 : $candidates[$i]['cocurr_q5']; echo number_format($ccf,2); ?></td>
	<td class="right" ><?php $cc_prod = $ccf * $_SESSION['settings']['factor_cocurrs']; echo number_format($cc_prod,2); ?></td>
	<td class="right" ><?php echo number_format($candidates[$i]['honor_q5'],2); ?></td>
	<?php if($ifh): ?>
		<td class="right" ><?php echo number_format($candidates[$i]['honor_rank_q5'],RDECI); ?></td>		
	<?php else: ?>	
		<td class="right <?php echo ($ties)? 'bg-red' : null; ?>" ><input class="vc50 right pdr05" <?php echo ($i==0)? 'autofocus':NULL; ?> type="text" name="sum[<?php echo $i; ?>][hrf]" value="<?php echo $rank; ?>"  /></td>
		<?php 
			$j 		= $i+1;
			$mine 	= $candidates[$i]['honor_q5'];				
			@$his 	= $candidates[$j]['honor_q5'];	
			$ties 	= ($mine == $his)? true : false;				
			if(!$ties) $rank++;												
		?>							
		<input type="hidden" name="sum[<?php echo $i; ?>][sumid]" value="<?php echo $candidates[$i]['sumid']; ?>" />		
	<?php endif; ?>
	
	
		
	
</tr>
<?php endfor; ?>


</table>


<?php if(!$ifh): ?>
	<p><input type="submit" name="submit" value="Finalize"  /></p>
<?php endif; ?>
</form>



<!-- ------------------------------------------------------------------------------------- -->

<script>

$(function(){	
	hd();
	nextViaEnter();
	selectFocused();

})


</script>
