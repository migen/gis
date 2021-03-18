<?php 

// pr($data);
// exit;
$roles=&$data['roles'];
$levels=&$data['levels'];


?>

<table class="general accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('general');" >General</th></tr>
	<tr><td class="vc250" > 
		<a href='<?php echo URL."speed/informant"; ?>' >Informant</a>
		<span class="shd" >
			<?php if($_SESSION['user']['privilege_id']==0): ?>
				| <a href='<?php echo URL."passwords/one"; ?>' >Passwords</a>	
			<?php endif; ?>	
		</span>
		| <a href="<?php echo URL.'courses/settings/4'; ?>" >Courses</a>	
	</td></tr>

	<tr><td><a href='<?php echo URL."passwords/teachers"; ?>' >Teachers Passwords</a></td></tr>
	<tr><td><a href='<?php echo URL."registrars/setting/adv_switch"; ?>' >Advisers (1-Locked, 0-Open)</a></td></tr>



<!----------------------------------------------------------------------------------------------------->

	<tr><td> 
	<select class="vc50" onchange="getSubjects(this.value,'ls');" id='slid'  >
		<option value="0"> Lvl </option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select> 
	<span id='ls'>
		<select class="vc100" id='lsid' >
			<option>Subject</option>
		</select>
	</span>
	&nbsp; Go
	</td></tr>

<!----------------------------------------------------------------------------------------------------->


	<tr><td class="" > 
		  <a href='<?php echo URL."files/notes"; ?>' >*NOTES</a>
		| <a href='<?php echo URL."registrars/sxns"; ?>' >All Students</a></td></tr>

	<tr><td>
		Photos
		| <a href="<?php echo URL.'photos/one/'.$_SESSION['pcid']; ?>" >Find</a> 	
		<br /> <select class="" onchange="jsredirect('employees/photos/'+this.value);" >
		<option value="" >Roles</option>
		<option value="" >All</option>
		<?php foreach($roles AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select> &nbsp; Go	
	</td></tr>
	

	<tr><td>&nbsp;</td></tr>
</table><br />

<div class="ht50" >&nbsp;</div>

<script>

$(function(){
	shd();
	// $("#general").hide();	
})


</script>
