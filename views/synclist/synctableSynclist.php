<h3>
	Sync Table | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'synclist'; ?>" >Synclist</a>
	
	
</h3>

<table class="gis-table-bordered table-altrow gis-table-fx	" >
	<tr><th class="vc300" >INIT / Setup Table</th></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?enrollments&exe'; ?>" >Enrollments</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?summaries&exe'; ?>" >Summaries</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?summext&exe'; ?>" >Summext</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?attd&exe'; ?>" >Attendance</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?ctp&exe'; ?>" >Ctp</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?profiles&exe'; ?>" >Profiles</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?photos&exe'; ?>" >Photos</a></td></tr>
	<tr><th class="vc300" >--- SyncAll ---</th></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncAll'; ?>" >Sync All</a></td></tr>
	<tr><td>
		<a href="<?php echo URL.'synclist/crid/1'; ?>" >Crid</a>
		| <a href="<?php echo URL.'synclist/lvl/4'; ?>" >Lvl</a>	
	</td></tr>
	
</table>


