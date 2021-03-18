<h5>
	POS RX Report
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
	
</h5>

<table class="gis-table-bordered" >
<tr>
	<th>Start <input id="start" type="date" value="<?php echo $start; ?>" /></th>
	<th>End <input id="end" type="date"value="<?php echo $end; ?>" /></th>
	<th><button onclick="filterRx();" >Filter</button></th>

</tr>
</table>

<br />
<table class="gis-table-bordered table-fx" >
<tr><th>View</th><th>Customer</th><th>Date</th><th>Product</th>
	<th>Price</th><th>Qty</th><th>Subtotal</th><th>Employee</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><a href="<?php echo URL.'posrx/id/'.$rows[$i]['posid']; ?>" ><?php echo $rows[$i]['posid']; ?></a></td>
	<td class="vc150" ><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td class="vc150" ><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
</tr>
<?php endfor; ?>
</table>


<script>

var gurl="http://<?php echo GURL; ?>";

function filterRx(){
	var start=$('#start').val();
	var end=$('#end').val();
	var url=gurl+'/pos/rxrpt/'+start+'/'+end;
	// alert(url);
	window.location=url;
}	/* fxn */

</script>
