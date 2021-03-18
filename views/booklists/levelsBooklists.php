<h3>
	Booklists Levels | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>

</h3>


<table class="gis-table-bordered" >
<tr>
	<th>Lvl</th>
	<th>Lvlname</th>
	<th>Booklist</th>
	<th>Sync</th>
</tr>
<?php foreach($levels AS $row): ?>
<tr>
	<th><?php echo $row['id']; ?></th>
	<th><?php echo $row['name']; ?></th>
	<th><a href="<?php echo URL.'booklists/level/'.$row['id']; ?>" >Booklist</a></th>
	<th><a href="<?php echo URL.'booklists/sync/'.$row['id']; ?>" >Sync</a></th>
</tr>
<?php endforeach; ?>
</table>
