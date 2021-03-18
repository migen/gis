<?php


	function add($db,$table,$data){
		$fields = implode('`,`',array_keys($data));
		$fvalues = ':'.implode(',:',array_keys($data));
		$q = "INSERT INTO $table (`$fields`) VALUES ($fvalues);";
		Session::set('q',$q);
		$sth = $db->prepare($q);
		foreach($data as $key => $value){ $sth->bindValue(":$key",$value); }
		if($sth->execute()){  return true; } else { return false; }		
	}	/* fxn */
		
	function update($db,$table,$data,$where){
		$fvPairs = NULL;
		foreach($data as $key=> $value) { $fvPairs .= "`$key`=:$key,"; }
		$fvPairs = rtrim($fvPairs,',');
		$q = "UPDATE $table SET $fvPairs WHERE $where LIMIT 1;";
		$sth = $db->prepare($q);
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

	function delete($db,$table,$id){		
		$q="DELETE FROM ".$table." WHERE id = :id LIMIT 1";
		$sth=$db->prepare($q);
		$sth->bindParam(':id',$id);		
		if($sth->execute()){ Session::set("message","Deleted."); return true;
		} else { Session::set("message","Delete failed."); return false; }				
	}	/* fxn */

	function createIfNotExists($db,$dbtable,$post){
		$q1="SELECT id FROM {$dbtable} WHERE ";
		foreach($post AS $k=>$v){ $q1.="{$k}='{$v}' AND "; }
		$q1=rtrim($q1," AND ");$q1.=" LIMIT 1;";
		$sth=$db->querysoc($q1);
		$row=$sth->fetch();
		if(!$row){ add($db,$dbtable,$post); } 		
	}	/* fxn */
	
	function clean($data){ return stripslashes(trim($data)); }	/* fxn */

	function fetchRowById($db,$dbtable,$id,$fields="*"){
		$q="SELECT $fields FROM $dbtable WHERE `id`='$id' LIMIT 1;";
		$sth=$db->querysoc($q);return $sth->fetch();
	}	/* fxn */

	function fetchRowByCond($db,$dbtable,$where,$fields="*"){
		$q="SELECT $fields FROM $dbtable WHERE $where LIMIT 1;";
		$sth=$db->querysoc($q);return $sth->fetch();
	}	/* fxn */

	function fetchRows($db,$dbtable,$fields='id,name',$order='name',$where=null,$limit=NULL){	
		$limits=isset($limit)? "LIMIT $limit":NULL;
		$q="SELECT $fields FROM $dbtable $where order by $order $limits;";debug($q);
		$sth = $db->querysoc($q);
		if(!$sth){ pr($q); die('Query failed. '.mysql_error());  }					
		return $sth->fetchAll();
	}	/* fxn */

	function lastId($db,$dbtable){
		$q="SELECT id AS `num` FROM {$dbtable} ORDER BY id DESC LIMIT 1;";	
		$sth=$db->querysoc($q);$row = $sth->fetch();return $row['num'];	
	}	/* fxn */

	function maxId($db,$dbtable){
		$q="SELECT max(id) AS `num` FROM {$dbtable};";	/* better than order limit */	
		$sth=$db->querysoc($q);$row = $sth->fetch();return $row['num'];	
	}	/* fxn */

	function numrows($db,$dbtable){
		$q="SELECT count(id) AS `num` FROM {$dbtable} LIMIT 1;";
		$sth=$db->querysoc($q);$row = $sth->fetch();return $row['num'];	
	}	/* fxn */
