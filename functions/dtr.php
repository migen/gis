<?php


function dtrLogin($db,$post,$dbg=PDBG){
		/* 1 get person left join attdlogs.id */
		/* 2 if no attdlogs.id, then insert, else update timeout */
		/* 3 session batch container - last persons loggedin */
		
		$date = $_SESSION['today'];				
		$time = $post['time'];				
		$code=trim($post['studcode']);
		$code=str_replace("-","",$code);						
		$dbo=PDBO;$dbp=DBP;
		// pr($post);
		$q="SELECT c.name AS name,c.code AS code,c.id AS ucid,p.photo,
				cr.name AS classroom,l.id AS lvl,b.id AS logid
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id 
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id 
			LEFT JOIN {$dbp}.photos AS p ON p.contact_id = c.id 
			LEFT JOIN (
				SELECT id,contact_id FROM {$dbg}.05_attendance_logs WHERE `date`='$date' 
			) AS b ON c.id=b.contact_id
			WHERE c.`code`='$code' LIMIT 1; ";		
		$sth=$db->querysoc($q);		
		$row=$sth->fetch();
		$_SESSION['attdrow']=$row;
		$ucid=$row['ucid'];
		$name=$row['name'];
		
				
		if($ucid){
			echo "contact found";	
			if($row['logid']){
				$q="UPDATE {$dbg}.05_attendance_logs SET `timeout`='$time' WHERE `contact_id`='$ucid' 
					AND `date`='$date' LIMIT 1; ";
				$msg="Updated timeout.";
			} else {
				$q="INSERT INTO {$dbg}.05_attendance_logs(`contact_id`,`date`,`timein`) VALUES 
					('$ucid','$date','$time'); ";
				$msg="Just loggedin.";
			}
			$db->query($q);
			
		} else {
			echo "no person found";
			$msg="No person found. ID Number - $code ";
		}
		$_SESSION['attdrow']['message']=$msg;			
		
		// exit;
		

}	/* fxn */