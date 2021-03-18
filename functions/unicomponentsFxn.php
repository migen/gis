<?php

function getUnicomponents($db,$dbg){
	$dbo=PDBO;
	$q="SELECT com.*,sub.name AS subject,cri.name AS criteria,com.id AS rid
	FROM {$dbg}.01_components AS com
	LEFT JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id=sub.id
	LEFT JOIN {$dbg}.01_criteria AS cri ON com.criteria_id=cri.id
	ORDER BY sub.name,cri.name;";			
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	return $data;
	
}	/* fxn */



function insertComponentIfNotExists($db,$criarr,$wtarr,$k,$s){
	$dbo=PDBO;
	$dbg=PDBG;
	$cri=$criarr[$k];$wt=$wtarr[$k];	
	$r="SELECT id FROM {$dbg}.05_components WHERE `level_id`='$l' AND  `subject_id`='$s' AND `criteria_id`='$cri' LIMIT 1;  ";
	$sth=$db->querysoc($r);
	$row=$sth->fetch();
	if(!$row){
		$q="INSERT INTO {$dbg}.01_components(`subject_id`,`criteria_id`,`weight`) 
			VALUES('$s','$cri','$wt');";							
	}
	return $q;

}	/* fxn */
