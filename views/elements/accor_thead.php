<?php 
	$user = $_SESSION['user'];

?>

<div class="accordParent" >	
<button onclick="accorToggle('thead')" style="width:262px;" class="bg-blue2" > <p class="b f16" >Teacher Head</p> </button>  	
<table id="thead" class="gis-table-bordered table-fx" >



<tr><td class="vc250" ><a href="<?php echo URL.'tcir'; ?>" >Classrooms Index Reports (CIR)</a></td></tr>
<tr><td><a href="<?php echo URL.'mca/locking'; ?>" >MCA (Locking)</a></td></tr>
<tr><td><a href="<?php echo URL.'classrooms/all'; ?>" >All Classrooms</a></td></tr>
<tr><td><a href="<?php echo URL.'passwords/teachers'; ?>" >Teachers Passwords</a></td></tr>


<tr><th class="center" >- Etc -</th></tr>
<tr><td><a href="<?php echo URL.'thead/cleanScores'; ?>" >Clean Scores</a></td></tr>


<tr><td>&nbsp;</td></tr>

</table>
</div>	<!-- accorParent -->
