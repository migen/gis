<style>

#content div { float:left; }

</style>

<?php 

$qtr=$_SESSION['qtr'];

?>

<h3>
	Synclist | <?php $this->shovel('homelinks'); ?>
	| <?php include_once('links_synclist.php'); ?>
	
	
</h3>

<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'synclist/lvl/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> &nbsp;&nbsp; 
	<?php endforeach; ?>
</p>


<div>

<table class="synclist accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('synclist');" >Synclist</th></tr>
	<tr><th class="vc200" >INIT / Setup Table</th></tr>	
	<tr><td><a href="<?php echo URL.'synclist/syncTable?enrollments&exe'; ?>" >Enrollments</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?summaries&exe'; ?>" >Summaries</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?summext&exe'; ?>" >Summext</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?attd&exe'; ?>" >Attendance</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?ctp&exe'; ?>" >Ctp</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?profiles&exe'; ?>" >Profiles</a></td></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncTable?photos&exe'; ?>" >Photos</a></td></tr>
	<tr><th class="" >--- SyncAll ---</th></tr>
	<tr><td><a href="<?php echo URL.'synclist/syncAll'; ?>" >Sync All</a></td></tr>
	<tr><td>
		<a href="<?php echo URL.'synclist/crid/1'; ?>" >Crid</a>
		| <a href="<?php echo URL.'synclist/lvl/4'; ?>" >Lvl</a>	
	</td></tr>
	
</table>
</div>

<div class="" >
<?php include_once(SITE."views/elements/accor_syncboard.php"); ?>
</div>

