<?php 

	// pr($data);
	// pr($parent);
	// pr($users[0]);
	// pr($departments);
	// pr($_SESSION['q']);

	$this->shovel('registration');

?>

<!------------------------------------------------------------------------------------------------------------------------>


<h5>
	Users 
	| <a href="<?php echo URL.'mis/index/'.$sy; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'mgt/contacts'; ?>">Users</a> 	
	| <a href="<?php echo URL.'contacts/ucis/'.$parent['pcid']; ?>">UCIS</a> 	
	
</h5>



<?php 
// pr($parent);
?>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>


<div style="float:right;width:20%" class="hd" id="names" > </div>

<!------------------------------------------------------------------------------------------------------------------------>
<form method="POST" >	<!-- add  -->

<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 white" >PCID</th><td class="vc300" ><input class="pdl05 full" type="text" name="pcid" value="<?php echo $parent['pcid']; ?>" readonly /></td></tr>
<tr><th class="bg-blue2 white" >Code</th><td class="vc300" ><input class="pdl05 full" type="text" name="code" value="<?php echo $parent['code']; ?>" readonly /></td></tr>
	<input type="hidden" name="fullname" value="<?php echo $parent['name']; ?>" />
	<input type="hidden" name="org" value="<?php echo $parent['is_org']; ?>" />
	<input type="hidden" name="active" value="<?php echo $parent['is_active']; ?>" />
	<input type="hidden" name="clear" value="<?php echo $parent['is_cleared']; ?>" />
<tr><th class="bg-blue2 white" >Name</th><td><?php echo $parent['name']; ?></td></tr>
<tr><th class="bg-blue2 white" >Username</th><td><?php echo $parent['account']; ?></td></tr>
<tr><th class="bg-blue2 white" >Activity</th><td><?php echo ($parent['is_active'])? 'Active':'Not Active'; ?></td></tr>
<tr><th class="bg-blue2 white" >Clearance</th><td><?php echo ($parent['is_cleared'])? 'Cleared':'Not Cleared'; ?></td></tr>
<tr><th class="bg-blue2 white" >E-Pass</th><td><?php echo $parent['pass']; ?></td></tr>
<tr><th class="bg-blue2 white" >Password</th><td><?php echo $parent['ctp']; ?></td></tr>
<tr><th class="bg-blue2 white" >TRP</th><td>
<?php echo $parent['title_id'].'-'.$parent['role_id'].'-'.$parent['privilege_id']; ?>
</td></tr>
<tr><th class="bg-blue2 white" >Type</th><td><?php echo ($parent['is_org'])? 'Organization':'Person'; ?></td></tr>


<?php if($parent['role_id']!=1): ?>
	<tr><th class="bg-blue2 white" >Departments</th><td>
		<a href="<?php echo URL.'mis/dept/'.$parent['pcid']; ?>">Manage</a>
		<br />
		<input type="checkbox" name="parent[ps]" value="1" <?php echo ($parent['is_ps']==1)? 'checked': NULL; ?>  >PS<br />
		<input type="checkbox" name="parent[gs]" value="1" <?php echo ($parent['is_gs']==1)? 'checked': NULL; ?> >GS<br />
		<input type="checkbox" name="parent[hs]" value="1" <?php echo ($parent['is_hs']==1)? 'checked': NULL; ?> >HS<br />
		<input type="hidden" name="parent[cid]" value="<?php echo $parent['pcid']; ?>"  >
		<input type="submit" name="pcdept" value="Update"  />
	
	</td></tr>
<?php endif; ?>

</table>


<hr/> <!------------------------------------------------------------------>

<h4>Users</h4>
<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>	
	<th>ucid</th>	
	<th class="vc100" >Title</th>
	<th class="vc100" >Login</th>
	<th class="vc70" >Pass</th>
	<th class="vc70" >Confirm Pass</th>
	<th class="vc100" >Department</th>
	<th class="hd vc25" > A </th>
	<th class="hd vc25" > T </th>
	<th class="hd vc25" > R</th>
	<th class="hd vc25" > P</th>
</tr>

<?php for($i=0;$i<$num_users;$i++): ?>
<tr class="rc" >
	<td> &nbsp; </td>
	<td><?php echo $users[$i]['ucid']; ?></td>	
	<td><?php echo $users[$i]['title']; ?></td>	
	<td><?php echo $users[$i]['account']; ?></td>
	<td><?php echo $users[$i]['ctp']; ?></td>
	<td><?php echo $users[$i]['ctp']; ?></td>
	<td> 
		<a href="<?php echo URL.'mis/dept/'.$users[$i]['ucid']; ?>">Department</a> 
		<br />
		<input type="checkbox" name="user[ps]" value="1" <?php echo ($users[$i]['is_ps']==1)? 'checked': NULL; ?>  >PS<br />
		<input type="checkbox" name="user[gs]" value="1" <?php echo ($users[$i]['is_gs']==1)? 'checked': NULL; ?> >GS<br />
		<input type="checkbox" name="user[hs]" value="1" <?php echo ($users[$i]['is_hs']==1)? 'checked': NULL; ?> >HS<br />
		<input type="hidden" name="user[cid]" value="<?php echo $users[$i]['ucid']; ?>"  >
	</td>
	

	<td class="" ><?php echo ($users[$i]['is_active']==1)? 'Y':'-'; ?></td>
	<td class="hd" ><?php echo $users[$i]['title_id']; ?></td>
	<td class="hd" ><?php echo $users[$i]['role_id']; ?></td>
	<td class="hd" ><?php echo $users[$i]['privilege_id']; ?></td>
<!--
	<td><a onclick="return confirm('Dangerous! Continue?');" href='<?php echo URL."mis/primarize/".$users[$i]['ucid']; ?>' >Primarize</a></td>

 -->
	
	<td>
		<a href="<?php echo URL.'misc/purge/'.$users[$i]['ucid']; ?>" onclick="return confirm('Sure?');" >Purge</a>
		| <a href="<?php echo URL.'codename/one/'.$users[$i]['ucid']; ?>" >Login</a>
		| <a href="<?php echo URL.'mgt/pass/'.$users[$i]['ucid']; ?>" >Pass</a></td>
	
</tr>

<?php endfor; ?>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr class="rc" >
	<td> &nbsp; </td>
	<td> &nbsp; </td>
	<td>
		<select class="vc180" onchange="xgetPriv(this.value,this.id)" id="<?php echo $i; ?>" name="users[<?php echo $i; ?>][tid]" >
			<option>Choose One</option>
			<?php foreach($titles AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>

	<?php 
		$num = $lastnum+1+$i;
		$prefix = strtoupper(VCFOLDER);
		$code = setCode($num,$sy,$prefix,$_SESSION['settings']['code_delimeter']);			

	?>
	
	
	<td><input id="login<?php echo $i; ?>" class="pdl05 vc100" type="text" name="users[<?php echo $i; ?>][login]" value="<?php echo $code; ?>" />
		<button onclick="xcheckLogin(<?php echo $i; ?>);return false;" > Check </button>   
	
	</td>
	<td class="vc70" ><input class="pdl05 full" type="text" name="users[<?php echo $i; ?>][pass1]" value='pass' readonly /></td>
	<td class="vc70" ><input class="pdl05 full" type="text" name="users[<?php echo $i; ?>][pass2]" value='pass' readonly /></td>
	
	<td></td>	
	
	<td>&nbsp;</td>
	<td class="hd" ><input id="tid<?php echo $i; ?>" class="pdl05 vc25" type="text" name="users[<?php echo $i; ?>][title]" readonly /></td>
	<td class="hd" ><input id="role<?php echo $i; ?>" class="pdl05 vc25" type="text" name="users[<?php echo $i; ?>][role]" readonly /></td>
	<td class="hd" ><input id="priv<?php echo $i; ?>" class="pdl05 vc25" type="text" name="users[<?php echo $i; ?>][priv]" readonly /></td>
	<td></td>
</tr>


<?php endfor; ?>			
</table>

<p><input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Add" /> &nbsp; <a href="<?php echo URL.'mis'; ?>"><button>Cancel</button></a>
</p>

</form> <!-- add -->

<p>
<table class="gis-table-bordered table-fx f10" >
<tr class="headrow" ><th>Last</th><th>ID</th><th>ID Number</th><th>Name</th></tr>
<tr><td>Student</td><td><?php echo $laststud['id']; ?></td><td><?php echo $laststud['code']; ?></td><td><?php echo $laststud['name']; ?></td></tr>
<tr><td>Employee</td><td><?php echo $lastempl['id']; ?></td><td><?php echo $lastempl['code']; ?></td><td><?php echo $lastempl['name']; ?></td></tr>
</table>
</p>

<!------------------------------------------------------------------------------------------------------------------------>
<!-- form3 numrows -->
<?php $this->shovel('numrows'); ?>

<!------------------------------------------------------------------------------------------------------------------------>


<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';
var limits='20';

$(function(){
	// hd();
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



function redirContact(ucid){
	var url 		= gurl+'/misc/users/'+ucid;	
	window.location = url;		
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
