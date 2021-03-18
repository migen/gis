<?php


function syncAllAssessed($db,$sy){
$dbo=PDBO;
$dbg=VCPREFIX.$sy.US.DBG;

$q="UPDATE {$dbg}.03_tsummaries AS a
INNER JOIN {$dbg}.05_summaries AS summ ON a.scid=summ.scid 
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
INNER JOIN (
	SELECT * FROM {$dbo}.`03_tuitions` 
) AS b ON (b.level_id = cr.level_id && b.num=cr.num)
SET a.assessed = b.total ; ";
debug("sync_tuitionsFxn: ".$q);
$db->query($q);

}	/* fxn */

