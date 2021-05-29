<h3>
	Booklists Levels SY<?php echo $sy; ?>
	| <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>

</h3>


<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>Lvl</th>
	<th>Lvlname</th>
	<th>Booklist</th>
	<th>Edit</th>
	<th>View</th>
	<th>Sync</th>
</tr>
<?php foreach($levels AS $row): ?>
<tr>
	<th><?php echo $row['id']; ?></th>
	<th><?php echo $row['name']; ?></th>
	<th><a href="<?php echo URL.'booklists/level/'.$row['id'].'?num=1'; ?>" >Booklist</a></th>
	<th><a href="<?php echo URL.'booklists/level/'.$row['id'].'?edit&num=1'; ?>" >Edit</a></th>
	<th><a href="<?php echo URL.'booklists/view/'.$row['id'].'?num=1'; ?>" >View</a></th>
	<th><a>Sync</a></th>
</tr>
<?php endforeach; ?>
</table>
