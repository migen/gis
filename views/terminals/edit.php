<?php 

	// pr($data);
	// pr($level);
	
?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Edit Terminal | 
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'mis/subjects'; ?>">Subjects</a>
	
	
</h5>

<!------------------------------------------------------------------------------------------------------------------------>

<form method="POST" >
<table class="gis-table-bordered table-fx" >

	<tr><th class="headrow white">Group</th><td><input class="pdl05" name="terminal[group]" value="<?php echo $terminal['group']; ?>" ></td></tr>
	<tr><th class="headrow white">Code</th><td><input maxlength="4" class="pdl05" name="terminal[code]" value="<?php echo $terminal['code']; ?>" ></td></tr>
	<tr><th class="headrow white">Name</th><td><input class="pdl05" name="terminal[name]" value="<?php echo $terminal['name']; ?>" ></td></tr>
	<tr><th class="headrow white">IP</th><td><input class="pdl05" name="terminal[ip]" value="<?php echo $terminal['ip']; ?>" ></td></tr>
	<tr><th class="headrow white">Location</th><td><input class="pdl05" name="terminal[location]" value="<?php echo $terminal['location']; ?>" ></td></tr>

<tr><th colspan="2" ><input class="vc100" type="submit" name="submit" value="Go" />

<input type="hidden" name="terminal[id]" value="<?php echo $terminal['id']; ?>" />

<button><a href="<?php echo URL.'mis/terminals'; ?>" class="no-underline" >Cancel</a></button>
</th></tr>
</table>

</form>



