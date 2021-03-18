<?php 
// pr($cr);
$teacher=$cr['adviser'];
$vice_principal=$_SESSION['settings']['school_principal_'.$deptcode];
$principal=$_SESSION['settings'];
function is_free_classroom($db,$dbg,$crid){
	$q="SELECT cr.is_free FROM {$dbg}.05_classrooms AS cr WHERE cr.id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;	
}	/* fxn */

$ecrow=is_free_classroom($db,$dbg,$crid);
$is_ec=($ecrow['is_free']==1)? 1:0;
if($is_ec){ $principal=$_SESSION['settings']['principal_ec']; }

$principal=$_SESSION['settings']['school_principal'];
if($is_ec){ $principal=$_SESSION['settings']['principal_ec']; }


?>

<style>
	.signature{ width:250px;float:left; }
</style>

<p>

<div class="signature" align="center" >Submitted by: <br /><br /><br /><hr width="80%" /><?php echo $teacher; ?></div> 

<?php if(!$is_ec): ?>
	<div class="signature" align="center" >Noted by: <br /><br /><br /><hr width="80%" /><?php echo strtoupper($vice_principal); ?></div> 
<?php endif; ?> 

<div class="signature" align="center" >Approved by: <br /><br /><br /><hr width="80%" /><?php echo strtoupper($principal); ?></div> 

</p>

