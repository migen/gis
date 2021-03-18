<?php



function syncPayables($db,$sy,$lvl=4){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT * FROM {$dbo}.03_classfees WHERE sy=$sy AND level_id=$lvl ORDER BY feetype_id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['classfees']=$classfees=$sth->fetchAll();
	$data['num_classfees']=$num_cf=$sth->rowCount();
	
	// pr($data);
	// exit;

	$qi="INSERT INTO {$dbo}.30_payables(sy,scid,feetype_id,amount,due_on)VALUES";
	foreach($classfees AS $cf){
		$feetype_id=$cf['feetype_id'];
		$amount=$cf['amount'];
		$due_on=$cf['due_on'];
		$q="SELECT p.id,p.scid AS pscid,summ.scid AS summscid,p.feetype_id
			FROM {$dbg}.05_summaries AS summ
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id		
			LEFT JOIN {$dbo}.30_payables AS p ON (p.sy=$sy AND p.scid=summ.scid
				AND p.feetype_id=$feetype_id)
			WHERE cr.level_id=$lvl 
			ORDER BY summ.scid;		
		";
		pr($q);
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		/* querybuilder for inserting classfee */
		foreach($rows AS $row){
			if(empty($row['pscid'])){
				$qi.="($sy,".$row['summscid'].",$feetype_id,'$amount','$due_on'),";
				
			}
			
		}		
	}	/* foreach */
	$qi=rtrim($qi,",");$qi.=";";	
	pr("insert-query:".$qi);
	$sth=$db->query($qi);echo ($sth)? "Success":"Fail";		
	

}	/* fxn */





