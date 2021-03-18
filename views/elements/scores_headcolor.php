<?php 


function getColorByCriteria($cri,$cri_colors){
	switch($cri){
		case ($cri<5):return "bg-".$cri_colors[$cri];break;
		default:return "green";break;
	}
}	/* fxn */



// pr($activities[0]);

?>


