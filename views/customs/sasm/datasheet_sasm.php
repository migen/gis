<?php


if($scid){	


	$contact=fetchRow($db,"{$dbcontacts}",$scid,"*");
	$profile=fetchRecord($db,"{$dbprofiles}","contact_id=$scid");
	
	if(empty($profile)){ 
		$profile=array('contact_id'=>$scid);$db->add("{$dbo}.00_profiles",$profile);
		flashRedirect("students/datasheet/$scid","Synced profile.");
	}
	
	$except="'id','contact_id','profile_finalized','birthdate','is_male',";	
	$except.="'address','other_info','remarks'";
	
	
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except);		
	$profiles_cols=$dr['field_array'];
	$profiles_field_str=$dr['field_string'];
	$profiles_count=$dr['count'];
	
	$constants=array('last_name','first_name','middle_name');
	$constants=&$constants;

	$skip_array=array('id','contact_id','profile_finalized');
	$text_array=array('address','other_info','remarks');


	extract($contact);
	extract($profile);
}	/* scid */

// pr($_SESSION['q']);

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
	SASM Datasheet | <?php $this->shovel('homelinks'); ?>

</h3>

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
	);

?>

<?php foreach($radios AS $radio): ?>
<?php extract($radio); ?>
	<div class="divCell vc-sm ">
		<div class="key" ><?php echo $label; ?></div>					
		<?php echo $choices[0]; ?><input name="<?php echo $table; ?>[<?php echo $field; ?>]" type="radio" value=1 
			<?php echo (${$field}==1)? "checked":NULL; ?> >
		<?php echo $choices[1]; ?><input name="<?php echo $table; ?>[<?php echo $field; ?>]" type="radio" value=0 
			<?php echo (${$field}==0)? "checked":NULL; ?> >
	</div>

<?php endforeach; ?>


<?php for($i=0;$i<$profiles_count;$i++): ?>
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

</div>	<!-- divRow-->

<div class="htgap" >&nbsp;</div>

<div class="left clear" ></div>
<div id="sectionTextarea" >
<br />
<?php foreach($text_array AS $key): ?>
	<div class="divTextarea" >
		<div class="divTextareaLabel" ><?php $label=str_replace("_"," ",$key); echo strtoupper($label); ?></div>
		<textarea rows=5 cols=80 name="profile[<?php echo $key; ?>]" ><?php echo ${$key}; ?></textarea>
	</div>
<?php endforeach; ?>

</div>	<!-- sectionTextarea-->


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
