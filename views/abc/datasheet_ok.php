<?php

extract($contact);
extract($profile);

?>

<?php if(isset($_GET['style'])): ?>
<style>
	#content div{ border:1px solid black; }
	div{border:1px solid black; }
	
</style>
<?php endif; ?>

<style>


.vc-sm{ width:320px; color:#222; }
.divCell{ float:left; border:1px solid #eee; }
.key{ float:left;min-width:120px;border;border:1px solid fff;font-weight:bold; }


@media only screen and (max-width: 992px) {
	.vc-sm{ width:420px; }
	
	
}





</style>

<h3 class="pagelinks" >
	Datasheet | <?php $this->shovel('homelinks'); ?>

</h3>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<script>
		var gurl = "http://<?php echo GURL; ?>";
		var limits='20';
		$(function(){
			$('#names').hide();
			$('html').live('click',function(){ $('#names').hide(); });
			
		})

		function redirContact(scid){
			var url = gurl+'/contacts/ucis/'+scid;	
			window.location = url;		
		}
		
	</script>
	<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<?php endif; ?>	<!-- if employee -->

<?php if(!$scid){ pr("No scid."); exit; }?>

<?php 



?>


<table class="gis-table-bordered" >
<tr>
	<th><?php echo $code; ?></th>
	<th><?php echo $name; ?></th>

</tr>
</table>
<br />
<form method="POST" >

	<?php foreach($constants AS $key): ?>	
	<?php 
		if(in_array($key,$skip_array)) continue;
		$label=str_replace("_"," ",$key);
		$label=strtoupper($label);	
	?>
		<div class="divCell vc-sm ">
			<div class="key" ><?php echo $label; ?></div>			
			<span><?php echo ${$key}; ?></span>
		</div>	
	<?php endforeach; ?>	

<br />
<br />
<br />
<br />

<div class="divRow " >
	<div class="divCell vc-sm ">
		<div class="key" >Gender</div>			
		Boy <input name="contact[is_male]" type="radio" value=1 <?php echo ($contact['is_male']==1)? "checked":NULL; ?> >
		Girl <input name="contact[is_male]" type="radio" value=0 <?php echo ($contact['is_male']==0)? "checked":NULL; ?> >		
	</div>

	<div class="divCell vc-sm ">
		<div class="key" >Access</div>			
		Locked <input name="profile[profile_finalized]" type="radio" value=1 
			<?php echo ($profile['profile_finalized']==1)? "checked":NULL; ?> >
		Open <input name="profile[profile_finalized]" type="radio" value=0 
			<?php echo ($profile['profile_finalized']==0)? "checked":NULL; ?> >		
	</div>


	<div class="divCell vc-sm ">
		<div class="key" >RFID</div>			
		<input name="contact[rfid]" value="<?php echo $rfid; ?>" >
	</div>




<?php for($i=0;$i<$profiles_count;$i++): ?>
	<?php 
		$key=$profiles_cols[$i]; 
		$label=str_replace("_"," ",$key);
		$label=strtoupper($label);
	?>
	<div class="divCell vc-sm ">
		<div class="key" ><?php echo $label; ?></div>			
		<?php if(in_array($key,$text_array)): ?>
			<textarea name="profile[<?php echo $key; ?>]" ><?php echo ${$key}; ?></textarea>
		<?php else: ?>
			<input name="profile[<?php echo $key; ?>]" value="<?php echo ${$key}; ?>" >
		<?php endif; ?>				
	</div>
<?php endfor; ?>
</div>
<br /><div class="clear" ><br /><input type="submit" name="submit" value="Save"  ></div>
</form>


<h3>Legends / Notes:</h3>
<ol>
	<li>LSA - LAST SCHOOL ATTENDED</li>
	<li>SIBLINGS INFO - 1) NAME OF SIBLINGS ENROLLED IN THIS SCHOOL, 2) ID NUMBER, AND 3) GRADE LEVEL </li>
</ol>




<div class="ht100	" >&nbsp;</div>
