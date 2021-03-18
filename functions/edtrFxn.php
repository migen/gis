<?php



function edtrLogin($db,$dbg,$post){
	$dbp=PDBP;$dbo=PDBO;
	$paydaytype_id = $_SESSION['hr']['paydaytype_id'];

	/* 1 get person left join attdlogs.id */
	/* 2 if no attdlogs.id, then insert, else update timeout */
	/* 3 session batch container - last persons loggedin */
	/* 4 process workhours */
	
	$today = $_SESSION['today'];				
	$time = $post['time'];				
	$code=trim($post['usercode']);
	$code=str_replace("-","",$code);			
	
	$q="SELECT c.name AS name,c.name AS employee,c.code AS emplcode,c.account AS emplacct,c.id AS ecid,c.parent_id AS pcid,p.photo,
			b.*,b.id AS logid,b.ecid AS logecid
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbp}.photos AS p ON p.contact_id = c.id 
		LEFT JOIN (
			SELECT * FROM {$dbg}.60_dtr_emps WHERE `date`='$today' 
		) AS b ON c.id=b.ecid
		WHERE c.`code`='$code' LIMIT 1; ";	
	$sth=$db->querysoc($q);		
	$row=$sth->fetch();
	$_SESSION['attdrow']=$row;
	$ecid=$row['ecid'];
	$name=$row['name'];
	// unset($row['photo']);
	// pr($row);exit;

	
	if($ecid){
		if($row['logid']){
			$q="UPDATE {$dbg}.60_dtr_emps SET `timeout`='$time' WHERE `ecid`='$ecid' AND `date`='$today' LIMIT 1; ";
			$msg="Updated timeout.";
		} else {
			$q="INSERT INTO {$dbg}.60_dtr_emps(`ecid`,`date`,`timein`) VALUES ('$ecid','$today','$time'); ";
			$msg="Just loggedin.";
		}
		$db->query($q);
	} else {
		echo "No person found";
		$msg="No person found. ID Number - $code ";		
	}


	/* 2 sessionize */
	$_SESSION['attdrow']['message']=$msg;			

	/* 3 get dtr row */		
	processWorkhours($db,$ecid,$today);
		
		

}	/* fxn */



function hoursOver($tbig,$tlil,$get_floor=false){	
	$big = strtotime($tbig);
	$lil = strtotime($tlil);
	$x = $big-$lil;
	$hrs = number_format(($x/60/60),2);
	$hrs=($get_floor)? floor($hrs):ceil($hrs);
	return $hrs;
}	/* fxn */


function roundoffHour($time){
	return date('H:00:00',strtotime($time));	
	
}	/* fxn */



function processWorkhours($db,$ecid,$today){
	$dbo=PDBO;
	require_once(SITE.'functions/hr.php');
	$cuttimein=$_SESSION['hr']['settings']['timein_employees'];
	$cuttimeout=$_SESSION['hr']['settings']['timeout_employees'];
	$hrs_lunchbreak=1;

	/* 1 get dtr row */
	$q="SELECT *,id AS dtrid FROM {$dbg}.60_dtr_emps WHERE `date`='$today' AND `ecid`='$ecid'; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();		
	$timein=$row['timein'];
	$timeout=$row['timeout'];
	$paydaytype_id=$row['paydaytype_id'];
	$is_approved=$row['is_approved'];
	$dtrid=$row['dtrid'];
	
	$is_absent = (($timein==0) && ($timeout==0))? true:false;
	
	if($is_absent){
		$workhours=0;
		$debug="Absent<br />";
	} else {
		$debug="";
		$debug.= "ecid: $ecid <br />";
		$debug.= "timein: $timein <br />";
		$debug.= "cuttimein: $cuttimein <br />";
		$debug.= "timeout: $timeout <br />";
		$debug.= "paydaytype_id: $paydaytype_id <br />";
		$debug.= "<hr />";		
		$hrs_tardy = ($timein>$cuttimein)? hoursOver($timein,$cuttimein,$get_floor=false):0;
		$debug.= "hrs_tardy: $hrs_tardy <br />";
		$hrs_overtime = ((!$hrs_tardy) && ($timeout>$cuttimeout))? hoursOver($timeout,$cuttimeout,$get_floor=true):0;
		$debug.= "hrs_overtime: $hrs_overtime <br />";
		
		$hrs_undertime = ($timeout<$cuttimeout)? hoursOver($cuttimeout,$timeout,$get_floor=false):0;
		$debug.= "hrs_undertime: $hrs_undertime <br />";
	
		if(($timein<=$cuttimein) && ($timeout>=$cuttimeout)){	/* case 1: normal in and out */
			$debug.= "Case 1: Normal in and out <br />";
			$workhours=hoursOver($cuttimeout,$cuttimein,$get_floor=false);
			$workhours-=$hrs_lunchbreak;						
		} elseif(($timein<=$cuttimein) && ($timeout<$cuttimeout)){	/* case 2: undertime */
			$debug.= "Case 2: Normal in but undertime <br />";
			$workhours=8-$hrs_undertime;
		} elseif(($timein>$cuttimein) && ($timeout>=$cuttimeout)){	/* case 3: late */
			$debug.= "Case 3: Late in but normal out <br />";
			$workhours=8-$hrs_tardy;
		} elseif(($timein>$cuttimein) && ($timeout<$cuttimeout)){	/* case 4: late and undertime */
			$debug.= "Case 4: Both Late in and Undertime <br />";
			$workhours=8-($hrs_tardy+$hrs_undertime);				
		}		
	}	/* absent */
	
	
	$debug.= "Workhours: $workhours <br />";
	pr($debug);

	
	/* 2 update dtr hours */	
	if($paydaytype_id%2){ $suffix='regular';$suffixetc='special';
	} else { $suffix='special';$suffixetc='regular'; }
	
	$q="UPDATE {$dbhr}.dtr_emps SET ";
		if($is_absent){
			$q.=" `hours_absence`='8' ";	
		} else {
			$q.="
				`hours_overtime`='$hrs_overtime', 
				`hours_undertime`='$hrs_undertime', 
				`hours_tardy`='$hrs_tardy',	
				`hours_{$suffix}`='$workhours',
				`hours_{$suffixetc}`='0'
			";				
		}
	$q.=" WHERE `id`='".$row['dtrid']."' LIMIT 1; "; 
	pr($q);
	exit;
	$sth=$db->query($q);
	
	
	// return $data;
	
	
	

}	/* fxn */

