<?php 

	$classrooms = $data['classrooms'];
	$levels = $data['levels'];
	$has_axis=$_SESSION['settings']['has_axis'];
	
?>


<table class="registrars accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('registrars');" >GIS Reports</th></tr>


<tr><td><a class="b" href="<?php echo URL.'cir/index'; ?>" >*CLASS INDEX REPORTS (CIR)</a></td></tr>

<tr><td>
	  <a href="<?php echo URL.'clearance/one'; ?>" >Clearance</a>
	| <a href="<?php echo URL.'transcripts/scid'; ?>" >Transcript</a>
</td></tr>

 


<?php if($_SESSION['settings']['trsgrades']==1): ?>
<tr><td>
<select class="vc200" onchange="jsredirect('trs/matrix/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0">Traits Matrix</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td></tr>
<?php endif; ?>







<tr><td class="center" >- ETC -</td></tr>
<tr><td>
	  <a href="<?php echo URL.'clubs/all'; ?>" >Clubs</a>
	| <a href="<?php echo URL.'foundation'; ?>" >Foundation</a>
	| <a href="<?php echo URL.'shs'; ?>" >SHS</a>

</td></tr>


<tr><td>*After Promotion - newSY DB*</td></tr>
<tr><td>
	<a href="<?php echo URL.'rosters/classroom'; ?>" >Roster (Section)</a>
 |  <a href="<?php echo URL.'rosters/batch'; ?>" >Batch</a>
 |  <a href="<?php echo URL.'rosters/sync'; ?>" >Sync</a>
</td></tr>
<tr><td><a href="<?php echo URL.'students/sectioner'; ?>" > Sectioner (Student) </a></td></tr>

<tr><td>&nbsp;</td></tr>
</table>


<script>
var limits="20";

$(function(){
	// $("#registrars").hide();	
})

function redirContact(ucid){
	var url = gurl + '/students/sectioner/' + ucid + '/' + sy;
	window.open(url);
	
}


</script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
