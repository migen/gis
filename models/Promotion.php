<?php

class Promotion extends Model{


public function __construct(){
	parent::__construct();
}


public function index(){
	echo "promotion model index";

}	/* fxn */




public function ntc($crid,$dbg=PDBG){		/* for reg or teachers/promotions ntc-next TMP classroom */
$dbo=PDBO;
/* 1 - get next level_id */
$q = " SELECT (level_id + 1) AS nlid FROM {$dbg}.05_classrooms WHERE id = '$crid' ;	";
$sth = $this->db->querysoc($q);
$row = $sth->fetch();

/* 2 - get next level tmp classroom */
$q = "
	SELECT cr.id AS crid,cr.name AS classroom,cr.acid AS acid,cr.level_id AS lvl	
	FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
	WHERE 
			cr.level_id = '".$row['nlid']."'
		AND	sec.code = 'TMP';		
";
$sth = $this->db->querysoc($q);
$row = $sth->fetch();

return $row;

}	/* fxn */
	
/* for reg or teachers/promotions ctc-current TMP classroom */
public function ctc($crid,$dbg=PDBG){	
$dbo=PDBO;

/* 1 - get next level_id */
$q = " SELECT level_id AS lid FROM {$dbg}.05_classrooms WHERE id = '$crid' ;	";
$sth = $this->db->querysoc($q);
$row = $sth->fetch();

/* 2 - get current level tmp classroom */
$q = "
	SELECT cr.id AS crid,cr.name AS classroom,cr.acid AS acid,cr.level_id AS lvl	
	FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
	WHERE 
			cr.level_id = '".$row['lid']."'
		AND	sec.code = 'TMP';		
";
$sth = $this->db->querysoc($q);
$row = $sth->fetch();

return $row;

}	/* fxn */


public function getPrep($dbg,$crid,$sy){
$dbo=PDBO;
$q = " SELECT * FROM {$dbg}.05_promotions WHERE `crid` = '$crid' LIMIT 1; ";
$sth = $this->db->querysoc($q);
return $sth->fetch();

}	/* fxn */



public function lockPromotion($crid,$this_year,$dbg=PDBG){
	$dbo=PDBO;
	$today = $_SESSION['today'];
	$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '1',`finalized_date` = '".$today."' 
		WHERE `crid` = '$crid' LIMIT 1; ";
	$this->db->query($q);
	
}	/* fxn */














}	/* PromotionModel */
