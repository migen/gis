<?php


function cutString($str,$len,$char="..."){ // longstringhere -> longstr...
	$str=(strlen($str)<=$len)? $str:substr($str,0,$len).$char;
	return $str;
}	/* fxn */




function betweenString($string, $start, $end){ // hello value there ->value
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}	/* fxn */


function cleanColname($str){	// c.name => name, c.id AS scid => scid, id AS scid => scid		
	$has_dot=(strpos($str,'.')!==false)? true:false;
	$has_as=(strpos($str,'as')!==false)? true:false;	
	if(!$has_dot && !$has_as){ return trim($str); }		
	$char=$has_as? "as":".";
	$str=strstr($str,$char,false);
	$str=ltrim($str,".");			
	if($has_as){ $str=trim($str,"as"); }					
	return trim($str);		
}	/* fxn */


