<?php 

// pr($tsum); 
// pr($taux);

?>

<div style="float:left;width:50%;" class="" >
<table class="gis-table-bordered table-altrow tblaux" >
<tr class="" >
	<th>&nbsp;</th>
	<th class="vc20">#</th>
	<th>ADDONS / DISC.</th>
	<th class="right" >Disc.</th>
	<th class="right" >Addon</th>
	<th class="screen" >Action</th>
</tr>
<?php
	$discounts=0;
	$addons=0;
?>
<?php for($i=0;$i<$numtaux;$i++): ?>
<?php 
	if($taux[$i]['is_discount']==1){
		$discounts+=$taux[$i]['amount'];
	} else {
		$addons+=$taux[$i]['amount'];	
	}
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $taux[$i]['num']; ?></td>
	<td><?php echo $taux[$i]['feetype']; ?></td>
	<td class="right" ><?php $disc = ($taux[$i]['is_discount'])? $taux[$i]['amount']:NULL; echo number_format($disc,2); ?></td>
	<td class="right" ><?php $addon = (!$taux[$i]['is_discount'])? $taux[$i]['amount']:NULL; echo number_format($addon,2); ?></td>
	<td class="screen" >
		<span class="" >
		  <a href="<?php echo URL.'addons/edit/'.$taux[$i]['tauxid']; ?>" >Edit</a>
		| <a class="u txt-blue" id="btndt<?php echo $i; ?>" 
		onclick="deleteTaux(<?php echo $taux[$i]['tauxid'].','.$i.',1,'.$sy; ?>);"  >Del</a>
		
		</span>
	</td>

</tr>
<?php endfor; ?>
<tr class="screen" >


	<th><button><span class="u" id="addAuxBtn" onclick="addAux(<?php echo 0; ?>);" >Add</span></button></th>
	<td><input class="vc20 center" id="num0" value="1" /></td>	
	<td>
		<select class="vc150" id="auxtype0" onchange="getAux(this.value);return false;" >
			<option value="0" >Choose</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" class="<?php echo ($sel['is_discount']==1)? 'red':NULL; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td>Amount</td>
	<td><input class="vc80 right pdr05" id="auxamt0"  /></td>	
	<td class="screen" >
		<input id="pct" value="0" class="vc40" >%
		<input id="principal" value="<?php echo $tsum['tuition']; ?>" class="vc60" >P
		<button onclick="getDiscountAmount();" >Get</button>
		
		
	
	</td>
</tr>

</table>

</div>


<script>



function getAux(id){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&id='+id+'&sy='+sy,		
		success: function(s) { 			
			var amt = 0;
			// console.log(s);
			$('#pct').val(s.percentage);
			if(s.percentage>0){ amt = parseFloat(tuition)*s.percentage/100;
			} else { amt = s.amount; }		
			$('#auxamt0').val(parseFloat(amt).toFixed(2));			
		}		  
	});					
	
	
}	/* fxn */


function getDiscountAmount(){
	var pct=$('#pct').val();
	var principal=$('#principal').val();
	principal= principal.replace(/\,/g,'');	
	// alert(pct*principal/100);
	var amt = (pct*principal/100);
	$('#auxamt0').val(amt);
}

</script>

