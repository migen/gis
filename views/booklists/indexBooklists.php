<h3>
	Booklists | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>


</h3>



<table class="data accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('data');" >Data</th></tr>


	<tr><td style="width:250px;" ><a href="<?php echo URL.'booklists/table'; ?>" >Booklists</a></td></tr>
	<tr><td style="width:250px;" ><a href="<?php echo URL.'booklists/manager'; ?>" >Manager</a></td></tr>
	<tr><td><a href="<?php echo URL.'booklists/levels'; ?>" >Levels</a></td></tr>
	<tr><td><a href="<?php echo URL.'students/booklist'; ?>" >Student</a></td></tr>

</table>



