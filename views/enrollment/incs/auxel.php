
<?php 
// $taux = $data['taux'];
// $numtaux = $data['numtaux'];
// $feetypes = $data['feetypes'];

?>

<table class="gis-table-bordered <?php echo $tblwidth; ?>" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc300" >Name</th>
	<th>Discount</th>
	<th>Addon</th>
	<th class="hd screen" ></th>
</tr>
<?php 
	$discounts=0;
	$addons=0;
	
	for($i=0;$i<$numtaux;$i++): 

	if($taux[$i]['is_discount']==1){
		$discounts+=$taux[$i]['amount'];
	} else {
		$addons+=$taux[$i]['amount'];	
	}	
	
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $taux[$i]['feetype']; ?></td>
	<td class="right" ><?php $disc = ($taux[$i]['is_discount'])? $taux[$i]['amount']:NULL; echo number_format($disc,2); ?></td>
	<td class="right" ><?php $addon = (!$taux[$i]['is_discount'])? $taux[$i]['amount']:NULL; echo number_format($addon,2); ?></td>
	<td class="hd screen" ><a class="u txt-blue" onclick="deleteTaux(<?php echo $taux[$i]['tauxid']; ?>);"  >Del</a></td>
</tr>
<?php endfor; ?>
<tr class="screen" >
	<th><button><span class="u" onclick="addAux(<?php echo 0; ?>);" >Add</span></button></th>
	<td>
		<select id="aux0" onchange="auxThis(this.value);return false;" >
			<option value="0" >Choose</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td>Amount</td>
	<td><input class="vc80 right pdr05" id="auxamount0"  /></td>	
	<td class="hd" ></td>
</tr>
</table>
