<style>
@media print{ .screen{display:none;} } 

</style>



<?php 

// pr($_SESSION['q']);

?>

<h5 class="screen" >
<form method="GET" >
	OR Number <?php echo '#'.$orno; ?> 
	| <a class="u" onclick="ilabas('orfind');" >Find</a> 
	<span class="orfind" >
		<?php spacer('3'); ?><input class="pdl05" id="orno" name="orno" placeholder="OR No."  />
		<input type="submit" value="Go"  />	
	</span>	
</form>	


<a class="u txt-blue" onclick="ilabas('std');" >View</a>
| <a class="u txt-blue"  onclick="ilabas('ornopage');" >Preview</a>
<?php if($scid): ?>
	| <a href="<?php echo URL.'ledgers/pay/'.$scid; ?>"  >Ledger</a>
	| <a href="<?php echo URL.'ledgers/soa/'.$scid; ?>"  >SOA</a>
	| <a href="<?php echo URL.'invoices/printorno/'.$orno.'?tplorno=1'; ?>"  >TPL</a>
<?php endif; ?>	
| <a href="<?php echo URL.'bills/add'; ?>"  >Cashiering</a>
| <a class="u txt-blue" onclick="windowPrint();" >PRINT</a>
| <a class="u txt-blue"  onclick="ilabas('delpay');" >EDIT OR</a>

<?php 
	$d['sy']=$sy;$d['repage']="invoices/printorno/$orno";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>


<div class="std screen" >	<!-- std -->

<p><table class="gis-table-bordered" >
<?php if($scid): ?>
	<tr><th>Student</th><td><?php echo $customer['customer']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $customer['level'].'-'.$customer['section']; ?></td></tr>
<?php else: ?>	
	<tr><th>Customer</th><td class="vc150" ><?php echo $customer['customer']; ?></td></tr>
<?php endif; ?>	
</table>
</p>

<table class="gis-table-bordered" >
<tr class="" >
<th>PayID</th>
<th>OR Type</th>
<th>Date</th>
<th>Particular</th>
<th>Tender</th>
<th>Amount</th>
<th>Reference</th>
<th>OR NO</th>
<th class="delpay" >Action</th>
</tr>

<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $row['payid']; ?></td>
	<td><?php echo $row['ortype']; ?></td>
	<td><?php echo $row['date']; ?></td>
	<td><?php echo $row['feetype']; ?></td>
	<td><?php echo $row['paytype']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['reference']; ?></td>
	<td><?php echo $row['orno']; ?></td>
	<td class="delpay" >
		<?php if($row['ortype_id']==1): ?>
			<a href="<?php echo URL.'invoices/cancelPayLedger/'.$row['payid'].DS.$sy; ?>" 
				onclick="return confirm('Delete Ledger Payment. Sure?');" >Cancel</a>
		<?php elseif($row['ortype_id']==2): ?>
			<a href="<?php echo URL.'invoices/cancelPayBill/'.$row['payid'].DS.$sy; ?>" 
				onclick="return confirm('Delete Bill Payment. Sure?');" >Cancel</a>		
		<?php elseif($row['ortype_id']==3): ?>
			<a href='<?php echo URL."advances/delete/".$row["payid"].DS.$sy; ?>' 
				onclick="return confirm('Delete Advance Payment. Sure?');" >Delete</a>	
		<?php endif; ?>			
		| 
		<?php if($row['ortype_id']==1): ?>
			<a href="<?php echo URL.'invoices/editOrnoLedger/'.$row['orno'].DS.$row['payid'].DS.$row['vsy']; ?>" >Edit 1</a>
			| <a class="u" onclick="xdeletePayment(<?php echo $row['vsy'].','.$row['payid']; ?>);" >Del Pymt</a>
		<?php elseif($row['ortype_id']==2): ?>
			<a href="<?php echo URL.'invoices/editOrnoBill/'.$row['orno'].DS.$row['payid'].DS.$row['vsy']; ?>" >Edit 2</a>
			| <a class="u" onclick="xdeleteBill(<?php echo $row['vsy'].','.$row['payid']; ?>);" >Del Bill</a>
		<?php else: ?>
			<a href="<?php echo URL.'advances/edit/'.$row['payid'].DS.$row['vsy']; ?>" >Edit 3</a>		
		<?php endif; ?>			
	</td>		
</tr>
<?php endforeach; ?>

</table>
</div>	<!-- std -->


<?php 

	$tplorno=isset($_GET['tplorno'])? $_GET['tplorno']:NULl;
	$inc = SITE."views/customs/".VCFOLDER."/orno{$tplorno}.php";	
	include_once($inc); 
?>


<!-- 
<p class="screen" ><button><a style="font-size:2em;" class="u no-underline" onclick="windowPrint();" >Window PRINT</a></button></p>

<p class="screen" ><button style="padding:6px;font-size:30px;" onclick="PrintElem('#ornopage');return false;" >PRINT Elem</button></p>

-->
<p class="screen" ><button><a style="font-size:2em;" class="u no-underline" onclick="windowPrint();" >PRINT</a></button></p>


<script>
	var gurl = "http://<?php echo GURL; ?>";
	
	$(function(){
		hd();
		itago('orfind');
		itago('delpay');
		
	})

	function windowPrint(){
		itago('screen');
		ilabas('ornopage');
		window.print();
	}

function printorno(orno){
	var vurl = gurl+'/ajax/xfees.php';	
	var task = "orno";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&orno='+orno,				
		async: true,
		success: function(s) { 
			console.log(s);
			var cs = s.length;
			content = '<tr><th>Fee</th><th>Amount</th></tr>';
			var ortotal=0;
			var od = $('#ordetails');			
for (var i = 0; i < cs; i++) {			
	ortotal+=parseFloat(s[i].amount);
	content += '<tr><td>'+s[i].feetype+'</td><td>'+s[i].amount+'</td></tr>';
}
			od.html(content);
			$('#ortotal').html(ortotal);
			PrintElem('#ornopage');						

		}		  
    });				
	
	
	
}	/* fxn */




function xdeletePayment(sy,pid){
	var url=gurl+"/ajax/xorno.php";
	var task="xdeletePayment";
	$.ajax({
		url:url,type:'POST',		
		data:'task='+task+'&url='+url+'&sy='+sy+'&pid='+pid,
		success:function(){ location.reload(); }	
	})
	
}


function xdeleteBill(sy,pid){
	var url=gurl+"/ajax/xorno.php";
	var task="xdeleteBill";
	$.ajax({
		url:url,type:'POST',
		data:'task='+task+'&url='+url+'&sy='+sy+'&pid='+pid,
		success:function(){ location.reload(); }	
	})

}

	
	
</script>

