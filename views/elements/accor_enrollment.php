<?php 

	// pr($data);
	// $classrooms = $data['classrooms'];
	// $levels = $data['levels'];
	$has_axis=$_SESSION['settings']['has_axis'];
	
?>

<table class="enrollment accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('enrollment');" >Enrollment</th></tr>

<tr><td>
	  <a href="<?php echo URL.'files/read/enrollment'; ?>" >Enrollment Guide</a>
</td></tr>

<tr><td>
	<input class="pdl05 full" id="part"   /><br />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
</td></tr>



<tr><td>
  	  1) <a target="_blank" href="<?php echo URL.'students/sectioner'; ?>" >Sectioner</a> 	  
	 | <a href="<?php echo URL.'students/register'; ?>" >Register</a>	  
</td></tr>

<tr><td>
	   <a href="<?php echo URL.'students/datasheet'; ?>" >Datasheet</a>
</td></tr>

<?php if($has_axis): ?>
	<tr><td  >
		  2) <a href="<?php echo URL.'students/assessment'; ?>" >Assessment</a>	  
	</td></tr>
<?php endif; ?>

<tr><td  >
	  4) <a href="<?php echo URL.'reglists'; ?>" >Filter</a>
	  | <a href="<?php echo URL.'students/links'; ?>" >Links</a>
	  | <a href="<?php echo URL.'enrollees/official/'.DBYR; ?>" >Official</a>
</td></tr>


<tr><td  >
	  5) <a href="<?php echo URL.'tsum/scid'; ?>" >Tuition Summary</a>
</td></tr>

<tr><td>--- Admin ---</td></tr>
<tr><td  >
	  6) <a href="<?php echo URL.'syncs/enrollments'; ?>" >Sync Enrollments</a>
	  | <a href="<?php echo URL.'scid/promoter'; ?>" >Promoter</a>
</td></tr>


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
