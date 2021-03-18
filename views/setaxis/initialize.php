<?php 


// pr($_SESSION['q']);
// pr($classrooms);

// pr($rows[0]);

?>

<h5>
	Fees Setup (<?php echo (isset($count))? $count:0; ?>)
	<span class="hd">HD</span>
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'ledgers/soa?crid='.$crid; ?>">SOA</a> 
	| <a href="<?php echo URL.'ledgers/lsDeleteCridAux/'.$crid; ?>">DEL-Aux</a> 
	| <a href="<?php echo URL.'ledgers/lsDeleteCridPayments/'.$crid; ?>">DEL-Pymts</a> 
	| <span class="u" onclick="ilabas('clipboard')" >Smartboard</span>

</h5>

<h4 class="brown" >IMPT* Lock settings ledger setup when done.</h4>


<p><?php $this->shovel('hdpdiv'); ?></p>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."setaxis/initialize/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>




<div class="clear" >&nbsp;</div>
<!----------------------------------------------------------------------------------------------->
<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Scid</th>
	<th>Classroom</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Mode<br />
		<input class="pdl05 vc30" type="number" min=1 max=4 id="imode" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('mode');" >						
	</th>
	<th class="right" >Total<br />Paid</th>
	<th>Payfee (B)<br />
		<select id="ipayfee" class='vc100'>	
			<option>Select</option>
			<?php foreach($feetypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('payfee');" >	
	</th>	
	<th class="right" >Paydate (B)<br />
		<input class="pdl05 vc80" id="idt" /><br />	
		<input type="button" value="All" onclick="populateColumn('dt');" >						
	</th>
	<th class="right" >Pymt (B)</th>
	<th class="right" >Orno (B)</th>
	<th class="right" >Details (B)</th>
	<th>Aux (A|D)<br />
		<select id="iaddon" class='vc100'>	
			<option>Select</option>
			<?php foreach($feetypes as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('addon');" >	
	</th>
	<th class="right" >Num<br />
		<input class="pdl05 vc50" id="inum" /><br />	
		<input type="button" value="All" onclick="populateColumn('num');" >						
	</th>		
	<th class="right" >Amount (A)<br />
		<input class="pdl05 vc50" id="iamount" /><br />	
		<input type="button" value="All" onclick="populateColumn('amount');" >						
	</th>
	<th class="right" >Total Bal</th>
	<th>Remarks</th>
	<th>Tsum<br />crid</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow<?php echo $i; ?>"  >
	<td><?php echo $i+1; ?></td>
	<td><input type="" class="vc50 right pdr05" name="posts[<?php echo $i; ?>][scid]" 
			value="<?php echo $rows[$i]['scid']; ?>" readonly /></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><input class="vc30 center mode" id="mode<?php echo $i; ?>" name="posts[<?php echo $i; ?>][paymode_id]" 
		value="<?php echo $rows[$i]['paymode_id']; ?>" /></td>	
	<td class="right" ><?php echo number_format($rows[$i]['tpaid'],2); ?></td>
	
	<td>
		<select class="payfee vc100" id="payfee<?php echo $i; ?>" name="posts[<?php echo $i; ?>][payfee_id]" >
			<option value="0" >Select</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td><input class="vc80 dt right pdr05" id="date<?php echo $i; ?>" 
		name="posts[<?php echo $i; ?>][date]" value="<?php echo $_SESSION['today']; ?>" /></td>

	<td><input class="vc80 right pdr05" id="tpay<?php echo $i; ?>" name="posts[<?php echo $i; ?>][tpay]" /></td>
			
	<td><input class="vc80 right pdr05" id="orno<?php echo $i; ?>" name="posts[<?php echo $i; ?>][orno]" /></td>			
	<td><input class="vc80 right pdr05" id="details<?php echo $i; ?>" name="posts[<?php echo $i; ?>][details]" /></td>			
	
	<td>
		<select class="addon vc100" id="addon<?php echo $i; ?>" name="posts[<?php echo $i; ?>][feetype_id]" >
			<option value="0" >Select</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input class="vc20 right pdr05 num" id="num<?php echo $i; ?>" name="posts[<?php echo $i; ?>][num]" value="1" /></td>
	<td><input class="vc80 right pdr05 amount" id="amount<?php echo $i; ?>" name="posts[<?php echo $i; ?>][amount]" /></td>
						
	<td><input class="vc80 right pdr05" id="balance<?php echo $i; ?>" name="posts[<?php echo $i; ?>][balance]" 
			value="<?php echo $rows[$i]['balance']; ?>" /></td>									
	<td><input class="vc80 right pdr05" id="remarks<?php echo $i; ?>" name="posts[<?php echo $i; ?>][remarks]" 
			value="<?php echo $rows[$i]['remarks']; ?>" /></td>												
	<td><?php echo $rows[$i]['tsumcrid']; ?></td>			
	<td>
		<?php $all = ($rows[$i]['is_active']!=1)? '&all':NULL; ?>
		  <a href="<?php echo URL.'ledgers/student/'.$rows[$i]['scid']; ?>" >Lgr</a>
		| <a href="<?php echo URL.'ledgers/soa/'.$rows[$i]['scid'].$all; ?>" >SOA</a>
	</td>
	<td class="hd" >
<span id="xsave<?php echo $i; ?>" class="u blue" onclick="xeditTsum(<?php echo $i; ?>);" >Save</span>	
	</td>
	<td class="hd" >		
	</td>
</tr>
<?php endfor; ?>


</table>


<h5><?php echo ($locked)? 'Locked':'Open'; ?></h5>
<p class="hd" >
<?php if($is_transitioned): ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		<input type="submit" name="update" value="Update" onclick="return confirm('Dangerous! Sure?');" />	
		<span class="u" onclick="ilabas('clipboard')" >Smartboard</span>
	<?php endif; ?>	
<?php endif; ?>	
</p>

</form>


<!------------------------------------------------------->


<?php 
include_once(SITE.'views/ledgers/incs/ledger_setup_notes.php');
?>



<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="date" >Payment Date</option>
	<option value="payfee" >Payment Fee</option>
	<option value="tpay" >Payment Amount</option>
	<option value="orno" >Or No.</option>
	<option value="amount" >Aux Amount</option>
	<option value="details" >Details</option>
	<option value="mode" >Mode</option>
	<option value="remarks" >Remarks</option>
	<option value="addon" >Aux (A|D)</option>
</select>
</p>
<?php $d['width'] = '30'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>






<!------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo $hdpass; ?>";
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo 'ledgers'; ?>';
var tfeeid = '<?php echo $tfeeid; ?>';
var ecid = '<?php echo $_SESSION['ucid']; ?>';



$(function(){
	hd();
	$('#hdpdiv').hide();
	itago('clipboard');
		
})



function xeditTsum(ri){
	$('#xsave'+ri).hide();

	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "xeditTsum";		
	var mode = $('input[name="posts['+ri+'][paymode_id]"]').val();	
	var rmks = $('input[name="posts['+ri+'][remarks]"]').val();	
	var date = $('input[name="posts['+ri+'][date]"]').val();	
	var tpay = $('input[name="posts['+ri+'][tpay]"]').val();	
	var orno = $('input[name="posts['+ri+'][orno]"]').val();	
	var details = $('input[name="posts['+ri+'][details]"]').val();	
	var scid = $('input[name="posts['+ri+'][scid]"]').val();	
	var feetype = $('select[name="posts['+ri+'][feetype_id]"]').val();	
	var amount = $('input[name="posts['+ri+'][amount]"]').val();	
	var balance = $('input[name="posts['+ri+'][balance]"]').val();	

	var pdata = 'task='+task+'&scid='+scid+'&rmks='+rmks+'&tpay='+tpay+'&orno='+orno+'&mode='+mode+'&feetype='+feetype;
	pdata+='&amount='+amount+'&balance='+balance+'&details='+details+'&tfeeid='+tfeeid+'&date='+date+'&ecid='+ecid;
	// alert(pdata);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,
		async: true,
		success: function() { }		  
    });				

	
	
}	/* fxn */



</script>

