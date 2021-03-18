<?php 

// pr($rows[0]);
// pr($ornos);

$colspan=15;

?>


<?php 

// pr($_GET);

?>

<?php if(isset($_GET['filter'])): ?>

<?php 
		$page="Payments Report";
		include_once('header_payments_report.php');
?>

<?php endif; ?>



<?php $total=0; ?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>PKID</th>	
	<th>SCID</th>	
	<th>SY</th>
	<th>Date</th>
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Name</th>
	<th>OR No.</th>
	<th>Feetype</th>
	<th>Paytype</th>
	<th>Transxn</th>
	<th>Reference</th>	
	<th>Notes</th>	
	<th>Employee</th>	
	<th>Amount</th>
</tr>

<?php for($i=0;$i<$count;$i++): $j=$i+1; ?>
<tr>
<?php $total+=$rows[$i]['amount']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo ($rows[$i]['scid']!=11)? $rows[$i]['studname']:$rows[$i]['payer']; ?></td>
	<td class="right" ><?php echo $rows[$i]['orno']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td><?php echo ($rows[$i]['in_tuition']==1)? 'Tuition':'Bill'; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
	<td><?php echo $rows[$i]['notes']; ?></td>
	<td><?php echo $rows[$i]['emplname']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>

<tr>
	<th colspan="<?php echo $colspan; ?>" >Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
</tr>

</table>

<h5>Total: <?php echo number_format($total,2); ?></h5>




<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	$('#names').hide();
})





</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/orno.js"></script>

