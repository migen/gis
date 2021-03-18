<?php

class Index extends Model{

public function __construct(){
	parent::__construct();
}



function passgen($len=8,$nsc=1){
	$special = "+=!@?$#*%";
	$alphaNum = "123456789qwertyupasdfghjkzxcvbWERTYUPASDFGKLZXC"; 
	$pw  = '';	 						/* password */
	$sc = str_shuffle($special);		/* specialChars */
	$pw .= substr($sc,1,$nsc);	
	$rc = $len - $nsc;					/* remaining chars */
	$an = str_shuffle($alphaNum);
	$pw .= substr($an,1,$rc);
	return str_shuffle($pw);	
}


public function dashboard($dbg=PDBG){
	$dbo=PDBO;	
	/* {$dbo}.`00_contacts`  with due collectibles */
	$q = "
		SELECT name,amount_due FROM {$dbo}.`00_contacts`  
		WHERE amount_due > 0
	";
	$sth = $this->db->querysoc($q);
	$data['contacts'] = $sth->fetchAll();

	/* open txns */
	$q = "
		SELECT t.id,t.name,t.amount FROM {$dbg}.txns AS t
		LEFT JOIN {$dbo}.`00_contacts`  AS c ON c.id = t.contact_id
		WHERE t.status_id = 2
	";
	$sth = $this->db->querysoc($q);
	$data['txns'] = $sth->fetchAll();
	
	/* unpaid {$dbg}.sales invoice */
	$q = "
		SELECT t.id,t.name,t.amount FROM {$dbg}.txns AS t
		LEFT JOIN {$dbo}.`00_contacts`  AS c ON c.id = t.contact_id
		WHERE t.status_id = 2
	";
	$sth = $this->db->querysoc($q);
	$data['txns'] = $sth->fetchAll();
	
	
	
	return $data;
	
}

public function selects($dbg=PDBG){
	$dbo=PDBO;	
	$data['statuses'] = $this->fetchRows("{$dbg}.statuses",'id,name','id');	
	$data['txntypes'] = $this->fetchRows("{$dbg}.txntypes");	
	$data['accounts'] = $this->fetchRows("{$dbg}.accounts");	
	$data['contacts'] = $this->fetchRows("".PDBO.".`00_contacts`");	
	$data['cities'] = $this->fetchRows("".PDBO.".cities");	
	return $data;
}




public function read($alias){	
	$dbo=PDBO;	
	$q  = " SELECT w.*, c.name as user 
			FROM {$dbo}.`00_webpages` AS w 
				LEFT JOIN {$dbo}.`00_contacts` AS c ON w.contact_id = c.id ";
	$q .= " WHERE w.alias = '".$alias."' LIMIT 1";
	$sth = $this->db->querysoc($q);
	return $sth->fetch();

}





}  /* IndexModel */