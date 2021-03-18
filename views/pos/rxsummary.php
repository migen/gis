<h5>
	POS Returns Exchange (<?php echo $count; ?>) 
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
	
</h5>

<?php 

if(isset($_GET['debug'])) { pr($q); }

// pr($rows[0]); 



?>


<table class="gis-table-bordered" >
<tr>
	<th>Start <input id="start" type="date" value="<?php echo $start; ?>" /></th>
	<th>End <input id="end" type="date"value="<?php echo $end; ?>" /></th>
	<th>Size<input id="fontsize" type="text" value="<?php echo '1.2'; ?>" class="vc50" /></th>
	<th><button onclick="filterReturns();" >Filter</button></th>

</tr>
</table>

<?php $fontsize=isset($_GET['fontsize'])? $_GET['fontsize']:1; ?>


<br />
<table class="gis-table-bordered table-fx" style="font-size:<?php echo $fontsize; ?>em;" >
<tr><th>View</th><th>Customer</th><th>Datetime</th><th>Total</th><th>Product</th>
	<th>Price</th><th>Qty</th><th>Subtotal</th><th>Employee</th>
	<th>Orig</th><th>Original OR</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td>
		<a href="<?php echo URL.'npos/view/'.$rows[$i]['pos_id']; ?>" ><?php echo $rows[$i]['pos_id']; ?></a>
	</td>
	<td class="vc150" ><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['total']; ?></td>
	<td class="vc150" ><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['price']*$rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><a href="<?php echo URL.'npos/view/'.$rows[$i]['rxref_posid']; ?>" ><?php echo $rows[$i]['rxref_posid']; ?></a></td>
	<td>
		<?php // pr($pos[$i]); ?>
		<table class="gis-table-bordered" >
			<?php foreach($pos[$i] AS $pd): ?>
				<tr>
					<td class="vc200" ><?php echo $pd['product']; ?></td>
					<td class="vc50" ><?php echo $pd['price']; ?></td>
					<td class="vc50" ><?php echo $pd['qty']; ?></td>
					<td class="vc50" ><?php echo $pd['amount']; ?></td>				
				</tr>
			<?php endforeach; ?>
			<tr></tr>
		</table>
	</td>
</tr>
<?php endfor; ?>
</table>


<script>

var gurl="http://<?php echo GURL; ?>";

function filterReturns(){
	var start=$('#start').val();
	var end=$('#end').val();
	var fontsize=$('#fontsize').val();
	var url=gurl+'/pos/rxsummary/'+start+'/'+end+'?fontsize='+fontsize;
	// alert(url);
	window.location=url;
}	/* fxn */

</script>
