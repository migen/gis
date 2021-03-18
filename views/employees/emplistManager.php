<?php 

// pr($emps[0]);
// pr($_SESSION['q']);

?>


<h5> 
	Employees Manager
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'mis/employees'; ?>"> Find / Add </a> 
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>

</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >

<tr class="headrow" >
<th>&nbsp;</th>
<th class="" >ID</th>
<th>Prnt</th>
<th>Actv</th>
<th>
	<input class="pdl05 vc60" type="text" id="iyear" placeholder="Year" type="number" /><br />	
	<input type="button" value="All" onclick="populateColumn('year');" >			
</th>
<th>Name</th>
<th>Login</th>
<th>Pass</th>
<th>Role</th>
<th>&nbsp;</th>
</tr>

<?php for($i=0;$i<$num_emps;$i++): ?>
<?php $active = $emps[$i]['is_active']; ?>
<tr class="<?php echo ($active==1)? NULL:'red'; ?>" id="trow<?php echo $i; ?>" >
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $emps[$i]['ecid']; ?>" /></td>
	<td><input class="pdl05 vc50" name="contact[<?php echo $i; ?>][id]" value="<?php echo $emps[$i]['ecid']; ?>" readonly /></td>
	<td><input class="pdl05 vc50" name="contact[<?php echo $i; ?>][parent_id]" value="<?php echo $emps[$i]['parent_id']; ?>" 
		onclick="xname('dbo','00_contacts',this.value);" ondblclick="xpopname('dbo','00_contacts',this.value);" /></td>

	<td><input class="pdl05 vc30" name="contact[<?php echo $i; ?>][is_active]" value="<?php echo $emps[$i]['is_active']; ?>" 	
		type="number" min="0" max="1"	/></td>
	<td><input class="pdl05 vc60 year" type="number" name="contact[<?php echo $i; ?>][year]" value="<?php echo $emps[$i]['year']; ?>" /></td>
	<td><input class="pdl05 vc250" name="contact[<?php echo $i; ?>][name]" value="<?php echo $emps[$i]['name']; ?>" /></td>
	<td><input class="pdl05 vc100" name="contact[<?php echo $i; ?>][code]" value="<?php echo $emps[$i]['employee_code']; ?>" /></td>
	<td><input class="pdl05 vc80" name="contact[<?php echo $i; ?>][pass]" value="<?php echo $emps[$i]['ctp']; ?>" /></td>
	<td><?php echo $emps[$i]['title']; ?></td>		
	<td>			
		<button><a id="btn<?php echo $i; ?>" onclick="xeditContactCtp(<?php echo $i; ?>);return false;" >Save</a></button>
		<button onclick="deltrow(<?php echo $i; ?>);" >Hide</button>
		&nbsp;&nbsp; 
		<span class="hd" >
			<input ondblclick="xpopname('dbo','00_contacts',this.value);" class="vc50 center" id="idto-<?php echo $i; ?>" value="0"  />
			<button onclick="return ptl(<?php echo $emps[$i]['ecid'].','.$i; ?>);" >PTL</button>	
		</span>
	</td>		
</tr>

<?php endfor; ?>
</table>

<p class="screen" >	
	<span class="" ><input onclick="return confirm('You sure?');" type='submit' name='save' value='Save All' ></span>
	<button onclick="alert('Password Protected!');return false;" >MANAGE</button>
	<span class="hd" ><input onclick="return confirm('DANGEROUS! Proceed?');" type='submit' name='batch' value='DELETE' ></span>
</p>


</form>

<!------------------------------------------------------------------------------------------------------------->



<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';


$(function(){
	hd();
	// alert('refreshed');
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();

})


function ptl(idfrom,i){

	if (confirm('DANGEROUS!!! Proceed?')){
		var idto = $('#idto-'+i).val();
		var vurl = gurl + '/mis/ptl/';
		var vurl 	= gurl + '/ajax/xmis.php';	
		var task	= "ptl";		
		
		$.ajax({
			url: vurl,type: 'POST',async: true,
			data: 'task='+task+'&idfrom='+idfrom+'&idto='+idto,						
			success: function() { 						
				
			}		  
		});				
		
		
		return true;
	} 
	return false;
	
}




function xeditContactCtp(i){
	var vurl 	= gurl + '/ajax/xcontacts.php';	

	var id 	  = $('input[name="contact['+i+'][id]"]').val();
	var parent_id  = $('input[name="contact['+i+'][parent_id]"]').val();
	var is_active  = $('input[name="contact['+i+'][is_active]"]').val();
	var year  = $('input[name="contact['+i+'][year]"]').val();
	var name  = $('input[name="contact['+i+'][name]"]').val();
	var code  = $('input[name="contact['+i+'][code]"]').val();
	var pass  = $('input[name="contact['+i+'][pass]"]').val();
	var task = "xeditContactCtp";
	
	var pdata  = "task="+task+"&id="+id+"&parent_id="+parent_id+"&is_active="+is_active;
		pdata += "&year="+year+"&name="+name+"&code="+code+"&account="+code+"&pass="+pass;
	
	$.ajax({
		url: vurl,
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { $('#btn'+i).hide(); }		  
    });				
	
	
}




</script>




