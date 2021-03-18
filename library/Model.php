<?php

// echo 'Simple Model called <br />';

class Model{
	public $db,$database,$pageNav;

	
public function __construct(){
	$this->db = new Database(DBTYPE,DBHOST,PDBO.";charset=utf8",DBUSER,DBPASS);
	
	// $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->pass);
	// $this->conn->query("SET NAMES 'utf8'");
	
	$this->db->query("SET NAMES 'utf8'");
	
	
	
	$this->database =& $this->db;
}	/* fxn */

private function kickout(){
	Session::logout();redirect('users/login');
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

