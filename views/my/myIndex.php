<?php 



?>

<h5>
	My Account
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'users/prefix'; ?>">Prefix</a>
	
</h5>


<table class="gis-table-bordered table-fx" >
<tr><th class="white bg-blue2 vc200" >Account</th></tr>

<?php  if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])): ?>
	<tr><td> <a href="<?php echo URL.'my/accounts'; ?>" >Accounts</a> </td></tr>	
	<tr><td> <a href="<?php echo URL.'passwords/account/'.$user['ucid']; ?>" >Change Username</a> </td></tr>
	<tr><td> <a href="<?php echo URL.'extra/securePassword/'.$user['account']; ?>" >Change Password</a> </td></tr>
	<tr><td> <a href="<?php echo URL.'files/read/tasks'; ?>" >Tasks - GIS</a> </td></tr>
	<tr><td> <a href="<?php echo URL.'contacts/ucis'; ?>" >Update Profile / UCIS </a> </td></tr>
<?php endif; ?>	

<?php if($_SESSION['user']['privilege_id']==0): ?>
	<tr><td> <a href="<?php echo URL.'contacts/staff'; ?>" >Staff</a> </td></tr>
<?php endif; ?>

<?php if(($_SESSION['srid']==RTEAC) && ($_SESSION['user']['privilege_id']==2)): ?>
	<tr><td><a target="_blank" href="<?php echo URL.'students/sectioner'; ?>" >Enrollment Sectioner</a></td></tr>	
<?php endif; ?>

<?php 
$srid=$_SESSION['srid'];
$dbroles=array(RMIS,RAXIS);
if(in_array($srid,$dbroles) && ($_SESSION['user']['privilege_id']==0)): ?>
	<tr><td> <a href="<?php echo URL.'db/box'; ?>" >GIS Box (Backup)</a> </td></tr>
<?php endif; ?>






</table>