<?php
class Webpage extends Model{
public function __construct(){
	parent::__construct();
}


public function searchTable($params){	
	$params = rally('stripslashes',$params);
	$conditions='';	
	
	if (!empty($params['name'])){ $conditions .= " AND wp.name LIKE '%".$params['name']."%' "; }				
	return $conditions; 	
}	/* fxn */

public function index($page){
	$dbo=PDBO;	
	$_SESSION['get'] 		= $_GET;	
	$_SESSION['ascending'] 	= isset($_GET['order'])? $_GET['order'] : 'ASC';
	$condition = $this->searchTable($_SESSION['get']);
	/* sort */
	$sort = isset($_GET['sort'])? $_GET['sort'] : 'wp.name ';
	$order = $_SESSION['ascending'];
	/* PAGINATION */
	$page     = isset($page) ? $page : 1;											/* 1 of 3 */
	$numrows  = isset($_GET['numrows'])? $_GET['numrows'] : $snumrows;
	$_SESSION['numrows'] = isset($numrows)? $numrows : $snumrows;
	$perPage  = ($_SESSION['numrows'] < $snumrows)? $_SESSION['numrows']: $snumrows;	/* 2 of 3 */
	$offset   = ($page - 1) * $perPage;												/* 3 of 3 */
	$loggedin = loggedin();
	$q = " SELECT wp.id, wp.contact_id, wp.alias, wp.name 
			FROM {$dbo}.`00_webpages` AS wp
		WHERE 1=1 ";
		$condition ORDER by $sort $order ";	
	$sth = $this->db->querysoc($q);	
	
	/* pageNav */
	$totalCount = $this->countAll($q);		
	if(!$totalCount){return false;}
	$pagination = new Pagination($page, $perPage, $totalCount);	
	$data['pages'] = $pagination->pageNav('webpages');	
	$data['num_pages']	= $pagination->totalPages();
	// echo "<br />q: $q <br />";						
	$sth = $this->db->querysoc($q);		
	$data['wp'] =  $sth->fetchAll();		
	return $data; 

}	/* fxn */



public function read($alias){	
	$dbo=PDBO;	
			FROM {$dbo}.`00_webpages` AS w 
				LEFT JOIN {$dbo}.`00_contacts` AS c ON w.contact_id = c.id ";
	$q .= " WHERE w.alias = '".$alias."' LIMIT 1";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();
}

public function readById($id){	
	$q  = " SELECT w.*, c.name as user 
			FROM {$dbo}.`00_webpages` AS w 
				LEFT JOIN {$dbo}.`00_contacts` AS c ON w.contact_id = c.id ";
	$q .= " WHERE w.id = '".$id."' LIMIT 1";
	return $sth->fetch();
}


public function add($row){
	$dbo=PDBO;	
	$this->dbadd("{$dbo}.`00_webpages`",$row);
}	/* fxn */

public function dbadd($table,$data){
	$dbo=PDBO;	
	$fvalues = ':'.implode(',:',array_keys($data));
	$q = "INSERT into $table (`$fields`) VALUES ($fvalues)";
	$sth = $this->db->prepare($q);
	foreach($data as $key => $value){
		$sth->bindValue(":$key",$value);
	}
	$sth->execute(); 		
}	

public function updateWebpage($row, $id){
	$dbo=PDBO;	
	$this->dbupdate(PDBO.'.`00_webpages`',$row,$id);
	// return $this->db->update($this->dbtable,$data," id = $id ");	
}	/* fxn */

public function dbupdate($table, $data, $id){
	$fvPairs = NULL;
	foreach($data as $key=> $value) {
		$fvPairs .= "`$key`=:$key,";
	}
	$fvPairs = rtrim($fvPairs, ',');
	$q = "UPDATE $table SET $fvPairs WHERE `id` = '$id' LIMIT 1;";
	
	// pr($q); exit;
	$sth = $this->db->prepare($q);

	foreach ($data as $key => $value) {
		$value = stripslashes($value);
		$sth->bindValue(":$key", $value);
	}		
	$sth->execute();
}	/* fxn */





} 	/* WebpageModel */


