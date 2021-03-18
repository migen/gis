<?php if(isset($_GET['debug'])){ pr($q); } ?>


<script>
var sy="<?php echo $sy; ?>"


</script>


<h5 class="screen" >
LSM Promotions Report
| <a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=1&default"; ?>' >Template One</a>
<a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=2&default"; ?>' >Template Two</a>
| <a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=3&default"; ?>' >Template Three</a>
| <a class="u" id="btnExport" >Excel</a> 

<?php 
	$d['sy']=$sy;$d['repage']="promotions/report/$crid";
	$this->shovel('sy_selector',$d); 
?>	


</h5>


<style>
div{ border:1px solid white; }
</style>

<?php
$level_id = $classroom['level_id'];
$incfile = "";

/* 1:ps to gr3, 2:gr4-gr6, 3:hs */
if(isset($_GET['tpl'])){	
	switch($_GET['tpl']){
		case 1: $incfile = "tpl01_06.php"; break;
		case 2: $incfile = "tpl07_09.php"; break;
		default: $incfile = "tpl10_13.php"; break;		
	}
	

} else {
	switch($level_id){
		case $level_id < 4: $incfile = "tpl_ps.php"; break;
		case $level_id < 10: $incfile = "tpl_gs.php"; break;
		case $level_id < 14: $incfile = "tpl_hs.php"; break;
		default: $incfile = "tpl_shs.php"; break;		
	}

}
// pr($incfile);
include_once($incfile);
		

