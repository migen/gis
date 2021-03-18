<div class="accordParent" >	
<button onclick="accorToggle('settings')" style="width:262px;" class="bg-blue2" > <p class="b f16" >Settings</p> </button>  	
<table id="settings" class="gis-table-bordered table-fx" >
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

<tr><td class="vc250 b" >*<a href="<?php echo URL.'files/notes'; ?>" >NOTES</a>
| <a href="<?php echo URL.'files/index'; ?>" >FILES</a>
| <a href="<?php echo URL.'files/edit/version'; ?>" >Version</a>
| <a target='blank' href="<?php echo URL.'mis/pdf'; ?>" >PDF</a>
</td></tr>

<tr><td>
		*<a href="<?php echo URL.'info'; ?>" >Info</a>
		| <a href="<?php echo URL.'data/levels'; ?>" >Batch</a>
		| <a href="<?php echo URL.'mis/levels/'.$sy; ?>" > LEVELS </a>		
	</td>
</tr>

<tr><td>
	*<a href="<?php echo URL.'settings/all/'.$sy; ?>" >Settings</a>
	| <a href="<?php echo URL.'locking/controls/'.DBYR; ?>" >Locking</a>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>
</td></tr>


<tr><td>&nbsp;</td></tr>
</table>
</div>