

<!---------------------------------------------------------------->


<?php 


$prep 		= $data['prep'];
$is_locked	= isset($data['is_locked'])? $data['is_locked'] : 0;
$is_this_year = isset($data['is_this_year'])? $data['is_this_year'] : 1;


?>




<h2> Report 
<?php if(!$is_locked): ?>
	<br /> <button onclick="tallyProm(); return false;" > Tally Promotions </button> 
<?php endif; ?>
</h2>

<table class="gis-table-bordered table-altrow table-fx" >

<tr class="headrow">
	<th class="vc150" >&nbsp;</th>
	<th class="vc70 center" >Male</th>
	<th class="vc70 center" >Female</th>
	<th class="vc70 center" >Total</th>
</tr>


<tr>
	<td> Promoted </td>		
	<td class="center" ><input class="tiprob center vc50" type="text" name="data[report][count_promoted_boys]" value="<?php echo $prep['count_promoted_boys']; ?>" /></td>
	<td class="center" ><input class="tiprog center vc50" type="text" name="data[report][count_promoted_girls]" value="<?php echo $prep['count_promoted_girls']; ?>" /></td>
	<td class="center" ><input class="tiprom center vc50" type="text" name="data[report][count_promoted_total]"  value="<?php echo $prep['count_promoted_total']; ?>"  /></td>
</tr>


<tr>
	<td>Conditional</td>		
	<td class="center" ><input class="ticonb center vc50" type="text" name="data[report][count_conditional_boys]" value="<?php echo $prep['count_conditional_boys']; ?>" /></td>
	<td class="center" ><input class="ticong center vc50" type="text" name="data[report][count_conditional_girls]" value="<?php echo $prep['count_conditional_girls']; ?>" /></td>
	<td class="center" ><input class="ticont center vc50" type="text" name="data[report][count_conditional_total]"  value="<?php echo $prep['count_conditional_total']; ?>"  /></td>
</tr>


<tr>
	<td> Retained </td>
	<td class="center" ><input class="toprob center vc50" type="text" name="data[report][count_retained_boys]" value="<?php echo $prep['count_retained_boys']; ?>"  /></td>
	<td class="center" ><input class="toprog center vc50" type="text" name="data[report][count_retained_girls]" value="<?php echo $prep['count_retained_girls']; ?>"  /></td>
	<td class="center" ><input class="toprom center vc50" type="text" name="data[report][count_retained_total]"  value="<?php echo $prep['count_retained_total']; ?>"  /></td>
</tr>

<tr>
	<td> Tally Count </td>
		
	<td class="center" ><input class="tmle vc50 center" type="text" name="data[report][count_boys]" value="<?php echo $prep['count_boys']; ?>"  /></td>	
	<td class="center" ><input class="tgrl vc50 center" type="text" name="data[report][count_girls]" value="<?php echo $prep['count_girls']; ?>"  /></td>	
	<td class="center" ><input class="tstd vc50 center" type="text" name="data[report][count_total]" value="<?php echo $prep['count_total']; ?>" /></td>		
</tr>


</table>


<table class="gis-table-bordered table-fx" >
<tr class="headrow">
	<th class="vc150" >&nbsp;</th>
	<th class="vc70 center" >Male</th>
	<th class="vc70 center" >Female</th>
	<th class="vc70 center" >Total</th>
</tr>

<tr>
	<td> Non-Regular </td>
	<td class="center" ><input class="tiregb center vc50" type="text" name="data[report][count_irregular_boys]" value="<?php echo $prep['count_promoted_boys']; ?>"/></td>
	<td class="center" ><input class="tiregg center vc50" type="text" name="data[report][count_irregular_girls]" value="<?php echo $prep['count_promoted_girls']; ?>" value="0"/></td>
	<td class="center" ><input class="tireg center vc50" type="text" name="data[report][count_irregular_total]"  value="<?php echo $prep['count_promoted_total']; ?>"/></td>
</tr>


<tr>
	<td> Beginning <br /> (B : 74% and below) </td>
	<td class="center vcenter" ><input class="vc50 center tdgbB" name="data[report][count_genave_boys_B]"  value="<?php echo $prep['count_genave_boys_B']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdggB" name="data[report][count_genave_girls_B]"  value="<?php echo $prep['count_genave_girls_B']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdgtB" name="data[report][count_genave_total_B]"  value="<?php echo $prep['count_genave_total_B']; ?>"  />  </td>
</tr>

<tr>
	<td> Development <br /> (D : 75% to 79%) </td>
	<td class="center vcenter" ><input class="vc50 center tdgbD" name="data[report][count_genave_boys_D]"  value="<?php echo $prep['count_genave_boys_D']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdggD" name="data[report][count_genave_girls_D]"  value="<?php echo $prep['count_genave_girls_D']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdgtD" name="data[report][count_genave_total_D]"  value="<?php echo $prep['count_genave_total_D']; ?>"  />  </td>
</tr>

<tr>
	<td> Approaching <br />Proficiency <br /> (AP : 80% to 84%) </td>
	<td class="center vcenter" ><input class="vc50 center tdgbAP" name="data[report][count_genave_boys_AP]"  value="<?php echo $prep['count_genave_boys_AP']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdggAP" name="data[report][count_genave_girls_AP]"  value="<?php echo $prep['count_genave_girls_AP']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdgtAP" name="data[report][count_genave_total_AP]"  value="<?php echo $prep['count_genave_total_AP']; ?>"  />  </td>
</tr>

<tr>
	<td> Proficient <br /> (P : 85% to 89%) </td>
	<td class="center vcenter" ><input class="vc50 center tdgbP" name="data[report][count_genave_boys_P]"  value="<?php echo $prep['count_genave_boys_P']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdggP" name="data[report][count_genave_girls_P]"  value="<?php echo $prep['count_genave_girls_P']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdgtP" name="data[report][count_genave_total_P]"  value="<?php echo $prep['count_genave_total_P']; ?>"  />  </td>
</tr>

<tr>
	<td> Advanced <br /> (A : 90% and above) </td>
	<td class="center vcenter" ><input class="vc50 center tdgbA" name="data[report][count_genave_boys_A]"  value="<?php echo $prep['count_genave_boys_A']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdggA" name="data[report][count_genave_girls_A]"  value="<?php echo $prep['count_genave_girls_A']; ?>"  />  </td>
	<td class="center vcenter" ><input class="vc50 center tdgtA" name="data[report][count_genave_total_A]"  value="<?php echo $prep['count_genave_total_A']; ?>"  />  </td>
</tr>


</table>



<?php 
// pr($prep);
// pr($data['promotion']);

?>