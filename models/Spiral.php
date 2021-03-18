<?php
class Spiral extends Model{
public function __construct(){
	parent::__construct();
}public function getClassroom($dbg,$crid){	$db	=&	$this->db;	$q="SELECT name,name AS classroom,acid FROM {$dbg}.05_classrooms WHERE id='$crid' LIMIT 1; ";	$sth=$db->querysoc($q);	return $sth->fetch();}	/* fxn */
}  /* Ab */