<?php




function getScheduleEnstep($db,$sy,$scid){	
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q="SELECT summ.crid,sk.enstep
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.05_rcards_schedules AS sk ON sk.crid=summ.crid
		WHERE summ.scid=$scid LIMIT 1;";
	// pr("schedulesFxn-getSchedule".$q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;		
	
}	/* fxn */




function getScheduleByModule($db,$sy,$scid,$module='tuition'){	
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q="SELECT summ.crid,sk.{$module}
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.05_rcards_schedules AS sk ON sk.crid=summ.crid
		WHERE summ.scid=$scid LIMIT 1;";	
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;		
	
}	/* fxn */



