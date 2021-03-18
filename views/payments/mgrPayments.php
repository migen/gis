<?php 

// pr($rows[0]);
// pr($_SESSION['q']);

?>

<h5>
	Payments Manager (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
	
</h5>


<!--- tracelogin --->
<p><?php $this->shovel('hdpdiv'); ?></p>


<table class="gis-table-bordered" >
<tr><th>Start</th><td class="vc150" ><?php echo $start; ?></td>
<th>End</th><td class="vc150" ><?php echo $end; ?></td></tr>
</table>
<br />
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>ID</th>
<th>SY</th>
<th>Date</th>
<th>Employee</th>
<th>Student</th>
<th>OR No</th>
<th>Amount</th>
<th>Fee</th>
<th>OR Type</th>
<th class="hd" >Action</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$vsy=$rows[$i]['vsy'];
	$orno=$rows[$i]['orno'];
	$payid=$rows[$i]['payid'];
	$ptable=$rows[$i]['ptable'];
	$ortype=$rows[$i]['ortype'];
	$ortype_id=$rows[$i]['ortype_id'];

?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $payid; ?></td>
	<td><?php echo $vsy; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo empty($rows[$i]['student'])? $rows[$i]['payer']:$rows[$i]['student']; ?></td>
	<td><?php echo $orno; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $ortype; ?></td>
<td class="hd" >
<?php if($ortype_id==2): ?>		
	<a href='<?php echo URL."invoices/editOrnoBill/$orno/$payid/$vsy"; ?>'  >Edit 2</a> |
<?php elseif($ortype_id==1): ?>		
	<a href='<?php echo URL."tpays/edit/$payid/$vsy"; ?>'  >Edit 1</a> |
<?php endif; ?>	


<a class="u" id="btn<?php echo $i; ?>" onclick="xdelPayment(<?php echo $i.',\''.$ptable.'\','.$payid.','.$vsy; ?>);return false;" >Delete</a>	


</td>

</tr>
<?php endfor; ?>
</table>


<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	hd();
	$('#hdpdiv').hide();

})


function xdelPayment(i,ptable,payid,vsy){
	$('#btn'+i).hide();
	var vurl 	= gurl + '/ajax/xpayments.php';	
	var task	= "xdelPayment";	
	var pdata = "task="+task+"&payid="+payid+"&ptable="+ptable+"&vsy="+vsy;

	$.ajax({ 
		type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				
	
	

}	/* fxn */






</script>
