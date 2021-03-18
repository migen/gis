<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbpayments="{$dbo}.30_payments";
	$colspan=9;

?>
<h3>
	Student Bills | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>


</h3>

<?php if($srid!=RSTUD): ?>
	<p><table id="tbl-1" class="gis-table-bordered " >
		<tr>
			<th>ID</th>
			<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,20);return false;' />		
		</td></tr>
	</table></p>
<div id="names" >names</div>
<?php endif; ?>	<!-- not student -->








<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
	<tr>
		<th>ID No.</th><td><?php echo $student['studcode']; ?></td>
		<th>Student</th><td><?php echo $student['studname']; ?></td>
		<input type="hidden" id="studname" value="<?php echo $student['studname']; ?>" />			
	</tr>
</table><br />


<table class="gis-table-bordered" >
<tr>
	<th class="vc100" >Date</th>
	<th class="vc150" >Feetype</th>
	<th class="vc150 right" >Amount</th>
	<th class="vc150" >Paytype</th>
	<th class="vc100" >OR No</th>
	<th class="vc100" >Reference</th>
	<th class="" ></th>
	<th class="" ></th>
	<th class="" ></th>
</tr>
<tr>
	<td>
		<input type="date" name="post[date]" value="<?php echo $_SESSION['today']; ?>" />
		<input type="hidden" name="post[sy]" value="<?php echo $sy; ?>" />	
		<input type="hidden" name="post[scid]" value="<?php echo $scid; ?>" />	
		<input type="hidden" name="post[ecid]" value="<?php echo $_SESSION['ucid']; ?>" />	
		<input type="hidden" name="post[in_tuition]" value="<?php echo 0; ?>" />	
	</td>
	<td >
		<select class="vc200" name="post[feetype_id]" >
			<option value=0>Select One</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td class="right" ><input class="right vc100" type="text" name="post[amount]" value="<?php echo '0.00'; ?>" /></td>	
	<td>
		<select class="vc100" name="post[paytype_id]" >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td><input type="text" name="post[orno]" value="<?php echo $nextOrno; ?>" /></td>	
	<td><input type="text" name="post[reference]" value="" /></td>	
	<td><input type="submit" name="submit" value="Pay" /></td>		
	<td></td>
	<td></td>
</tr>
<tr>
	<th colspan="<?php echo $colspan; ?>" >History</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td><?php echo str_pad($rows[$i]['orno'],5,'0',STR_PAD_LEFT); ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
	<td><a href="<?php echo URL.'payments/edit/'.$rows[$i]['pkid']; ?>" >Edit</a></td>
	<td><a href="<?php echo URL.'ornos/view/'.$rows[$i]['orno']; ?>" >Print OR</a></td>
	<td><input type="submit" value="Delete" onclick="xdelete(dbpayments,<?php echo $i; ?>);return false;" />
		<input type="hidden" id="pkid-<?php echo $i; ?>" class="pdl05" value="<?php echo $rows[$i]['pkid']; ?>" />	
		<input type="hidden" id="feetype-<?php echo $i; ?>" value="<?php echo $rows[$i]['feetype']; ?>" />	
		<input type="hidden" id="amount-<?php echo $i; ?>" value="<?php echo $rows[$i]['amount']; ?>" />		
	</td>
	
</tr>
<?php endfor; ?>
</table>
</form>
<?php endif; ?>		<!-- scid -->










<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbpayments = "<?php echo $dbpayments; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	// alert(dbpayments);
})




function axnFilter(id){
	var url=gurl+"/students/bills/"+id+"/"+sy;
	window.location=url;
}





function xdelete(dbpayments,i){
	var id=$('#pkid-'+i).val();
	var tableName='Payments';

	if (confirm('DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var amount=$('#amount-'+i).val();
		var feetype=$('#feetype-'+i).val();		
		var studname=$('#studname').val();		
		var logdetails="Bill Payment of P"+amount+" "+feetype+" deleted for "+studname;		
		var pdata='task='+task+'&id='+id+'&dbtable='+dbpayments+'&logdetails='+logdetails+'&logsy='+sy;
		// alert(pdata);
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	}
	
}	/* fxn */




</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

