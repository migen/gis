<?php

class Contact extends Model{


public function __construct(){
	parent::__construct();
}


public function index(){}	/* fxn */


public function getucis($ucid,$dbg=DBG){
$dbo=PDBO;
$q = "
	SELECT 
		c.id AS ucid,c.parent_id AS pcid,c.name AS contact,
		pc.name AS parent,
		sum.crid AS sumcrid,sum.acid AS sumacid,
		sum.crid AS studcrid,
		p.*,s.*,c.*,tuit.*,l.name AS level,img.*,
		f.fullname AS father,f.phone AS father_phone,f.phone_office AS father_phone_office,
		f.address AS father_address,f.address_office AS father_address_office,
		f.occupation_id AS father_occupation_id,f.religion_id AS father_religion_id,f.nationality_id AS father_nationality_id,
		m.fullname AS mother,m.phone AS mother_phone,m.phone_office AS mother_phone_office,
		m.address AS mother_address,m.address_office AS mother_address_office,
		m.occupation_id AS mother_occupation_id,m.religion_id AS mother_religion_id,m.nationality_id AS mother_nationality_id,		
		g.fullname AS guardian,g.phone AS guardian_phone,g.phone_office AS guardian_phone_office,
		g.address AS guardian_address,g.address_office AS guardian_address_office,
		g.occupation_id AS guardian_occupation_id,g.religion_id AS guardian_religion_id,g.nationality_id AS guardian_nationality_id,
		g.guardian_type_id		
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`03_tuitions` AS tuit ON cr.level_id = tuit.level_id
		LEFT JOIN {$dbo}.fathers AS f ON f.ucid = c.id
		LEFT JOIN {$dbo}.mothers AS m ON m.ucid = c.id
		LEFT JOIN {$dbo}.guardians AS g ON g.ucid = c.id
		LEFT JOIN ".DBP.".photos AS img ON img.contact_id = c.parent_id
	WHERE 
			c.id = '$ucid' LIMIT 1;
";

// pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetch();


}	/* fxn */


/* for ucis */
public function splitName($fullname){				
	$fullname   = trim($fullname);
	$name_array = explode(' ',$fullname);
	$row['last_name']   = isset($name_array[0])? trim(array_shift($name_array),',') : '';
	$row['middle_name'] = !empty($name_array)? array_pop($name_array) : '';
	$row['first_name']  = !empty($name_array)? implode(' ',$name_array) : '';
	return $row;
}




public function searchContacts($params){	
	$dbo=PDBO;
	$params = rally('stripslashes',$params);
	$conditions='';	
	
	if (!empty($params['code'])){ $conditions .= " AND c.code LIKE '".$params['code']."%'"; }				
	if (!empty($params['contact'])){ $conditions .= " AND c.name LIKE '%".$params['contact']."%'"; }					
	if (isset($params['parent']) && $params['parent']!=2){ $conditions .= " AND id=parent_id "; }
	if (isset($params['role']) && $params['role']!='0'){ $conditions .= " AND c.role_id = '".$params['role']."'"; }
	if (!empty($params['first_letter']) && ($params['first_letter'] != "")){ $conditions .= " AND c.name LIKE '".$params['first_letter']."%'"; }					
	if (!empty($params['scid'])){ $conditions .= " AND c.id = ".$params['scid']; }		
	return $conditions; 	
}


public function contacts($page){
	$dbo=PDBO;
	// require_once(SITE.'library/Pagination.php');
	$db=&$this->db;

	/* conditions for advancedSearch */
	$_SESSION['get'] = $_GET;	
	$_SESSION['ascending'] = isset($_GET['order'])? $_GET['order'] : 'ASC';
	$condition = $this->searchContacts($_SESSION['get']);
		
	/* sort */
	$sort = isset($_GET['sort'])? $_GET['sort'] : 'c.name ';
	$order = $_SESSION['ascending'];
		
	/* PAGINATION */
	$page     = isset($page) ? $page : 1;									/* 1 of 3 */
	$numrows  = isset($_GET['numrows'])? $_GET['numrows'] : 10;
	$_SESSION['numrows'] = isset($numrows)? $numrows : 100;
	$perPage  = ($_SESSION['numrows'] < 100)? $_SESSION['numrows']: '100';	/* 2 of 3 */
	$offset   = ($page - 1) * $perPage;										/* 3 of 3 */
	$dbg = PDBG;$dbo=PDBO;
	
	$q = "
		SELECT 
			c.*,c.id AS ucid,c.parent_id AS pcid,
			pc.name,
			c.is_male,ctp.ctp,
			r.name AS role,
			t.name AS title 
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		WHERE 1=1				
	";
	
	$q .= "  $condition  ";	
	$q .= " ORDER by $sort $order ";
	
	
	/* pageNav */
	$sth=$db->querysoc($q);
	$totalCount = $sth->rowCount();		
	// pr($totalCount);
	

/* 	
	$q="SELECT count(id) AS num FROM {$dbo}.`00_contacts`; ";
	$sth=$db->querysoc($q);
	$row = $sth->fetch();		
	$totalCount=$row['num'];
	pr($totalCount);
	
 */	
	if(!$totalCount){return false;}
	$pagination = new Pagination($page,$perPage,$totalCount);	
	$data['pages'] = $pagination->pageNav('contacts','index');	
	pr($data['pages']);
	$data['num_pages']	= count($data['pages']);
	
	$q .= " LIMIT $perPage OFFSET {$offset} ";		
	
	// echo "<br />q: $q <br />";						
	$_SESSION['q'] = $q;
	
	$sth = $this->db->querysoc($q);		
	$data['contacts'] =  $sth->fetchAll();		
		
	return $data; 
 
}	/* fxn */























}	/* ContactModel */
