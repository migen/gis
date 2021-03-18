<h5>
	Cashiering
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."bills/add"; ?>'>Cashier</a>			
	| <a href='<?php echo URL."bills/index"; ?>'>Filter</a>			
	
</h5>

<div class="forty" >

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>Payor</th>
	<td>
		<input style="width:220px;" class="pdl05" id="part" name="name" maxlength="60" />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />
		<input class="pdl05 vc50" id="ucid" name="ucid" value="0" readonly />		
	</td>
</tr>	
<tr>
<th>Payor type</th>
<td>
<select style="width:225px;" id="payortype" disabled >
	<option value="3" >Other</option>
	<option value="2" >Employee</option>
	<option value="1" >Student</optiont>
</select>
</td>
</tr>

<tr>
<th colspan="2" >
<span class="bl" ><input type="submit" name="submit" value="Ledger" ></span>
<input type="submit" name="submit" value="Misc" >
</th>
</tr>


</table>

</form>

<div id="names" >names</div>

</div>

<div>
<?php include_once('incs/notes_cashiering.php'); ?>
</div>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	// itago('bl');
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	$('html').live('change',function(){ 
		if(($('#payortype')).val()==1){ ilabas('bl'); }
	});

	
})



function redirContact(ucid){
	$('#ucid').val(ucid);
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetContactByUcid";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&ucid='+ucid,				
		async: true,
		success: function(s) { 
			if(s.role_id>1){
				$('#payortype').val(2);
			} else {
				$('#payortype').val(1);	
				// ilabas('bl');
				
			}
		
		}		  
    });				
	
	
}	/* fxn */



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

