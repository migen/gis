<h5>
	Subjects
	| <?php $this->shovel('homelinks'); ?>

</h5>



<table class="links gis-table-bordered table-fx" >
	<tr><th class="vc300 headrow" onclick="accordionTable('links');" >Links</th></tr>
	<tr><td><a href="<?php echo URL.'classrooms/level&all'; ?>" >All Classrooms</a></td></tr>
	<tr><td><a href="<?php echo URL.'gset/renameClassrooms/'.DBYR; ?>" >Rename Classrooms</a></td></tr>
	<tr><td><a href="<?php echo URL.'gset/initClassrooms/'.DBYR; ?>" >Init Classrooms</a></td></tr>

	<tr><td>-- --</td></tr>
	<tr><td><a href="<?php echo URL.'records'; ?>" >Records</a></td></tr>



</table>


<div class="ht100" ></div>
