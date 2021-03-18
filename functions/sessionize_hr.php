<?php


function sessionize_hr($db){
	$dbg=PDBG;$dbo=PDBO;
	sessionizePaydaytype($db,$dbg);
	sessionizeSettingsHr($db,$dbg);
	sessionizePayperiods($db,$dbg);
	sessionizePaydaytypes($db,$dbg);
	sessionizeEmployees($db,$dbo,$dbg);
	
}	/* fxn */


function sessionizeEmployees($db,$dbo,$dbg){	
	$dbo=PDBO;
	$q=" SELECT c.id,c.name FROM {$dbo}.`00_contacts` AS c INNER JOIN {$dbg}.06_paymaster AS m ON c.id=m.ecid
		WHERE c.role_id>1 AND c.role_id<>'".RSUPP."' AND m.paygroup_id>0 AND c.id=c.parent_id AND c.is_active=1;";
	$sth=$db->querysoc($q);
	$xr=$sth->fetchAll();
	$rows=array();
	foreach($xr AS $row){
		/* 1 */
		$id=$row['id'];
		$rows[$id]=$row;
		/* 2 */
		$q=" SELECT * FROM {$dbg}.06_restdays WHERE `pcid`='$id' ORDER BY `restday` ASC; ";
		$sth=$db->querysoc($q);		
		$recs=$sth->fetchAll();				
		$rows[$id]['restdays']=array();
		foreach($recs AS $rec){ $rows[$id]['restdays'][]=$rec['restday']; }		
	}	/* foreach */	
	$_SESSION['hr']['employees']=&$rows;
	$_SESSION['hr']['employees_count']=count($rows);		

}	/* fxn */

function sessionizePaydaytype($db,$dbg){		
	$dbo=PDBO;
	$today=$_SESSION['today']; 
	$q 	 = " SELECT h.*,pd.name AS paydaytype FROM {$dbg}.06_holidays AS h
		LEFT JOIN {$dbg}.06_paydaytypes AS pd ON h.paydaytype_id=pd.id
		WHERE `date`='$today' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$paydaytype="Regular";$paydaytype_id=1;
	if($row){ $paydaytype=$row['paydaytype'];$paydaytype_id=$row['paydaytype_id']; } 
	$_SESSION['hr']['paydaytype']=&$paydaytype;
	$_SESSION['hr']['paydaytype_id']=&$paydaytype_id;
		
}  /* fxn */


function sessionizeSettingsHr($db,$dbg){		
	$dbo=PDBO;
	$q 	 = " SELECT `name`,`value` FROM {$dbg}.06_settings_hr  ORDER BY `name` ASC; ";
	$sth = $db->querysoc($q);
	$settings = $sth->fetchAll();
	$_SESSION['hr']['settings']=array();
	foreach($settings AS $row){
		$k = $row['name'];
		$v = $row['value'];
		$_SESSION['hr']['settings'][$k] = $v;
	}							
}  /* fxn */


function sessionizePaydaytypes($db,$dbg){ $_SESSION['hr']['paydaytypes'] = fetchRows($db,"{$dbg}.06_paydaytypes","*","name"); } /* fxn */

function sessionizePayperiods($db,$dbg){		
	$dbo=PDBO;
	$q 	 = " SELECT * FROM {$dbg}.06_payperiods WHERE is_active=1 ORDER BY `begdate` ASC; ";
	$sth = $db->querysoc($q);
	$settings = $sth->fetchAll();
	$_SESSION['hr']['payperiods']=array();
	foreach($settings AS $row){
		$k = $row['id'];
		$v = $row['name'];
		$_SESSION['hr']['payperiods'][$k] = $v;
	}					
		
}  /* fxn */

