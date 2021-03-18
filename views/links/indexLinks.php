<h5>
	Links (Snippets)
	| <?php $this->shovel('homelinks'); ?>

</h5>


<?php if($_SESSION['pcid']==1): ?>
<table class="root gis-table-bordered table-altrow" >
<tr><th class="headrow vc300" onclick="accordionTable('root');" >Root</th></tr>
<tr><td>  <a href="<?php echo URL.'clients'; ?>" >Clients</a>
		| <a href="<?php echo URL.'clients/info'; ?>" >Info</a></td></tr>
<tr><td><a href="<?php echo URL.'clients/info'; ?>" >Clients Info</a></td></tr>

</table>
<br />
<?php endif; ?>	<!-- root -->


<table class="nest gis-table-bordered table-altrow" >
<tr><th colspan=3 class="headrow vc300" onclick="accordionTable('nest');" >Nest</th></tr>
<tr><td>aaa</td><td>bbb</td><td>ccc</td></tr>

</table>
<br />

<table class="links gis-table-bordered table-fx" >
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


<div class="ht100" ></div>
