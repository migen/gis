<?php


?>

<style>

.btn-one{
	font-weight:bold;font-size:1.2em;color:#333;background-color:lightblue;border-radius:10px;padding:6px 12px;border:1px solid #ccc;
}


</style>

<h5>

	Student CodeName (SCN) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'contacts/ucis/'.$id; ?>">UCIS</a> 
	| <a href="<?php echo URL.'passwords/resets/'.$id; ?>">Password</a> 	
	
</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>

<?php if($id): ?>
<form method="POST" >

<table id="contdiv" class="gis-table-bordered table-fx table-altrow" >
<tr><th colspan=2>Contact</th></tr>
<tr><th>U|P</th><td><?php echo $contact['id']; 
	echo ($contact['id']!=$contact['parent_id'])? ' | '.$contact['parent_id']:NULL; ?></td></tr>	
<tr><th class="vc150" >ID No</th><td><input class="full pdl05" type="text" 
		name="contact[code]" value="<?php echo $contact["code"]; ?>" ></td></tr>
<tr><th class="vc150" >Full Name</th><td class="vc300" >
	<input class="full pdl05" type="text" name="contact[name]" 
		value="<?php echo $contact["name"]; ?>" ></td></tr>

<tr><th colspan=2>Profile</th></tr>
<tr><th class="vc150" >First Name</th><td class="vc300" >
	<input class="full pdl05" type="text" name="profile[first_name]" 
		value="<?php echo $profile["first_name"]; ?>" ></td></tr>
<tr><th class="vc150" >Middle Name</th><td><input class="full pdl05" type="text" 
		name="profile[middle_name]" value="<?php echo $profile["middle_name"]; ?>" ></td></tr>
<tr><th class="vc150" >Last Name</th><td><input class="full pdl05" type="text" 
	name="profile[last_name]" value="<?php echo $profile["last_name"]; ?>" ></td></tr>
	
<tr>
	<th colspan=2>
		<input class="btn-one" type="submit" name="submit" value="Save" >
	</th>
</tr>	
	
</table>
</div>


</form>
<?php endif; ?>

<div id="names" >names</div>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

})



function redirContact(ucid){
	var url = gurl+'/codename/student/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

