<?php 
	
	$dbo=PDBO; 

?>

<table class="faves accordion gis-table-bordered table-altrow" >
<tr><th class="accorHeadrow" onclick="accordionTable('faves');" >MIS Faves</th></tr>

<tr><td>
	<a class="b" href='<?php echo URL."notes"; ?>' >Notes</a>
	| <a class="b" href='<?php echo URL."files/edit/version"; ?>' >Version</a>	
	| <a class="b" href='<?php echo URL."files/read/cases"; ?>' >Cases</a>	
</td></tr>



<tr><td><a class="b" href="<?php echo URL.'cir'; ?>" >*Class Index Report ( C I R )</a></td></tr>
<tr><td><a class="b" href="<?php echo URL.'lir'; ?>" >*LEVEL Index Report ( L I R )</a></td></tr>

<tr><td  >
	<a class="b" href="<?php echo URL.'cir/cert'; ?>" >Cert CIR</a>
	| <a class="b" href="<?php echo URL.'cir/index?ext'; ?>" >Ext CIR</a>
	| <a class="" href="<?php echo URL.'cir/index'; ?>" >C I R R</a>	
</td></tr>


<tr><td> 
<select class="vc200" onchange="jsredirect('mca/locking/'+this.value);" >
	<option value="0">Advisories & Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
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


<tr><td class="b" >
	<a class="" href='<?php echo URL."finance"; ?>' >Finance</a>
	| <a class="" href='<?php echo URL."registrars"; ?>' >Registrar</a>
	| <a class="" href='<?php echo URL."links/mis"; ?>' >Links</a>
</td></tr>

<tr><td>
	<span class="b" >Students</span> - <a class="" href='<?php echo URL."students"; ?>' >Portal</a>
	| <a class="" href='<?php echo URL."students/links"; ?>' >Links</a>
	| <a class="" href='<?php echo URL."setup/students"; ?>' >Setup</a>
</td></tr>

<tr><td>
	<a class="b" href='<?php echo URL."misdata/index"; ?>' >MIS Data</a>
</td></tr>

<tr><td>
	<a class="b" href='<?php echo URL."links/devtools"; ?>' >Devtools</a>
	| <a class="b" href='<?php echo URL."links/axis"; ?>' >Axis</a>
	| <a class="b" href='<?php echo URL."links/etc"; ?>' >Misc</a>
</td></tr>

<tr><td>
	<a class="b" href='<?php echo URL."gset"; ?>' >GSET</a>
	| <a class="" href='<?php echo URL."syncs"; ?>' >Syncs</a>
	| <a class="" href='<?php echo URL."purge"; ?>' >Purge</a>	
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."sessions"; ?>' >Sessions</a>
	| <a href="<?php echo URL.'sessions/unsetter'; ?>" >Unsetter</a>
	| <a class="" href='<?php echo URL."synclist"; ?>' >Synclist</a>
</td></tr>




<tr><td>
	<a class="" href='<?php echo URL."enrollment"; ?>' >Settings</a>
	| <a class="b" href='<?php echo URL."enrollment"; ?>' >Enrollment</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."logs"; ?>' >Logs</a>
	| <a class="" href='<?php echo URL."logs/v2"; ?>' >V2</a>
	| <a class="" href='<?php echo URL."mis/query"; ?>' >Query</a>
</td></tr>

<tr><td>
	<a class="b" href='<?php echo URL."records/dbtables"; ?>' >Records</a>
	| <a class="" href='<?php echo URL."locking/controls/".DBYR; ?>' >Locking</a>
	| <a class="" href='<?php echo URL."tools/methods"; ?>' >Methods</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."setup/grading"; ?>' >Setup</a>
	| <a class="" href='<?php echo URL."stats"; ?>' >Stats</a>
	| <a class="" href='<?php echo URL."data"; ?>' >Data</a>
</td></tr>
<tr><td>&nbsp;</td></tr>

<?php if($_SESSION['settings']['has_axis']==1): ?>
	<tr><td class="center b" >AXIS Faves</td></tr>
	<tr><td class="" >
		  <a target="_blank" href="<?php echo URL.'enrollment/ledger'; ?>" >Ledger</a>
		| <a href="<?php echo URL.'tuitions/table/'.$_SESSION['settings']['sy_enrollment']; ?>" >Tuitions</a>	
		| <a href="<?php echo URL.'tfeetypes/table'; ?>" >Fees</a>		
	</td></tr>

	<tr><td>&nbsp;</td></tr>
<?php endif; ?>



<tr><td class="center b" >Temp Dev</td></tr>
<tr><td>
	Payables - 
	<a class="" href='<?php echo URL."syncPayables/index"; ?>' >Links</a>
	| <a class="" href='<?php echo URL."payables/batch"; ?>' >Add/Destroy</a>
</td></tr>

<tr><td>
	Payables - 
	<a class="" href='<?php echo URL."syncPayables/batchUpdate"; ?>' >Replace/Update</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."ensteps/student"; ?>' >Ensteps</a>
	| <a class="" href='<?php echo URL."schedules/classroom"; ?>' >Schedules</a>
	| <a class="" href='<?php echo URL."students"; ?>' >Portal</a>
</td></tr>

<tr><td>
	<a class="" href='<?php echo URL."help"; ?>' >Documentation Help</a>
</td></tr>

<tr><td>&nbsp;</td></tr>


</table>




