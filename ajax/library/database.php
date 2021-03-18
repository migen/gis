<?php

class Database extends PDO{
	private $conn;
	public $lastQuery;
		
	public function __construct($dbtype,$dbhost,$dbname,$dbuser,$dbpass,$dbport=DBPORT){
		parent::__construct($dbtype.":dbhost=".$dbhost.";port=".$dbport.";dbname=".$dbname.";",$dbuser,$dbpass);				
		$this->query("SET NAMES 'utf8'");
	}		
	
	public function querysoc($q){
		$sth = $this->query($q);
		if(!$sth){ print_r($q); die('Query failed. '.mysql_error());  }		
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		return $sth;		
	}
	
	
	public function add($table,$data){
		$fields = implode('`,`',array_keys($data));
		$fvalues = ':'.implode(',:',array_keys($data));
		$q = "INSERT into $table (`$fields`) VALUES ($fvalues)";
		$sth = $this->prepare($q);
		foreach($data as $key => $value){
			$sth->bindValue(":$key",$value);
		}
		if($sth->execute()){ 
			return true;
		} else {
			return false;
		}		
	}	
	
	
	public function update($table,$data,$where){
		$fvPairs = NULL;
		foreach($data as $key=> $value) {
			$fvPairs .= "`$key`=:$key,";
		}
		$fvPairs = rtrim($fvPairs,',');
		$q = "UPDATE $table SET $fvPairs WHERE $where LIMIT 1;";
		$_SESSION['q'] = $q;
		$sth = $this->prepare($q);
		foreach ($data as $key => $value) {
			$value = stripslashes($value);
			$sth->bindValue(":$key",$value);
		}				
// $x="UPDATE $table SET ";foreach($data AS $key=>$value){$x.="`$key`='".$value."',"; }$x=rtrim($x,",");$x.=" WHERE $where LIMIT 1;";exit;				
		if($sth->execute()){ 
			return true;
		} else {
			return false;
		}										
	}		/* fxn */

	public function delete($id,$table){		
		$q = "DELETE FROM ".$table." WHERE id = :id LIMIT 1";
		$sth = $this->prepare($q);
		$sth->bindParam(':id',$id);		
		if($sth->execute()){
			return true;
		} else {
			return false;
		}				
	}
		

}	/* DB Class */	

$db = new Database(DBTYPE,DBHOST,null,DBUSER,DBPASS);


/* ------------------------------------------------------------------------------------- */


/* non-PDO database connection */
function dbconnect() {    
    error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED );
    $conn = mysql_connect(DBHOST.':'.DBPORT,DBUSER,DBPASS);
    if (!$conn) {
        die('Could not connect: ' . mysql_error());
    }
    
    mysql_query("SET character_set_results=utf8",$conn);
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
    mysql_query("set names 'utf8'",$conn);

    return $conn;
}

