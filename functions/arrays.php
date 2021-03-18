<?php






function textwrap($str,$len,$chars){
	$cx = "";
	$pos = 0;
	$num = strlen($str) / $len;
	for($i=0;$i<$num;$i++){
		$pos = $i*$len;		
		$a   = substr($str,$pos,$len); 
		$x	 = substr($str,$pos);		
		$cx .= $a.$chars;
		
	}
	return $cx;
} /* fxn */


/* recursion,recursive */
function flatter($rs){	
	global $rows;
	foreach($rs as $r){
		if(!is_array($r)){
			$rows[] = $r;
		} else {
			flatter($r);
		}					
	}
	return $rows;
}


function trimGet($get){
	foreach($get AS $k=>$v){
		if($v=='' || $v==NULL){
			unset($get[$k]);
		}
	}
	return $get;
}	/* fxn */


function bcr($ctlrs){	/* build controller array */
	$bcr = array();
	$i=0;
	foreach($ctlrs AS $ctlr){
		$bcr[$i]['ctlr'] = $ctlr;
		$bcr[$i]['cls'] = ucfirst($ctlr).'Controller';
		$i++;		
		$bcr[$i]['ctlr'] = $ctlr;
		$bcr[$i]['cls'] = ucfirst(rtrim($ctlr,'s'));		
		$i++;
	}
	return $bcr;
}	/* fxn */
