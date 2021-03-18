<table border="0" class="gis-table-bordered" style="font-size:0.7em;width:<?php echo $rtw; ?>;" >
<tbody>
<tr><td class="center" colspan="4" >SUMMARY TABLE</td></tr>

<tr><td style="width:<?= $cw; ?>" >STATUS</td>
<td>MALE</td><td>FEMALE</td><td>TOTAL</td></tr>

<tr>
	<td style="width:<?= $cw; ?>" >PROMOTED</td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_promoted_boys']; ?>" 
			onchange="xeditPreport('count_promoted_boys',this.value);return false;" /></td>

	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_promoted_girls']; ?>" 
			onchange="xeditPreport('count_promoted_girls',this.value);return false;" /></td>

	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_promoted_total']; ?>" 
			onchange="xeditPreport('count_promoted_total',this.value);return false;" /></td>			
			
</tr>
<tr>
	<td style="width:<?= $cw; ?>" >*Conditional</td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_conditional_boys']; ?>" 
			onchange="xeditPreport('count_conditional_boys',this.value);return false;" /></td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_conditional_girls']; ?>" 
			onchange="xeditPreport('count_conditional_girls',this.value);return false;" /></td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_conditional_total']; ?>" 
			onchange="xeditPreport('count_conditional_total',this.value);return false;" /></td>			
	
</tr>
<tr>
	<td style="width:<?= $cw; ?>" >RETAINED</td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_retained_boys']; ?>" 
			onchange="xeditPreport('count_retained_boys',this.value);return false;" /></td>			
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_retained_girls']; ?>" 
			onchange="xeditPreport('count_retained_girls',this.value);return false;" /></td>			
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_retained_total']; ?>" 
			onchange="xeditPreport('count_retained_total',this.value);return false;" /></td>						
	
</tr>
</tbody>
</table>

<br />

<table border="0" class="gis-table-bordered" style="font-size:0.7em;width:<?php echo $rtw; ?>;" >
<tbody>
<tr><td class="center" colspan="4" 
	style="" >LEARNING PROGRESS AND ACHIEVEMENT <br />(Based on Learner's General Average)</td></tr>
<tr><td style="width:<?= $cw; ?>" >Descriptors & Grading Scale</td>
<td>MALE</td><td>FEMALE</td><td>TOTAL</td></tr>
<tr>
	<td style="width:<?= $cw; ?>" >Did Not Meet Expectations<br />(74 and below)</td>
	
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_boys_B']; ?>" 
			onchange="xeditPreport('count_genave_boys_B',this.value);return false;" /></td>							
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_girls_B']; ?>" 
			onchange="xeditPreport('count_genave_girls_B',this.value);return false;" /></td>						
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_total_B']; ?>" 
			onchange="xeditPreport('count_genave_total_B',this.value);return false;" /></td>	
</tr>

<tr>
	<td style="width:<?= $cw; ?>" >Fairly Satisfactory (75-79)</td>

	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_boys_D']; ?>" 
			onchange="xeditPreport('count_genave_boys_D',this.value);return false;" /></td>							
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_girls_D']; ?>" 
			onchange="xeditPreport('count_genave_girls_D',this.value);return false;" /></td>						
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_total_D']; ?>" 
			onchange="xeditPreport('count_genave_total_D',this.value);return false;" /></td>
</tr>

<tr>
	<td style="width:<?= $cw; ?>" >Satisfactory (80-84)</td>

	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_boys_AP']; ?>" 
			onchange="xeditPreport('count_genave_boys_AP',this.value);return false;" /></td>							
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_girls_AP']; ?>" 
			onchange="xeditPreport('count_genave_girls_AP',this.value);return false;" /></td>						
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_total_AP']; ?>" 
			onchange="xeditPreport('count_genave_total_AP',this.value);return false;" /></td>	
	
</tr>

<tr>
	<td style="width:<?= $cw; ?>" >Very Satisfactory (85-89)</td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_boys_P']; ?>" 
			onchange="xeditPreport('count_genave_boys_P',this.value);return false;" /></td>							
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_girls_P']; ?>" 
			onchange="xeditPreport('count_genave_girls_P',this.value);return false;" /></td>						
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_total_P']; ?>" 
			onchange="xeditPreport('count_genave_total_P',this.value);return false;" /></td>
</tr>

<tr>
	<td style="width:<?= $cw; ?>" >Outstanding (90-100)</td>
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_boys_A']; ?>" 
			onchange="xeditPreport('count_genave_boys_A',this.value);return false;" /></td>							
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_girls_A']; ?>" 
			onchange="xeditPreport('count_genave_girls_A',this.value);return false;" /></td>						
	<td style="width:<?= $tw; ?>" ><input class="vc30 center" value="<?php echo $prep['count_genave_total_A']; ?>" 
			onchange="xeditPreport('count_genave_total_A',this.value);return false;" /></td>	
</tr>

</tbody>
</table>


<script>

var gurl="http://<?php echo GURL; ?>";
var crid="<?php echo $crid; ?>";

$(function(){


})

function xeditPreport(key,val){	
	var vurl 	= gurl + '/ajax/xpreport.php';	
	var task	= "updatePreport";	
	var pdata = "task="+task+"&key="+key+"&val="+val+"&crid="+crid;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				
		
}	/* fxn */


</script>

