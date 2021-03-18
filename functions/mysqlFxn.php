<?php

function a(){
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$dbnew="00_bbb";
	$dbold="00_aaa";

	$q="CREATE DATABASE IF NOT EXISTS {$dbnew}; ";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "created db succeeded":"created db failed";
	
	// $q="USE {$dbold};SHOW TABLES from {$dbold};";
	$q="SHOW TABLES from {$dbold};";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
	

	

}	/* fxn */

