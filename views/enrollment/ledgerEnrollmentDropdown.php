<style>

div.half{border:1px solid fff; margin-right:10px; width:auto; }
div.left{border:1px solid fff; margin-right:10px; width:auto; width:75%; }


</style>

<?php 

pr($_SESSION['settings']['filter_dropdown']);

?>

<?php if($scid): 
	$sch=VCFOLDER;
	$studname=$student['studname']; 
	$tfee_total=$student['total']; 
	$paymode=$student['paymode']; 
	$tuition_amount=$student['tuition_amount']; 
	$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
	if(is_readable($incfile)){ include_once($incfile); $getAssessment="getAssessmentSjam"; } else { $getAssessment="getAssessment"; }

	$assarr=$getAssessment($student,$paymode);
	$tfee_duedates_arr=explode(",",$assarr['duedates']);


?>

<script>
	var scid="<?php echo $scid; ?>";
	var studname="<?php echo $studname; ?>";
</script>
<?php else: ?>
	<?php  
	$sch=VCFOLDER;
	$studname=''; 
	$tfee_total=0; 
	$paymode=''; 
	$tuition_amount=0; 
	$assarr=array();
	$tfee_duedates_arr=array();

?>
<?php endif; ?>


<?php 


$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";
$dbfeetypes="{$dbo}.03_feetypes";
$dbpayables="{$dbo}.30_payables";
$dbpayments="{$dbo}.30_payments";


?>




<h4>
	GIS Ledger Dropdown <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tuitions/level/$lvl/$sy"; ?>' >Tuition</a>
	| <a href='<?php echo URL."students?scid=$scid"; ?>' >Student</a>
	| <a href='<?php echo URL."students/paymode/$scid/$sy"; ?>' >Paymode</a>
	| <a href='<?php echo URL."students/assessment/$scid/$sy"; ?>' >Assessment</a>
	| <span class="u" onclick="traceshd()" >SHD</span>

</h4>

<p>
<table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick="getDataByTable(dbcontacts,10);return false;" />		
		</td>
	</tr>	



</table></p>

<div class="divleft" >
<?php if($scid): ?>	


<table class="gis-table-bordered" >
	<tr><th>ID No.</th><td><?php echo $student['studcode']; ?></td>
		<th>Classroom</th><td><?php echo $student['classroom'].' #'.$student['crid']; ?></td>	
		<th>Paymode</th><td><?php $paymode=$student['paymode']; echo $paymode; ?></td>	
	</tr>
	<tr><th>Student</th><td><?php echo $student['studname']; ?></td>
		<th>Amount</th><th class="right" ><?php echo number_format($tfee_total,2); ?></th>
		<th>Initial Periodic</th><th><?php echo number_format($assarr['initial_periodic'],2); ?></th>		
	</tr>
		

</table><br />


<!--------------- payables a) tuition b) payables ------------------------------------------->
<div class="half" >
<h5>Payables</h5>
<table class="gis-table-bordered"  >
<tr>
	<th>#</th>
	<th>Feetype</th>
	<th>Amount</th>
	<th>Due On</th>
	<th>Edit</th>
	<th>Delete</th>
	<th></th>
</tr>
<?php $total_payables=0; ?>
<?php for($i=0;$i<$assarr['count'];$i++): ?>
<?php $total_payables+=$assarr['adjusted_periodic']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo 'Tuition Fee - '.getOrdinalEnrollment($i+1).' Payment'; ?></td>
	<td class="right" ><?php $adj_amount=$assarr['adjusted_periodic']; echo number_format($adj_amount,2); ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo $adj_amount; ?>" >
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="Tuition Fee" >
		<input type="hidden" id="feetype_id-<?php echo $i; ?>-1" value="1" >
	</td>
	<td><?php echo $tfee_duedates_arr[$i]; ?></td>
	<td></td>
	<td></td>
	<td><button onclick="pasteAmount(<?php echo $i; ?>,1);" >Copy</button></td>
	
</tr>
<?php endfor; ?>




<!-- -->
<?php 
	$i=$assarr['count']+1; 
	
?>
<?php foreach($payables AS $row): ?>
<?php 
	$row_is_discounted=($row['is_discount']==1)? true:false;
	$row['amount']=($row['is_discount'])? $row['amount']*-1:$row['amount']; 
	$total_payables=($row_is_discounted)? $total_payables:$total_payables+$row['amount'];
?>

<tr>
	<td><?php echo $i; ?></td>
	<td class="vc200" ><?php echo $row['feetype']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['due_on']; ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo $row['amount']; ?>" />	
		<input type="hidden" id="pkid-<?php echo $i; ?>-1" class="pdl05" value="<?php echo $row['pkid']; ?>"  />		
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="<?php echo $row['feetype']; ?>" />	
		<input type="hidden" id="feetype_id-<?php echo $i; ?>-1" value="<?php echo $row['feetype_id']; ?>" />	
	<td><a href="<?php echo URL.'payables/edit/'.$row['payable_id'].DS.$sy; ?>" >Edit</a></td>
	<td><input type="submit" value="Del" onclick="xdelete(dbpayables,<?php echo $i; ?>,1);return false;" /></td>		
	<td>
		<?php if(!$row_is_discounted): ?>
			<button onclick="pasteAmount(<?php echo $i; ?>,1);" >Copy</button>
		<?php endif; ?>	
	</td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
<tr class="shd addPayment" >
	<td></td>
	<td class="vc200" >
		<select class="vc200" id="feetype_id-1" onchange="axnFeetype(this.value,1)"  >
			<option value=0>Select One</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td><input id="amount-1" class="vc100 right" value="<?php echo 0; ?>" ></td>
	<td><input type="" id="due_on-1" class="vc100" value="<?php echo $today; ?>" ></td>	
	<td><input type="submit" id="btnAdd-1" value="Add" onclick="putPayable(dbpayables,1);return false;" /></td>
	<td></td>
	<td></td>
</tr>
<!-- total -->
<tr>
	<th colspan=2>Total payables</th>
	<th class="right" ><?php echo number_format($total_payables,2); ?></th>
	<th colspan=4></th>
</tr>
</table><br />
</div>


<!--------------- payments ------------------------------------------->
<div class="half" >
<h5>Payments</h5>
<table class="gis-table-bordered"  >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Feetype</th>
	<th>Amount</th>
	<th>Paytype</th>
	<th>Reference</th>
	<th>Edit</th>
	<th>Delete</th>

</tr>
<?php $i=1; ?>
<?php $total_payments=0; ?>
<?php foreach($payments AS $row): ?>
<?php $total_payments+=$row['amount']; ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['date']; ?></td>
	<td class="vc200" ><?php echo $row['feetype']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['paytype']; ?></td>
	<td><?php echo $row['reference']; ?>
		<input type="hidden" id="pkid-<?php echo $i; ?>-2" class="pdl05" value="<?php echo $row['pkid']; ?>" />	
		<input type="hidden" id="amount-<?php echo $i; ?>-2" value="<?php echo $row['amount']; ?>" />	
		<input type="hidden" id="feetype-<?php echo $i; ?>-2" value="<?php echo $row['feetype']; ?>" />	
	</td>
	<td><a href="<?php echo URL.'payments/edit/'.$row['payment_id'].DS.$sy; ?>" >Edit</a></td>
	
	<td><input type="submit" value="Del" onclick="xdelete(dbpayments,<?php echo $i; ?>,2);return false;" /></td>	
	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
<tr class="shd addPayment" >
	<td></td>
	<td><input id="date-2" class="vc100" value="<?php echo $today; ?>" ></td>
	<td class="vc200" >
		<select class="vc200" id="feetype_id-2" onchange="axnFeetype(this.value,2)"  >
			<option value=0>Select One</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	
	<td><input class="right" id="amount-2" class="vc100" value="<?php echo 0; ?>" ></td>
	<td><select id="paytype_id-2" >
		<?php foreach($paytypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select></td>
	<td><input id="reference-2" class="vc200"  ></td>	
	<td><input type="submit" id="btnAdd-2" value="Add" onclick="putPayment(dbpayments,2);return false;" /></td>
	<td></td>
</tr>
<!-- total -->
<tr>
	<th colspan=3>Total payments</th>
	<th class="right" ><?php echo number_format($total_payments,2); ?></th>
	<th colspan=4></th>
</tr>

</table><br />
</div>


<?php endif; ?>	<!-- scid -->
</div>	<!-- divleft -->

<div class="shd" id="names" >names</div>




<script>

var gurl="http://<?php echo GURL; ?>";
var limit=20;
var sy="<?php echo $sy; ?>";
var ecid="<?php echo $ucid; ?>";
var dbcontacts="<?php echo $dbcontacts; ?>";
var dbfeetypes="<?php echo $dbfeetypes; ?>";
var dbpayables="<?php echo $dbpayables; ?>";
var dbpayments="<?php echo $dbpayments; ?>";
var tuition_amount="<?php echo $tuition_amount; ?>";

$(function(){
	// shd();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	selectFocused();
	enterStudcode(dbcontacts);
	
	
	
})	/* fxn */


function discountPromiseTwo(amount,percent,is_percent){
	amount=parseFloat(amount);
	percent=parseFloat(percent);
	is_percent=parseInt(is_percent);
	var discamt;
	if(is_percent==1){ discamt=percent*tuition_amount/100; } 
	else { discamt=amount; }
	$('#amount-1').val(discamt);
	
}	/* fxn */

function discountPromiseOne(feetype_id){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetRowById";
	var pdata='task='+task+'&id='+feetype_id+'&dbtable='+dbfeetypes+'&sy='+sy;
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) { 
			discountPromiseTwo(s.amount,s.percent,s.is_percent); 
		}		  

    });				

	
}	/* fxn */





function enterStudcode(dbtable){
    $('#part').bind("keydown",function(e) {
        if (e.which == 13) {
            e.preventDefault();
			var part=$('#part').val();
			var vurl = gurl+'/ajax/axdata.php';	
			var task = "xgetIdByCode";
			var pdata='task='+task+'&part='+part+'&dbtable='+dbtable;
			$.ajax({
				url:vurl,dataType:"json",type:"POST",
				data:pdata,async:true,
				success: function(s) {  
					var scid=s.id;
					var url=gurl+"/enrollment/ledger/"+scid+"/"+sy;
					window.location=url;
				}		  
			});												
        }
    });
	
}	/* fxn */

function pasteAmount(i,num){
	// alert(i+", "+num);
	var amount=$('#amount-'+i+'-'+num).val();
	var feetype=$('#feetype-'+i+'-'+num).val();
	var feetype_id=$('#feetype_id-'+i+'-'+num).val();
	// alert(amount+", type_id: "+feetype_id+", feetype: "+feetype);
	$('#part-2').val(feetype);
	$('#feetype_id-2').val(feetype_id);
	$('#amount-2').val(amount);
	
	
}	/* fxn */


function xdelete(dbtable,i,num){
	var id=$('#pkid-'+i+'-'+num).val();
	var tableName=(num==1)? 'Payable':'Payment';

	if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var amount=$('#amount-'+i+'-'+num).val();
		var feetype=$('#feetype'+i+'-'+num).val();
		var logdetails = tableName+" of P"+amount+" "+feetype+" deleted for "+studname;		
		var pdata='task='+task+'&id='+id+'&dbtable='+dbtable+'&logdetails='+logdetails+'&logsy='+sy;
		
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	}
	
	
}	/* fxn */


function axnFeetype(id,num){
	$("#feetype_id-"+num).val(id);
	if(num==1){ discountPromiseOne(id); }
	
}	/* fxn */



function axnFilter(id){
	var rurl=gurl+'/enrollment/ledger/'+id+'/'+sy;		
	window.location=rurl;		
}	/* fxn */





function putPayment(dbtable,num){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xsaveData";
	var feetype_id=$('#feetype_id-'+num).val();
	var paytype_id=$('#paytype_id-'+num).val();
	var amount=$('#amount-'+num).val();
	amount=amount.replace(",", "");	
	var date=$('#date-'+num).val();
	var reference=$('#reference-'+num).val();
	var logdetails="Ledger Payment P"+amount+" for "+studname;
	var pdata="task="+task+"&dbtable="+dbtable+"&logdetails="+logdetails+"&logsy="+sy;
	pdata+="&sy="+sy+"&scid="+scid+"&feetype_id="+feetype_id+"&amount="+amount;
	pdata+="&date="+date+"&ecid="+ecid+"&reference="+reference;
	$('#btnAdd-'+num).hide();
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function() {  location.reload(); }		  

    });				
	
}	/* fxn */


function putPayable(dbtable,num){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xsaveData";
	var feetype_id=$('#feetype_id-'+num).val();
	var amount=$('#amount-'+num).val();
	amount=amount.replace(",", "");	
	var due_on=$('#due_on-'+num).val();
	var logdetails="Ledger Payable P"+amount+" for scid:"+scid;
	var pdata="task="+task+"&dbtable="+dbtable+"&logdetails="+logdetails+"&logsy="+sy;
	pdata+="&sy="+sy+"&scid="+scid+"&feetype_id="+feetype_id+"&amount="+amount;
	pdata+="&due_on="+due_on;
	$('#btnAdd-'+num).hide();
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function() {  location.reload(); }		  
    });				
	
}	/* fxn */



function filterFeetypes(dbtable,num){
	var part=$("#part-"+num).val();
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetData";	
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",async:true,
		data: "task="+task+"&part="+part+"&limit="+limit+"&dbtable="+dbtable,
		success: function(s) { 
			var cs=s.length;
			content='';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span class="txt-blue b u" onclick="axnFeetype('+s[i].id+','+num+');return false;" >'+s[i].name+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}	
	})


}	/* fxn */






</script>


<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
