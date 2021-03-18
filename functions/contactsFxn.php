<?php



function sesuser(){
	if(isset($_SESSION['user'])){
		return $_SESSION['user'];
	}
	return false;
}	/* fxn */


function getContacts($db,$role_id=NULL,$fields=NULL,$order="c.name",$all=false,$limits=NULL){
	$brid=$_SESSION['brid'];$dbo=PDBO;
	$cond="";
	$cond.=(isset($role_id))? " AND c.role_id = $role_id ":NULL;
	// $cond.=(!$all)? " AND c.is_active = 1 ":NULL;
	$fields=(isset($fields))? ','.$fields:NULL;
	$limits=(isset($limits))? " LIMIT $limits ":NULL;
		
	$q="SELECT IF(c.id<>c.parent_id,'diff','same') AS single,c.id,c.parent_id,c.id AS ucid,c.parent_id AS pcid,
		r.name AS role,pc.name,c.code,c.account,c.role_id,c.privilege_id $fields
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
			LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
		WHERE c.branch_id=$brid $cond ORDER BY $order $limits; ";		
	$fxn='functions/contacts : '.__FUNCTION__;
	$sth=$db->querysoc($q,$fxn);
	return $sth->fetchAll();
}	/* fxn */



function lastContactNumber($db,$sy,$role_id=NULL){
	$dbo=PDBO;
	$with_role 	= isset($role_id)? " AND `role_id` = '$role_id' " : NULL;
	$q 		= " SELECT count(id) AS `num` FROM {$dbo}.`00_contacts` WHERE `sy` = '$sy' $with_role LIMIT 1; ";
	$sth	= $db->querysoc($q);
	$row 	= $sth->fetch();
	return $row['num'];
}	/* fxn */


function validateCode($db,$code,$dbg=PDBG){	
	$dbo=PDBO;
	$q="SELECT `id` FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return ($row)? true : false;

}	/* fxn */

function validateAccount($db,$account){	
	$dbo=PDBO;
	$q=" SELECT `id` FROM {$dbo}.`00_contacts` WHERE `account` = '$account' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row =$sth->fetch();
	return ($row)? true : false;

}	/* fxn */



function lastContactId($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT max(id) AS scid FROM {$dbo}.`00_contacts`;";		/* better than order limit */
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['scid'];
}	/* fxn */


function lastContact($db,$sy,$is_student=1){
	$dbo=PDBO;
	$cond 	= ($is_student==1)? " c.`role_id` = ".RSTUD." " : " c.`role_id` != ".RSTUD." " ;
	$q 		= " SELECT pc.name,c.id,c.code 
			FROM {$dbo}.`00_contacts` AS c
				LEFT JOIN {$dbo}.`00_contacts` AS pc ON pc.id = c.parent_id
			WHERE $cond ORDER BY id DESC LIMIT 1; 
		";
	$sth	= $db->querysoc($q);
	$row 	= $sth->fetch();
	return $row;
}	/* fxn */

function getProfileDetails($db,$cid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT p.*,MONTH(p.birthdate) AS birthmonth,YEAR(p.birthdate) AS birthyear 
	FROM {$dbo}.`00_profiles` AS p WHERE p.contact_id = '$cid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function getUcidByCode($db,$code,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT `id` AS 'cid' FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['cid'];	
}	/* fxn */


function getContactAccounts($db,$cid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT c.* FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_contacts` AS u ON u.parent_id = c.id
		   WHERE c.parent_id = '$cid' GROUP BY c.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function readContact($db,$ucid){
$dbo=PDBO;
$q = "SELECT p.*,c.*,c.id AS cid
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
	WHERE c.id = '$ucid' LIMIT 1;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
return $row;


}	/* fxn */


function parseContact($fullname){
	$dbo=PDBO;
	$fullname=trim($fullname);
	$row['fullname']=$fullname;
	$row['name_array']=$name_array=explode(' ',$fullname);
	$row['count']=count($name_array);
	$row['first_name']=isset($name_array[0])? trim(array_shift($row['name_array']),',') : '';
	$lname_index=$row['count']-1;
	$row['last_name']=$name_array[$lname_index];	
	$row['fname_initial']=substr($row['first_name'],0,1);
	$row['lname_initial']=substr($row['last_name'],0,1);
	$row['name']="";
	foreach($name_array AS $name){ $row['name'].=ucfirst($name)." "; }
	$row['code']=strtolower($row['fname_initial'].$row['last_name']);
	return $row;	

}	/* fxn */
