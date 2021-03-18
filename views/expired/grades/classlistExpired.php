<?php 

	$in_rl = in_remarksLevel($cr);
	$user = $_SESSION['user'];
	
$sch=VCFOLDER;	
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles":"profiles/classroom";	

// pr($vpath);
// pr($crprofiles_path);

?>

<h5>
	Expired Classlist <?php echo $sy; ?> (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>	
</h5>

 
<?php  $this->shovel('classroom_details',$cr);  ?>

<?php 

	include_once('incs/classlist_split.php');	
	// include_once('incs/classlist_view.php');	
	exit;
?>



<div class="clear ht50" ></div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})






</script>
