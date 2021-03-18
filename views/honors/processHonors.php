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
$lvl=$cr['level_id'];
$cutoff_crs=90;
$decihonors=0;

$ec=$cr['is_free'];

function getHonorByGenaveV1($genave=NULL){
	switch($genave){
		case $genave>=98: $honor="WHH";break;
		case $genave>=95: $honor="WH";break;
		case $genave>=90: $honor="H";break;
		default: $honor="";
	}
	return $honor;
}

function getHonorByGenave($genave=NULL){
	switch($genave){
		case $genave>=98: $honor['genave']=$genave;$honor['num']=1;$honor['dg']="WHH";break;
		case $genave>=95: $honor['genave']=$genave;$honor['num']=2;$honor['dg']="WH";break;
		case $genave>=90: $honor['genave']=$genave;$honor['num']=3;$honor['dg']="H";break;
		default: $honor['genave']=$genave;$honor['num']=0;$honor['dg']="";;
	}
	return $honor;
}


/* 

function getHonorLegend($rank=NULL){
	switch($rank){
		case 1: $honor="WHH";break;
		case 2: $honor="WH";break;
		case 3: $honor="H";break;
		default: $honor="";
	}
	return $honor;
}

*/

if($ec && !isset($_GET['std'])){  
	$vfile="incs/processHonors_table_EC.php";
} else {
	$vfile="incs/processHonors_table.php";
}

if(isset($_GET['vfile'])){ pr($vfile); }
include_once($vfile);

