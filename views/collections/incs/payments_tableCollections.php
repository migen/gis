<?php 

// pr($rows[0]);
// pr($ornos);

?>


<?php $total=0; ?>

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>OR<br >Type</th>
	<th>Date</th>
	<th>Classroom</th>
	<th>Name</th>
	<th>SY</th>
	<th>Or No.</th>
	<th>Or Date</th>
	<th>Amount</th>
	<th>Breakdowns</th>
	<th>Feetype</th>
	<th>Paytype</th>
	<th>Reference</th>	
	<th>ID</th>	
</tr>

<?php for($i=0;$i<$count;$i++): $j=$i+1; ?>
<tr>
<?php $total+=$rows[$i]['amount']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ortype']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo ($rows[$i]['scid'])? $rows[$i]['student']:$rows[$i]['payer']; ?></td>
	<td><?php echo $rows[$i]['vsy']; ?></td>		
	<td><span class="u" onclick="syOrnoValue(<?php echo $rows[$i]['orno'].','.$rows[$i]['vsy']; ?>);return false;" >
		<?php echo $rows[$i]['orno']; ?></span></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td class="right" >
		<?php 
			if($rows[$i]['numrows']>1){
				foreach($ornos[$i] AS $orno){
					echo number_format($orno['amount'],2).'<br />';
				}
			} 
		?>
	</td>
	<td><?php echo $rows[$i]['feetype'].' #'.$rows[$i]['pointer']; ?></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
	<td><?php echo $rows[$i]['payid']; ?></td>
</tr>
<?php endfor; ?>

<tr>
	<th colspan="5" >Total</th>
	<th></th>
	<th><?php echo $i; ?></th>
	<th></th>
	<th><?php echo number_format($total,2); ?></th>
	<th colspan="5" ></th>
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

