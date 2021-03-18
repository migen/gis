<?php 

function insertComponentIfNotExists($db,$criarr,$wtarr,$k,$l,$s){
	$dbo=PDBO;
	$dbg=PDBG;
	$cri=$criarr[$k];$wt=$wtarr[$k];	
	$r="SELECT id FROM {$dbg}.05_components WHERE `level_id`='$l' AND  `subject_id`='$s' AND `criteria_id`='$cri' LIMIT 1;  ";
	$sth=$db->querysoc($r);
	$row=$sth->fetch();
	if(!$row){
		$q="INSERT INTO {$dbg}.05_components(`level_id`,`subject_id`,`criteria_id`,`weight`) 
			VALUES('$l','$s','$cri','$wt');";							
	}
	return $q;

}	/* fxn */


function getComponentsByLevel($db,$level_id,$dbg=PDBG){
	$dbo=PDBO;
	$sort = isset($_GET['sort'])? $_GET['sort']:'cty.id,sub.name,cri.position,cri.id';
	$order = isset($_GET['order'])? $_GET['order']:'ASC';
	$q = " SELECT 
			cri.name AS criteria,cri.is_raw,cty.name AS ctype,com.id,sub.name AS subject,
			l.name AS level,com.level_id,com.subject_id,com.criteria_id,com.weight,sub.subjtype_id  
		FROM {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_levels` AS l ON com.level_id = l.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id = sub.id
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
			INNER JOIN {$dbo}.`05_crstypes` AS cty ON cri.crstype_id = cty.id
			LEFT JOIN {$dbo}.`05_subjtypes` AS st ON sub.subjtype_id = st.id
		WHERE
			com.level_id =  '$level_id'
		ORDER BY $sort $order;	";
	$sth = $db->querysoc($q);
	$data['components']=$sth->fetchAll();
	$data['q']=$q;
	return $data;
	// return $sth->fetchAll();	
} 	/* fxn */


 

function getCourseComponents($db,$lvl,$sub,$dbo,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT cri.name AS criteria,cri.is_raw,cri.code AS cricode,com.id,com.criteria_id,com.weight
	FROM {$dbg}.05_components AS com 
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
	WHERE com.level_id =  '$lvl' AND com.subject_id = '$sub' ORDER BY cri.id; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function selectsForAddComponents($db,$dbg=PDBG){
	$dbo=PDBO;
	$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",'id,name',' id ');	
	$data['sections'] = fetchRows($db,"{$dbo}.`05_sections`");	
	$data['courses'] = fetchRows($db,"{$dbg}.05_courses");	
	$data['subjects'] = fetchRows($db,"{$dbo}.`05_subjects`");	
	$data['criteria'] = fetchRows($db,"{$dbo}.`05_criteria`",'id,name,crstype_id','name',' WHERE crstype_id = 1');	
	return $data;
}	/* fxn */

function selectsForAddMiscComponents($db,$dbg=PDBG){
	$dbo=PDBO;
	$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",'id,name',' id ');	
	$data['sections'] = fetchRows($db,"{$dbo}.`05_sections`");	
	$data['courses'] = fetchRows($db,"{$dbg}.05_courses");	
	$data['subjects'] = fetchRows($db,"{$dbo}.`05_subjects`");	
	$data['criteria'] = fetchRows($db,"{$dbo}.`05_criteria`",'id,name,crstype_id','name',' WHERE (crstype_id <> 1) ');		
	return $data;
}	/* fxn */



function readComponents($db,$id,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT com.*,cri.id AS criteria_id,cri.name AS criteria,l.name AS level,sub.name AS subject 
		FROM {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
			INNER JOIN {$dbo}.`05_levels` AS l ON com.level_id = l.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id = sub.id
		WHERE com.`id` =  '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */



