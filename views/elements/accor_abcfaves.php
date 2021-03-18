

<table class="faves accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('faves');" >Faves</th></tr>
<tr><td  >
	  <a href="<?php echo URL.'codename/one'; ?>" >Code</a>&nbsp;<a href="<?php echo URL.'codename/name'; ?>" >Name</a>
	| <a class="b" href="<?php echo URL.'cirr'; ?>" >*CIRR(DO)</a>	
	| <a class="b" href="<?php echo URL.'lir'; ?>" >*LIR</a>	
</td></tr>
<tr><td><a class="b" href="<?php echo URL.'cir/index'; ?>" >*CLASS INDEX REPORTS (CIR)</a></td></tr>
<tr><td>
	<a class="b" href="<?php echo URL.'cir/index?ext'; ?>" >Ext CIR</a>
	| <a class="b" href="<?php echo URL.'cir/cert'; ?>" >Cert CIR</a>
</td></tr>


<tr><td>
<?php if($_SESSION['settings']['trsgrades']==1): ?>
	<a class="" href="<?php echo URL.'trs/tir'; ?>" >Trs Index (TIR)</a>
<?php endif; ?>	
</td></tr>

<tr><td> 
<select class="vc200" onchange="jsredirect('mca/locking/'+this.value);" >
	<option value="0">Advisories & Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>

<tr><td>
	  <a class="" href="<?php echo URL.'mgt/contacts'; ?>" >Contacts</a>
	|  <a class="" href="<?php echo URL.'contacts'; ?>" >Links</a>
</td></tr>

<tr><td>
	<a class="" href="<?php echo URL.'students/links'; ?>" >Student</a>
	| <a class="" href="<?php echo URL.'mis/teachers'; ?>" >Teac</a>
	| <a class="" href="<?php echo URL.'mis/advisers'; ?>" >Advi</a>
</td></tr>

<tr><td>
	  <a class="" href="<?php echo URL.'crs/crid'; ?>" >Crs-Crid</a>
	| <a class="" href="<?php echo URL.'cr/index'; ?>" >CR List</a>
	| <a class="" href="<?php echo URL.'cr/level/4'; ?>" >CR Level</a>
</td></tr>

<tr><td>
	  <a class="" href="<?php echo URL.'tasks'; ?>" >Tasks</a>
	| <a class="" href="<?php echo URL.'tasks/add'; ?>" >Add</a>
	| <a class="" href="<?php echo URL.'iso'; ?>" >ISO</a>
	| <a href="<?php echo URL.'sessions/unsetter'; ?>" >Unsetter</a>
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

<tr><td class="vc250 b" >*<a href="<?php echo WURL.'gogo/files/notes'; ?>" >NOTES</a>
| <a href="<?php echo WURL.'gogo/files/index'; ?>" >FILES</a>
| <a href="<?php echo WURL.'gogo/files/edit/version'; ?>" >Version</a>
| <a target='blank' href="<?php echo URL.'mis/pdf'; ?>" >PDF</a>
</td></tr>

<tr><td>
		*<a href="<?php echo URL.'info'; ?>" >Info</a>
		| <a href="<?php echo URL.'data/levels'; ?>" >Batch</a>
		| <a href="<?php echo URL.'mis/levels/'.$sy; ?>" > LEVELS </a>		
		| <a href="<?php echo URL.'ibook'; ?>" >iBook</a>		
	</td>
</tr>

<tr><td>
	  <a href="<?php echo URL.'locking/controls/'.DBYR; ?>" >Locking</a>
	| <a href="<?php echo URL.'db/box'; ?>" >Gisbox</a>
	| <a href="<?php echo URL.'snippets'; ?>" >Snippets</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'links'; ?>" >Links</a>
	| <a href="<?php echo URL.'clearance/one'; ?>" >Clearance</a>
	| <a href="<?php echo WURL.'gogo'; ?>" >Gogo</a>
</td></tr>

<tr><td>
	  <a href="<?php echo URL.'scores/filter/'.DBYR.'/'.$_SESSION['qtr']; ?>" >Scores Filter</a>
</td></tr>

<tr><td>&nbsp;</td></tr>


</table>




