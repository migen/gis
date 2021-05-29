<?php

require_once('datasheet_sjam_model.php');


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
.divTextarea{ float:left; padding-right:10px; }
.divTextareaLabel{ width:30%;word-wrap:break-word;font-weight:bold; }
.htgap{ height:20px;clear:both; }

.btn{ padding:15px; text-transform:uppercase; }

@media only screen and (max-width: 992px) {
	.vc-sm{ width:420px; }
	
	
}





</style>

<h3 class="pagelinks" >
	SJAM Datasheet | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 

print($controls);

?>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<script>
		var gurl = "http://<?php echo GURL; ?>";
		var limits='20';
		$(function(){
			selectFocused();
			nextViaEnter();
			$('#names').hide();
			$('html').live('click',function(){ $('#names').hide(); });
			
		})

		function redirContact(scid){
			var url = gurl+'/students/datasheet/'+scid;	
			window.location = url;		
		}
		
	</script>
	<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<?php endif; ?>	<!-- if employee -->

<?php if(!$scid){ pr("No scid."); exit; }?>

<?php 

// pr("pta: $is_scholar_pta ");

// pr($profile);

?>


<table class="gis-table-bordered" >
<tr>
	<th><?php echo $code; ?></th>
	<th><?php echo $name; ?></th>
	<th><?php echo ($profile_finalized==1)? 'Locked':'Open'; ?></th>

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


<div class="divRow " >

<?php if($srid!=RSTUD): ?>
<div class="divCell vc-sm ">
		<div class="key" >Access</div>			
		Locked <input name="profile[profile_finalized]" type="radio" value=1 
			<?php echo ($profile['profile_finalized']==1)? "checked":NULL; ?> >
		Open <input name="profile[profile_finalized]" type="radio" value=0 
			<?php echo ($profile['profile_finalized']==0)? "checked":NULL; ?> >		
	</div>
<?php endif; ?>

<?php 
	$radios=array(
		array('label'=>'Gender','table'=>'contact','field'=>'is_male','choices'=>array('boy','girl')),
		array('label'=>'Employee Child?','table'=>'profile','field'=>'is_employee_child','choices'=>array('Yes','No')),
		array('label'=>'Grantee FAPE?','table'=>'profile','field'=>'is_grantee_fape','choices'=>array('Yes','No')),
		array('label'=>'Scholar Academic?','table'=>'profile','field'=>'is_scholar_academic','choices'=>array('Yes','No')),
		array('label'=>'Scholar PTA?','table'=>'profile','field'=>'is_scholar_pta','choices'=>array('Yes','No')),
	);

?>

<?php 
	// for($i=0;$i<$profiles_count;$i++): 
	for($i=0;$i<6;$i++): 

?>
	<?php 
		$key=$profiles_cols[$i]; 
		$label=str_replace("_"," ",$key);
		$label=strtoupper($label);
	?>
	<div class="divCell vc-sm ">
		<div class="key" ><?php echo $label; ?></div>			
		<input name="profile[<?php echo $key; ?>]" value="<?php echo ${$key}; ?>" >
	</div>
<?php endfor; ?>

	<div class="divCell vc-sm ">
		<div class="key" ><?php echo 'Religion'; ?></div>			
		<input name="profile[religion]" value="<?php echo $religion; ?>" >
	</div>


</div>	<!-- divRow-->

<div class="htgap" >&nbsp;</div>

<div class="left clear" ></div>


<?php if($srid==RSTUD): ?>
<input type="hidden" name="profile[profile_finalized]" value=1 >
<?php endif; ?>
<?php if($srid!=RSTUD) : ?>
	<br /><div class="clear" ><br /><input class="btn" type="submit" name="submit" value="Save" ></div>
<?php endif; ?>

<?php if(($srid==RSTUD) && ($profile_finalized!=1)): ?>
	<br /><div class="clear" ><br /><input class="btn" type="submit" name="submit" value="Finalize" 
		onclick="return confirm('One time update only. Sure?');" ></div>
<?php endif; ?>

</form>

<div class="clear" >&nbsp;</div>

<h3>Legends / Notes:</h3>
<ol>
	<li><span class="b" >IMPORTANT: One time updating only. Will be locked after Finalizing.</span></li>
	<li><span class="b" >Inform school registrar for any info correction.</span></li>
	<li>LSA - LAST SCHOOL ATTENDED</li>
	<li>ICE - IN CASE OF EMERGENCY</li>
	<li>SIBLINGS INFO - 1) NAME OF SIBLINGS ENROLLED IN THIS SCHOOL, 2) ID NUMBER, AND 3) GRADE LEVEL </li>	
</ol>




<div class="ht100	" >&nbsp;</div>
