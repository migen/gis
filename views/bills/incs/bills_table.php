<table id="tblExport" class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Customer</th>
	<th>Fee</th>
	<th>Amount</th>
	<th>OR No</th>
	<th>Paytype</th>
	<th>Reference</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td class="vc200" ><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td class="u" onclick="copyOrno(<?php echo $i; ?>);return false;" >
		<span id="orno<?php echo $i; ?>" ><?php echo $rows[$i]['orno']; ?></span></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
</tr>
<?php endfor; ?>
</table>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	excel();
})

function copyOrno(i){
	var val=$('#orno'+i).text();
	val=$.trim(val);
	$('#orno').val(val);
}

function printOrno(){
	var orno=$('#orno').val();
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}	/* fxn */


</script>