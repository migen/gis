<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>


<table class="axis accordion gis-table-bordered table-altrow" >
	<tr><th style="widtd:250px;" class="accorHeadrow" onclick="accordionTable('axis');" >AXIS (Accounting)</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.'mini'; ?>" >Mini Controller</a>
	</td></tr>

	<tr><th class="vc300 headrow" onclick="accordionTable('links');" >Links</th></tr>
	<tr><td><a href="<?php echo URL.'abc/methods'; ?>" >Class Methods</a></td></tr>
	<tr><td><a href="<?php echo URL.'axn/session'; ?>" >Axn Session</a></td></tr>
	<tr><td><a href="<?php echo URL.'products/all'; ?>" >Products</a></td></tr>
	<tr><td><a href="<?php echo URL.'bootstrap'; ?>" >Bootstrap</a></td></tr>
	<tr><td><a href="<?php echo URL.'animals'; ?>" >Animals / Links</a></td></tr>
	<tr><td><a href="<?php echo URL.'data/migrate'; ?>" >Aipos Migrate</a></td></tr>
	<tr><td><a href="<?php echo URL.'opos'; ?>" >Ai-POS</a></td></tr>
	<tr><td><a href="<?php echo URL.'posts'; ?>" >Posts API traversy</a></td></tr>
	<tr><td><a href="<?php echo URL.'swot'; ?>" >SWOT</a></td></tr>
	<tr><td>
		Filter - <a href="<?php echo URL.'courses/filter'; ?>" >Course</a>
		| <a href="<?php echo URL.'scores/filter'; ?>" >Scores</a>	
	</td></tr>
	<tr><td><a href="<?php echo URL.'db'; ?>" >DB</a></td></tr>
	<tr><td><a href="<?php echo URL.'students/portal'; ?>" >Student Portal</a></td></tr>
	<tr><td><a href="<?php echo URL.'txns/stack'; ?>" >DB Stack / Txns</a></td></tr>
	<tr><td><a href="<?php echo URL.'college'; ?>" >College</a></td></tr>
	<tr><td><a href="<?php echo WURL.'gogo'; ?>" >Gogo App for Parent & Student</a></td></tr>
	<tr><td><a href="<?php echo URL.'studyears/crid'; ?>" >Studyears Filter Redirect</a></td></tr>
	<tr><td><a href="<?php echo URL.'onemany'; ?>" >One Many</a></td></tr>
	<tr><td><a href="<?php echo URL.'uni/baid'; ?>" >Books Authors</a></td></tr>
	<tr><td><a href="<?php echo URL.'uni/tables'; ?>" >Uni Tables</a></td></tr>
	<tr><td><a href="<?php echo URL.'css/tabs'; ?>" >CSS Tabs</a></td></tr>
	<tr><td><a href="<?php echo URL.'accordion/div'; ?>" >Accordion Div</a></td></tr>
	<tr><td><a href="<?php echo URL.'accordion'; ?>" >Accordion Table</a></td></tr>

	<tr><td>-- --</td></tr>
	<tr><td><a href="<?php echo URL.'records'; ?>" >Records</a></td></tr>



</table>




