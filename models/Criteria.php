<?php
class Criteria extends Model{
public function __construct(){
	parent::__construct();
}
public function getCriteriaDetails($criteria_id,$dbg=PDBG){	$dbo=PDBO;	$q = " SELECT cri.*, cty.name AS crstype 		   FROM {$dbo}.`05_criteria` AS cri			   INNER JOIN {$dbo}.`05_crstypes` AS cty ON cri.crstype_id = cty.id		   WHERE cri.id = '$criteria_id' LIMIT 1; ";		// pr($q);	$sth = $this->db->querysoc($q);	return $sth->fetch();}	/* fxn */
}  /* Criteria */