<?php 
// pr($_GET);
// pr($_SERVER);


$url=getUrl();
$url=rtrim($url,'&printable');



?>

<h5 class="screen" >
	Stocks By Terminal (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href="<?php echo URL.$url; ?>">Editable</a>
	| <a class="u" id="btnExport" >Excel</a> 

	<?php // echo $_GET['url']; ?>
	
</h5>



<p class="brown b screen" >*The items shown are managed by Stocks on "Display" module.
<br />*Set Signed=0 to include negative stocks.
<br />*Set Disp (Display)=0 to include all items not only displayed.
<br />*Set TQ-L (i.e. -1000) qty and TQ-U (upper)=0 to find the range, ex. all negative qty from -1000 to -1.
</p>

<?php 

// pr($terminal);
// pr($rows[0]);

if(isset($_GET['debug'])){ pr($q); }

?>


<div class="center clear" >
<?php $page="Stocks by Terminal"; $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<?php $numcols=isset($_GET['printable'])? 8:9; ?>
<?php // include_once('incs/stocks_filter.php'); ?>

<br />

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>PrID</th>
	<th>Code</th>
	<th>Barcode</th>
	<th>Product</th>
	<th class="right" >Cost</th>
	<th class="right" >Price</th>
	<th>T<?php echo $terminal; ?></th>
	<th>Level</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo str_pad($rows[$i]['prodid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td class="" ><?php echo $rows[$i]['code']; ?></td>
	<td class="" ><?php echo $rows[$i]['barcode']; ?></td>
	<td class="" ><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cost'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
	<td class="right" ><?php echo $rows[$i]['tq']; ?></td>
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>
</tr>

<?php 
	$j=$i+1;
	if($rows[$i]['suppid']!=@$rows[$j]['suppid']){
		$lblsupp=isset($rows[$j]['suppid'])? $rows[$j]['supplier'].' - #'.$rows[$j]['suppid'].' - '.$rows[$j]['comm']:'NO Supplier';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
	} 
?>	
<?php endfor; ?>
</table>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl="http://<?php echo GURL; ?>";
var trml="<?php echo $terminal; ?>";

$(function(){
	excel();

})

function xsaveQty(i){
	$('#btn'+i).hide();
	var tq=$('#tq'+i).val();
	var lq=$('#lq'+i).val();
	var prid=$('#prid'+i).val();
	// alert("trml: "+trml+", tq: "+tq+", lq: "+lq+", prid: "+prid);

	var vurl = gurl+'/ajax/xstocks.php';		
	var task = "xsaveQty";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&tq='+tq+'&lq='+lq+'&trml='+trml+'&prid='+prid,						
		success: function() { }		  
    });				
	


}

</script>