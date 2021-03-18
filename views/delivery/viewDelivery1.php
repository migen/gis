<h5>
	PO Delivery Report
	| <span class="u" onclick="traceshd();" >Eraser</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'delivery/view/'.$poid; ?>" >All</a>
	| <a href="<?php echo URL.'purchases/viewPO/'.$poid; ?>" >PO</a>

</h5>

<?php 

// pr($drrows[0]);

// pr($data);



?>

<?php 
$incs="podetailsDelivery.php";include_once($incs);
?>




<h4 class="brown" >
Click on a specific date to filter by that date only.
</h4>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Date</th>
<th>Product</th>
<th class="right" >Qty</th>
<th>Cost</th>
<th>Amount</th>
<th class="shd" ></th>
</tr>

<?php $total=0; ?>
<?php for($i=0;$i<$drcount;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'delivery/view/'.$poid.DS.$drrows[$i]['rxdate']; ?>" >
		<?php echo $drrows[$i]['rxdate']; ?></a></td>
	<td><?php echo $drrows[$i]['product']; ?></td>
	<td class="right" ><?php echo $drrows[$i]['rxqty']; ?></td>
	<td><?php echo $drrows[$i]['cost']; ?></td>
	<td class="right" ><?php $amt = ($drrows[$i]['rxqty']*$drrows[$i]['cost']); echo number_format($amt,2); ?></td>
	<?php $total+=$amt; ?>
	<td class="shd" ><button id="btn-<?=$i?>" onclick="xdeletePx(<?php echo $i; ?>);" >Delete</button></td>
	<input type="hidden" id="pxid-<?=$i;?>" value="<?=$drrows[$i]['pxid'];?>" />
</tr>
<?php endfor; ?>
<tr><th colspan="5" >Total</th>
<th class="right" ><?php echo number_format($total,2); ?></th>
<th class="shd" ></th>
</tr>
</table>

<div class="ht50" ></div>


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