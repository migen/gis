<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;
$dbo = PDBO;

$task=isset($_POST['task'])? $_POST['task']:'test';

switch($task){

case "test":
	$id=isset($_GET['id'])? $_GET['id']:1;
	$q="SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id=$id LIMIT 1; ";
	print($q);echo "<br />";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;

case "xgetRolesBySearch":
	// $rows=array( array('id'=>1,'name'=>'Makol'),array('id'=>2,'name'=>'Barry'));
	$search=$_POST['search'];
	$q="SELECT * FROM {$dbo}.`00_roles` WHERE name LIKE '%".$search."%' LIMIT 2; ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q1']=$rows;
	echo json_encode($rows);	
	break;


case "contact":
	$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;


case "level":	
	$q = " SELECT id,code,name FROM {$dbo}.`05_levels` WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;


case "role":
	$q = " SELECT id,code,name FROM {$dbo}.`00_roles` WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;

case "xdelrow":
	$dbtbl = $_POST['dbtbl'];
	$id	   = $_POST['id'];
	$q = " DELETE FROM $dbtbl WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;
	
	
default:
	$row = array('code'=>'defcode','name'=>'defname');
	echo json_encode($row);	
	break;








}	/* switch */

?>

<script>

var gurl = "http://<?php echo GURL; ?>";

function removeStudentFromClub1(i,scid){
	var vurl 	= gurl + '/ajax/xclubs.php';	
	var task	= "removeStudentFromClub";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: "scid="+scid+"&task="+task,				
		success: function() { 			
			$('#btn-'+i).hide();
		}		  
    });				
	
}	/* fxn */


</script>
