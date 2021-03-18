<style>

.indented{ text-indent:20px; }


</style>

<?php 

// pr($rows[0]);

?>

<h3>
	Feetypes (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >SHD</span>
	
</h3>

<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Feetype <span class="shd" >#</span> </th>
	<th>Prnt ID</th>
	<th>Parent <span class="shd" >#</span></th>
	<th>Code</th>
	<th>Position</th>
	<th>Amount</th>	
	<th>Pct</th>	
	<th>is<br />disc</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $is_child=($rows[$i]['parent_id']>0)? true:false; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['feetype_id']; ?></td>
	<td class="<?php echo ($is_child)? 'indented':'b'; ?>" ><?php echo $rows[$i]['feetype']; ?>
		<span class="shd" ><?php echo '#'.$rows[$i]['pkid']; ?></span></td>
	<td><?php echo $rows[$i]['parent_id']; ?></td>
	<td><?php echo $rows[$i]['supfeetype']; ?>
		<span class="shd" ><?php echo '#'.$rows[$i]['parent_id']; ?></span></td>
		
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo ($rows[$i]['percent']+0); echo ($rows[$i]['percent']>0)? '%':null; ?></td>
	<td><?php echo ($rows[$i]['is_discount'])? 'Disc':NULL; ?></td>
</tr>


<?php endfor; ?>
</table>

<div class="ht50" ></div>

<script>

$(function(){
	shd();
	
})

</script>