<h5>
	Edit Announcement
	| <a href="<?php echo URL.'mis/announcements'; ?>">Announcements</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<!---------------------------------------------------------------------------------------->

<?php 

	// pr($data);
	
	
?>

<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr><th class="vc150" >By</th><td class="vc300" ><input name="announcement_by" class="full pdl05" value="<?php echo $announcement['announcement_by']; ?>"  /></td></tr>
<tr><th>Announcement</th><td><textarea name="announcement" class="full pdl05" ><?php echo $announcement['announcement']; ?></textarea></td></tr>
<tr><th>Position</th><td><input name="position" class="vc80 center" value="<?php echo $announcement['position']; ?>" /></td></tr>
<tr><th>Is Active</th><td><input name="is_active" class="vc80 center" value="<?php echo $announcement['is_active']; ?>" /></td></tr>
<tr><td colspan="2"><input type="submit" name="edit" value="Update"  /></td></tr>

</form>

</table>

