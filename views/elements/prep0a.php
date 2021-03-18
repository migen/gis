<?php 

// $num_girls 	= $data['num_girls'];
// $num_boys 	= $data['num_boys'];

$prep 		= $data['prep'];
$is_locked	= isset($data['is_locked'])? $data['is_locked'] : 0;
$is_this_year = isset($data['is_this_year'])? $data['is_this_year'] : 1;


// pr($data);
// pr($cr);

?>


<?php if(empty($prep)): ?>
	<a href="<?php echo URL.'teachers/addPrep/'.$data['cr']['id'].DS.$data['curr_sy']; ?>" > Add Promotions Record </a>
<?php exit; ?>
<?php endif; ?>

<h2> Report 
<?php if(!$is_locked): ?>
	<br /> <button onclick="tallyProm0(); return false;" > Tally Promotions 0 </button> 
<?php endif; ?>
</h2>

<table class="gis-table-bordered" >

<tr class="headrow">
	<th class="vc200" >&nbsp;</th>
	<?php if(!$is_locked): ?> 
		<th class="vc150 center" > Automate </th>
	<?php endif; ?>
	<th class="vc70 center" >Boys</th>
	<th class="vc70 center" >Girls</th>
	<th class="vc70 center" >Total</th>
</tr>

<tr>
	<td> Total Number of Pupils </td>
	<?php if(!$is_locked): ?>	
		<td>
			<button onclick="tally('mle',1); return false;" > Boys </button> 
			<button onclick="tally('grl',0); return false;" > Girls </button> 
			<button onclick="tallyAll('std'); return false;" > Total </button> 
		</td>
	<?php endif; ?>
		
	<td class="center" ><input class="tmle vc50 center" type="number" name="data[report][count_boys]" value="<?php echo $prep['count_boys']; ?>" onchange="same('ccmle',this.value);return false;" /></td>	
	<td class="center" ><input class="tgrl vc50 center" type="number" name="data[report][count_girls]" value="<?php echo $prep['count_girls']; ?>" onchange="same('ccgrl',this.value);return false;" /></td>	
	<td class="center" ><input class="tstd vc50 center" type="number" name="data[report][count_total]" value="<?php echo $prep['count_total']; ?>" onchange="same('ccstd',this.value);return false;" /></td>		
</tr>



<tr>
	<td> Number Promoted </td>
	<?php if(!$is_locked): ?> <td> &nbsp; </td> <?php endif; ?>	
	<td class="center" ><input class="tmle ccmle center vc50" type="number" name="data[report][count_promoted_boys]" value="<?php echo $prep['count_promoted_boys']; ?>" onchange="same('ccmle',this.value);return false;" /></td>
	<td class="center" ><input class="tgrl ccgrl center vc50" type="number" name="data[report][count_promoted_girls]" value="<?php echo $prep['count_promoted_girls']; ?>" value="0" onchange="same('ccgrl',this.value);return false;" /></td>
	<td class="center" ><input class="tstd ccstd center vc50" type="number" name="data[report][count_promoted_total]"  value="<?php echo $prep['count_promoted_total']; ?>" onchange="same('ccstd',this.value);return false;" /></td>
</tr>



<tr>
	<td> Total Age Pupils </td>
	<?php if(!$is_locked): ?> 
		<td>
			<button onclick="sum('bage'); return false;" > Boys </button> 
			<button onclick="sum('gage'); return false;" > Girls </button> 
			<button onclick="sum('age'); return false;" > Total </button> 
		</td>
	<?php endif; ?>
		
	<td class="center" ><input class="tbage center vc50" type="text" name="data[report][sum_age_boys]" value="<?php echo $prep['sum_age_boys']; ?>" /></td>
	<td class="center" ><input class="tgage center vc50" type="text" name="data[report][sum_age_girls]" value="<?php echo $prep['sum_age_girls']; ?>" /></td>
	<td class="center" ><input class="tage center vc50" type="text" name="data[report][sum_age_total]" value="<?php echo $prep['sum_age_total']; ?>"  /></td>

</tr>


<tr>
	<td> Total Age Promoted </td>
	<?php if(!$is_locked): ?> <td> &nbsp; </td> <?php endif; ?>
	<td class="center" ><input class="tbage center vc50" type="text" name="data[report][sum_age_promoted_boys]" value="<?php echo $prep['sum_age_promoted_boys']; ?>"  /></td>
	<td class="center" ><input class="tgage center vc50" type="text" name="data[report][sum_age_promoted_girls]" value="<?php echo $prep['sum_age_promoted_girls']; ?>"  /></td>
	<td class="center" ><input class="tage center vc50" type="text" name="data[report][sum_age_promoted_total]" value="<?php echo $prep['sum_age_promoted_girls']; ?>"  /></td>

</tr>



<tr>
	<td> Average Age Pupils </td>
	<?php if(!$is_locked): ?> 	
		<td>
			<button onclick="ave('bage'); return false;" > Boys </button> 
			<button onclick="ave('gage'); return false;" > Girls </button> 
			<button onclick="ave('age'); return false;" > Total </button> 
		</td>
	<?php endif; ?>
		
	<td class="center" ><input class="abage center vc50" type="text" name="data[report][ave_age_boys]" value="<?php echo $prep['ave_age_boys']; ?>"  /></td>
	<td class="center" ><input class="agage center vc50" type="text" name="data[report][ave_age_girls]" value="<?php echo $prep['ave_age_girls']; ?>"  /></td>
	<td class="center" ><input class="aage center vc50" type="text" name="data[report][ave_age_total]" value="<?php echo $prep['ave_age_total']; ?>"  /></td>
</tr>

<tr>
	<td> Average Age Promoted </td>
	<?php if(!$is_locked): ?> <td> &nbsp; </td> <?php endif; ?>
	<td class="center" ><input class="abage center vc50" type="text" name="data[report][ave_age_promoted_boys]" value="<?php echo $prep['ave_age_promoted_boys']; ?>"  /></td>
	<td class="center" ><input class="agage center vc50" type="text" name="data[report][ave_age_promoted_girls]" value="<?php echo $prep['ave_age_promoted_girls']; ?>"  /></td>
	<td class="center" ><input class="aage center vc50" type="text" name="data[report][ave_age_promoted_total]" value="<?php echo $prep['ave_age_promoted_total']; ?>"  /></td>
</tr>




</table>

<br /><hr />


<?php 

// pr($data['promotion']);

?>