<?php 

	// pr($_SESSION); 
	$user = $_SESSION['user']; 
	
?>


<h5> 
	Student Dashboard 
	<?php $this->shovel('homelinks','students/dashboard'); ?>

	
</h5>


<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th class="headrow white vc200" > Menu </th></tr>
		
	<?php if(HASGCIS==1): ?>
		<tr><td class="vc200" ><a href="<?php echo URL.'students/myTeachers'; ?>" > Teachers Evaluation </a></td></tr>
	<?php endif; ?>
	
	<tr><td class="vc200" ><a href="<?php echo URL.'extra/securePasswordStudent/'.$_SESSION['user']['code']; ?>" > Change Password </a></td></tr>

	<tr><td class="vc200" >
		<a href="<?php echo URL.'contacts/ucis/'.$user['ucid']; ?>"  >Profile</a>
	</td></tr>
	
</table>


