<?php

$clsr = $data;
$sgs = $_SESSION['settings'];


$rflrgr 	= $sgs['rank_grade'];
$rgaflrgr 	= $sgs['rank_genave'];
$rctflrgr 	= $sgs['rank_conduct'];




	
if($clsr['is_ps']){
	$rflrgr 	= $sgs['rank_floor_grade_ps'];
	$rgaflrgr 	= $sgs['rank_genave_ps'];
	$rctflrgr 	= $sgs['rank_conduct_ps'];
	
} elseif($clsr['is_gs']){
	$rflrgr 	= $sgs['rank_floor_grade_gs'];
	$rgaflrgr 	= $sgs['rank_genave_gs'];
	$rctflrgr 	= $sgs['rank_conduct_gs'];	
} elseif($clsr['is_hs']){
	$rflrgr 	= $sgs['rank_floor_grade_hs'];
	$rgaflrgr 	= $sgs['rank_genave_hs'];
	$rctflrgr 	= $sgs['rank_conduct_hs'];	
}


