<?php


function isValidEmployeexxx($db,$post){
	$dbo=PDBO;
	$dbo="2011_abc";
	$dbp=DBP;$dbg=PDBG;
	$code=trim($post['usercode']);
	$code=str_replace("-","",$code);		
	$q=" SELECT id,name,role_id FROM {$dbo}.`00_contacts` AS c WHERE c.`code`='$code' LIMIT 1; ";		
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return ($row['role_id']>1)? true:false;
			
}

function hoursOverxxx($tbig,$tlil,$get_floor=false){	
	$big = strtotime($tbig);
	$lil = strtotime($tlil);
	$x = $big-$lil;
	$hrs = number_format(($x/60/60),2);
	$hrs=($get_floor)? floor($hrs):ceil($hrs);
	return $hrs;
}	/* fxn */

function roundoffHourxxx($time){
	return date('H:00:00',strtotime($time));	
	
}	/* fxn */

function getPayrollxxx($db,$dbhr="2011_abc"){
	$dbo=PDBO;
	$q="SELECT
			c.name AS employee,
			b.pcid,
			SUM(b.`hours_overtime`) AS total_hours_overtime,
			SUM(b.`hours_special`) AS hours_special			
		FROM {$dbhr}.`00_contacts` AS c
			LEFT JOIN (
				SELECT * FROM {$dbhr}.dtr_emps WHERE 
					`date` >='$beg' AND `date` <='$end' 
			) AS b ON b.pcid=c.id
		WHERE c.`id`=c.`parent_id` AND c.`role_id` > '".RSTUD."'
		$condrole GROUP BY b.pcid ";	
	debug($q);			
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);
	
	return $data;

}	/* fxn */



