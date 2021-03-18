<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr><th colspan="<?php echo $colspan; ?>" >DCR Date Range: <?php echo $start.' to '.$end; ?></th></tr>

<tr>
<th>Employee</th>
<?php for($i=0;$i<$count;$i++): ?>
	<td><?php echo $cashiers[$i]['code']; ?></td>
<?php endfor; ?>
<th class="right" >Total</th>
</tr>
<tr><th colspan="<?php echo $colspan; ?>" >OR Number</th></tr>
<tr>
<th class="left" >Beginning</th>
<?php for($i=0;$i<$count;$i++): ?>
	<td><?php echo $ornos[$i]['min']; ?></td>
<?php endfor; ?>
<td></td>
</tr>

<tr>
<th class="left" >Ending</th>
<?php for($i=0;$i<$count;$i++): ?>
	<td><?php echo $ornos[$i]['max']; ?></td>
<?php endfor; ?>
<td></td>
</tr>

<tr><th class="left"  colspan="<?php echo $colspan; ?>" >Sales & Collection</th></tr>
<tr>
<th>Sales Cash</th>
<?php $a=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $a+=$sales[$i]['tender_cash']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['tender_cash'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($a,2); ?></th>
</tr>

<tr>
<th>Sales Non-Cash</th>
<?php $b=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $b+=$sales[$i]['tender_etc']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['tender_etc'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($b,2); ?></th>
</tr>

<tr>
<th>Sales Paid</th>
<?php $c=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $c+=$sales[$i]['paid']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['paid'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($c,2); ?></th>
</tr>

<tr>
<th>Sales Credit</th>
<?php $d=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $d+=$sales[$i]['unpaid']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['unpaid'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($d,2); ?></th>
</tr>

<tr>
<th>Sales Total</th>
<?php $e=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $e+=$sales[$i]['total']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['total'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($e,2); ?></th>
</tr>


<tr>
<th>Cash Count</th>
<?php $e=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $e+=$sales[$i]['cash_count']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['cash_count'],2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($e,2); ?></th>
</tr>


<tr><th colspan="<?php echo $colspan; ?>" >Overage | Shortage (-)</th></tr>

<tr>
<th>Cash</th>
<?php $g=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
	<?php $difference = $sales[$i]['cash_count']-$sales[$i]['tender_cash']; ?>
	<?php $g+=$difference; ?>	
	<td class="right" ><?php echo number_format($difference,2); ?></td>
<?php endfor; ?>
<th class="right" ><?php echo number_format($g,2); ?></th>
</tr>


</table>