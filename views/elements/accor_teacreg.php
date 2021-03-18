<?php 

	// pr($data);
	$classrooms = $data['classrooms'];
	$levels = $data['levels'];
?>




<div class="accordParent" >	
<button onclick="accorToggle('enrollment')" style="width:262px;" class="bg-blue2" > <p class="b f16" >Enrollment</p> </button>  	
<table id="enrollment" class="gis-table-bordered table-fx" >

<tr><td class="vc250" >
	  <a href="<?php echo URL.'files/read/enrollment'; ?>" >Enrollment Guide</a>
</td></tr>

<tr><td class="vc250" >
	<input class="pdl05" id="part"   />
	<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
</td></tr>


<tr><td class="vc250" >
	  1) <a href="<?php echo URL.'assessment/assess'; ?>" >Assessment</a>	  
	 | <a href="<?php echo URL.'profiles/student'; ?>" >Profile</a>
</td></tr>

<tr><td class="vc250" >
  	  2) <a target="_blank" href="<?php echo URL.'students/sectioner'; ?>" >Sectioner</a> 	  
	  &nbsp; 
	  &nbsp;
	 2A) <a href="<?php echo URL.'registration/one'; ?>" >Register</a>	  
</td></tr>




<tr><td>&nbsp;</td></tr>

</table>
</div>




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
