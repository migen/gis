<?php 

	$in_rl = in_remarksLevel($cr);
	$user = $_SESSION['user'];
	
	$sch=VCFOLDER;	
	$ucfsch=ucfirst(VCFOLDER);
	$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
	$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles":"profiles/classroom";	


?>

<h5>
	Expired Classlist 
	| <?php echo $cr['name']; ?> (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."classlists/master/$crid"; ?>' >Masterlist</a>				
	| <a href='<?php echo URL."{$crprofiles_path}/$crid/$sy"; ?>'>Profiling</a>				
</h5>


<div class="half" >

<?php  
	include_once('incs/classlist_rcard.php');


?>
</div>


<?php  // foreach($classrooms AS $row){ echo "#".$row['id']." - ".$row['name']."<br />"; } ?>









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
