<h5>
	Announcements	
	| <a href="<?php echo URL.'mis/announcementAdd/'.$sy; ?>" >Add</a>  
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

</h5>

<!------------------------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>Announcement</th>
	<th>By Whom</th>
	<th>Pos</th>
	<th>Active</th>
	<th>Manage</th>
</tr>

<?php $i=0; ?>
<?php foreach($announcements AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['announcement']; ?></td>
	<td><?php echo $row['announcement_by']; ?></td>
	<td><?php echo $row['position']; ?></td>
	<td><?php echo $row['is_active']; ?></td>
	<td>
		<a href="<?php echo URL.'mis/announcementEdit/'.$row['id'].DS.$sy; ?>" >Edit</a>  
	</td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>

</table>

<!--------------------------------------------------------------------------------------------------->

<!-- pagination -->
<p><?php  if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?></p>
