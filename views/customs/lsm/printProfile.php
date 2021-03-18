<?php 

// pr($_SESSION['q']);

?>

<h5>
	Student Profile
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'setup/students'; ?>">Registration</a>
	
</h5>


<div class="screen" >	<!-- filter -->
<?php 
	$d['contacts'] = $contacts;
	$d['new_customer'] = false;
	$d['nofocus'] = true;
	$this->shovel('filter_contacts',$d);
?>
</div><br /> <!-- filter -->

<div style="float:left;width:70%;border:1px solid black;" >	<!-- profile -->
<?php 
if($scid){
	$page="Student Profile";
	include_once('incs/profile.php');
} 


?>

</div>	<!-- profile -->

<div style="float:left;width:20%;" class="hd screen" id="names" > </div>

<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = "<?php echo $_SESSION['home']; ?>";


$(function(){
	nextViaEnter();
	
	
})	/* fxn */

function redirContact(ucid){
	var url = gurl + '/profiles/student/'+ucid;	
	window.location = url;		
}


</script>
