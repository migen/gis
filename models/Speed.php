<?php
class Speed extends Model{
public function __construct(){
	parent::__construct();
}
public function getInfoContacts($pcid,$dbg=PDBG){	$dbo=PDBO;		$q = "SELECT			c.*,c.id AS ucid,c.parent_id AS pcid,c.name AS contact,			p.*,s.*,ctp.ctp		FROM {$dbo}.`00_contacts` AS c			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id		WHERE c.id='$pcid' OR c.`code` LIKE '%$pcid%' OR c.`name` LIKE '%$pcid%' OR	c.`account` LIKE '%$pcid%'		LIMIT 30; ";	$sth	= $this->db->querysoc($q);	$data['profile'] = $sth->fetchAll();			return $data;}	/* fxn */

}  /* Speed */