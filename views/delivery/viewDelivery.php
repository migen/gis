<h5>
	Receiving / Delivery Form
	| <span class="u" onclick="traceshd();" >Debug-Eraser</span>
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >SHD</span>
	| <a href="<?php echo URL.'delivery/view/'.$poid; ?>" >All</a>
	| <a href="<?php echo URL.'purchases/viewPO/'.$poid; ?>" >PO</a>

</h5>

<?php 

// pr($drrows[0]);

// pr($data);
// pr($rows[0]);
// pr($dr[0]);
// exit;

?>

<?php 
$incs="podetailsDelivery.php";include_once($incs);
?>



<br />

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th class="shd" >Prid</th>
<th>Product</th>
<th class="right" >Order<br />Qty</th>
<th>Cost</th>
<th>Amount</th>
<th>Dvry<br />Date</th>
<th>Dvry<br />Qty</th>
<th>Total<br />Dvry</th>
<th>Balance<br />Qty</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $rows[$i]['product_id']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['roqty']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
	<td class="right" ><?php $amt = ($rows[$i]['rxqty']*$rows[$i]['cost']); echo number_format($amt,2); ?></td>	
	<?php 
		$datestr="";
		$rqstr="";
		foreach($dr[$i] AS $drrow){ 
			$datestr.=$drrow['rxdate'].'<br />'; 
			$rqstr.=$drrow['rxqty'].'<br />'; 
		}
		$datestr=rtrim($datestr,"<br />");		
		$rqstr=rtrim($rqstr,"<br />");		
	?>	
	<td><?php echo $datestr; ?></td>
	<td class="right" ><?php echo $rqstr; ?></td>
	<td class="right" ><?php echo $rows[$i]['rxqty']; ?></td>	
	<td class="right" ><?php echo ($rows[$i]['roqty']-$rows[$i]['rxqty']); ?></td>
</tr>	
<?php endfor; ?>
</table>

<?php 
// pr($drrows[0]);
// pr($rows[0]);
// pr($data);

?>

<div class="ht50" ></div>

<?php // if(isset($_GET['debug'])): ?>
<?php $incs="referenceDeliveryTable.php";include_once($incs); ?>
<?php // endif; ?>

<script>
var gurl="http://<?php echo GURL; ?>";

$(function(){
	shd();
})

function xdeletePx(i){
	$('#btn-'+i).hide();
	var pxid = $('#pxid-'+i).val();
	var sure = confirm('Sure?');
	if(sure){
		var vurl = gurl+'/ajax/xdelivery.php';		
		var task = "xdeletePx";		
		var pdata= "task="+task+"&pxid="+pxid;
		$.ajax({
		  type: 'POST',url: vurl,data: pdata,	  
		  success: function(){ $('#row-'+i).remove(); }			  		  
	   });						
	}


}	/* fxn */


</script>