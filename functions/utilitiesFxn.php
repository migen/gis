<?php

function is_decimal($val){ return is_numeric($val) && floor($val)!=$val; }


function convertToTime($num){
	$is_integer=is_integer($num)? true:false;
	$is_decimal=is_decimal($num)? true:false;
	if($is_integer || $is_decimal){
		$format="%02d:%02d:%02d";$hours=$num;$minutes=0;
		if($is_decimal){
			$hours=floor($num);$decimal=$num-$hours;$minutes=$decimal*60;		
		} 
		return sprintf($format,$hours,$minutes,0);					
	} else {
		return $num;		
	}	
}	/* fxn */

