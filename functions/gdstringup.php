<?php
//////////////////////////////////////////////////////////////////////
//
// Developed by Heinz Schweitzer
// ASSUMPTION: hardcoded character cell width of 8 and a hight of 12
// change to your needs
//////////////////////////////////////////////////////////////////////
header ("Content-type: image/gif"); 
$s=$_GET["text"];
if(strlen($s)==0){
	$s="Missing Text!";
}
$el=explode("<br>",$s);
$nel=count($el);
if($nel>0){
	for($i=0,$imghigh=0;$i<$nel;$i++){	
		$high=strlen($el[$i])*8+2;
		if($high>$imghigh){
			$imghigh=$high;
		}
	}
} else {
	$imghigh=strlen($s)*8+2;
}
if($nel==1){
	$imgwidth=12;
}else{
	$imgwidth=12+($nel*14);
}
$im = imagecreatetruecolor($imgwidth, $imghigh)or die('Cannot Initialize new GD image stream');
$black = imagecolorallocate($im, 0, 0, 0);
imagecolortransparent($im, $black);
$text_color = imagecolorallocate($im,10, 10,10);
$font=imageloadfont("courier-bold.gdf");
$py=imagefontwidth($font);
for($i=0,$x=0;$i<$nel;$i++){
	$l=strlen($el[$i]);	
	imagestringup($im,$font , $x, $imghigh,  $el[$i], $text_color);
	$x+=14;
}
imagegif($im);
imagedestroy($im);


