<h5> 
	Student Dashboard 
	<?php $this->shovel('homelinks','students/dashboard'); ?>

</h5>


<table class="gis-table-bordered table-fx table-altrow" >
	<tr><th class="headrow white vc200" > Menu </th></tr>
	<tr><td class="vc200" ><a href="<?php echo URL.'students/teachers'; ?>" > Teacher Evaluation </a></td></tr>
	<tr><td class="vc200" ><a href="<?php echo URL.'extra/securePasswordStudent/'.$_SESSION['user']['code']; ?>" > Change Password </a></td></tr>

	<tr><td class="vc200" >
	<?php
		if($_SESSION['student']['profile']['is_finalized']){
			echo "<p><a href='".URL."profiles/student'>Profle</a></p>";  				
		} else {
			echo "<p><a href='".URL."students/editContact/".$_SESSION['user']['contact_id']."'>Accomplish Profle</a></p>";  				
		}			
	?>
	</td></tr>
	
</table>


