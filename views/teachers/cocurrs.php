<?php 
// pr($candidates[0]);

// pr($classroom);
$ifh = $classroom['is_finalized_honors'];
// echo "ifh: ".$classroom['is_finalized_honors']."<br />";

$ccfactor = $_SESSION['settings']['factor_cocurrs'];

?>

<h5> 
	<span ondblclick="tracehd();" > Co-Curricular & Honors </span> |
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
	<?php if($ifh): ?>
		<th>Honor<br />Rank</th>	
	<?php endif; ?>
</tr>
<?php for($i=0;$i<$num_candidates;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $candidates[$i]['sumid']; ?></td>
	<td class="hd" ><?php echo $candidates[$i]['scid']; ?></td>
	<td><?php echo $candidates[$i]['student_code']; ?></td>
	<td><?php echo $candidates[$i]['student']; ?></td>
	<td class="right" ><?php echo $candidates[$i]['q5']; ?></td>
	<td id="gap-<?php echo $i; ?>" class="right" ><?php $ga_prod = $candidates[$i]['q5'] * $_SESSION['settings']['factor_genave']; echo number_format($ga_prod,2); ?></td>
	<td><?php $ccf = (isZeroNullOrEmpty($candidates[$i]['cocurr_q5']))? 0 : $candidates[$i]['cocurr_q5']; ?>
		<input onchange="tallyRow(this.value,<?php echo $i; ?>);"  <?php echo ($i==0)? 'autofocus':NULL; ?> class="vc80 pdr05 right" name="sum[<?php echo $i; ?>][cocurr_q5]" value="<?php echo number_format($ccf,2); ?>"  <?php echo ($ifh)? 'readonly':NULL; ?> />
	</td>
	<td class="right" id="ccp-<?php echo $i; ?>" ><?php $cc_prod = $ccf * $_SESSION['settings']['factor_cocurrs']; echo number_format($cc_prod,2); ?></td>
	<td class="right" id="hfg-<?php echo $i; ?>" ><?php $hf = $ga_prod + $cc_prod; echo number_format($hf,2); ?></td>
	<?php if($ifh): ?>
		<td class="right" ><?php $hrf = (isZeroNullOrEmpty($candidates[$i]['honor_rank_q5']))? 0 : $candidates[$i]['honor_rank_q5']; echo number_format($hrf,2); ?></td>
	<?php endif; ?>
		<input type="hidden" name="sum[<?php echo $i; ?>][ga_prod]" value="<?php echo $ga_prod; ?>" />
		<input type="hidden" name="sum[<?php echo $i; ?>][sumid]" value="<?php echo $candidates[$i]['sumid']; ?>" />
		
	
</tr>
<?php endfor; ?>


</table>


<?php if(!$ifh): ?>
	<p><input type="submit" name="tally" value="Submit"  /></p>
<?php endif; ?>
</form>



<!-- ------------------------------------------------------------------------------------- -->

<script>
var ccf = '<?php echo $ccfactor; ?>';


$(function(){	
	// alert(ccf);
	hd();
	nextViaEnter();
	selectFocused();

})

function tallyRow(val,i){
	// alert(val+'-'+i);
	var gap = $('#gap-'+i).text();
	// alert(gap);
	var ccp = val*ccf;
	var hfg = parseFloat(gap) + parseFloat(ccp);
	// var hfg = gap + ccp;
	$('#ccp-'+i).text(ccp);
	$('#hfg-'+i).text(hfg);
	

}


</script>
