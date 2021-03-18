<?php 

// $num_girls 	= $data['num_girls'];
// $num_boys 	= $data['num_boys'];

$sy 		= $data['sy'];
$nsy 		= $data['nsy'];
$crid 		= $data['crid'];
$prep 		= $data['prep'];
$is_locked	= isset($data['is_locked'])? $data['is_locked'] : 0;
$is_this_year = isset($data['is_this_year'])? $data['is_this_year'] : 1;


// pr($data);
// pr($cr);

?>




<h2> Report 
<?php if(!$is_locked): ?>
	<br /> <button onclick="tallyProm0(); return false;" > Tally Promotions </button> 
<?php endif; ?>
</h2>

<table class="gis-table-bordered" >

<tr class="headrow">
	<th class="vc200" >&nbsp;</th>
	<th class="vc70 center" >Boys</th>
	<th class="vc70 center" >Girls</th>
	<th class="vc70 center" >Total</th>
</tr>

<tr>
	<td> Total Number of Pupils </td>		
	<td class="center" ><input class="tmle vc50 center" type="number" name="data[report][count_boys]" value="<?php echo $prep['count_boys']; ?>" onchange="same('ccmle',this.value);return false;" /></td>	
	<td class="center" ><input class="tgrl vc50 center" type="number" name="data[report][count_girls]" value="<?php echo $prep['count_girls']; ?>" onchange="same('ccgrl',this.value);return false;" /></td>	
	<td class="center" ><input class="tstud vc50 center" type="number" name="data[report][count_total]" value="<?php echo $prep['count_total']; ?>" onchange="same('ccstd',this.value);return false;" /></td>		
</tr>



<tr>
	<td> Number Promoted </td>
	<td class="center" ><input class="tiprob center vc50" type="number" name="data[report][count_promoted_boys]" value="<?php echo $prep['count_promoted_boys']; ?>" onchange="same('ccmle',this.value);return false;" /></td>
	<td class="center" ><input class="tiprog center vc50" type="number" name="data[report][count_promoted_girls]" value="<?php echo $prep['count_promoted_girls']; ?>" value="0" onchange="same('ccgrl',this.value);return false;" /></td>
	<td class="center" ><input class="tiprom center vc50" type="number" name="data[report][count_promoted_total]"  value="<?php echo $prep['count_promoted_total']; ?>" onchange="same('ccstd',this.value);return false;" /></td>
</tr>



<tr>
	<td> Total Age Pupils </td>		
	<td class="center" ><input class="tbage center vc50" type="text" name="data[report][sum_age_boys]" value="<?php echo $prep['sum_age_boys']; ?>" /></td>
	<td class="center" ><input class="tgage center vc50" type="text" name="data[report][sum_age_girls]" value="<?php echo $prep['sum_age_girls']; ?>" /></td>
	<td class="center" ><input class="tage center vc50" type="text" name="data[report][sum_age_total]" value="<?php echo $prep['sum_age_total']; ?>"  /></td>

</tr>


<tr>
	<td> Total Age Promoted </td>
	<td class="center" ><input class="tpbage center vc50" type="text" name="data[report][sum_age_promoted_boys]" value="<?php echo $prep['sum_age_promoted_boys']; ?>"  /></td>
	<td class="center" ><input class="tpgage center vc50" type="text" name="data[report][sum_age_promoted_girls]" value="<?php echo $prep['sum_age_promoted_girls']; ?>"  /></td>
	<td class="center" ><input class="tpmage center vc50" type="text" name="data[report][sum_age_promoted_total]" value="<?php echo $prep['sum_age_promoted_girls']; ?>"  /></td>

</tr>



<tr>
	<td> Average Age Pupils </td>		
	<td class="center" ><input class="abage center vc50" type="text" name="data[report][ave_age_boys]" value="<?php echo $prep['ave_age_boys']; ?>"  /></td>
	<td class="center" ><input class="agage center vc50" type="text" name="data[report][ave_age_girls]" value="<?php echo $prep['ave_age_girls']; ?>"  /></td>
	<td class="center" ><input class="aage center vc50" type="text" name="data[report][ave_age_total]" value="<?php echo $prep['ave_age_total']; ?>"  /></td>
</tr>

<tr>
	<td> Average Age Promoted </td>
	<td class="center" ><input class="apbage center vc50" type="text" name="data[report][ave_age_promoted_boys]" value="<?php echo $prep['ave_age_promoted_boys']; ?>"  /></td>
	<td class="center" ><input class="apgage center vc50" type="text" name="data[report][ave_age_promoted_girls]" value="<?php echo $prep['ave_age_promoted_girls']; ?>"  /></td>
	<td class="center" ><input class="apmage center vc50" type="text" name="data[report][ave_age_promoted_total]" value="<?php echo $prep['ave_age_promoted_total']; ?>"  /></td>
</tr>




</table>

<br /><hr />


<?php 

// pr($data['promotion']);

?>