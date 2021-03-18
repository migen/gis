<h5>
	Edit College Student
	| <?php $this->shovel('homelinks','College'); ?>
	
	
</h5>

<?php if(!$is_college): ?><h4 class="brown" >* NOT a college student. Check with MIS.</h4><?php endif; ?>

<?php 

// pr($data);
// exit;

$width_a=150;
$width_b=200;
$width_c=350;


// pr($contact);

?>


<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>

<table class="gis-table-bordered" >
<tr>
	<td>Summcrid: <?php echo $summrow['summcrid']; ?></td>
<?php if($is_college): ?>	
	<td>UniSummcrid: <?php echo $summrow['unisummcrid']; ?></td>
<?php endif; ?>
</tr>
</table><br />

<form method="POST" >
<table class="accordion contact gis-table-bordered table-altrow" >
	<tr><th colspan=2 class="btn-accordion headrow center" 
		style="width:<?php echo $width_c; ?>px;" onclick="accordionTable('contact');" >Contact</th></tr>
	<tr><td style="width:<?php echo $width_a; ?>px;" >Code / ID No.</td>
		<td style="width:<?php echo $width_b; ?>px;"  >
		<input name="contact[code]" value="<?php echo $contact['code']; ?>" ></td></tr>
	<tr><td>Account Login</td><td><input name="contact[account]" value="<?php echo $contact['account']; ?>" ></td></tr>
	<tr><td>Name</td><td><input name="contact[name]" value="<?php echo $contact['name']; ?>" ></td></tr>
	<tr><td>Role ID</td><td><input class="vc50 pdl05" name="contact[role_id]" value="<?php echo $contact['role_id']; ?>" ></td></tr>
	<tr><td>Is Active</td><td><input class="vc50 pdl05" name="contact[is_active]" value="<?php echo $contact['is_active']; ?>" ></td></tr>
	<tr><td>Is Male</td><td><input class="vc50 pdl05" name="contact[is_male]" value="<?php echo $contact['is_male']; ?>" ></td></tr>

</table><br />

<?php if($is_college): ?>
<table class="accordion summary gis-table-bordered table-altrow" >
	<tr><th colspan=2 class="btn-accordion headrow center" 
		style="width:<?php echo $width_c; ?>px;" onclick="accordionTable('summary');" >Summary</th></tr>
	<tr><td style="width:<?php echo $width_a; ?>px;" >Summ scid &nbsp;
		<?php if(empty($summary['scid'])): ?>
			<a href="<?php echo URL.''; ?>" >Init</a><?php endif; ?>
	</td>
		<td style="width:<?php echo $width_b; ?>px;"  ><?php echo $summary['scid']; ?></td></tr>
	<tr><td>Level</td><td><input name="summary[level_id]" value="<?php echo $summary['level_id']; ?>" ></td></tr>
	<tr>
		<td>Classroom</td>
		<td>
			<select name="summary[crid]" >
				<option value=0>Select One</option>
				<?php foreach($uniclassrooms AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$summary['crid'])? 'selected':NULL; ?> >
						<?php echo $sel['name']; ?>
					</option>					
				<?php endforeach; ?>
			</select>
		</td>		
	</tr>
</table><br />
<?php endif; ?>	<!-- is_college -->

<table class="accordion profile gis-table-bordered table-altrow" >
	<tr><th colspan=2 class="btn-accordion headrow center" 
		style="width:<?php echo $width_c; ?>px;" onclick="accordionTable('profile');" >Profile</th></tr>
	<tr><td style="width:<?php echo $width_a; ?>px;"  >Contact ID</td>
	<td style="width:<?php echo $width_b; ?>px;"  ><?php echo $contact['id']; ?></td></tr>
	<?php foreach($field_array AS $field): ?>
		<tr><td><?php echo ucfirst($field); ?></td>
		<td><input name="profile[<?php echo $field; ?>]" value="<?php echo $profile[$field]; ?>" /></td></tr>
	<?php endforeach; ?>



</table><br />

<input type="submit" name="submit" value="Save" />
</form>

<div class="clear ht50" ></div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='50';
// var lady=charmee();


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(id){
	var url = gurl+'/unistudents/edit/'+id;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
