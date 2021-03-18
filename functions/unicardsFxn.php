<?php


function getUnigradesByStudent($db,$dbg,$scid,$sem){
	$dbo=PDBO;
	$q="SELECT g.*,crs.name AS course FROM {$dbg}.10_grades AS g 
	INNER JOIN {$dbg}.01_courses AS crs ON g.course_id=crs.id WHERE g.scid=$scid AND g.semester=$sem; ";	
	debug($q);$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */

// function getInfoByStudent($db,$dbg,$scid){ 
function getUniclasslistStudentsInfo($db,$dbg,$crid,$lvl,$limit,$order){ 
	$dbo=PDBO;
	$limitcond=(isset($limit))? 'LIMIT '.$limit:NULL;
	pr($limitcond);
	if(!isset($order)){ $order=$_SESSION['settings']['classlist_order']; }		
	$q="SELECT summ.scid,c.name,c.code,c.is_active,cr.name AS classroom,m.code AS major_code,s.name AS section,summ.level_id
	FROM {$dbo}.`00_contacts` AS c INNER JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.01_classrooms AS cr ON summ.crid=cr.id INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id	
	INNER JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id WHERE summ.crid=$crid AND summ.level_id=$lvl ORDER BY $order $limitcond; ";
	debug($q);$sth=$db->querysoc($q);$data['rows']=$sth->fetchAll();$data['count']=$sth->rowCount();	
	return $data;
}	/* fxn */


function getData($db,$dbg,$crid,$lvl,$sem,$limit=NULL,$order=NULL){
	$dbo=PDBO;
	reqFxn("uniclasslistsFxn");
	/* 1 */
	$d=getUniclasslistStudentsInfo($db,$dbg,$crid,$lvl,$limit,$order);
	$data['students']=$rows=$d['rows'];
	$data['count']=$count=$d['count'];
	
	/* 2 */
	$studgrades=array();
	for($i=0;$i<$count;$i++){
		$scid=&$rows[$i]['scid'];		
		$studgrades[$i]=getUnigradesByStudent($db,$dbg,$scid,$sem);
		
	}	/* for */
	$data['studgrades']=&$studgrades;
	
	return $data;
	
	
	
}	/* fxn */

