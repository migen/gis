<?php


function sessionizeBranchesByUser($db){
	$srid=$_SESSION['srid'];
	if(in_array($srid,array(RMIS,RREG))){
		if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
		
	}	
}	/* fxn */



function sessionizeUserRoles($db){
	$pcid=$_SESSION['user']['parent_id'];
	$dbo=PDBO;
	$q = "SELECT c.id,c.parent_id,c.id AS ucid,c.role_id,c.privilege_id,c.account,r.name AS role,c.code,c.title_id,
			t.name AS title,c.`account`,c.branch_id
		FROM {$dbo}.`00_contacts` AS c	
			LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		WHERE c.parent_id = '$pcid';";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['user_roles']=$rows;
	$_SESSION['num_user_roles']=$sth->rowCount();	
	

}	/* fxn */



function sessionizeUserByUcid($db,$ucid){
	$dbo=PDBO;
	$q="SELECT c.name AS fullname,c.id AS ucid,c.id AS contact_id,c.parent_id,c.parent_id AS pcid,c.code,c.title_id,c.`account`,
			c.`account` AS username,c.is_active,c.role_id,c.privilege_id,r.name AS role,r.home,t.name AS title,c.branch_id
		 FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_roles` AS r ON r.id = c.role_id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id			
		 WHERE c.`id` = $ucid  LIMIT 1; ";
	$fxn=__FUNCTION__;
	$sth=$db->querysoc($q,$fxn);
	$row = $sth->fetch();
	$_SESSION['user']=$row;	

}	/* fxn */


function sessionizeAxn($db,$role=false){ 

	$dbo=PDBO;
	$cond = ($role)? " OR `role_id` = '$role'":NULL; 
	$q = "SELECT * FROM {$dbo}.`00_actions` WHERE 1=1 $cond; ";	
	$sth = $db->querysoc($q);
	$_SESSION['actions'] = $sth->fetchAll();

	$cond = ($role)? " WHERE `role_id` = '$role'":NULL; 
	$q = "SELECT * FROM {$dbo}.`00_actions` $cond; ";
	$sth = $db->querysoc($q);
	$actions = $sth->fetchAll();

	foreach($actions AS $row){
		$code = $row['code'];
		$_SESSION['axn'][$code] = $row['id'];
	}
	
}	/* fxn */


function sessionizeInfo(){
	$user=$_SESSION['user'];$_SESSION['home']=$user['home'];		
	$_SESSION['brid']=$user['branch_id'];$_SESSION['srid']=$srid=$user['role_id'];	
	$_SESSION['suid']=$user['ucid'];$_SESSION['spid']=$user['pcid'];
	$_SESSION['ucid']=$user['ucid'];$_SESSION['pcid']=$user['pcid'];$_SESSION['role']=$user['role'];	
	$_SESSION['order']='DESC';
}	/* fxn */


function sessionizeBranch($db,$user){
	$brid=$user['branch_id'];$dbo=PDBO;
	$row=fetchRow($db,"{$dbo}.`00_branches`",$brid,$field="*");
	$_SESSION['brcode']=$row['code'];$_SESSION['branch']=$branch=$row['name'];		
	$_SESSION['suid']=$user['ucid'];$_SESSION['spid']=$user['pcid'];
	$_SESSION['ucid']=$user['ucid'];$_SESSION['pcid']=$user['pcid'];$_SESSION['role']=$user['role'];	
	$_SESSION['order']='DESC';
}	/* fxn */


function sessionizeTime(){
	$_SESSION['date']=$date=date('Y-m-d');$_SESSION['time']=$time=date('H:i:s');$_SESSION['today']=$date;
	$_SESSION['moid']=date('m',strtotime($date));$_SESSION['day']=date('d',strtotime($date));
	$_SESSION['year']=DBYR;
	$_SESSION['month_code']=strtolower(date('M',strtotime($date)));
	$_SESSION['month']=date('F',strtotime($date));$_SESSION['datetime']=$date.' '.$time;
}  	/* fxn */


function sessionizeSettingsGis($db,$dbg=PDBG){		/* stays here,used by models/user direct inherits model.php */
	$dbo=PDBO;	
	$q=" SELECT name,value FROM {$dbo}.`00_settings` ; ";
	$sth=$db->querysoc($q);$rows=$sth->fetchAll();
	foreach($rows AS $row){ $k=$row['name'];$v=$row['value'];$_SESSION['settings'][$k]=$v; }	
	$_SESSION['sy']=$_SESSION['settings']['school_year'];
	$_SESSION['qtr']=$_SESSION['settings']['quarter'];	
	/* actions full array, axn only code */
	$user=$_SESSION['user'];$srid=$user['role_id'];
	if($srid!=RSTUD){ $axnrole=false;sessionizeAxn($db,$axnrole); }
	/* college */
	
	if(isset($_SESSION['settings']['has_college']) && ($_SESSION['settings']['has_college']==1)){
		require_once(SITE.'functions/sessionize_collegeFxn.php');sessionizeCollegeSettings($db,$dbg=PDBG);
	}
		
		
}  /* fxn */


function urooms($db,$ucid){
	$dbo=PDBO;
	$q = " SELECT r.name AS room, rc.*, ctc.`id` AS `ctcid`, ctc.name AS ctc 
			FROM {$dbo}.rooms_contacts AS rc 
				LEFT JOIN {$dbo}.rooms AS r ON rc.room_id = r.id
				LEFT JOIN {$dbo}.ctagcategories AS ctc ON r.ctagcategory_id = ctc.id
			WHERE rc.contact_id = '$ucid'; ";
	$sth = $db->querysoc($q);
	$urooms = $sth->fetchAll();	
	$_SESSION['urooms'] = $urooms;	
	$uroom_ids = buildArray($urooms,'room_id');
	$_SESSION['uroom_ids'] = $uroom_ids;		

}  	/* fxn */


function resessionizeUser($db,$ucid){
	sessionizeUserByUcid($db,$ucid);
	sessionizeUser($db,$ucid);
	
}	/* fxn */


function sessionizeUser($db,$ucid){
	require_once(SITE."views/customs/".VCFOLDER."/customs.php");
	sessionizeUserRoles($db);
	sessionizeInfo();
	sessionizeTime();
	sessionizeSettingsGis($db);	
	if($_SESSION['settings']['has_axis']==1){
		require_once(SITE."functions/sessionize_axis.php");
		sessionize_axis($db,PDBG);		
		// pr('sesh_axis');exit;
	}
	$user=$_SESSION['user'];$srid=$user['role_id'];	
	if($srid!=RSTUD){ sessionizeAxn($db,$role=false); }	
	if($_SESSION['settings']['has_branches']==1){ sessionizeBranch($db,$user); sessionizeBranchesByUser($db); }			
	
}	/* fxn */
