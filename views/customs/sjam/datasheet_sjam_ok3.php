<?php

require_once('datasheet_sjam_model.php');
$today=$_SESSION['today'];

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
	SJAM Datasheet 
	| <?php $this->shovel('homelinks'); ?>
	<?php if($scid): ?>
		| <a href="<?php echo URL.'students/ds/'.$scid.DS.$sy; ?>" >DS</a>
	<?php endif; ?>

</h3>



<?php 

/* navigation controls */
echo $controls."<div class='clear'>&nbsp;</div>";

/* locking */
$is_locked=($srid==RSTUD)? isFinalizedEnstep($db,$scid,$enstep=1):false;



?>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<script>
		var gurl = "http://<?php echo GURL; ?>";
		var limits='20';

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
<form method="POST" id="form" >

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



<div class="screen clear action-btn">
	<div class="form-group">
		<div class="input-group">								
		<?php if($srid==RSTUD): ?>
		
		<?php endif; ?>
		<?php if($srid!=RSTUD) : ?>							
			<br />
			<div class="clear" ><br />
				<div style="margin:6px 0;padding:6px 0;font-size:1.2em;" class="clear" >
					Finalized: <input type="number" style="font-size:1.2em;" 
					min=0 max=1 name="profile[profile_finalized]" value="<?php echo $profile_finalized; ?>" >
				</div>
				<input class="btn input-control datasheet-btn" 
				id="submit" type="submit" name="submit" value="Save" >
			</div>
		<?php endif; ?>

		<?php if(($srid==RSTUD) && (!$is_locked)): ?>
			<br />
			<div class="" ><br />
			<input class="btn datasheet-btn" 
				 type="submit" name="submit" value="Save"  >							
			<input class="btn datasheet-btn" id="btnFinalize"
				 type="submit" name="submit" value="Finalize" 
				onclick="return confirm('One time update only. Sure?');" >
			</div>
		<?php endif; ?>
				
				
		</div>
	</div>
</div>

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


<script>

	var today="<?php echo $today; ?>";
	

	$(function(){
		selectFocused();
		nextViaEnter();
		$('#names').hide();
		$('html').live('click',function(){ $('#names').hide(); });

		$('#btnFinalize').click(function(){
			var lock = "<input name='contact[enstep]' value=2 >";
			lock+="<input name='step[finalized_s1]' value='"+today+"' >";
			$('#form').append(lock);
		})

/* 		
		$('#btnFinalize').click(function(){
			var lock = "<input name='profile[profile_finalized]' value=1 >";
			$('#form').append(lock);
		})
 */		
		
	})


</script>
