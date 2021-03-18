<?php
class Title extends Model{

public function __construct(){
	parent::__construct();
}
public function titlesDetails($dbg=PDBG){	$q = "  SELECT 				t.*,t.id AS title_id,r.id AS role_id,r.name AS role 			FROM {$dbo}.`00_titles` AS t				INNER JOIN {$dbo}.`00_roles` AS r ON t.role_id = r.id			ORDER BY r.name,t.privilege_id ";	$sth = $this->db->querysoc($q);	return $sth->fetchAll();}	/* fxn */

}  /* Title */