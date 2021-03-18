<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/contacts/ucis/'+ucid;	
	window.location = url;		
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<?php if(isset($_GET['style'])): ?>
<style>
	#content div{ border:1px solid black; }
</style>
<?php endif; ?>

<style>


.vc-sm{ width:320px; color:#222; }
.divCell{ float:left; }
.key{ float:left;min-width:120px;border;border:1px solid fff; }


@media only screen and (max-width: 992px) {
	.vc-sm{ width:420px; }
	
	
}





</style>

<h3 class="pagelinks" >
	UCIS | <?php $this->shovel('homelinks'); ?>
	<?php if($ucid): ?>
		| <a href='<?php echo URL."enrollment/links/$ucid"; ?>' >EnrollLink</a>
		| <a href='<?php echo URL."profiles/scid/$ucid"; ?>' >Profile</a>
		| <a href='<?php echo URL."profiles/student/$ucid"; ?>' >Student</a>
		| <a href='<?php echo URL."summary/edit/$ucid"; ?>' >Summary</a>
	<?php endif; ?>

</h3>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>

<?php if(!$ucid){ pr("No ucid."); exit; }?>

<form method="POST" >
<div class="divRow " >
<h3>Contact</h3>
<?php for($i=0;$i<$contacts_count;$i++): ?>
	<?php $key=$contacts_cols[$i]; ?>
	<div class="divCell vc-sm ">
		<div class="key" ><?php echo $key; ?></div>
		<?php if(in_array($key,$text_array)): ?>
			<textarea name="contact[<?php echo $key; ?>]" ><?php echo $contact[$key]; ?></textarea>
		<?php else: ?>
			<input name="contact[<?php echo $key; ?>]" value="<?php echo $contact[$key]; ?>" >
		<?php endif; ?>
	</div>

<?php endfor; ?>
</div>
<div class="clear" ><br />Save &nbsp; <input type="submit" name="submit" value="Contact"  ></div>
</form>


<form method="POST" >
<hr />
<div class="divRow " >
<br /><h3>Profile</h3>
<?php for($i=0;$i<$profiles_count;$i++): ?>
	<?php $key=$profiles_cols[$i]; ?>
	<div class="divCell vc-sm ">
		<div class="key" ><?php echo $key; ?></div>			
		<?php if(in_array($key,$text_array)): ?>
			<textarea name="profile[<?php echo $key; ?>]" ><?php echo $profile[$key]; ?></textarea>
		<?php else: ?>
			<input name="profile[<?php echo $key; ?>]" value="<?php echo $profile[$key]; ?>" >
		<?php endif; ?>				
	</div>
<?php endfor; ?>
</div>
<br /><div class="clear" ><br />Save &nbsp; <input type="submit" name="submit" value="Profile"  ></div>
</form>

<div class="ht100	" >&nbsp;</div>
