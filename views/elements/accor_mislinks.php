<?php 
	
	$dbo=PDBO; 

?>

<table class="mislinks accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('mislinks');" >MIS Links</th></tr>

<tr><td>
	<a class="" href='<?php echo URL."finance"; ?>' >Finance</a>
</td></tr>


<tr><td>
	<a class="" href='<?php echo URL."sessions"; ?>' >Sessions</a>
	| <a href="<?php echo URL.'sessions/unsetter'; ?>" >Unsetter</a>
	| <a class="" href='<?php echo URL."synclist"; ?>' >Synclist</a>
</td></tr>

<tr><td>
	Students - <a class="" href='<?php echo URL."students"; ?>' >Home</a>
	| <a class="" href='<?php echo URL."students/links"; ?>' >Links</a>
	| <a class="" href='<?php echo URL."setup/students"; ?>' >Setup</a>
</td></tr>


<tr><td>
	<a class="b" href='<?php echo URL."gset"; ?>' >GSET</a>
	| <a class="" href='<?php echo URL."syncs"; ?>' >Syncs</a>
	| <a class="" href='<?php echo URL."purge"; ?>' >Purge</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."enrollment"; ?>' >Settings</a>
	| <a class="b" href='<?php echo URL."enrollment"; ?>' >Enrollment</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."logs"; ?>' >Logs</a>
	| <a class="" href='<?php echo URL."mis/query"; ?>' >Query</a>
	| <a class="b" href='<?php echo URL."misc"; ?>' >Misc</a>
</td></tr>

<tr><td>
	<a class="b" href='<?php echo URL."records/dbtables"; ?>' >Records</a>
	| <a class="" href='<?php echo URL."locking/controls/".DBYR; ?>' >Locking</a>
	| <a class="" href='<?php echo URL."tools/methods"; ?>' >Methods</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."setup/grading"; ?>' >Setup</a>
	| <a class="" href='<?php echo URL."stats"; ?>' >Stats</a>
	| <a class="" href='<?php echo URL."data"; ?>' >Data</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'sectioning/crid'; ?>" >Class Sectioning</a>
	| <a href="<?php echo URL.'sectioning/level'; ?>" >Level</a>
</td></tr>

<tr><td ><a href="<?php echo URL.'advisers/classroomsIndex'; ?>" >Attendance Daily Students</a></td></tr>

<tr><td>&nbsp;</td></tr>


</table>




