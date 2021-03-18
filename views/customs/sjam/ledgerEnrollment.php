<style>

div.half{border:1px solid fff; margin-right:10px; width:auto; }

</style>

<?php if($scid): 
$sch=VCFOLDER;
$studname=$student['studname']; 
$tfee_total=$student['total']; 
$paymode=$student['paymode']; 
$escamount=$student['escamount']; 
$has_esc=($escamount>0)? 1:0;

// pr("esc amount: ".$escamount);
// pr($student);
$incfile=SITE."views/customs/{$sch}/incs/enrollment_{$sch}.php";
if(is_readable($incfile)){ include_once($incfile); $getAssessment="getAssessmentSjam"; } else { $getAssessment="getAssessment"; }



$assarr=$getAssessment($student,$paymode);
$tfee_duedates_arr=explode(",",$assarr['duedates']);


?>

<script>
	var scid="<?php echo $scid; ?>";
	var studname="<?php echo $studname; ?>";
</script>
<?php endif; ?>


<?php 

// pr($_SESSION['q']);



$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";
$dbfeetypes="{$dbo}.03_feetypes";
$dbpayables="{$dbo}.30_payables";
$dbpayments="{$dbo}.30_payments";


// pr($student);


?>


<h3>
	SJAM Ledger <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tuitions/level/$lvl/$sy"; ?>' >Tuition</a>
	| <a href='<?php echo URL."students?scid=$scid"; ?>' >Student</a>
	| <a href='<?php echo URL."students/paymode/$scid/$sy"; ?>' >Paymode</a>
	| <a href='<?php echo URL."esc/scid/$scid/$sy"; ?>' >ESC</a>

</h3>

<p>
<table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick="xgetDataByTable(dbcontacts);return false;" />		
		</td>
	</tr>	



</table></p>


<?php if($scid): ?>	


<table class="gis-table-bordered" >
	<tr><th>ID No.</th><td><?php echo $student['studcode']; ?></td>
		<th>Classroom</th><td><?php echo $student['classroom'].' #'.$student['crid']; ?></td>	
		<th>Paymode</th><td><?php $paymode=$student['paymode']; echo $paymode; ?></td>	
	</tr>
	<tr><th>Student</th><td><?php echo $student['studname']; ?></td>
		<th>Amount</th><th class="right" ><?php echo number_format($tfee_total,2); ?></th>
		<th>ESC</th><td><?php echo ($has_esc)? number_format($escamount,2):0; ?></td>		
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
</tr>
<?php $total_payables=0; ?>
<?php for($i=0;$i<$assarr['count'];$i++): ?>
<?php $total_payables+=$assarr['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo 'Tuition Fee - '.getOrdinalEnrollment($i+1).' Payment'; ?></td>
	<td class="right" ><?php echo number_format($assarr['amount'],2); ?></td>
	<td><?php echo $tfee_duedates_arr[$i]; ?></td>
	<td></td>
	<td></td>
</tr>
<?php endfor; ?>



<!-- esc -->
<?php if($has_esc): ?>
<?php 
	$escamount=$escamount*-1;
	$total_payables+=$escamount;
?>
<tr>
	<td><?php echo $assarr['count']; ?></td>
	<td><?php echo "ESC discount"; ?></td>
	<td class="right" ><?php echo number_format($escamount,2); ?></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php endif; ?>

<!-- -->
<?php 
	$esc_increment=($has_esc)? 2:1; 
	$i=$assarr['count']+$esc_increment; 
?>
<?php foreach($payables AS $row): ?>
<?php 
	$row['amount']=($row['is_discount'])? $row['amount']*-1:$row['amount']; 
	$total_payables+=$row['amount'];
?>

<tr>
	<td><?php echo $i; ?></td>
	<td class="vc200" ><?php echo $row['feetype']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['due_on']; ?>
		<input type="hidden" id="amount-<?php echo $i; ?>-1" value="<?php echo $row['amount']; ?>" />	
		<input type="hidden" id="pkid-<?php echo $i; ?>-1" class="pdl05" value="<?php echo $row['pkid']; ?>"  />		
		<input type="hidden" id="feetype-<?php echo $i; ?>-1" value="<?php echo $row['feetype']; ?>" />	
	<td><a href="<?php echo URL.'payables/edit/'.$row['payable_id'].DS.$sy; ?>" >Edit</a></td>
	<td><input type="submit" value="Del" onclick="xdelete(dbpayables,<?php echo $i; ?>,1);return false;" /></td>		
</tr>
<?php $i++; ?>
<?php endforeach; ?>
<tr class="shd addPayment" >
	<td></td>
	<td class="vc200" >
		<input class="pdl05" id="part-1" autofocus  />
		<input type="submit" name="auto" value="Filter" onclick="ajaxFilter(dbfeetypes,1);return false;" />		
		<input id="feetype_id-1" class="vc50" />		
		
	</td>
	<td><input id="amount-1" class="vc100" value="<?php echo 0; ?>" ></td>
	<td><input type="" id="due_on-1" class="vc100" value="<?php echo $today; ?>" ></td>	
	<td><input type="submit" id="btnAdd-1" value="Add" onclick="xputPayable(dbpayables,1);return false;" /></td>
	<td></td>
</tr>
<!-- total -->
<tr>
	<th colspan=2></th>
	<th class="right" ><?php echo number_format($total_payables,2); ?></th>
	<th colspan=3></th>
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
		<input class="pdl05" id="part-2" autofocus  />
		<input type="submit" name="auto" value="Filter" onclick="ajaxFilter(dbfeetypes,2);return false;" />		
		<input id="feetype_id-2" class="vc50" />				
	</td>
	<td><input id="amount-2" class="vc100" value="<?php echo 0; ?>" ></td>
	<td><select id="paytype_id-2" >
		<?php foreach($paytypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select></td>
	<td><input id="reference-2" class="vc200"  ></td>	
	<td><input type="submit" id="btnAdd-2" value="Add" onclick="xputPayment(dbpayments,2);return false;" /></td>
	<td></td>
</tr>
<!-- total -->
<tr>
	<th colspan=3></th>
	<th class="right" ><?php echo number_format($total_payments,2); ?></th>
	<th colspan=4></th>
</tr>

</table><br />
</div>
<?php endif; ?>	<!-- scid -->


<div class="clear" id="names" ></div>

<div class="ht100" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limit=20;
var sy="<?php echo $sy; ?>";
var ecid="<?php echo $ucid; ?>";
var dbcontacts="<?php echo $dbcontacts; ?>";
var dbfeetypes="<?php echo $dbfeetypes; ?>";
var dbpayables="<?php echo $dbpayables; ?>";
var dbpayments="<?php echo $dbpayments; ?>";

$(function(){
	selectFocused();
	enterStudcode(dbcontacts);

})

function enterStudcode(dbtable){
    $('#part').bind("keydown",function(e) {
        if (e.which == 13) {
            e.preventDefault();
			var part=$('#part').val();
			var vurl = gurl+'/ajax/xdata.php';	
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


function axnFilter(id,num){
	$("#feetype_id-"+num).val(id);
}	/* fxn */


function redirPage(id){
	var rurl=gurl+'/enrollment/ledger/'+id+'/'+sy;		
	window.location=rurl;		

}	/* fxn */


function xputPayment(dbtable,num){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xsaveData";
	var feetype_id=$('#feetype_id-'+num).val();
	var paytype_id=$('#paytype_id-'+num).val();
	var amount=$('#amount-'+num).val();
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


function xputPayable(dbtable,num){
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xsaveData";
	var feetype_id=$('#feetype_id-'+num).val();
	var amount=$('#amount-'+num).val();
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



function ajaxFilter(dbtable,num){
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
	content+='<p><span class="txt-blue b u" onclick="axnFilter('+s[i].id+','+num+');return false;" >'+s[i].name+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}	
	})


}	/* fxn */



function xgetDataByTable(dbtable){
	var part = $('#part').val();		
	var vurl = gurl+'/ajax/xdata.php';	
	var task="xgetData";		
	var pdata="task="+task+"&part="+part+"&limit="+limit+"&dbtable="+dbtable;
	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",async:true,
		data: pdata,
		success: function(s) { 
			var cs=s.length;
			content='';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span class="txt-blue b u" onclick="redirPage('+s[i].id+');return false;" >'+s[i].name+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}	
	})
	

	
}	/* fxn */





</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
