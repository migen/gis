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
	<tr><td><a href="<?php echo URL.'records'; ?>" >Records</a></td></tr>
	<tr><td><a href="<?php echo URL.'bootstrap'; ?>" >Bootstrap CSS</a></td></tr>
	<tr><td><a href="<?php echo URL.'p5'; ?>" >P5JS</a></td></tr>
	<tr><td><a href="<?php echo URL.'react'; ?>" >React</a></td></tr>



</table>


<div class="ht100" ></div>
