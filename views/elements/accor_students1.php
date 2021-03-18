<?php 
	// $user = $_SESSION['user'];
// pr($data);

$ucid=$data['ucid']
	
?>

<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>

<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></th></tr>
<tr><th><a href='<?php echo URL."rcards/scid/"; ?>' >Report Card</a></th></tr>
<tr><th><a href='<?php echo URL."portals/pass"; ?>' >Change Password</a></th></tr>
<tr><th><a href='<?php echo URL."studs/classes/$ucid"; ?>' >Classes</a></th></tr>
<tr><th><a href='<?php echo URL."students/enrollment/$ucid"; ?>' >Enrollment</a></th></tr>

<tr><td>&nbsp;</td></tr>
</table>


