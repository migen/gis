<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg=PDBG;	
$dbo=PDBO;	


switch($_POST['task']){

case "xDelTerminal": /* pos report */
	$pkid = $_POST['pkid'];
	$q = "DELETE FROM {$dbo}.`03_terminals_employees` WHERE `id` = '$pkid' LIMIT 1; ";
	$db->querysoc($q);
	$_SESSION['q'] = $q;
	$_SESSION['message'] = "Terminal deleted.";	
	break;

case "xyz_enroll": /* working okay */
	$code=$_POST['code'];
	$name=$_POST['name'];
	$q="INSERT INTO {$dbo}.xyz(code,name)VALUES('$code','$name'); ";
	$sth=$db->query($q);	
	$res=($sth)? true:false;
	echo json_encode($res);
	break;


/* INSERT INTO table_listnames (name, address, tele)
SELECT * FROM (SELECT 'Rupert', 'Somewhere', '022') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM table_listnames WHERE name = 'Rupert'
) LIMIT 1;
 */
case "registerContact": /* registration */
	$scid=$_POST['scid'];$code=$_POST['code'];
	$name=$_POST['name'];
	$name=$db->quote($name);	// sanitize string, real_escape_string
	// $q="SELECT id FROM {$dbo}.`00_contacts` WHERE code='$code' OR name='$name' LIMIT 1; ";
	$q="SELECT id FROM {$dbo}.`00_contacts` WHERE code='$code' LIMIT 1; ";
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(!empty($row)){ echo json_encode(false); break; }
	$sy=$_SESSION['sy'];$ecid=$_SESSION['ucid'];$today=$_SESSION['today'];	
	// 2 - contacts
	$q="INSERT INTO {$dbo}.`00_contacts`(id,parent_id,code,name,sy,ecid,is_active,title_id,role_id,privilege_id,modified_date)
		VALUES($scid,$scid,'$code',$name,$sy,$ecid,1,1,1,1,'$today'); ";	
	// 3 - enrollments, summaries
	$q.="INSERT IGNORE INTO {$dbo}.`05_enrollments`(sy,scid)VALUES($sy,$scid); ";
	$q.="INSERT IGNORE INTO {$dbg}.`05_summaries`(scid)VALUES($scid); ";	
	$_SESSION['q']=$q;
	$db->query($q);	
	echo json_encode(true);
	break;	

	
default:
	break;

	
	

}	/* switch */




	

	
