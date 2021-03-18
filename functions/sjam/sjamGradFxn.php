<?php


function syncSjamGradHonors($db,$dbg,$dbo,$lvl,$rows){	
	$updated=true;
	$q="INSERT INTO {$dbg}.50_gradhonors_sjam(`lvl`,`scid`,`curr_acad`,`curr_cond`)VALUES ";
	foreach($rows AS $row){
		if(empty($row['ghscid'])){
			$updated=false;
			$scid=$row['scid'];
			$acad=$row['curr_acad'];
			$cond=$row['curr_cond'];
			$q.="('$lvl','$scid','$acad','$cond'),";			
		}		
	}
	$q=rtrim($q,",");$q.=";";
	if(!$updated){ $db->query($q);pr($q); }
		

}	/* fxn */

function getSjamGradHonors($db,$dbg,$dbo,$lvl,$fqtr=5,$final=NULL){	
	// $ordercond=isset($final)? "gh.overall_total":"summ.`ave_q{$fqtr}`";
	// $ordercond=isset($final)? "gh.total_wtd ASC":"summ.`ave_q{$fqtr}` DESC";
	$prevsy=DBYR-1;
	$pdbg=VCPREFIX.$prevsy.US.DBG;
	$ordercond="summ.`ave_q{$fqtr}` DESC";
	$wherecond="";
	if($final){
		$wherecond=" AND gh.total_wtd>0 "; $ordercond="gh.total_wtd ASC";				
	}	
		
	$q="SELECT
			gh.scid AS ghscid,gh.*,
			summ.scid,c.name AS `student`,summ.`ave_q$fqtr` AS `curr_acad`,summ.`conduct_q$fqtr` AS `curr_cond`,
			psumm.`ave_q$fqtr` AS `prev_acad`,psumm.`conduct_q$fqtr` AS `prev_cond`,
			cr.name AS classroom,sxn.name AS section			
		FROM {$dbo}.`00_contacts` AS `c`
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$pdbg}.05_summaries AS psumm ON psumm.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
		LEFT JOIN {$dbg}.50_gradhonors_sjam AS gh ON summ.scid=gh.scid		
		WHERE cr.level_id='$lvl' AND summ.`conduct_q$fqtr`>=90 $wherecond
		ORDER BY $ordercond LIMIT 15; ";
		
	debug($q);
	$sth=$db->querysoc($q);
	$d['rows']=$sth->fetchAll();
	$d['count']=$sth->rowCount();
	return $d;
	
}	/* fxn */





// SET @r=0; UPDATE records SET rank= @r:= (@r+1) where type = 2 ORDER BY seconds DESC LIMIT 10000;
function sortAcadRanks($db,$dbg,$lvl){	
	$q="SET @r=0;
	UPDATE {$dbg}.`50_gradhonors_sjam` SET `rank_acad`=@r:=(@r+1) WHERE lvl='$lvl' ORDER BY total_acad DESC;  "; 
	$sth=$db->query($q);
	
}	/* fxn */


function sortGradWeights($db,$dbg,$lvl){
	/* 1 */
	$q="UPDATE {$dbg}.`50_gradhonors_sjam` SET `wtd_acad`=(`rank_acad`*8),
		`wtd_cond`=(`rank_cond`*2) WHERE `lvl`='$lvl'; ";
	$db->query($q);
	/* 2 */
	$q="UPDATE {$dbg}.`50_gradhonors_sjam` SET `total_wtd`=(`wtd_acad`+`wtd_cond`) WHERE `lvl`='$lvl'; ";
	$db->query($q);	
	/* 3 */
	$q="UPDATE {$dbg}.`50_gradhonors_sjam` SET `overall_total`=(`total_acad`*0.8)+(`total_cond`*0.2) WHERE `lvl`='$lvl'; ";
	$db->query($q);		

}


function getSjamRanks($db,$dbg,$dbo,$lvl,$type){
	$q="SELECT c.id AS scid,c.name AS student,gh.rank_{$type} AS rank,
			gh.rank_{$type} AS dbrank,gh.total_{$type} AS total,
			gh.total_acad,gh.total_cond
		FROM {$dbg}.`50_gradhonors_sjam` AS gh
		INNER JOIN {$dbo}.`00_contacts` AS c ON gh.scid=c.id
		WHERE gh.lvl='$lvl' ORDER BY gh.total_{$type} DESC LIMIT 15;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	return $data;
}	/* fxn */


function getSjamRanksTotal($db,$dbg,$dbo,$lvl){
	$q="SELECT c.id AS scid,c.name AS student,gh.overall_rank AS rank,
			gh.overall_rank AS dbrank,gh.overall_total AS total
		FROM {$dbg}.`50_gradhonors_sjam` AS gh
		INNER JOIN {$dbo}.`00_contacts` AS c ON gh.scid=c.id
		WHERE gh.lvl='$lvl' ORDER BY gh.overall_total DESC LIMIT 15;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	return $data;
}	/* fxn */


// gh.overall_total AS total
function getSjamRanksTotalAsc($db,$dbg,$dbo,$lvl){
	$q="SELECT c.id AS scid,c.name AS student,gh.overall_rank AS rank,
			gh.overall_rank AS dbrank,gh.total_wtd AS total
		FROM {$dbg}.`50_gradhonors_sjam` AS gh
		INNER JOIN {$dbo}.`00_contacts` AS c ON gh.scid=c.id
		WHERE gh.lvl='$lvl' ORDER BY gh.total_wtd ASC LIMIT 15;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	return $data;
}	/* fxn */



function getSjamGradHonorsOfShs($db,$dbg,$dbo,$lvl,$fqtr=5,$final=NULL){	
	$prevsy=DBYR-1;
	$pdbg=VCPREFIX.$prevsy.US.DBG;
	$ordercond="summ.`ave_q{$fqtr}` DESC";
	$wherecond="";
	if($final){
		$wherecond=" AND gh.total_wtd>0 "; $ordercond="gh.total_wtd ASC";				
	}	
		
	$q="SELECT
			gh.scid AS ghscid,gh.*,
			summ.scid,c.name AS `student`,
			summ.`ave_q1` AS `curr_q1`,summ.`ave_q2` AS `curr_q2`,summ.`ave_q3` AS `curr_q3`,summ.`ave_q4` AS `curr_q4`,
			summ.`ave_q$fqtr` AS `curr_acad`,
			summ.`conduct_q1` AS `curr_cond_q1`,summ.`conduct_q2` AS `curr_cond_q2`,summ.`conduct_q3` AS `curr_cond_q3`,summ.`conduct_q4` AS `curr_cond_q4`,						
			summ.`conduct_q$fqtr` AS `curr_cond`,
			psumm.`ave_q1` AS `prev_q1`,psumm.`ave_q2` AS `prev_q2`,psumm.`ave_q3` AS `prev_q3`,psumm.`ave_q4` AS `prev_q4`,			
			psumm.`ave_q$fqtr` AS `prev_acad`,			
			psumm.`conduct_q1` AS `prev_cond_q1`,psumm.`conduct_q2` AS `prev_cond_q2`,psumm.`conduct_q3` AS `prev_cond_q3`,psumm.`conduct_q4` AS `prev_cond_q4`,			
			psumm.`conduct_q$fqtr` AS `prev_cond`,
			cr.name AS classroom,sxn.name AS section			
		FROM {$dbo}.`00_contacts` AS `c`
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$pdbg}.05_summaries AS psumm ON psumm.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
		LEFT JOIN {$dbg}.50_gradhonors_sjam AS gh ON summ.scid=gh.scid		
		WHERE cr.level_id='$lvl' AND summ.`conduct_q$fqtr`>=90 $wherecond
		ORDER BY $ordercond LIMIT 15; ";
	debug($q);
	$sth=$db->querysoc($q);
	$d['rows']=$sth->fetchAll();
	$d['count']=$sth->rowCount();
	return $d;
	
}	/* fxn */


