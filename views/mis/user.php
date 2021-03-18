<?php 
	// pr($user);
?>

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	accorHd();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	





function redirContact(ucid){
	var url 		= gurl + '/misc/user/' + ucid;	
	window.location = url;		
}


function gotomerge(name){
	var url = gurl+"/mis/merge?name="+name;
	window.location = url;
}

function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }


</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

<h5>

	<span class="u" ondblclick="tracehd();" >User</span>
	<span class="hd" ><a href='<?php echo URL."tools/upname"; ?>'>UP Name</a></span>	
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					


</h5>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus value="" /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>	

</table><br />


<?php if(!empty($ucid)): ?>	<!-- has ucid -->


<div class="forty" >	<!-- container -->

<div class="accordParent" >	
<button onclick="accorToggle('user')" style="width:346px;" class="bg-blue2" > <p class="b f16" >User</p> </button>  	
<table id="user" class="gis-table-bordered table-fx table-altrow" >
<tr><th class="vc100" >
<a href="<?php echo URL.'contacts/ucis/'.$user['ucid']; ?>" >UCIS</a>
 | <?php echo ($user['is_male']==1)? 'M':'F'; ?>
</th><td class="vc200" ><span ondblclick="gotomerge($(this).text());" class="u" ><?php echo $user['person']; ?></span></td></tr>

<tr><th>IP : U | P</th><td>
	<?php echo $user['ucid']; ?>
	<?php echo ($user['ucid']!=$user['pcid'])? ' | '.$user['pcid']:NULL; ?>
</td></tr>
<tr><th>ID Login</th><td><?php echo $user['code']; ?></td></tr>
<tr><th>Pass</th><td><?php echo $user['ctp']; ?></td></tr>
<tr><th>Role </th>
	<td><?php echo $user['role']; ?>
	> <?php echo $user['title_id'].'-'.$user['role_id'].'-'.$user['privilege_id']; ?>
</td></tr>
<?php if($is_student): ?>
	<tr><th>SY | CRID</th><td><?php echo $user['sy'].' | '.$user['crid']; ?></td></tr>
<?php endif; ?>
<tr><th>Actv | Clrd</th><td><?php echo $user['is_active'].' | '.$user['is_cleared']; ?></td></tr>
</table>
</div>	<!-- faves -->

<br />
<div class="accordParent" >	
<button onclick="accorToggle('contact')" style="width:346px;" class="bg-blue2" > <p class="b f16" >Contact</p> </button>  	
<table id="contact" class="gis-table-bordered table-fx table-altrow" >
<tr><th>SMS </th><td><?php echo $user['sms']; ?></td></tr>
<tr><th class="vc100" >Email</th><td class="vc200" ><?php echo $user['email']; ?></td></tr>
<tr><th>phone</th><td><?php echo $user['phone']; ?></td></tr>
<tr><th>Address</th><td><?php echo $user['address']; ?></td></tr>
<tr><th>Remarks</th><td><?php echo $user['remarks']; ?></td></tr>

</table>
</div>	<!-- faves -->


<?php if($user['role_id']==RSTUD): ?>	<!-- if student -->
<br />
<div class="accordParent" >	
<button onclick="accorToggle('student')" style="width:346px;" class="bg-blue2" > <p class="b f16" >Student</p> </button>  	
<table id="student" class="gis-table-bordered table-fx table-altrow" >
<tr><th class="vc100" >ID Number</th><td class="vc200" ><?php echo $user['code']; ?></td></tr>
<tr><th>Sectioner</th><td ><a href="<?php echo URL.'students/sectioner/'.$user['parent_id']; ?>" >View</td></tr>
<tr><th>Grades</th><td ><a href="<?php echo URL.'rcards/scid/'.$user['parent_id']; ?>" >Report Card</td></tr>

<?php if($_SESSION['settings']['has_axis']): ?>
	<tr><th>Tuition</th><td ><a href="<?php echo URL.'ledgers/student/'.$user['parent_id']; ?>" >Ledger</td></tr>
<?php endif; ?>	


</table>
</div>	<!-- faves -->

<?php endif; ?>	<!-- if student -->

</div>	<!-- container -->

<?php endif; ?>	<!-- has ucid -->




<div class="third hd" id="names" > </div>


<div class="clear ht100" >&nbsp;</div>


