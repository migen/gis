<?php

class Hrd extends Model{

public function __construct(){
	parent::__construct();
}


public function instruments($dbg=PDBG){	
	$dbo=PDBO;	
	$q = " SELECT *,id AS instrid FROM {$dbg}.instruments; ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll(); 				
}	// fxn

public function instrument($instrid,$dbg=PDBG){	
	$dbo=PDBO;	
	$q = " SELECT *,id AS instrid FROM {$dbg}.instruments WHERE `id` = '$instrid' ; ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetch(); 				
}	// fxn


public function icomponents($instrid){	
	$dbo=PDBO;	
	$dbg=PDBG;
	$q = " SELECT icomp.*,i.name AS icriteria,i.instrutype_id 
			FROM {$dbg}.instrucomponents AS icomp
			LEFT JOIN {$dbg}.instrucriteria AS i ON icomp.instrucriteria_id = i.id
			ORDER BY i.instrutype_id; ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll(); 				
}	// fxn


public function instrutypes($dbg=PDBG){	
	$dbo=PDBO;	
	$q = " SELECT *,id AS instyid FROM {$dbg}.instrutypes; ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll(); 				
}	// fxn


public function instrucriteria($dbg=PDBG){	
	$dbo=PDBO;		
	$q = " SELECT icri.*,itype.name AS itype FROM {$dbg}.instrucriteria AS icri
			LEFT JOIN {$dbg}.instrutypes AS itype ON icri.instrutype_id = itype.id; ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll(); 				
}	// fxn






}  /* Hrd */