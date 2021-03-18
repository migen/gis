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
	Student Profile | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."profiles/scid/$scid"; ?>'>Dynamic</a>
	| <a href='<?php echo URL."photos/one/$scid"; ?>'>Photo</a>
	| <a href='<?php echo URL."codename/one/$scid"; ?>'>Codename</a>
	| <a href="<?php echo URL.'reservations/acknowledgement/'.$scid.DS.$sy; ?>">Acknowledgement</a>
	| <a href="<?php echo URL.'registration/one'; ?>">Register</a>
	| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>">Sectioner</a>
	| <a href="<?php echo URL.'assessment/assess/'.$scid; ?>">Assessment</a>
	
</h5>

<h4>
	  <a class="txt-blue u" onclick="expandAll();" >Expand All</a>
	| <a class="txt-blue u" onclick="collapseAll();" >Collapse All</a>
</h4>
</div>	<!-- links -->

<div class="screen" >	<!-- filter -->
<div class="third" ><?php 
	$d['contacts'] = $contacts;
	$d['new_customer'] = false;
	$d['nofocus'] = true;
	$this->shovel('filter_contacts',$d);
?></div>
<div style="float:left;width:30px;" >&nbsp;</div>

<?php include_once('incs/addlookupvalue.php'); ?>

</div><br /> <!-- filter -->



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
