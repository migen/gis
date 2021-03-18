<!-- library/GSController -->

<?php 


// pr($iscores);

// pr($data);
// pr($iscores[0]);
// pr($iscores);
// pr($student);

?>


<h5>
	Evaluation SY-<?php echo $sy; ?> Period-<?php echo $period; ?>
	| <a href="<?= URL.''; ?>" > Home </a>
	<?php if($user['role_id']==RMIS): ?>
		| <a href="<?= URL.'setup/grading/'.$sy; ?>" > Setup </a>
	<?php endif; ?>

</h5>


<div class="half" >
	<p>
	<table class="gis-table-bordered table-fx" >
	<tr><th>Assessee</th><td><?php echo $teacher['account']; ?></td><td class="vc300" ><?php echo $teacher['name']; ?></td></tr>
	<?php if($user['role_id'] != RSTUD): ?>
		<tr><th>Assessor</th><td><?php echo $student['account']; ?></td><td><?php echo $student['name']; ?></td></tr>
	<?php endif; ?>
	</table>
	</p>
</div>


<div class="third" >
<?php /* echo $itype['descriptions'];  */  ?>
<p><?php include_once(SITE."views/customs/".VCFOLDER."/ted.php"); ?></p>

</div>

<div class="clear" ></div>

<!------ sync ----------------------------------------------------------------------------------------------------------->	
<?php if($num_iscores != $num_icomponents){ echo "<h5 class='brown' >Incomplete setup or mismatched items. Please check with your guidance. </h5>"; exit; } ?>
	

<form id="form" method="POST" >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="hd">ISCID</th>
	<th class="vc500" >Item</th>
	<th>Max</th>
	<th>Wt</th>
	<th>Rate</th>
	<th class="center" >Score</th>
</tr>

<?php $rate=0; ?>
<?php $total_score=0; ?>
<tr><th colspan="6" ><?php echo $iscores[0]['icategory']; ?></th></tr>
<?php for($i=0;$i<$num_iscores;$i++): ?>
<?php $j=$i+1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd"><?php echo $iscores[$i]['iscid']; ?></td>
	<td><?php echo $iscores[$i]['item']; ?></td>
	<td id="max-<?php echo $i; ?>" ><?php echo $iscores[$i]['max']; ?></td>
	<td id="wt-<?php echo $i; ?>" ><?php echo $iscores[$i]['weight']; ?></td>
	<td> <input class="vc50 center rtg" onchange='processRating(<?php echo $i; ?>,this.value,<?php echo $iscores[$i]['max'].",".$iscores[$i]['weight']; ?>);' type="text" name="iscores[<?php echo $i?>][rate]" value="<?php echo $iscores[$i]['rate']; ?>" /> </td>
		<?php $rate += $iscores[$i]['rate']; ?>
		<?php $score 	  = $iscores[$i]['rate']/$iscores[$i]['max']*$iscores[$i]['weight']; ?>
		<?php $total_score += $score; ?>
	<td class="sc-<?php echo $i; ?> center" ><?php echo $iscores[$i]['score']; ?></td>
	<td class="hd" > <input class="sc-<?php echo $i; ?> sc" type="hidden" name="iscores[<?php echo $i; ?>][score]" value="<?php echo $score; ?>" /></td>
</tr>	


<?php if(($iscores[$i]['icategory_id']!=@$iscores[$j]['icategory_id']) && $j<$num_iscores): ?>
	<tr><th colspan="6" ><?php echo $iscores[$j]['icategory']; ?></th></tr>
<?php endif; ?>


<input type="hidden" name="iscores[<?php echo $i?>][iscid]" value="<?php echo $iscores[$i]['iscid']; ?>"  />
<?php endfor; ?>

<?php $average = $rate/$num_iscores; ?>

<tr><th colspan="4" >Average / Total</th>
<td class="rtgave center b" ><?php echo $rave = number_format($average,2); ?></td>
<input type="hidden" class="center vc50 rtgave" id="total" value="<?php echo $rave; ?>"  readonly />
<td class="scsum center b"><?php echo $rtscore = number_format($total_score,2); ?></td>
<input type="hidden" class="center vc50 scsum" id="total" value="<?php echo $rtscore; ?>"  readonly />
</tr>

</table>

<p>
<?php if(isset($evaluation['igid'])): ?>
<?php $igid = $evaluation['igid']; ?>
	<?php if($evaluation['is_finalized']!='1'): ?>
		<input type="submit" name="save" value="Save"   />
		<button> <a class="txt-black no-underline" onclick="return confirm('Are you sure?');" href='<?php echo URL."$home/finalizeEval/$igid/$sy/$period/$tcid/$scid"; ?>' > Finalize </a></button>	
	<?php endif; ?>	
<?php else: ?>	
	<input type="submit" name="update" value="Update"   />
<?php endif; ?>	
</p>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>


<!-------------------------------------------------------------------------------------->


<script>
// make this native javascript

var gurl 	 = 'http://<?php echo GURL; ?>';
var home 	 = '<?php echo $home; ?>';
var hdpass 	 = '<?php echo HDPASS; ?>';
var no_error = true;
var numitems = '<?php echo $num_iscores; ?>';
var sy 		 = '<?php echo $sy; ?>';
var period 	 = '<?php echo $period; ?>';
var asor 	 = '<?php echo $scid; ?>';
var asee 	 = '<?php echo $tcid; ?>';
var DS		= '/';


$(function(){	

	$('#hdpdiv').hide();
	hd();
	nextViaEnter();		
	selectFocused();		
	
	
});


function processRating(i,val,max,wt){
	
	/* 1 - validate max */
	if((val>max) || (val<0)){
		alert('Invalid rate');
	}
	var sc = (val/max)*wt;
	$('.sc-'+i).text(sc);
	$('.sc-'+i).val(sc);
 	
	/* update rtgsum and rtgave | rating sum and ave */
	var rtgsum = 0;
	var rtgave = 0;
	var scsum  = 0;
	$('.rtg').each(function(){
		rtgsum += parseInt($(this).val());				
	})
	$('.sc').each(function(){
		scsum += parseInt($(this).val());				
	})	
	rtgave = rtgsum/numitems;
	$('.rtgave').text(rtgave);
	$('.rtgave').val(rtgave);

	$('.scsum').text(scsum);
	$('.scsum').val(scsum);
	
	
}


	

</script>
