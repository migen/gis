<?php

Class BatchController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){ redirect("batch/set"); }


public function set($params=NULL){	
	require_once(SITE.'functions/dbtools.php');
	require_once(SITE.'functions/paginationFxn.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	$data['cond']=$cond=isset($_GET['cond'])? $_GET['cond']:"1=1";

	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	/* 3 */
	if(isset($_GET['fields'])){
		$field_string="id,name";
		$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
		$data['columns']=$columns=explode(",",$field_string);			
	} else if(isset($_GET['full'])){
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
		$data['columns']=$columns=$dr['field_array'];		
	} else {
		$field_string="id,name";
		$data['columns']=$columns=explode(",",$field_string);					
	}
	$data['num_columns']=count($data['columns']);
	$data['field_str']=$field_str=implode(",",$columns);
	
	/* 2b */
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['all_columns']=$all_columns=$dr['field_array'];			
	$data['all_field_str']=$all_field_str=implode(", ",$all_columns);

	/* 3A */
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$id=$post['id'];
			$q.="UPDATE {$dbtable} SET ";
			foreach($columns AS $col){ $q.=" `$col`='".$post[$col]."',"; }
			$q=rtrim($q,",");
			$q.=" WHERE id=$id LIMIT 1;";
		}
		$sth=$db->query($q);
		$message = ($sth)? "Success":"Failed";
		$url=$_SERVER['REDIRECT_QUERY_STRING'];
		$url=trim($url,"url");
		$url=trim($url,"=");
		$url=str_replace("&edit","",$url);
		flashRedirect($url,$message);exit;		
	}	/* post */
	
	/* 3B */
	if(isset($_POST['editor'])){
		pr($_POST);
		$ids = stringify($_POST['rows']);		
		$url = 'batch/editor/'.$ids;
		pr($url);
		exit;
		redirect($url);		
	}
		
	
	
	/* 4 */
	$data['limit']=$limit=isset($_GET['limit'])? $_GET['limit']:10;
	$order=in_array("name",$columns)? "name":"id";	
	$data['order']=$order=isset($_GET['order'])? $_GET['order']:$order;
	$q="SELECT * FROM $dbtable WHERE $cond ORDER BY $order ";
	$sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$data['pagesPerSet']=$pagesPerSet=isset($_GET['perset'])? $_GET['perset']:10;	/* numpages per set */	
	$offset=($currPage-1)*$limit;
	$url="records/set/$dbtable";	
	$data['pagenav']=pagenav($url,$totalCount,$offset,$limit,$currPage,$pagesPerSet);		
	$q.="LIMIT $limit OFFSET $offset; ";	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	debug($q);$data['q']=$q;
	
	// $vfile=(isset($_GET['edit']))? "records/editSetRecords":"records/setRecords";
	$vfile="batch/indexBatch";
	
	vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


public function edit($params=NULL){
	$data['dbtable']=$params[0];
	$data['id']=$params[1];
	pr($data);	
	pr("Edit = single record | EditMany = multiple records");
	
}	/* fxn */



public function editor($params=NULL){	/* editMany */
	pr($params);
	
}	/* fxn */


// uniclassrooms/batch - as reference
public function indexRef(){
	$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		require_once(SITE.'functions/uniclassroomsFxn.php');		
		$posts=$_POST['posts'];
		$dbtable="{$dbg}.01_classrooms";
		foreach($posts AS $post){
			if(!empty($post['major_id']) && !empty($post['section_id'])){
				$db->createIfNotExists($dbtable,$post);							
			}
		}	/* foreach */	
		upnameClassrooms($db,$dbg);
		flashRedirect("uniclassrooms","Batch added.");		
		exit;				
	}	/* post */
	
	if(!isset($_SESSION['majors'])){ $_SESSION['majors'] = fetchRows($db,"{$dbg}.`05_majors`","id,code,name"); } 
	$data['majors']=$_SESSION['majors'];	
	if(!isset($_SESSION['unisections'])){ $_SESSION['unisections'] = fetchRows($db,"{$dbg}.01_sections","id,code,name"); } 
	$data['unisections']=$_SESSION['unisections'];	
	$this->view->render($data,"batch/indexBatch");
	
}	/* fxn */



public function update($params=NULL){
	$db=&$this->baseModel->db;
	$data['db']=$db;	
	if(!isset($params[0])){ prx("Param 1 - dbtable required."); }
	$data['dbtable']=$dbtable=$params[0];
	$data['first']=fetchRow($db,$dbtable,1);
	$data['table_fields']=array_keys($data['first']);
	
	if(isset($_POST['update'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			if(!empty($post['id'])){
				extract($post);$q.="UPDATE $dbtable SET $key='$value' WHERE id=$id LIMIT 1; ";				
			}	
		}
		$sth=$db->query($q);
		$msg=($sth)? "success":"fail";
		if(isset($_GET['debug'])){ pr($q);prx($msg); } 
		$url="records/set/$dbtable";
		flashRedirect($url,$msg);									
		exit;
	
	}	/* post */	
	
	$this->view->render($data,"batch/updateBatch");
	
}	/* fxn */



public function setfield($params=NULL){
	$dbo=PDBO;$db=&$this->baseModel->db;
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:false;
	if(!isset($params[0])){ 
		prx("Param 1 (dbtable) and param 2 (field) required."); }	
	$data['field']=$field=isset($params[1])? $params[1]:'name';

	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];		
		$q="";
		foreach($posts AS $post){
			extract($post);
			if($oldval!=$newval){
				$q.="UPDATE $dbtable SET $field='$newval' WHERE id=$id LIMIT 1;";
			}
			
		}		
		
		$sth=$db->query($q);
		$msg=($sth)? "success":"fail";
		if(isset($_GET['debug'])){ pr($q);prx($msg); } 
		$url="records/set/$dbtable";
		flashRedirect($url,$msg);									
		exit;		
		
	}	/* post */
	
	$fields="id,name,$field";
	$data['fields']=$fields=isset($_GET['fields'])? $fields.','.$_GET['fields']:$fields;
	$field_array=trim($fields);
	$data['field_array']=explode(",",$field_array);
		
	// prx($fields);	
	$data['row']=$row=fetchRow($db,$dbtable,1);
	$data['table_fields']=$table_fields=array_keys($row);
	
	// prx($data);
	
	$dr=fetchAll($db,$dbtable,$fields,"name");
	$data['rows']=$dr['rows'];
	$data['count']=$dr['count'];
	$vfile="batch/setfieldBatch";
	$this->view->render($data,$vfile);
	
}	/* fxn */









}	/* BlankController */
