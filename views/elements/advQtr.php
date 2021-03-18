<?php 



$home 		= $data['home'];
$sy 		= $data['sy'];
$qtr 		= $data['qtr'];
$intfqtr 	= $data['intfqtr'];
$aq 		= $data['aq'];
$num_aq 	= $data['num_aq'];
$ssy 		= $_SESSION['sy'];	
$sqtr 		= $_SESSION['qtr'];	


// pr($aq[0]);

?>



<div class='accordParent' >

<button onclick="accorToggle('aqt')" class="vc300 bg-blue2" > <p class="b f16" > Manage Homerooms </p> </button>  

<?php 

// prx($aq[0]);
?>

<table id="aqt" class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
<td> &nbsp </td>
<td> &nbsp </td>
<td colspan="6" class="b center" > AQ Status : 1 - Lock / 0 - Unlock  </td>
<td colspan="6" class="b center" > Attendance : 1 - Lock / 0 - Unlock  </td>
<td colspan="5" class="b center" > Conduct : 1 - Lock / 0 - Unlock  </td>
<th class="center" > CCR </th>
<th colspan="5" ></th>
</tr>

<!-- ================================================================================  -->

<tr class="headrow">
	<th>#</th>
	<th class="vc150" >Classlist</th>
	<?php for($j=1;$j<=$intfqtr;$j++): ?>
		<th class=" center" >Q<?php echo $j; ?></th>
	<?php endfor; ?>	
	<th class="vc50 center" >Save</th>
	
	<?php for($j=1;$j<=4;$j++): ?>
		<th class=" center" >Q<?php echo $j; ?></th>
	<?php endfor; ?>		
	<th class=" center" >Save</th>
	
	<th class="vc50 center" >Submissions <br /> Q<?php echo $qtr; ?>  </th>

	<?php for($j=1;$j<=4;$j++): ?>
		<th class=" center" >Q<?php echo $j; ?></th>
	<?php endfor; ?>		
	<th class=" center" >Save</th>
	
	<th>Class Report</th>
	<th> Honors <br /> Final </th>
	<th> Save </th>
	<th> Prom<br />otion</th>
	<th> Save </th>

</tr>


<!-- ================================================================================  -->


<?php for($i=0;$i<$num_aq;$i++): ?>
<tr>
	<td><?php echo $aq[$i]['crid']; ?></td>
	<td><a href="<?php echo URL.'classlists/classroom/'.$aq[$i]['crid'].DS.$sy; ?>" ><?php echo $aq[$i]['classroom']; ?></a></td>
	<?php for($j=1;$j<=$intfqtr;$j++): ?>
		<td class="center <?php echo (!$aq[$i]['is_finalized_q'.$j])? 'bg-pink' : null; ?> " >
			<select id="aq<?php echo $j; ?><?php echo $i; ?>" class="vc40 center"  >
				<option value="0" <?php echo (!$aq[$i]['is_finalized_q'.$j])? 'selected' : null; ?>  > 0 </option>
				<option value="1" <?php echo ($aq[$i]['is_finalized_q'.$j])? 'selected' : null; ?>  > 1 </option>
			</select>		
		</td>
	<?php endfor; ?>

	
	<td> <button id="asb<?php echo $i; ?>" onclick="xeditAq(<?php echo $i; ?>);return false;" > Save </button>  </td>
	
<!--------------------------------------------------------------------------------------------------------------->

<?php for($j=1;$j<=4;$j++): ?>
	<td class="center <?php echo (!$aq[$i]['attendance_q'.$j])? 'bg-pink' : null; ?>" >
		<select id="attq<?php echo $j.$i; ?>" class="vc40 center" name="attq<?php echo $j; ?>[<?php echo $i; ?>][q<?php echo $j; ?>]"  >
			<option value="0" <?php echo (!$aq[$i]['attendance_q'.$j])? 'selected' : null; ?>  > 0 </option>
			<option value="1" <?php echo ($aq[$i]['attendance_q'.$j])? 'selected' : null; ?>  > 1 </option>
		</select>		
	</td>
<?php endfor; ?>	
	
	<td> <button id="attsb<?php echo $i; ?>" onclick="xeditAttq(<?php echo $i; ?>);return false;" > Save </button>  </td>
	
<!--------------------------------------------------------------------------------------------------------------->	
	
	<td><a href="<?php echo URL.'submissions/view/'.$aq[$i]['crid'].DS.$ssy.DS.$qtr; ?>" >
		<?php echo ($aq[$i]['is_finalized_q'.$qtr])? $aq[$i]['finalized_date_q'.$qtr]: 'Pending'; ?></a></td>	
		
<!--------------------------------------------------------------------------------------------------------------->

	<?php for($j=1;$j<=4;$j++): ?>
		<td class="center <?php echo (!$aq[$i]['conduct_q'.$j])? 'bg-pink' : null; ?>" >
			<select id="cdtq<?php echo $j.$i; ?>" class="vc40 center" name="cdt<?php echo $j; ?>[<?php echo $i; ?>][q<?php echo $j; ?>]"  >
				<option value="0" <?php echo (!$aq[$i]['conduct_q'.$j])? 'selected' : null; ?>  > 0 </option>
				<option value="1" <?php echo ($aq[$i]['conduct_q'.$j])? 'selected' : null; ?>  > 1 </option>
			</select>		
		</td>
	<?php endfor; ?>	
	
	<td> <button id="cdtBtn-<?php echo $i; ?>" onclick="xeditCdtLocking(<?php echo $i; ?>);return false;" > Save </button>  </td>
		
		
	<td>
		<a href="<?php echo URL.'reports/ccr/'.$aq[$i]['crid'].DS.$ssy.DS.'1'; ?>"  >Q1</a> |
		<a href="<?php echo URL.'reports/ccr/'.$aq[$i]['crid'].DS.$ssy.DS.'2'; ?>"  >Q2</a> |
		<a href="<?php echo URL.'reports/ccr/'.$aq[$i]['crid'].DS.$ssy.DS.'3'; ?>"  >Q3</a> |
		<a href="<?php echo URL.'reports/ccr/'.$aq[$i]['crid'].DS.$ssy.DS.'4'; ?>"  >Q4</a>
	</td>

	<td class="center" >
		<?php if($qtr!=4): ?>
			<?php echo ($aq[$i]['is_finalized_honors'])? '1':'-'; ?>
		<?php else: ?>				
			<select id="ifh<?php echo $i; ?>" class="vc50 center" name="aq[<?php echo $i; ?>][is_finalized_honors]"  >
				<option value="0" <?php echo (!$aq[$i]['is_finalized_honors'])? 'selected' : null; ?>  > 0 </option>
				<option value="1" <?php echo ($aq[$i]['is_finalized_honors'])? 'selected' : null; ?>  > 1 </option>
			</select>		
		<?php endif; ?>		
	</td>		
	<td>
		<button id="hsb<?php echo $i; ?>" onclick="xeditHonorLocking(<?php echo $i; ?>);return false;" > Save </button> 		
	</td>
	
	<td class="center" >
		<?php if($qtr!=4): ?>
			<?php echo ($aq[$i]['prom_finalized'])? '1':'-'; ?>
		<?php else: ?>				
			<select id="ifp<?php echo $i; ?>" class="vc50 center" name="aq[<?php echo $i; ?>][prom_finalized]"  >
				<option value="0" <?php echo (!$aq[$i]['prom_finalized'])? 'selected' : null; ?>  > 0 </option>
				<option value="1" <?php echo ($aq[$i]['prom_finalized'])? 'selected' : null; ?>  > 1 </option>
			</select>		
		<?php endif; ?>		
	</td>		
	<td>
		<button id="psb<?php echo $i; ?>" onclick="xeditPromotionLocking(<?php echo $i; ?>);return false;" > Save </button> 		
	</td>	
	
	<!-- ajax post but still prefer to use val over text hence this hidden field -->
	<input id="aqid<?php echo $i; ?>"  type="hidden" value="<?php echo $aq[$i]['aqid']; ?>"  />
	<input id="acrid<?php echo $i; ?>" type="hidden" value="<?php echo $aq[$i]['crid']; ?>"  />
	
</tr>
<?php endfor; ?>
</table>

</div>


<script>


function xeditCdtLocking(i){
	$('#cdtBtn-'+i).hide();
	var acrid 	= $('#acrid'+i).val();
	var cdtq1 	= $('#cdtq1'+i).val();
	var cdtq2 	= $('#cdtq2'+i).val();
	var cdtq3 	= $('#cdtq3'+i).val();
	var cdtq4 	= $('#cdtq4'+i).val();

	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditCdtLocking";

	var pdata = "task="+task+"&cdtq1="+cdtq1+"&cdtq2="+cdtq2+"&cdtq3="+cdtq3+"&cdtq4="+cdtq4+"&acrid="+acrid;
	// alert(pdata);
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){} 
	});				


}	/* fxn */




</script>
