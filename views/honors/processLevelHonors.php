<?php 
$size=isset($_GET['size'])? $_GET['size']:1;
?>

<style>

td,th{ font-size:<?php echo $size; ?>em; }

</style>

<?php 


$decicard=$_SESSION['settings']['decicard'];
$decigenave=$_SESSION['settings']['decigenave'];
$deciconducts=$_SESSION['settings']['deciconducts'];
// $lvl=$cr['level_id'];
$cutoff_crs=90;
$decihonors=0;

// $ec=$cr['is_free'];

function getHonorByGenave($genave=NULL){
	switch($genave){
		case $genave>=98: $honor="WHH";break;
		case $genave>=95: $honor="WH";break;
		case $genave>=90: $honor="H";break;
		default: $honor="";
	}
	return $honor;
}


$vfile="incs/processLevelHonors_table.php";

if(isset($_GET['vfile'])){ pr($vfile); }
include_once($vfile);

