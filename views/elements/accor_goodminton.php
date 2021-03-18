<?php 
	$user = $_SESSION['user'];
	// pr($user); 
?>

<div class="accordParent" >	
<button onclick="accorToggle('hris')" style="width:262px;" class="bg-blue2" > <p class="b f16" >HRIS</p> </button>  	
<table id="hris" class="gis-table-bordered table-fx" >



<tr><th class="center" >Admin</th></tr>
<tr><td class="vc250" ><a href="<?php echo URL.'goodminton/players?all'; ?>" >Players</a></td></tr>

<tr><td>
	<a href="<?php echo URL.'edtr'; ?>" >EDTR</a>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
</td></tr>





<tr><td>&nbsp;</td></tr>

</table>
</div>	<!-- accorParent -->
