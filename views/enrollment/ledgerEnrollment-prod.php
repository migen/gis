<!-- 
20200621-3

-->

<style>

div.half{border:1px solid fff; margin-right:10px; width:auto; }
div.left{border:1px solid fff; margin-right:10px; width:auto; width:75%; }


</style>

<?php 

// pr($_SESSION['q']);

/* 	
	// edit-delete-policy-test
	$dbo=PDBO;
	$ucid=$user['ucid'];
	$q="SELECT id,code,name,role_id,privilege_id FROM {$dbo}.00_contacts WHERE id=$ucid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$user=$sth->fetch();
 */
 
 
extract($user);
$is_admin=(($role_id==RMIS) || ($role_id==RAXIS && $privilege_id==0))? true:false;




?>

<?php if($scid): 
	$sch=VCFOLDER;
	extract($student);
	
	// $studname=$student['studname']; 
	$tfee_total=$total; 
	$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
	if(is_readable($incfile)){ include_once($incfile); $getAssessment="getAssessmentSjam"; } else { $getAssessment="getAssessment"; }

	/* process */
	$payarr=parsePayables($payables);	
	extract($payarr);	
	$student['total_discount']=$total_discount=$payarr['total_discount'];
	$student['total_nondiscount']=$total_nondiscount=$payarr['total_nondiscount'];
	$student['total_adjustment']=$total_adjustment=$total_nondiscount-$total_discount;

	/* process */
	$arp=adjustPayablesSjam($student);
	$adjusted_periodic=$arp['adjusted_periodic'];
	$initial_periodic=$arp['initial_periodic'];
	$student['resfee_paid']=$resfee_paid=getResfee($payments);
	$has_resfee=($resfee_paid>0)? true:false;	
	// $data['tfee_duedates_arr']=explode(",",$tfee_duedates);

	/* process */
	$paymentsarr=parsePayments($payments);	
	$data['total_payment']=$student['total_payment']=$paymentsarr['total_payment'];

	/* process */
	$paymentsarr=parsePayments($payments);
	extract($paymentsarr);
	
	$total_payable=($adjusted_periodic*$duedates_count)+$previous_balance+$total_nondiscount;
	
	$total_payment=$paymentsarr['total_payment'];
	$total_balance=($total_payable-$total_payment);
	$balance_cutoff=$_SESSION['settings']['balance_cutoff'];	
	$has_previous_balance=($previous_balance>$balance_cutoff)? true:false;
	$has_other_payables=($total_nondiscount>0)? true:false;

	
	/* process */
	$data['nextOrno']=getOrnoNext($db);	// callback

	/* process */
	$data['resfee_paid']=$student['resfee_paid']=getResfee($payments);	// callback

	$data['has_previous_balance']=($student['previous_balance']>0)? true:false;
	
	extract($data);
	
	
	

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
	$arp=array();
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
	GIS Ledger Dropdown	
	<select onchange="jsredirect(`enrollment/ledger/${scid}/${this.value}`)" >
		<option value="<?php echo DBYR; ?>" 
			<?php echo ($sy==(DBYR))? 'selected':NULL; ?>
		><?php echo DBYR; ?></option>
		<?php if($_SESSION['settings']['sy_enrollment']>DBYR): ?>
			<option value="<?php echo (DBYR+1); ?>" 
				<?php echo ($sy==(DBYR+1))? 'selected':NULL; ?>
			><?php echo (DBYR+1); ?></option>
		
		<?php endif; ?>
	</select>
	
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."students/tuitions/$scid/$sy"; ?>' >Tuition</a>
	| <a href='<?php echo URL."students?scid=$scid"; ?>' >Student</a>
	| <a href='<?php echo URL."students/paymode/$scid/$sy"; ?>' >Paymode</a>
	<?php if($scid): ?>
		| <a href='<?php echo URL."students/balances/$scid/$sy?feetype_id=3"; ?>' >Balances</a>	
	<?php else: ?>
		| <a href='<?php echo URL."students/balances?feetype_id=3"; ?>' >Balances</a>	
	<?php endif; ?>
	| <a href='<?php echo URL."students/assessment/$scid/$sy"; ?>' >Assessment</a>
	| <a href='<?php echo URL."students/bills/$scid"; ?>' >Bills</a>
	| <a href='<?php echo URL."students/payments/$scid"; ?>' >Payments</a>
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
	</tr>
	<tr><th>Student</th><td><?php echo $student['studname']; ?></td>
		<th>Paymode</th><td><?php $paymode=$student['paymode']; echo ucfirst($paymode); ?></td>	
	</tr>
		

</table><br />


<!--------------- payables a) tuition b) payables ------------------------------------------->
<div class="half" >
<h5>Payables</h5>
<table class="gis-table-bordered table-altrow table-fx"  >
<tr>
	<th>#</th>
	<th>Feetype</th>
	<th>Ptr</th>
	<th>Amount</th>
	<th>Paid</th>
	<th>Balance</th>
	<th>Due On</th>
	<th class="" ></th>
	<th class="vc80" ></th>
	<th></th>
</tr>
<?php $total_payables=$total-$total_discount; ?>
<?php for($i=0;$i<$duedates_count;$i++): ?>
<?php // $total_payables+=$arp['adjusted_periodic']; ?>
<?php $row_amount=$arp['adjusted_periodic']; ?>
<?php $ptr=$i+1; ?>
<?php if($i==0){ $row_amount-=$resfee_paid; } ?>
<?php 
	$payable=array(
		'amount'=>$row_amount,
		'ptr'=>$ptr,
		'feetype_id'=>1,
	);	
	/* payableBalanceRow */	
	$pbr=updatePayableBalance($db,$payable,$payments); 
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo 'Tuition Fee - '.getOrdinalEnrollment($i+1).' Payment'; ?></td>
	<td><?php echo $ptr; ?></td>
	<td class="right" ><?php echo number_format($row_amount,2); ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo $pbr['balance']; ?>" >
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="Tuition Fee" >
		<input type="hidden" id="feetype_id-<?php echo $i; ?>-1" value="1" >
		<input type="hidden" id="ptr-<?php echo $i; ?>-1" value="<?php echo $ptr; ?>" />	
	</td>
	<td class="right" ><?php echo number_format($pbr['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($pbr['balance'],2); ?></td>
	<td><?php echo $tfee_duedates_arr[$i]; ?></td>
	<td></td>
	<td></td>
	<td><button onclick="pasteAmount(<?php echo $i; ?>,1);" >Copy</button></td>
	
</tr>
<?php endfor; ?>	<!-- duedates_count -->




<!-- -->
<?php 
	$i=$duedates_count+1; 
	
?>
<?php foreach($payables AS $row): ?>
<?php 	
	/* previous_balance */
	if($row['feetype_id']==3){	
		continue;	
	} else {
		$total_payables+=($row['is_discount']!=1)? $row['amount']:0;		
		
	}  
	$payable=$row;
	/* payableBalanceRow */	
	$pbr=updatePayableBalance($db,$payable,$payments); 	
	
	
?>

<?php 
	$row_is_discounted=($row['is_discount']==1)? true:false;
	$row['amount']=($row['is_discount'])? $row['amount']*-1:$row['amount']; 
?>


<tr>
	<td><?php echo $i; ?></td>
	<td class="vc200" ><?php echo $row['feetype']; ?></td>
	<td class="vc20" ><?php echo $row['ptr']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td class="right" ><?php echo number_format($pbr['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($pbr['balance'],2); ?></td>	
	<td><?php echo $row['due_on']; ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo number_format($pbr['balance'],2); ?>" />	
		<input type="hidden" id="pkid-<?php echo $i; ?>-1" class="pdl05" value="<?php echo $row['pkid']; ?>"  />		
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="<?php echo $row['feetype']; ?>" />	
		<input type="hidden" id="feetype_id-<?php echo $i; ?>-1" value="<?php echo $row['feetype_id']; ?>" />	
		<input type="hidden" id="ptr-<?php echo $i; ?>-1" value="<?php echo $row['ptr']; ?>" />	
	<td>
		<a href="<?php echo URL.'payables/edit/'.$row['payable_id'].DS.$sy; ?>" >Edit</a>
	</td>
	<td>
		<?php if($is_admin): ?>	
			<input type="submit" value="Del" onclick="xdelete(dbpayables,<?php echo $i; ?>,1);return false;" />		
		<?php endif; ?>					
	</td>					
	<td>
		<?php if(!$row_is_discounted): ?>
			<button onclick="pasteAmount(<?php echo $i; ?>,1);" >Copy</button>
		<?php endif; ?>	
	</td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>	<!-- payables -->

<?php if($has_previous_balance): ?>
<?php 
	$j=$i+1;
	
	$payable=array(
		'amount'=>$student['previous_balance'],
		'ptr'=>1,
		'feetype_id'=>3,
	);	
	$pbr=updatePayableBalance($db,$payable,$payments); 	

?>		


	<tr>
		<td><?php echo $j; ?></td>
		<td><?php echo 'PREVIOUS BALANCE'; ?></td>
		<td>1</td>
		<td class="right" ><?php echo number_format($student['previous_balance'],2); ?></td>
		<td class="right" ><?php echo number_format($pbr['paid'],2); ?></td>
		<td class="right" ><?php echo number_format($pbr['balance'],2); ?></td>
		<td><?php echo ($pbr['balance']>0)? 'Immediately':NULL; ?></td>
		<td><a href="<?php echo URL.'students/balances/'.$row['scid']; ?>" >Balances</a></td>		
		<td>
			<input type="hidden" id="amount-<?php echo $j; ?>-1" value="<?php echo number_format($pbr['balance'],2); ?>" />	
			<input type="hidden" id="feetype_id-<?php echo $j; ?>-1" value="<?php echo $payable['feetype_id']; ?>" />	
			<input type="hidden" id="ptr-<?php echo $j; ?>-1" value="<?php echo $payable['ptr']; ?>" />			
		</td>
		<td>
			<button onclick="pasteAmount(<?php echo $j; ?>,1);" >Copy</button>
		</td>		
	</tr>
<?php endif; ?>	<!-- has_prevbal -->

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
	<td><input class="vc50" id="ptr-1" value="<?php echo 1; ?>" ></td>	
	<td><input class="vc100 right" id="amount-1" value="<?php echo 0; ?>" ></td>
	<td></td>
	<td></td>	
	<td><input class="vc100" id="due_on-1" value="<?php echo $today; ?>" ></td>	
	<td><input type="submit" id="btnAdd-1" value="Add" onclick="putPayable(dbpayables,1);return false;" /></td>
	<td></td>
	<td></td>
</tr>
<!-- total -->
<tr>
	<th colspan=3>Total Payables</th>
	<th class="right" ><?php echo number_format($total_payable,2); ?></th>
	<th colspan=7></th>
</tr>
<tr>
	<th colspan=3>Total Payments</th>
	<th class="right" ><?php echo number_format($total_payment,2); ?></th>
	<th colspan=7></th>
</tr>
<?php 
	$total_balance=$total_payable-$total_payment;
?>
<tr>
	<th colspan=3>Total Balance</th>
	<th class="right" ><?php echo number_format($total_balance,2); ?></th>
	<th colspan=7></th>
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
	<th class="" >Ptr</th>
	<th>Amount</th>
	<th>Paytype</th>
	<th>Orno</th>
	<th>Reference / Notes</th>
	<th>View</th>
	<th class="vc80" ></th>
	<th class="vc80" ></th>

</tr>
<?php $i=1; ?>
<?php $total_payments=0; ?>
<?php foreach($payments AS $row): ?>
<?php $total_payments+=$row['amount']; ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['date']; ?></td>
	<td class="vc200" ><?php echo $row['feetype']; ?></td>
	<td class="" ><?php echo $row['ptr']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['paytype']; ?></td>
	<td><?php echo $row['orno']; ?></td>
	<td class="vc200" >
		<?php echo $row['reference']; ?>
		<?php echo isset($row['notes'])? ' / '.$row['notes']:NULL; ?>	
		<input type="hidden" id="pkid-<?php echo $i; ?>-2" class="pdl05" value="<?php echo $row['pkid']; ?>" />	
		<input type="hidden" id="amount-<?php echo $i; ?>-2" value="<?php echo $row['amount']; ?>" />	
	</td>
	<td><a href="<?php echo URL.'ornos/view/'.$row['orno'].DS.$sy; ?>" >O R </a></td>

	
	
	<td>
		<?php if($is_admin): ?>
			<a href="<?php echo URL.'payments/edit/'.$row['payment_id'].DS.$sy; ?>" >Edit</a>
		<?php endif; ?>			
	</td>
	
	<td>
		<?php if($is_admin): ?>	
			<input type="submit" value="Del" onclick="xdelete(dbpayments,<?php echo $i; ?>,2);return false;" />
		<?php endif; ?>					
	</td>	
	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
<tr class="shd addPayment" >
	<td></td>
	<td><input class="vc100" id="date-2" value="<?php echo $today; ?>" ></td>
	<td class="vc200" >
		<select class="vc200" id="feetype_id-2" onchange="axnFeetype(this.value,2)"  >
			<option value=0>Select One</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	
	<td><input class="vc50" id="ptr-2" value="<?php echo 1; ?>" ></td>
	<td><input class="right vc100" id="amount-2" value="<?php echo 0; ?>" onchange="copyToReceived();return false;" ></td>
	<td><select id="paytype_id-2" >
		<?php foreach($paytypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select></td>
	<td><input class="vc100" id="orno-2" value="<?php echo $nextOrno; ?>" >	</td>	
	<td><input class="vc200" id="reference-2" ></td>	
	<td colspan=3 >
		<span class="b" >Notes:</span> 
		<textarea cols=20 rows=2 id="notes-2" ></textarea>	
	</td>
</tr>
<!-- total -->
<tr>
	<th colspan=4>Total payments</th>
	<th class="right" ><?php echo number_format($total_payments,2); ?></th>
	<th colspan=6>
		Received <input id="received-2" onchange="getChange();return false;"  >
		Change <input id="change-2"  >
		<input type="submit" id="btnAdd-2" value="Pay" onclick="putPayment(dbpayments,2);return false;" />
	
	</th>
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

function copyToReceived(){
	var amt = $('#amount-2').val();
	$('#received-2').val(amt);
	
}	/* fxn */

function getChange(){
	var received=$('#received-2').val();
	var amount=$('#amount-2').val();
	received=received.replace(",", "");		
	amount=amount.replace(",", "");			
	received=parseFloat(received).toFixed(2);
	amount=parseFloat(amount).toFixed(2);
	var change = received - amount;
	$('#change-2').val(change.toFixed(2));
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
	var amount=$('#amount-'+i+'-'+num).val();
	amount=amount.replace(",", "");		
	amount=parseFloat(amount).toFixed(2);
	var feetype=$('#feetype-'+i+'-'+num).val();
	var feetype_id=$('#feetype_id-'+i+'-'+num).val();
	var ptr=$('#ptr-'+i+'-'+num).val();
	$('#feetype_id-2').val(feetype_id);
	$('#ptr-2').val(ptr);
	$('#amount-2').val(amount);
	$('#received-2').val(amount);
		
}	/* fxn */


function xdelete(dbtable,i,num){
	var id=$('#pkid-'+i+'-'+num).val();
	var tableName=(num==1)? 'Payable':'Payment';

	if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var amount=$('#amount-'+i+'-'+num).val();
		var feetype=$('#feetype-'+i+'-'+num).val();		
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
	var received=$('#received-'+num).val();
	received=received.replace(",", "");	
	var change=$('#change-'+num).val();
	change=change.replace(",", "");		
	
	var date=$('#date-'+num).val();
	var ptr=$('#ptr-'+num).val();
	var orno=$('#orno-'+num).val();
	var reference=$('#reference-'+num).val();	
	var notes=$('#notes-'+num).val();	
	var logdetails="Ledger Payment P"+amount+" for "+studname;
	var pdata="task="+task+"&dbtable="+dbtable+"&logdetails="+logdetails+"&logsy="+sy;
	pdata+="&sy="+sy+"&scid="+scid+"&feetype_id="+feetype_id+"&paytype_id="+paytype_id+"&amount="+amount+"&date="+date+"&ecid="+ecid;
	pdata+="&reference="+reference+"&notes="+notes+"&orno="+orno+"&ptr="+ptr+"&received="+received+"&change="+change;
	$('#btnAdd-'+num).hide();
	
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function() {  
			updateUserOrno(orno);		
			location.reload(); 
		}		  
    });				
	
}	/* fxn */


function updateUserOrno(orno){
	var vurl = gurl+'/ajax/xorno.php';	
	var task="updateUserOrno";
	var pdata='task='+task+'&orno='+orno;	
	$.ajax({
		url:vurl,type:"POST",
		data:pdata,async:true,
		success: function() {  }		  		
    });					
}	/* fxn */



function putPayable(dbtable,num){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xsaveData";
	var feetype_id=$('#feetype_id-'+num).val();
	var ptr=$('#ptr-'+num).val();
	var amount=$('#amount-'+num).val();
	amount=amount.replace(",", "");	
	var due_on=$('#due_on-'+num).val();
	var logdetails="Ledger Payable P"+amount+" for scid:"+scid;
	var pdata="task="+task+"&dbtable="+dbtable+"&logdetails="+logdetails+"&logsy="+sy;
	pdata+="&sy="+sy+"&scid="+scid+"&feetype_id="+feetype_id+"&amount="+amount;
	pdata+="&due_on="+due_on+"&ptr="+ptr;
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
