<?php

// echo 'Simple Model called <br />';

class Model{
	public $db,$database,$pageNav;

	
public function __construct(){
	$this->db = new Database(DBTYPE,DBHOST,DBO.";charset=utf8",DBUSER,DBPASS);
	$this->database =& $this->db;
}	/* fxn */

private function kickout(){
	Session::logout();
	redirect('users/login');
}	/* fxn */

public function logout(){
	Session::logout();
}	/* fxn */

public function countAll($q=null){
	if(is_null($q)){ return false; }	
	$sth = $this->db->query($q);
	if(!$sth){ pr($q); die('Query failed. '.mysql_error());  }					
	return $sth->rowCount();
}	/* fxn */

public function totalCount($table){
	$q = " SELECT count(id) AS numrows FROM $table; ";
	$sth = $this->db->query($q);
	if(!$sth){ pr($q); die('Query failed. '.mysql_error());  }					
	$row = $sth->fetch();
	return $row['numrows'];
}	/* fxn */



public function rowExists($table,$condkey,$condvalue,$fields="*"){
	$q = " SELECT $fields FROM $table WHERE `$condkey` = '$condvalue' LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	$row = $sth->fetch();
	return ($row)? true : false;
}	/* fxn */


public function actions($dbg=PDBG){
	$q = " SELECT axn.*,m.code AS module_code 
			FROM {$dbg}.`00_actions` AS axn 
				INNER JOIN {$dbo}.modules AS m ON axn.module_id = m.id
			ORDER BY axn.name;
		";
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



public function update($table,$data,$id){
	return $this->db->update($table,$data," id = $id ");	
}	/* fxn */


/* for selects at Models; previously noel or nameOnlyElements */
public function fetchRows($dbtable,$fields='id,name',$order='name',$where=null,$limit=NULL){	
	$limits = isset($limit)? "LIMIT $limit":NULL;
	$q = " SELECT $fields FROM $dbtable $where order by $order $limits ; ";
	$sth = $this->db->querysoc($q);
	if(!$sth){ pr($q); die('Query failed. '.mysql_error());  }					
	return $sth->fetchAll();
}	/* fxn */


public function fetchRecord($table,$where){
	$q = " SELECT * FROM $table WHERE $where LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

public function fetchRow($table,$id){
	$q = " SELECT * FROM $table WHERE `id` = '$id' LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

public function rowByCondition($table,$where){
	$q = " SELECT * FROM $table $where LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


public function deleteRow($table,$id){
	$q = " DELETE FROM $table WHERE `id` = '$id' LIMIT 1; ";
	$this->db->query($q);
}	/* fxn */


public function urooms($ucid){
	$q = " SELECT r.name AS room, rc.*, ctc.`id` AS `ctcid`, ctc.name AS ctc 
			FROM {$dbo}.rooms_contacts AS rc 
				LEFT JOIN {$dbo}.rooms AS r ON rc.room_id = r.id
				LEFT JOIN {$dbo}.ctagcategories AS ctc ON r.ctagcategory_id = ctc.id
			WHERE rc.contact_id = '$ucid'; ";
	$sth = $this->db->querysoc($q);
	$urooms = $sth->fetchAll();
	
	$_SESSION['urooms'] = $urooms;	
	$uroom_ids = buildArray($urooms,'room_id');
	$_SESSION['uroom_ids'] = $uroom_ids;		
	

}  	/* fxn */


public function sessionizeMembers($room_id){
	$q = " SELECT pc.id,pc.code,pc.name
		FROM {$dbo}.rooms_contacts AS rc
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON rc.contact_id = pc.id
			WHERE rc.room_id = '$room_id' ; ";
	$sth = $this->db->querysoc($q);
	$members = $sth->fetchAll();
	
	$_SESSION['room'][$room_id]['members'] 		= $members;	
	$pcids 	= buildArray($members,'id');

	$_SESSION['room'][$room_id]['pcids'] 		= $pcids;	
	return $members;

}	/* fxn */


public function lastID($dbtable){
	$q = " SELECT max(id) AS id FROM $dbtable ; ";
	$sth = $this->db->querysoc($q);
	$row = $sth->fetch();
	return $row['id'];
}	/* fxn */


} 	/* Model */

