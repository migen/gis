<!--	style="height:200px;" 

-->

<style></style>
<script></script>

<?php 


// $this->shovel('border');

$has_crm  = (isset($_SESSION['settings']['has_crm']) && $_SESSION['settings']['has_crm']==1)? true:false;
$has_rfid = (isset($_SESSION['settings']['has_rfid']) && $_SESSION['settings']['has_rfid']==1)? true:false;


if(isset($_SESSION['user'])){
	$user	= $_SESSION['user'];
	$home	= $role = $_SESSION['home'];
	$srid 	= $user['role_id'];	

	$trp = $user['role_id'].'-'.$user['privilege_id'];
	$up = 'U#'.$user['ucid'];
	$up .= ($user['ucid']!=$user['pcid'])? 'P#'.$user['pcid']:NULL;   
		
} 
  
  
?>


<div class="screen" id="smartlinks" >
<table class="" ><tr>
	<td class="" >&nbsp;</td>
	
	
	
	<td class="" >
	
	<?php if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])): ?>
		H<a class="no-underline " href="<?php echo URL.'users/session'; ?>">i</a> <?php echo $guardian=NULL; ?> 
		<span id="<?php echo $user['username'].'-'.$user['role'].' TRP: '.$trp.' '.$up; ?>" onclick="alert(this.id);" class='bold' >
			<?php echo $user['fullname']; ?> </span> 
			&nbsp; &nbsp; &nbsp; 
		<a href="<?php echo URL.'users/logout'; ?>"  >Logout</a> 
		| <a href='<?php echo URL.$home; ?>' >Home</a>	
		
	<?php else: ?>
		<a href="<?php echo URL.'users/login'; ?>" >Login</a>

	<?php endif; ?>		

	<?php if($has_crm): ?>	
		| <a href="<?php echo URL.'rooms'; ?>" >CRM</a>
	<?php endif; ?>	
	

<?php if($has_rfid==1): ?>	
	<?php if(loggedin() && ($user['role_id']==RMIS)): ?>

	<?php endif; ?>
<?php endif; ?>
				
	
	
	<?php $ssy = (isset($_SESSION['sy']))? '| SY '.$_SESSION['sy'] : NULL; echo $ssy; ?>
	<?php $sqtr = (isset($_SESSION['qtr']))? '- Q'.$_SESSION['qtr'] : NULL; echo $sqtr; ?>
	
	
	</td>


	
	
</tr></table>
</div>
