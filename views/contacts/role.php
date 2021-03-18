<h5>
	Update Contact

</h5>


<form>
<table class="gis-table-bordered table-fx" >
<tr><th>Name</th><td><?php echo $contact['name']; ?>
<tr><th>Title</th><td>
	<select   >
		<?php foreach($titles AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$contact['title_id'])? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>
<tr><th>Role</th><td><?php echo $contact['role']; ?>
</td></tr>
<tr><th>TRP</th><td>
	<input class="vc30" id="tid" name="d[title_id]" value="<?php echo $contact['title_id']; ?>" >	
	<input class="vc30" id="role" name="d[role_id]" value="<?php echo $contact['role_id']; ?>" >	
	<input class="vc30" id="priv" name="d[privilege_id]" value="<?php echo $contact['privilege_id']; ?>" >	
</td></tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Update" onclick="return confirm('Proceed?');"  /></td></tr>

</table>

</form>

<!-------------------------------------------------------------------------------------------------->

<script>

var gurl     = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	nextViaEnter();
	
})




function xcheckLogin(i){

var login = $('#login'+i).val();
var vurl 	= gurl + '/ajax/xcontacts.php';	
var task	= "xverifyCode";
	
$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: 'task='+task+'&code='+login,						
	success: function(s) { 			
		if(s.id){ alert(s.id+' : '+s.name); 
		} else { alert('Available'); } 			
	}		  
});				
	

}	/* fxn */



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


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>