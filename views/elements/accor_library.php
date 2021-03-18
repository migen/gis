<?php 
	$user = $_SESSION['user'];

	
?>

<table class="library accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('library');" >Library</th></tr>

<tr><td class="vc250" >
	  <a href="<?php echo URL.'patrons/visit'; ?>" >*Patrons Visit</a>
	| <a href="<?php echo URL.'librarians'; ?>" >Home</a>	
	| <a href="<?php echo URL.'librarians/reset'; ?>" >Reset</a>	
</th></tr>

<tr><td> 
	Photos
	| <a href="<?php echo URL.'photos/one/'.$_SESSION['pcid']; ?>" >Find</a> 
	
| <select class="vc100" onchange="looper('employees,photos,'+this.value);" >
	<option value="" >Roles</option>
	<option value="" >All</option>
	<?php foreach($roles AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go	
	
</td></tr>


<tr><th>
Reports - <a href="<?php echo URL.'librarians/patrons'; ?>" >Detls</a>
| <a href="<?php echo URL.'librarians/stats'; ?>" >Summary</a>
</th></tr>

<tr><th>
Libstats - <a href="<?php echo URL.'libstats/index'; ?>" >Index</a>
| <a href="<?php echo URL.'libstats/month'; ?>" >Month</a>
</th></tr>

<?php if($user['role_id']==RMIS): ?>
<tr><th>
	  <a href="<?php echo URL.'subdepts/ip'; ?>" >IP</a>
	| <a href="<?php echo URL.'subdepts'; ?>" >Subdepts</a>
<?php if(!isset($_SESSION['library_photos'])){ require_once(SITE.'views/customs/'.VCFOLDER.'/customs.php'); }  ?>
<?php // if(isset($_SESSION['library_photos']) && $_SESSION['library_photos']): ?>
<?php if($_SESSION['library_photos']): ?>
	| <a href="<?php echo URL.'librarians/crlist'; ?>" >Photos Crlist</a>
<?php endif; ?>	
</th></tr>
<?php endif; ?>


<tr><td>&nbsp;</td></tr>
</table>
