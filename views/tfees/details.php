<?php

	// unset($data['feetypes']);
	// pr($data);	
	// pr($_SESSION['q']);
	// echo (empty($tuition))? 'empty tuition':'not empty tuition';

?>


<h5>
	Assessment Fees <?php echo $tuition['label']; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'accounts'; ?>" >Accounts</a>	

<?php 
	$data['sy']=$sy;$data['repage']="tfees/details/$level_id";
	$incs="incs/sy_selector.php";include_once($incs);
?>	

	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."tfees/details/".$sel['id']."/$sy?num=1"; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<!-- ================ page details ============================================== -->

<form method="POST" >

<div style="width:400px;float:left;" >	<!-- topleft -->

<table class="gis-table-bordered table-fx" >
	<tr><th class='white headrow'>Level</th><td class="vc200" ><?php echo $tuition['level']; ?>
		<?php if(empty($tuition)): ?>
			<a href='<?php echo URL."syncs/tuitions/$sy/$level_id/$sy?num=$num"; ?>' >Sync Tuitions</a>
		<?php endif; ?>
	</td></tr>
	<tr><th class='white headrow'>Classroom</th><td><input name="tuition[label]" class="pdl05" 
		value="<?php echo $tuition['label']; ?>" /></td></tr>		
	<tr><th class='white headrow'>Sxn#</th><td><input name="tuition[num]" class="pdl05" 
		value="<?php echo $tuition['num']; ?>" readonly /></td></tr>		
	
	<tr><th class='white headrow'>School Year</th><td><?php echo $sy.' - '.($sy+1); ?></td></tr>
	<tr><th class='white headrow'>Total</th><td><?php echo number_format($tuition['total'],2,'.',','); ?></td></tr>	
	<tr><th class='white headrow'>Tuition Fee</th><td>
		<input name="tuition[tuition]" class="pdl05" value="<?php echo number_format($tuition['tuition'],2,'.',''); ?>" /></td></tr>		

	<tr><th class='white headrow'>Reservation Fee</th><td>
		<input name="tuition[resfee]" class="pdl05" value="<?php echo number_format($tuition['resfee'],2,'.',''); ?>" /></td></tr>	
<tr><th class='white headrow'>Reservation due</th><td>
	<input type="date" name="tuition[resdue]" class="pdl05" 
		value="<?php echo (isset($tuition['resdue']))? $tuition['resdue']:$today; ?>" /></td></tr>			

</table>

</div>	<!-- topleft -->

<div style="width:300px;float:left;" >	<!-- topleft -->

<table class="gis-table-bordered table-fx" >
	<tr><th class='white headrow'>1 - DP YY</th><td>
		<input class="pdl05" name="tuition[y1_dpfee]" value="<?php echo number_format($tuition['y1_dpfee'],2,'.',''); ?>" /></td></tr>	
	<tr><th class='white headrow'>DP YY Due</th><td>
		<input class="pdl05" type="" name="tuition[y1_dpdue]" value="<?php echo $tuition['y1_dpdue']; ?>" /></td></tr>			

	<tr><th class='white headrow'>2 - DP SA</th><td>
		<input class="pdl05" name="tuition[s2_dpfee]" value="<?php echo number_format($tuition['s2_dpfee'],2,'.',''); ?>" /></td></tr>	
	<tr><th class='white headrow'>DP SA Due</th><td>
		<input class="pdl05" type="" name="tuition[s2_dpdue]" value="<?php echo $tuition['s2_dpdue']; ?>" /></td></tr>					
		
	<tr><th class='white headrow'>3 - DP MM</th><td>
		<input class="pdl05" name="tuition[m3_dpfee]" value="<?php echo number_format($tuition['m3_dpfee'],2,'.',''); ?>" /></td></tr>	
	<tr><th class='white headrow'>DP MM Due</th><td>
		<input class="pdl05" type="" name="tuition[m3_dpdue]" value="<?php echo $tuition['m3_dpdue']; ?>" /></td></tr>					

	<tr><th class='white headrow'>4 - DP QQ</th><td>
		<input class="pdl05" name="tuition[q4_dpfee]" value="<?php echo number_format($tuition['q4_dpfee'],2,'.',''); ?>" /></td></tr>	
	<tr><th class='white headrow'>DP QQ Due</th><td>
		<input class="pdl05" type="" name="tuition[q4_dpdue]" value="<?php echo $tuition['q4_dpdue']; ?>" /></td></tr>					
		
	<tr><td colspan="2" ><input type="submit" name="update" value="Update"  /></td></tr>
</table>

</div>	<!-- topleft -->


<input type="hidden" name="tuition[level_id]" value="<?php echo $level_id; ?>" />
</form>

<!-- ============================================================== -->

<div class="clear" ></div>


<?php if($num_fees): ?>

<?php $total = 0; ?>

<h4> Tuition Details </h4>
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Particulars</th>
	<th>Amount</th>
	<th>Actions</th>
</tr>
<?php for($i=0;$i<$num_fees;$i++): ?>
<?php $total += $fees[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ucfirst($fees[$i]['feetype']); ?></td>
	<td class="right" ><?php echo $fees[$i]['amount']; ?></td>
	<td> 	
		<a href="<?php echo URL.'tfees/edit/'.$fees[$i]['tdid'].DS.$sy; ?>">Edit</a> | 
		<a onclick="return confirm('Sure?');"  href="<?php echo URL.'tfees/delete/'.$fees[$i]['tdid'].DS.$sy; ?>">Del</a>
	</td>
	
	
</tr>
<?php endfor; ?>

<tr>
	<td id="total" class="right b" colspan="3"><?php echo number_format($total,2);  ?></td>
	<td>	
		<?php if($total!=$tuition['total']): ?>
			<button onclick="reconcileTuitionTotal(<?php echo $total; ?>);return true;" >Reconcile</button>
		<?php endif; ?>
	</td>
</tr>

</table>


<?php endif; ?>


<!-- ============================================================== -->

<h4> Add Particulars </h4>

<form method="POST" >
<table class="gis-table-bordered table-fx" >

<input type="hidden" name="level_id" value="<?php echo $level_id; ?>" />
<input type="hidden" name="num" value="<?php echo $num; ?>" />

<tr>
	<td>
		<select class="full" name="feetype_id" >
			<option> Select </option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
			
		</select>
	</td>
</tr>

<tr>
	<td><input class="pdl05" type="text" name="amount" placeholder="Amount"/></td>
</tr>

<tr>
	<td><input type="submit" name="add" value="Go"  /></td>
</tr>

</table>
</form>


<!-- -->


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var num = "<?php echo $num; ?>";

$(function(){
	// alert(gurl);

})



function reconcileTuitionTotal(total){
	var level_id = $('input[name="level_id"]').val();
	var vurl 	= gurl + '/ajax/xenrollment.php';	
	var task	= "reconcileTuitionTotal";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&total='+total+'&level_id='+level_id+'&sy='+sy+'&num='+num,						
	});				
	location.reload();
	
}	/* fxn */

</script>
