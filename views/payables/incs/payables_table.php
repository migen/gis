<?php 

// pr($rows[0]);
// pr($ornos);


?>


<?php $total=0; ?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>PKID</th>	
	<th>SCID</th>	
	<th>SY</th>
	<th>DueOn</th>
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Name</th>
	<th>Feetype</th>
	<th>Ptr</th>
	<th>Amount</th>
	<th>Paid</th>
	<th>Balance</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): $j=$i+1; ?>
<tr>
<?php $total+=$rows[$i]['amount']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['due_on']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['ptr']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<td><a href="<?php echo URL.'enrollment/ledger/'.$rows[$i]['scid'].DS.$sy; ?>" >Ledger</a></td>
</tr>
<?php endfor; ?>

<tr>
	<th colspan="9" >Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
	<th></th>
</tr>

</table>

<h3>Total: <?php echo number_format($total,2); ?></h3>

<div class="ht50" ></div>




<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	$('#names').hide();
})





</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/orno.js"></script>

