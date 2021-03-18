

<?php 
	
	$with_chinese 	= $_SESSION['settings']['with_chinese'];
	$readonly = ($is_employee)? false:true;		


	
	
	// pr($data);
// pr($contact);
// pr($row);
	
// pr($_SESSION['q']);	
	
?>


<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';
var limits='20';

$(function(){
	hd();
	shd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });

})	



function checkFields(){
	var fname = $('#fullname').val();
	var crid  = $('#crid').val();
	var scode = $('#scode').val();		
	
	if(scode.length<6){ alert('Minimum of 6 characters for ID.'); return false; }
	if(crid=='0'){ alert('Classroom required.'); return false; }
	if(fname==''){ alert('Name required.'); return false; }
	
	$('#checkBtn').hide();
	alert('You may register.');
	$('#newBtn').show();
	return true;
	
	
}	


function yearend(year){
	var ye = parseInt(year)+1;
	$('#yearend').text(ye);
}


 
function redirContact(ucid){
	var url 		= gurl + '/contacts/ucis/' + ucid;	
	window.location = url;		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

<!------------------------------------------------------------------------------------------------->

<?php 


?>

<h5 class="screen" > Information  (*Required)
	&nbsp; 
	<a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."photos/one/".$row['parent_id'].DS.$sy; ?>' >Photo</a>	
	<?php if(isset($is_student) && ($is_student)): ?>
		| <a href="<?php echo URL.'students/sectioner/'.$id; ?>">Sectioner</a> 
		| <a href="<?php echo URL.'students/links/'.$id; ?>">Links</a> 
	<?php endif; ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a onclick="return confirm('Dangerous! Sure?');" href="<?php echo URL.'mis/purge/'.$id; ?>" >Purge</a>
	<?php endif; ?>		

<?php if($_SESSION['srid']==RMIS): ?>	
	| <a href='<?php echo URL."mgt/users/$id"; ?>' >Users</a> 
	| <span onclick="traceshd();" class="u" >Pwd</span>
<?php endif; ?>
	
	
</h5>


<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>


	
<div class="hd" id="names" > hhh</div>

<?php if(!$id){ exit; } ?>



<div class="half" >
<form method="POST"  >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow"><th colspan="2" > ----- Contact -----  </th></tr>

<tr><th>ID </th><td> 		
	<a href='<?php echo URL."contacts/ucis/".$row['pcid']; ?>' > PCID: <?php echo $row['pcid']; ?></a>
	| <?php echo "ID: ".$row['ucid']; ?> 		
	| <?php echo "Name: ".$row['pcname']; ?> 		
</td></tr>
	
<tr><th class="vc200" >
<?php if($user['role_id']!=RSTUD): ?>
	<a href='<?php echo URL."photos/one/".$row['parent_id'].DS.$sy; ?>' >Upload Photo</a>
<?php else: ?> Photo <?php endif; ?>
</th><td class="vc500"  >
<img src="data:image/jpeg;base64,<?php echo base64_encode($photo=NULL); ?>" width="150" border="0" /></td></tr>
<tr><th>Login Account<span class="shd" >-Password</span>
</th><td><?php echo $row['account']; ?>
<span class="shd" ><?php echo "-".$row['ctp']; ?></span></td></tr>
<tr><th class="vc200" >ID No | Code</th><td class="vc500"  ><?php echo $row['code']; ?>
<?php if($srid==RMIS): ?> 
- <a href='<?php echo URL."codename/one/$id"; ?>' >Edit ID</a>
| <a href='<?php echo URL."mgt/pass/$id"; ?>' >Edit Pass</a>
<?php endif; ?>
</td></tr>

<tr><th>LRN</th><td><input class="full pdl05" name="contact[lrn]" value="<?php echo $row['lrn']; ?>" ></td></tr>

<tr><th>Last, Given Middle</th><td><input class="full pdl05" name="contact[name]" value="<?php echo $row['name']; ?>"  ></td></tr>

<tr><th>*Birthdate (MM/DD/YYYY) </th>
	<td><input type="date" class="reqd full pdl05" name="profile[birthdate]" value="<?php echo $row['birthdate']; ?>"  ></td></tr>
<tr><th>phone (Others)</th><td><input class="full pdl05" name="profile[phone]" value="<?php echo $row['phone']; ?>"  ></td></tr>
<tr><th>Mobile (SMS) </th><td><input class="full pdl05" name="profile[sms]" value="<?php echo $row['sms']; ?>"  ></td></tr>
<tr><th>*Home Address</th><td><input class="reqd full pdl05" name="profile[address]" value="<?php echo $row['address']; ?>"  ></td></tr>



<!---------------------------------------------------------------------------------------------------------------------->


<?php if($is_employee): ?>	<!-- if user is employee -->

<?php if($is_student): ?>	<!-- if contact ucid is student -->
	<tr><th class="vc200" >Level</th><td class="vc500"  ><?php echo $row['level']; ?></td></tr>
	
	<tr><th>Crids</th><td>
		C# <input class="vc50 pdl05" name="contact[crid]" value="<?php echo $contact['ccrid']; ?>" 
		<?php echo ($is_admin)? NULL:'readonly'; ?>   >
		
		Summ#<input class="vc50 pdl05" name="summ[crid]" value="<?php echo $contact['sumcrid']; ?>" 
		<?php echo ($is_admin)? NULL:'readonly'; ?>   >
		<?php if($has_axis): ?>
				TsumCrid#<input class="vc50 pdl05" name="tsum[crid]" value="<?php echo $contact['tsumcrid']; ?>" 
				<?php echo ($is_admin)? NULL:'readonly'; ?>   >
		<?php endif; ?>				
	</td></tr>


		
<?php endif; ?>	<!-- if student -->

<tr class="headrow" ><th class="center" colspan="2" > ----- Admin Only ----- </th></tr>

<tr><th>Prnt (U==P)</th><td>
	<?php echo ($is_admin)? NULL:'readonly'; ?>  >
<span class="b" >UCID</span>
	<input class="vc100  pdl05" value="<?php echo $row['ucid']; ?>" <?php echo ($is_admin)? NULL:'readonly'; ?> >
<span class="b" >PCID</span>
	<input class="vc100 pdl05" value="<?php echo $row['pcid']; ?>" <?php echo ($is_admin)? NULL:'readonly'; ?> >	
</td></tr>
	
	<?php 
		$is_mis = ($_SESSION['srid']==RMIS)? true:false; 
		$trp_reaonly = ($is_mis)? '':'readonly';
	?>
	<tr><th>Access Control</th><td>
		<span class="b" >Title </span><input class="vc50 pdl05" name="contact[title_id]" value="<?php echo $row['title_id']; ?>" <?php echo $trp_reaonly; ?> />
		<span class="b" >Role </span><input class="vc50 pdl05" name="contact[role_id]" 
			value="<?php echo $row['role_id']; ?>" <?php echo $trp_reaonly; ?> />
		<span class="b" >Priv </span><input class="vc50 pdl05" name="contact[privilege_id]" 
			value="<?php echo $row['privilege_id']; ?>" <?php echo $trp_reaonly; ?> />	
	</td></tr>
	
	<tr><th>CSY</th><td><input class="vc100 pdl05" type="number" name="contact[sy]" 
		value="<?php echo $row['csy']; ?>" 	
		<?php echo ($is_admin)? NULL:'readonly'; ?>  >
		<span class="b" >Gender</span> 
		<select class="vc100" name="contact[is_male]" >
			<option value="1" <?php echo ($row['is_male']==1)? 'selected':NULL; ?>  >Boy</option>
			<option value="0" <?php echo ($row['is_male']!=1)? 'selected':NULL; ?>  >Girl</option>
		</select>		
		
	</td></tr>


			
	
<?php if($is_student): ?>		
	<tr>
		<th>Scid</th>
		<td>Summ <?php echo $row['sumucid']; ?>
		<?php if($has_axis): ?>	
			| Tsum <?php echo $row['tsumucid']; ?>
		<?php endif; ?>		
		</td>
	</tr>	
<?php endif; ?>

	<tr class="shd" >
		<th>Pwd</th>
		<td><?php echo $row['pass']; ?></td>
	</tr>

	
	<tr class="shd" >
		<th>Ucid</th>
		<td>
			  CTP <?php echo $row['ctpucid']; ?>
			| Profile	<?php echo $row['profpcid']; ?>		
		</td>
	</tr>
	
	
	<tr><th>Statuses </th><td>
	Active <select class="vc100" name="contact[is_active]" >
		<option value="1" <?php echo ($row['is_active']==1)? 'selected':NULL; ?>  >Active-1</option>
		<option value="0" <?php echo ($row['is_active']==0)? 'selected':NULL; ?>  >Dropped-0</option>
		<option value="2" <?php echo ($row['is_active']==2)? 'selected':NULL; ?>  >Transferred-2</option>
	</select>
	
	| Cleared <select class="vc100" name="contact[is_cleared]" >
		<option value="1" <?php echo ($row['is_cleared']==1)? 'selected':NULL; ?>  >Cleared</option>
		<option value="0" <?php echo ($row['is_cleared']!=1)? 'selected':NULL; ?>  >Unpaid</option>
	</select>
	</td></tr>	
	
	<tr><th>Remarks</th><td><input class="full pdl05" name="contact[remarks]" value="<?php echo $row['remarks']; ?>"  ></td></tr>
	
	
			
<?php endif; ?>	<!-- if employee -->



<!---------------------------------------------------------------------------------------------------------------------->


<tr class="screen" ><td colspan="2" ><input type="submit" name="submit" value="Update" onclick="return validateForm();"  /></td></tr>
</table>
</form>

</div>

<div class="ht100 clear" >&nbsp;</div>


<?php 


?>	
	
