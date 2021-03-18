<?php 

	/* signatures */
	$adviser=$cr['adviser'];
	
	$vice_principal=$_SESSION['settings']['school_principal_'.$deptcode];
		
	$principal=$_SESSION['settings']['school_principal'];

	function is_free_classroom($db,$dbg,$crid){
		$q="SELECT cr.is_free FROM {$dbg}.05_classrooms AS cr WHERE cr.id='$crid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		return $row;	
	}	/* fxn */

	$ecrow=is_free_classroom($db,$dbg,$crid);
	$is_ec=($ecrow['is_free']==1)? 1:0;
	if($is_ec){ $principal=$_SESSION['settings']['principal_ec']; }
	

?>

<style>
	.signature{ width:300px;float:left; }
</style>

<p>

<div class="signature" align="center" >Prepared by: <br /><br /><br /><hr width="90%" /><?php echo $adviser; ?></div> 

<?php if(!$is_ec): ?>
	<div class="signature" align="center" >Checked and Noted by: <br /><br /><br /><hr width="90%" />
	<?php echo strtoupper($vice_principal); ?></div> 
<?php endif; ?> 

<div class="signature" align="center" >Checked & Approved by: <br /><br /><br /><hr width="90%" /><?php echo strtoupper($principal); ?></div> 

</p>


<div class="clear ht50 " ></div>
