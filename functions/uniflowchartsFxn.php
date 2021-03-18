<?php



function getFlowchartCourses($db,$dbg,$major_id,$yr,$sem){
	$dbo=PDBO;	
	$q="SELECT f.*,f.id AS fid,sub.name AS subject,sub.code,sub.name
		FROM {$dbg}.01_flowcharts AS f
		INNER JOIN {$dbo}.`05_subjects` AS sub ON f.subject_id=sub.id
		WHERE f.major_id='$major_id' AND f.level_id=$yr AND f.semester=$sem
		ORDER BY f.level_id,f.semester,sub.name;";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

	
	
}	/* fxn */

function getUniflowchartByMajor($db,$dbg,$major_id){
	$dbo=PDBO;
	$q="SELECT f.*,f.id AS fid,sub.name AS subject,sub.code,sub.name,
			GROUP_CONCAT(ps.name ORDER BY ps.name SEPARATOR ', ') AS prerequisites
		FROM {$dbg}.01_flowcharts AS f
		INNER JOIN {$dbo}.`05_subjects` AS sub ON f.subject_id=sub.id
		LEFT JOIN {$dbg}.01_prerequisites AS pr ON pr.subject_id = sub.id
		LEFT JOIN {$dbo}.`05_subjects` AS ps ON pr.parent_id = ps.id
		WHERE f.major_id='$major_id' 
		GROUP BY f.id 
		ORDER BY f.level_id,f.semester,sub.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	return $data;	
	
	
}	/* fxn */
