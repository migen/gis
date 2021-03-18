<?php

// pr($data);
// pr($contacts[0]);
// pr($titles);

?>


<h5>
	Batch Edit 
	| <a href="<?php echo URL.'mgt/contacts'; ?>">Users</a> 
	| <a href="<?php echo URL; ?>mis">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>

<!------------------------------------------------------------------------------>


<form method='POST' >
<table class="table-fx gis-table-bordered">
<tr class="headrow" >
	<th class="vc30" >#</th>
	<th class="vc50" >UCID</th>
	<th class="vc100" >Code</th>
	<th class="vc200" >Name</th>	

	<th class="vc50" > PID
		<input id="ipid" class="full" >
		<br /><input type="button" value="All" onclick="populateColumn('pid');" >				
	</th>	
	
	<th class="vc80" >Title</th>
	<th class="vc20" >T</th>
	<th class="vc20" >R</th>
	<th class="vc20" >P</th>
	
	<th class="vc50" > Male <br />
		<select id="imle" class='vc50'>	
			<option value="1" > Y </option>
			<option value="0" > N </option>
		</select>					
		<br /><input type="button" value="All" onclick="populateColumn('mle');" >				
	</th>	
	
	<th class="vc50" > Active <br />
		<select id="iia" class='vc50'>	
			<option value="1" > Y </option>
			<option value="0" > N </option>
		</select>					
		<br /><input type="button" value="All" onclick="populateColumn('ia');" >				
	</th>	
		
	
</tr>

<?php for($i=0;$i<$num_contacts;$i++): ?>
<tr class="<?php echo ($contacts[$i]['is_active']=='1')? NULL:'bg-pink'; ?>" >
	<td> <?php echo $i+1; ?> 	</td>

	<td class="" ><?php echo $contacts[$i]['cid']; ?></td>

	<td><input class="" name="contacts[<?php echo $i; ?>][code]" value="<?php echo $contacts[$i]['code']; ?>"  /></td>	
	
	<td><input name="contacts[<?php echo $i; ?>][name]" class="pdl05 full" value="<?php echo ($contacts[$i]['name']); ?>"  /></td>	


	<td><input name='contacts[<?php echo $i; ?>][parent_id]' id="pid<?php echo $i; ?>" class="pid" 
		value="<?php echo $contacts[$i]['parent_id']; ?>" /></td>	

	<td>
		<select class="" onchange="xgetPriv(this.value,this.id)" id="<?php echo $i; ?>"  >
			<option>Choose One</option>
			<?php foreach($titles AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  <?php echo ($contacts[$i]['title_id']==$sel['id'])? 'selected':NULL; ?>  >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
	
	<td><input id="tid<?php echo $i; ?>" class="center full" name="contacts[<?php echo $i; ?>][title_id]" 
		value="<?php echo $contacts[$i]['title_id']; ?>" readonly /></td>

	<td><input id="role<?php echo $i; ?>" class="center full" name="contacts[<?php echo $i; ?>][role_id]" 
		value="<?php echo $contacts[$i]['role_id']; ?>" readonly /></td>	

	<td><input id="priv<?php echo $i; ?>" class="center full" name="contacts[<?php echo $i; ?>][privilege_id]" 
		value="<?php echo $contacts[$i]['privilege_id']; ?>" readonly /></td>

		
	<td>
		<select name='profiles[<?php echo $i; ?>][is_male]' id="male<?php echo $i; ?>" class="mle vc50"  >
			<option value="1" <?php echo ($contacts[$i]['is_male']==1)? 'selected':null; ?> >Y</option>
			<option value="0" <?php echo ($contacts[$i]['is_male']!=1)? 'selected':null; ?> >N</option>
		</select>	
	</td>	
	
	<td>
		<select name='contacts[<?php echo $i; ?>][is_active]' id="active<?php echo $i; ?>" class="ia vc50"  >
			<option value="1" <?php echo ($contacts[$i]['is_active']==1)? 'selected':null; ?> >Y</option>
			<option value="0" <?php echo ($contacts[$i]['is_active']!=1)? 'selected':null; ?> >N</option>
		</select>	
	</td>	
	
		

	<input type='hidden' name='contacts[<?php echo $i; ?>][id]' value="<?php echo $contacts[$i]['cid']; ?>"/>
	<input type='hidden' name='profiles[<?php echo $i; ?>][contact_id]' value="<?php echo $contacts[$i]['cid']; ?>"/>
</tr>

<?php endfor; ?>
</table>

<br /><input type='submit' name='submit' value='Submit'> &nbsp; 

<button><a class="no-underline" href="<?php echo URL.'mis'; ?>">Cancel</a></button>

<!------------------------------------------------------------------------------>

<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl     = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	rc('rc');
	nextViaEnter();
	
})


function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}

function xcheckLogin(i){

var login = $('#login'+i).val();
var vurl 	= gurl + '/mis/xcheckLogin';	
	
$.ajax({
	url: vurl,
	dataType: "json",
	type: 'POST',
	data: 'login='+login,				
	async: true,
	success: function(s) { 
		if(s.account){
			alert(s.code+': That username has been taken.');
		} else { 
			alert('Available');
		}		
	}		  
});			


}	

function xgetPriv(tid,i){	
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= "xgetPriv";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 			
			$('#tid'+i).val(s.tid);
			$('#role'+i).val(s.roleid);
			$('#priv'+i).val(s.privid);
		}		  
    });				

	
}	/* fxn */



</script>
