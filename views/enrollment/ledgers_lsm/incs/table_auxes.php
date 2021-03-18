<script>
	$(function(){
		excel();
	})

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<table id="tblExport" class="gis-table-bordered table-altrow\" >

<tr class="headrow" >
	<th>ID</th>
	<th>Due</th>
	<th>Students</th>
	<th>Fee</th>
	<th>Addons</th>
	<th>Discounts</th>
</tr>


<?php 
	$disctotal=0;
	$addontotal=0;
?>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	if($rows[$i]['is_discount']==1){
		$disctotal+=$rows[$i]['amount'];
	} else {
		$addontotal+=$rows[$i]['amount'];	
	}
?>
<tr>
	<td><?php echo $rows[$i]['invid']; ?></td>
	<td><?php echo $rows[$i]['due']; ?></td>
	<td><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_discount']!=1)? $rows[$i]['amount']:0; ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_discount']==1)? $rows[$i]['amount']:0; ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th><?php echo $i; ?></th>
	<th colspan="3" >Total</th>
	<th class="right" ><?php echo number_format($addontotal,2);?></th>
	<th class="right" ><?php echo number_format($disctotal,2);?></th>
</tr>
</table>