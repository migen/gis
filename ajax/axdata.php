<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;$dbg=PDBG;


switch($_POST['task']){


case "xgetIdByCode":	
	$post=$_POST;$dbtable=$post['dbtable'];
	$part=trim($_POST['part']);	
	$q="SELECT id FROM $dbtable WHERE code = '".$part."' OR name='".$part."' LIMIT 1; ";	
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	break;	

case "xgetDataEncode":	/* 20200612 */
	$part=trim($_POST['part']);
	$limit=$_POST['limit'];
	$dbtable=$_POST['dbtable'];
	$q = " SELECT id,code,name
		FROM {$dbtable} WHERE `code` LIKE '%".$part."%' 
		OR `name` LIKE '%".$part."%' ORDER BY `name` LIMIT $limit;  ";		
	$_SESSION['q']="axdata: ".$q;	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$rows=array_map(function($r) {
	  $r['name']=utf8_encode($r['name']);
	  return $r;
	}, $rows);	
	echo json_encode($rows);
	break;


case "xgetData":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$limit=$post['limit'];
	$part=trim($_POST['part']);
	$q="SELECT id,code,name FROM $dbtable WHERE code LIKE '%".$part."%' OR name LIKE '%".$part."%' LIMIT $limit; ";	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['q']="axdata-xgetData: $q";	
	echo json_encode($rows);		
	break;	


case "abc":	/* 20201028 - xgetDataByTableWithCondition*/	
	$post=$_POST;$dbtable=$post['dbtable'];
	$limit=$post['limit'];
	$cond=$post['cond'];
	$part=trim($_POST['part']);
	$q="SELECT id,code,name FROM $dbtable WHERE code LIKE '%".$part."%' OR name LIKE '%".$part."%' $cond LIMIT $limit; ";	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['q']="axdata-xgetData-cond: $q";	
	echo json_encode($rows);		

	break;	


case "xgetRowById":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$id=$post['id'];	
	$q="SELECT * FROM $dbtable WHERE id=$id LIMIT 1; ";	
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	break;	


case "xgetIdByCode":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$part=$post['part'];	
	$q="SELECT id FROM $dbtable WHERE code = '".$part."' OR name='".$part."' LIMIT 1; ";	
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	break;	



case "xsaveData":	/* 20200226 */		
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];		
	$db->add($dbtable,$post);	
	$_SESSION['q']=$post;
	break;	

case "xdeleteData":	/* 20200226 */
	/* process */
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];$id=$_POST['id'];		
	$db->delete($id,$dbtable); 
	break;	

	
case "xeditData":
	$post=$_POST;unset($post['task']);unset($post['dbtable']);unset($post['id']);
	$dbtable=$_POST['dbtable'];	$id=$_POST['id'];	
	$db->update($dbtable,$post,"`id`=$id");
	break;	

	
	
	
default:
	break;

	
	

}	/* switch */




	

	
