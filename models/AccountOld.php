<?php

class Account extends Model{



/* --------------------- common duplicates ------------------------------------------------------------ */



public function getStudentAccounts($dbg,$scid,$sy,$fields=NULL){

	$q = " 
		SELECT 
			c.id AS scid,c.code AS student_code,c.name AS student,
			c.is_active,c.is_cleared,c.account,
			summ.crid AS crid,s.prevcrid AS prevcrid,
			c.`sy`,s.is_sectioned,s.is_enrolled,s.year_entry,s.batch,
			s.is_discountable,s.years_in_school,s.level_entry,  
			c.is_male,p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,
			p.sms,p.email,p.phone,
			cr.name AS classroom,cr.section_id,cr.level_id,cr.acid AS acid,
			l.is_k12,l.is_ps,l.is_gs,l.is_hs,l.name AS level,
			sec.name AS section		
			$fields
		FROM {$dbg}.05_students AS s 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON s.contact_id = p.contact_id
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		WHERE s.contact_id = '$scid' LIMIT 1; 
	";	
				
	$sth = $this->db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */




public function __construct(){
	parent::__construct();
}





public function enrollments($dbg,$sy,$crid){

$q = "
	SELECT 
		c.`id` AS `scid`,c.`code`,c.`code` AS `student_code`,c.`name` AS `student`,
		sum.`id` AS `sumid`,sum.`assessed`,sum.`paid`,sum.`outstanding`,sum.`date_lastpaid`,		
		sum.`ave_q5` AS `afg`,sum.`conduct_q5` AS `cfg` 
	FROM {$dbg}.`05_summaries` AS `sum`
		LEFT JOIN {$dbg}.05_students AS `s` ON sum.`scid` = s.`contact_id`
		LEFT JOIN {$dbo}.`00_contacts` AS `c` ON sum.`scid` = c.`id`
		LEFT JOIN {$dbo}.`00_profiles` AS `p` ON sum.`scid` = p.`contact_id`
		LEFT JOIN {$dbg}.05_classrooms AS `cr` ON sum.`crid` = cr.`id`
	WHERE 	sum.`crid` 		= '$crid'	
		AND c.`is_active`			= '1'
	ORDER BY c.`is_male` DESC,c.`name` ASC;
";

// $_SESSION['q'] = isset($_SESSION['q'])? $_SESSION['q'] : "";
// $_SESSION['q'] .= "models-account-enrollments <br />".$q."<br />";
// pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



public function studentAssessor($dbg,$scid,$sy){

$q = " SELECT sum.`is_fullypaid`,sum.`assessed`,sum.`paid`,sum.`outstanding`,
		t.`total`,c.name AS `student`,c.code
FROM {$dbg}.`05_summaries` AS `sum` 
	LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
	LEFT JOIN {$dbo}.`03_tuitions` AS t ON cr.level_id = t.level_id
	LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
WHERE sum.`scid` = '$scid' LIMIT 1;  
"; 
$sth = $this->db->querysoc($q);
return $sth->fetch();


}	/* fxn */


public function payTuition($dbg,$sy,$date,$ecid,$scid,$amount,$reference,$assessed,$newpaid,$outstanding,$is_fullypaid){

$q = " INSERT INTO {$dbg}.30_payments (`scid`,`ecid`,`date`,`amount`,`reference`) 
VALUES ('$scid','$ecid','$date','$amount','$reference'); ";

$q .= " 
	UPDATE {$dbg}.05_summaries SET
		`assessed` 	= '$assessed',
		`paid` 	 	= '$newpaid',
		`outstanding` 	 = '$outstanding',
		`is_fullypaid` 	 = '$is_fullypaid'		
	WHERE `scid`	=	'$scid' LIMIT 1;		
";

/* 3 - students.is_enrolled */
$q .= " UPDATE {$dbg}.05_students SET `is_enrolled` = '1' WHERE `contact_id` = '$scid' LIMIT 1; ";

/* 4 - contacts.is_cleared */
if($is_fullypaid){ $q .= " UPDATE {$dbo}.`00_contacts` SET `is_cleared` = '1' WHERE `id` = '$scid' LIMIT 1; "; }

// pr($q); exit;
$this->db->query($q);

}	/* fxn */


// $this->Account->payTuition($sy,$date,$ecid,$scid,$amount,$reference,$assessed,$newpaid,$outstanding,$is_fullypaid);	
public function updateTuition($dbg,$tpid,$sy,$ecid,$scid,$date,$amount,$reference,$assessed,$paid,$outstanding,$is_fullypaid){

$q = " UPDATE {$dbg}.30_payments SET
			`date`		= '$date',
			`amount`	= '$amount',
			`reference`	= '$reference',
			`ecid`	= '$ecid'			
		WHERE	 `id`		= '$tpid' LIMIT 1;
 ";

$q .= " 
	UPDATE {$dbg}.05_summaries SET
		`assessed` 	= '$assessed',
		`paid` 	 	= '$paid',
		`outstanding` 	 = '$outstanding',
		`is_fullypaid` 	 = '$is_fullypaid'		
	WHERE `scid`	=	'$scid' 
	LIMIT 1;		
";

/* 3 - students.is_enrolled */
$q .= " UPDATE {$dbg}.05_students SET `is_enrolled` = '1' WHERE `contact_id` = '$scid' LIMIT 1; ";

/* 4 - contacts.is_cleared */
if($is_fullypaid){ $q .= " UPDATE {$dbo}.`00_contacts` SET `is_cleared` = '1' WHERE `id` = '$scid' LIMIT 1; "; }

// pr($q); exit;
$this->db->query($q);

}	/* fxn */



public function tuitionPayment($dbg,$tpid){

$q = "
	SELECT tp.* 
	FROM {$dbg}.30_payments AS tp
	WHERE 	tp.`id` = '$tpid' LIMIT 1;

";
$sth = $this->db->querysoc($q);
return $sth->fetch();

}	/* fxn */



public function tuitionPayments($dbg,$scid,$sy){

$q = "
	SELECT tpays.*,tpays.scid AS scid,tpays.id AS tpid,
			c.name AS employee
	FROM {$dbg}.30_payments AS tpays
		LEFT JOIN {$dbo}.`00_contacts` AS c ON tpays.ecid = c.id
	WHERE 	tpays.scid  = '$scid'
";
// pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


public function products(){
$q = "
	SELECT 
		p.*
	FROM {$dbo}.`03_products` AS p
";
// pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


public function sessionizeAccount($dbg=PDBG){
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->db;

	$ucid = $_SESSION['user']['ucid'];
	
	/* 2 - settings */	
	sessionizeSettingsGis($db,$dbg);	
	$this->urooms($ucid);
	sessionizeTablesAxis($db,$dbg);
		
		
}		/* fxn */


public function ehistory($dbg,$scid){
	$q = "
		SELECT 
			c.id AS scid,c.code AS student_code,c.name AS student,
			cr.name AS classroom,
			sum.id AS sumid,sum.date_lastpaid,sum.assessed,sum.paid,sum.outstanding	
		FROM {$dbg}.05_summaries AS sum 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		WHERE 	
				sum.`scid`   = '$scid';
		ORDER BY c.`name` DESC;
	";
	// pr($q);
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}




public function getBalance($ucid){
	$q    = " SELECT b.*,c.`id`,c.`code`,c.`account`,c.`name`,c.`id` AS `ucid`,p.photo,
			t.`acn` AS `card_acn`,c.`acn` AS `db_acn` 
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`balances` AS b ON b.contact_id = c.id		
			LEFT JOIN ".DBP.".photos AS p ON p.contact_id = c.id		
			LEFT JOIN {$dbo}.`terminals` AS t ON t.ucid = c.id		
		WHERE c.`id` = '$ucid' LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();

}	


	
public function studentSummary($dbg=PDBG,$sy,$scid){
$q = "SELECT sum.id AS sumid,cr.name AS classroom,c.name AS student,c.code AS student_code,cr.*,sum.*
	FROM {$dbg}.05_summaries AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
	WHERE sum.`scid`  = '$scid' LIMIT 1; ";

$sth = $this->db->querysoc($q);
return $sth->fetch();


}	/* fxn */
		





}  /* Account */