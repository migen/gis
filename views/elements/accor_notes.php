<?php 
	
	$dbo=PDBO; 

?>

<table class="notes accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('notes');" >Notes</th></tr>


<tr><td>
	<a class="b" href='<?php echo URL."files/edit/version"; ?>' >Version</a>
</td></tr>

<tr><td>
	  <a class="" href="<?php echo URL.'tasks'; ?>" >Tasks</a>
	| <a class="" href="<?php echo URL.'tasks/add'; ?>" >Add</a>
	| <a class="" href="<?php echo URL.'iso'; ?>" >ISO</a>
</td></tr>

<?php 	
	$one = array('version','transition'); 
	$two = isset($_SESSION['settings']['files'])? explode(',',$_SESSION['settings']['files']):array();
	$files = array_merge($one,$two);	
?>

<tr><td>
<select class="full" onchange="jsredirect('files/read/'+this.value);" >
	<option value="" >Files</option>
	<?php foreach($files AS $file): ?>
		<option><?php echo $file; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><td class="b" >*<a href="<?php echo URL.'files/notes'; ?>" >NOTES</a>
| <a href="<?php echo URL.'files/index'; ?>" >FILES</a>
| <a target='blank' href="<?php echo URL.'mis/pdf'; ?>" >PDF</a>
</td></tr>

<tr><td class="b" >
  <a href="<?php echo URL.'config/updates.php'; ?>" >Updates</a>
| <a href="<?php echo URL.'files/edit/version'; ?>" >Version</a>
| <a href="<?php echo URL.'info'; ?>" >Info</a>
</td></tr>



<tr><td>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'links'; ?>" >Links</a>
	| <a href="<?php echo URL.'snippets'; ?>" >Snippets</a>
</td></tr>


<tr><td>&nbsp;</td></tr>


</table>




