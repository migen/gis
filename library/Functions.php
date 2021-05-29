<?php

function url($url){ return URL.$url; }
function doubleAmount($amount){ return "GIS Processed doubled amount: ".(($amount*2)+10); }
function sages($get){ $strget='?';foreach($get as $k=>$v){ if($k=='url'){continue;} $strget.=$k.'='.$v.'&'; } $strget=rtrim($strget,'&');return $strget; }	
function spacer($num){for($i=0;$i<$num;$i++){echo "&nbsp;";}}
function liner($num){for($i=0;$i<$num;$i++){echo "<br />";}}
function loggedin(){ if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){return true;}return false; }
function user(){ if(isset($_SESSION['user'])){ return $_SESSION['user']; } return false; }
function flashRedirect($url="index",$message="Not allowed."){ $_SESSION['message'] = $message;$u=URL.$url;header("Location: $u");exit; }
function redirect($url='index'){ $u = URL.$url; header("Location: $u");exit; }
function flashRedirectUrl($url,$message='Not allowed.'){ $_SESSION['message'] = $message; header("Location: $url");exit; }	
function redirectUrl($url){	header("Location: $url");exit; }	
function buildArray($xs,$field){ $r=array();foreach($xs as $x){ $r[] = $x[$field];}return $r; } 
function stringify($array){ $ids=null;foreach($array as $id){$ids.=$id.'/'; }  return rtrim($ids,'/'); }
function getStringify($get){ $str="?";foreach($get AS $k => $v){ $str.="$k=$v&"; } $str=rtrim($str,'&');return $str; }
function clean_date($rawdate){$noZero=str_replace('0','',$rawdate);$cleandate=str_replace('*','',$noZero);return $cleandate; }
function even($num){ return $num % 2; }	 function odd($num){ return $num & 1; }
function pr($arr){ echo '<pre>'; print_r($arr); echo '</pre>'; }
function prx($arr){ echo '<pre>'; print_r($arr); echo '</pre>'; exit; }
function ps($sth){ echo ($sth)? "Success":"Fail"; }
function isNullOrEmpty($var){ return (!isset($var) || trim($var)===''); }
function isZeroNullOrEmpty($var){ return (!isset($var) || trim($var)==='' || ($var == 0)); }
function reqr($fr){ foreach($fr AS $fxn){ require_once(SITE."functions/{$fxn}.php"); } }
function sanitizeString($str){ $str=preg_replace("([^0-9-/])", "", $str);return $str; }	
function dt(){ $date = date('Y-m-d');$time = date('H:i:s');$dt=$date.' '.$time;return $dt; }
function sudo(){ $suid=$_SESSION['user']['ucid']; if($suid<>1){ flashRedirect('index','Root only.'); } }	
function shovel($file){ include_once(SITE."views/elements/{$file}.php"); }
function debug($q,$subject=NULL){ if(isset($_GET['debug'])){ if(!is_null($subject)){ pr($subject); } pr($q); } }
function unsetter($var){ if(isset($_GET['unsession'])){ $_SESSION[$var]=NULL; } }
function reqFxn($fxn){ require_once(SITE.'functions/'.$fxn.'.php'); }
function vfile($vfile){ if(isset($_GET['vfile'])){ pr($vfile); } }	/* fxn */
function view($one,$two,$sch=VCFOLDER){	
	$vpath=SITE."views/{$one}.php";if(is_readable($vpath)){ $vfile="/{$one}";
	} else { $vfile='/'.$two; } return $vfile; }	/* fxn */
function cview($one,$two,$sch=VCFOLDER){
	$vpath = SITE."views/customs/{$sch}/{$one}.php";		
	if(is_readable($vpath)){ $vfile="/customs/{$sch}/{$one}";} else { $vfile=$two; }return $vfile; }	/* fxn */
function sessionizeArray($db,$key,$dbtable,$order="name"){
	$q="SELECT id,code,name FROM {$dbtable} ORDER BY $order; ";
	$sth=$db->querysoc($q);$rows=$sth->fetchAll();$_SESSION[$key]=$rows; }
function numrows($db,$dbtable){
	$q=" SELECT count(id) AS `num` FROM {$dbtable} LIMIT 1; ";
	$sth = $db->querysoc($q);$row = $sth->fetch();return $row['num'];	
}	/* fxn */
function finalId($db,$dbtable){
	$q=" SELECT id AS `num` FROM {$dbtable} ORDER BY id DESC LIMIT 1; ";
	$sth = $db->querysoc($q);$row = $sth->fetch();return $row['num'];	
}	/* fxn */
function maxId($db,$dbtable){
	$q = " SELECT max(id) AS `num` FROM {$dbtable};";	/* better than order limit */	
	$sth = $db->querysoc($q);$row = $sth->fetch();return $row['num'];	
}	/* fxn */
function lastId($db,$dbtable){ $q=" SELECT id AS `num` FROM {$dbtable} ORDER BY id DESC LIMIT 1; ";	
	$sth=$db->querysoc($q);$row = $sth->fetch();return $row['num'];	 }	

function sessionizeSecret($db,$key){ if(!isset($_SESSION['hdpass_'.$key])){ $_SESSION['hdpass_'.$key]=hdpass($db,$key);$_SESSION['message']="Key sessionized."; } }

function hdpass($db,$key){ $dbo=PDBO;$q=" SELECT `value` FROM {$dbo}.`00_secrets` WHERE `name`='$key' LIMIT 1; ";
	$sth=$db->querysoc($q);$row = $sth->fetch();return $row['value']; }	

function fetchRecord($db,$table,$where,$fields="*"){
	$q=" SELECT $fields FROM $table WHERE $where LIMIT 1; ";debug($q);$sth=$db->querysoc($q);return $sth->fetch(); }	

function fetchRow($db,$table,$id,$field="*"){
	$q=" SELECT $field FROM $table WHERE `id` = '$id' LIMIT 1; "; $sth=$db->querysoc($q);return $sth->fetch(); }	

/* same as model */	 
function fetchRows($db,$dbtable,$fields='id,name',$order='name',$where=null,$limit=NULL){	
	$limits=isset($limit)? "LIMIT $limit":NULL;
	$q=" SELECT $fields FROM $dbtable $where order by $order $limits ; ";debug($q);$sth=$db->querysoc($q);
	if(!$sth){ pr($q); die('Query failed. '.mysql_error());  } return $sth->fetchAll(); }	/* fxn */

function fetchAll($db,$dbtable,$fields='id,name',$order='name',$where=null,$limit=NULL){	
	$limits=isset($limit)? "LIMIT $limit":NULL;
	$q=" SELECT $fields FROM $dbtable $where order by $order $limits ; ";debug($q);$sth=$db->querysoc($q);
	if(!$sth){ pr($q); die('Query failed. '.mysql_error());  } 
	$data['rows']=$sth->fetchAll(); 
	$data['count']=$sth->rowCount(); 
	return $data;
}	/* fxn */


function rally($func,$arr ){ $clean=array();
    foreach($arr as $k=>$v){ $clean[$k] = (is_array($v)?rally($func,$v):(is_array($func)? call_user_func_array($func,$v):$func($v) ) ); }
    return $clean; }

function pia($part,$arr,$col,$getrow=true){ $rows=buildArray($arr,$col);$found=array();$num=count($rows);
	for($i=0;$i<$num;$i++){ if(stripos($rows[$i],$part)!==FALSE) { 
			$found[]=($getrow)? $arr[$i]:$rows[$i]; } } return (empty($found))? FALSE : $found; }

function initSession($db,$index=false){
	if(!isset($_SESSION[$index])){ require_once(SITE.'functions/sessionize_'.$index.'.php'); $func="sessionize_{$index}"; $func($db); } 
}	/* fxn */

function in_record($db,$dbtable,$key,$value){
	$q="SELECT id FROM $dbtable WHERE $key='$value' LIMIT 1;";$sth=$db->query($q);$row=$sth->fetch();
	return ($row)? true:false;	
}	/* fxn */

function sessionizeColumnsOfDbtable($db,$schema,$table,$index,$except="null"){
	if(!isset($_SESSION['cols'][$index])){
		require_once(SITE.'functions/dbtools.php');	
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except);		
		$_SESSION['cols'][$index]=$dr['field_array'];
		$_SESSION['cols'][$index.'_field_str']=$dr['field_string'];
		$_SESSION['cols'][$index.'_count']=$dr['count'];
	}	
}	/* fxn */

function searchFromArray($array,$field, $value) {
   foreach ($array AS $item) { if ($item[$field] === $value) { return $item; } } return null;
}	/* fxn */

function requireIfReadable($file){
	$incfile=SITE.$file;if(is_readable($incfile)){ require_once($incfile); } pr($incfile);	
}	/* fxn */

function dateIsFinalized($date){ 
	return (isset($date) && ($date!=='0000-00-00'))? true:false;
}	/* fxn */
