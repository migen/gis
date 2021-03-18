
<h5>
	Employees | 
	<a href="<?php echo URL; ?>mis">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
</h5>


<table class="gis-table-bordered table-fx" >
<tr>
	<td><input id="ecode" class='pdl05 vc100' type="text" placeholder="id number" /></td>
<td>
	<button onclick="gotoEmp();return false;" > Go </button> 
</td>
</tr>

</table>


<form method="POST" >

<input type="hidden" name="role_id" value="1" />
<input type="hidden" name="privilege_id" value="1" />


<h5> New Employees </h5>
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc20" >#</th>
	<th class="vc100" >First Name</th>
	<th class="vc100" >Middle Name</th>
	<th class="vc100" >Last Name</th>
	<th class="vc80" >Is <br />Male</th>
	<th class="vc80" >ID <br />Number</th>
	<th>Verify</th>
	<th class="center" >
		Privilege<br />
		<select id="iprv" class='vc100'>	
			<option> Choose </option>
			<?php foreach($titles as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /><input type="button" value="All" onclick="populatePrivileges();" >		
	</th>	
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	
	<td><input class="pdl05 vc100" type="text" name="contacts[<?php echo $i; ?>][first]" /></td>
	<td><input class="pdl05 vc100" type="text" name="contacts[<?php echo $i; ?>][middle]" /></td>
	<td><input class="pdl05 vc100" type="text" name="contacts[<?php echo $i; ?>][last]" /></td>
	<td><select class="vc80 pdl05" name="contacts[<?php echo $i; ?>][is_male]"  > <option value="1"  >Yes</option> <option value="0"  >No</option> </select></td>	
	<td><input id="cd<?php echo $i; ?>" class="pdl05 vc80" type="text" name="contacts[<?php echo $i; ?>][code]" /></td>
	<td><button onclick="verify(<?php echo $i; ?>);return false;" >Verify</button></td>
	
	<td>
		<select onchange="getPrivilege(this.value,this.id)" id="<?php echo $i; ?>" class="prv vc100" name="contacts[<?php echo $i; ?>][title_id]" >
			<option>Choose One</option>
			<?php foreach($titles AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
		<td><input id="roleid<?php echo $i; ?>" class="vc30" type="text" name="contacts[<?php echo $i; ?>][role_id]" readonly /></td>
		<td><input id="privid<?php echo $i; ?>" class="vc30" type="text" name="contacts[<?php echo $i; ?>][privilege_id]" readonly /></td>
		
</tr>

<?php endfor; ?>			

</table>

<p>
	<input type="submit" name="add" value="Add"  />
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>



<p><?php $this->shovel('numrows'); ?></p>

<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){

	nextViaEnter();

})

function populatePrivileges(){
	populateColumn('prv');
	setPrivileges();
}	// fxn

function verify(i){	// contacts.code	
	var vurl 	= gurl + '/mis/verifyContact';	
	var code = $('#cd'+i).val();
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'code='+code,						
		success: function(s) { 			
			if(s.name){ alert(s.name); 
			} else { alert('Available'); } 
		}		  
    });				
	
}	// fxn


function getPrivilege(prid,i){	
	var vurl 	= gurl + '/mis/getPrivilege';	
	// alert(vurl);
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'prid='+prid,				
		success: function(s) { 			
			$('#roleid'+i).val(s.role_id);
			$('#privid'+i).val(s.privilege_id);
		}		  
    });				
	
}	// fxn

function setPrivileges(){	
	$('.prv').each(function(){
		getPrivilege(this.value,this.id);
		// alert(this.value+'-'+this.id);
	})

}	// fxn


function gotoEmp(){	
	var ecode = $('#ecode').val();	
	var vurl 	= gurl + '/employees/getEmployee';	
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'ecode='+ecode,				
		success: function(s) { 			
			if(s.ecid){
				var rurl 	= gurl + '/employees/employee/'+s.ecid;
				window.location = rurl;				
			} else {
				alert('No employee record found.');
			}
		}		  
    });				
	

}	// fxn



</script>
