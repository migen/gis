<?php 

// pr($data);
// pr($_SESSION['q']);
$fullname    = trim($contact['name']);		
$name_array = explode(' ',$fullname);

$last_name   = isset($name_array[0])? trim(array_shift($name_array),',') : '';
$first_name   = trim(trim(implode(' ',$name_array),','));
$middle_name   = isset($name_array[1])? $name_array[1] : '';	


?>
<?php if($_SESSION['srid']!=RSTUD): ?>	<!-- not student -->
<div class="screen" >	<!-- links -->
<h5>
	Student Profile
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>


</div>	<!-- links -->



<?php endif; ?>	<!-- not student -->

<div style="float:left;width:20%;" class="hd screen" id="names" > </div>

<div style="float:left;width:100%;" >	<!-- profile -->
<?php 
if($scid){
	$page = "Student Profile";	
	$inc = SITE.'views/elements/letterhead_datetime_twologos.php';	
	echo "<div class='center' >";include($inc);echo "</div>";

	include_once('incs/form_student.php');
	
	
	
	
} 	/* scid */


?>

</div>	<!-- profile -->


<div class="clear ht100" ></div>

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


function collapseAll(){
	itago('trcontact');
	itago('trstudent');
	itago('trprofile');
}	/* fxn */


function expandAll(){
	ilabas('trcontact');
	ilabas('trstudent');
	ilabas('trprofile');
}	/* fxn */


</script>
