<?php

Class DreamsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function migrate(){
	$db=&$this->model->db;$dbg=PDBG;$dbp=PDBP;	
	/* 1 copy rows */
	$q=" INSERT INTO {$dbp}.80_dreams SELECT d.* FROM {$dbg}.80_dreams d WHERE year < '2018'; ";
	pr($q);
	// $sth1=$db->query($q);
	// echo ($sth1)? "Success":"Fail";
	
	$sth1=true;
	echo ($sth1)? "Success":"Fail";
	
	$q=" INSERT INTO {$dbp}.80_dreamdetails		
		( SELECT dt.* FROM {$dbg}.80_dreamdetails AS dt 
		INNER JOIN {$dbg}.80_dreams AS d ON d.id=dt.dream_id WHERE d.year < '2018'); ";
	pr($q);
	$sth2=$db->query($q);
	// echo ($sth2)? "Success":"Fail";

	$sth2=true;
	echo ($sth2)? "Success":"Fail";
	echo "<br />";
	if($sth1 && $sth2){
		echo "OK to delete from dreams and dreamdetails in dbg ";
	}
	


	/* 3 - delete from rows */
	// $q=" DELETE FROM {$dbg}.zfrom WHERE year < '2018'; ";
	// pr($q);
	// $db->query($q);
	



}	/* fxn */


public function edit($params){
	$db=&$this->model->db;
	$dbg=isset($_GET['dbname'])? $_GET['dbname']:PDBG;	
	$id=$params[0];
	if(isset($_POST['submit'])){
		$q="UPDATE {$dbg}.80_dreams SET name='".$_POST['name']."' WHERE id='$id' LIMIT 1; ";
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.80_dreamdetails SET
				date='".$post['date']."',item='".$post['item']."'
				WHERE id='".$post['id']."' LIMIT 1; ";
		}
		$db->query($q);		
		flashRedirect("dreams/edit/$id&dbname=$dbg","Updated.");
	}	/* submit */
	
	$q="SELECT * FROM {$dbg}.80_dreams WHERE id='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$q="SELECT * FROM {$dbg}.80_dreamdetails WHERE dream_id='$id'; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);

	
	$this->view->render($data,'dreams/editDream');
	
}	/* fxn */


public function index(){
	$db=&$this->model->db;$dbg=PDBG;$dbp=PDBP;	
	$data['message'] = "*Test CRUD for two (2) joint tabes {$dbg}.80_dreams and dreamdetails and {$dbp}.80_dreams
		<br />80_dreams: id,who,year,item, 80_dreamdetails-id,dream_id,date,item";
	
	$q="SELECT '$dbg' AS dbname,a.* FROM {$dbg}.80_dreams AS a 
		UNION (SELECT '$dbp' AS dbname,b.* FROM {$dbp}.80_dreams AS b);";	
	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'dreams/indexDreams');
	

}	/* fxn */


public function test(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;

/* 

CREATE TABLE newtable LIKE oldtable; 
INSERT newtable SELECT * FROM oldtable;
OR
CREATE TABLE tbl_new AS SELECT * FROM tbl_old;	// no triggers. only data


INSERT INTO dues_storage
SELECT d.*, CURRENT_DATE()
FROM dues d
WHERE id = 5; */

	/* 1 copy rows */
	$q=" INSERT INTO {$dbg}.zto SELECT d.* FROM {$dbg}.zfrom d WHERE year < '2018'; ";
	pr($q);
	$db->query($q);

	/* 2 - duplicate table */
	$q=" CREATE TABLE {$dbg}.zfrom_copy LIKE {$dbg}.zfrom; 
	INSERT {$dbg}.zfrom_copy SELECT * FROM {$dbg}.zfrom; ";
	pr($q);
	$db->query($q);

	/* 3 - delete from rows */
	$q=" DELETE FROM {$dbg}.zfrom WHERE year < '2018'; ";
	pr($q);
	$db->query($q);
	
	echo "<br />All 3 queries executed.";

	echo "<hr />";
	echo "<h3>Now join tables for all rows</h3>";
	
	// $q="SELECT a.*,b.*  
		// FROM {$dbg}.zfrom AS a
		// JOIN {$dbg}.zto AS b
	// ";
	$q="SELECT * FROM {$dbg}.zfrom UNION (SELECT * FROM {$dbg}.zto);";		// ok
	
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
	

	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */



public function dbinit($params=NULL){
require_once(SITE.'functions/dbinit_axis.php');
$db=&$this->model->db;
if(isset($params[0])){
	dbinit_axis($db);
}



}	/* fxn */




}	/* BlankController */
