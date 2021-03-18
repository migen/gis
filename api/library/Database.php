<?php

class Database extends PDO{  /* bread */

	public function __construct($dbtype,$dbhost,$dbname,$dbuser,$dbpass,$dbport=DBPORT){
		try {
			parent::__construct($dbtype.":dbhost=".$dbhost.";port=".$dbport.";dbname=".$dbname.";",$dbuser,$dbpass);
		} catch (PDOException $e) { echo "Error!: " . $e->getMessage()."<br/> Check DB if running."; die(); }		
	}
	 
	public function querysoc($q,$fxn=NULL){
		$sth = $this->query($q);
/* ------------------------ */
	if(!$sth){ echo isset($fxn)? $fxn:NULL; 
		pr($q); die('Query failed. '.mysql_error());  } 	/* dev stage, redirect unauth if live */
/* ------------------------ */
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		return $sth;		
	}	/* fxn */
		
	public function add($table,$data){
		$fields = implode('`,`',array_keys($data));
		$fvalues = ':'.implode(',:',array_keys($data));
		$q = "INSERT INTO $table (`$fields`) VALUES ($fvalues);";
		Session::set('q',$q);
		$sth = $this->prepare($q);
		foreach($data as $key => $value){ $sth->bindValue(":$key",$value); }
		if($sth->execute()){  return true; } else { return false; }		
	}	/* fxn */
		
	public function update($table,$data,$where){
		$fvPairs = NULL;
		foreach($data as $key=> $value) { $fvPairs .= "`$key`=:$key,"; }
		$fvPairs = rtrim($fvPairs,',');
		$q = "UPDATE $table SET $fvPairs WHERE $where LIMIT 1;";
		$sth = $this->prepare($q);
		$_SESSION['q'] = $q;
		foreach ($data as $key => $value) {
			$value = stripslashes($value);
			$sth->bindValue(":$key",$value);
		}		
		if($sth->execute()){ 
			Session::set("message","Updated successfully."); return true;
		} else {
			Session::set("message","Update failed."); return false;
		}						
	}	/* fxn */

	public function delete($id,$table){		
		$q = "DELETE FROM ".$table." WHERE id = :id LIMIT 1";
		$sth = $this->prepare($q);
		$sth->bindParam(':id',$id);		
		if($sth->execute()){
			Session::set("message","Deleted successfully."); return true;
		} else {
			Session::set("message","Delete failed."); return false;
		}				
	}	/* fxn */
		
	public function clean($data){ return stripslashes(trim($data)); }	/* fxn */

	 
} 	/* Db */

	$db=new Database(DBTYPE,DBHOST,DBO.";charset=utf8",DBUSER,DBPASS);

