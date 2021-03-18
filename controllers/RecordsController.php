<?php

/* fxns 

1) crud - view, edit
2) filter, data with pagination
3) list/set
4) all tables

*/


Class RecordsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();

	$acl = array(array(5,0));
	$this->permit($acl);					

}

public function index($params=NULL){ 
	ob_start();
	echo "<h3>Records ";$this->view->shovel('links_records');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");

}	/* fxn */


public function index1(){	
	$dbo=PDBO;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable;
	pr($data);
	$vfile="abc/defaultAbc";vfile($vfile);$this->view->render($data,$vfile);
	
}	/* fxn */

public function edit($params){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	$data['id']=$id=isset($params[1])? $params[1]:1;
	$data['key']=$key=isset($_GET['key'])? $_GET['key']:false;
	$data['value']=$value=isset($_GET['value'])? $_GET['value']:false;
	
	// echo (isset($))

	
	/* 2 */	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		if($key){
			$db->update($dbtable,$post,"$key='$value'");						
		} else {			
			$db->update($dbtable,$post,"id=$id");			
		}
		$url=($key)? "records/view/$dbtable?key=$key&value=$value":"records/view/$dbtable/$id";
		flashRedirect($url,"Updated successfully.");
		exit;		
	}	/* fxn */
	/* 3 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['columns']=&$dr['field_array'];
	/* 4 */	
	
	if($key){
		$q="SELECT * FROM {$dbtable} WHERE $key='$value' LIMIT 1;";		
	} else {
		$q="SELECT * FROM {$dbtable} WHERE id=$id LIMIT 1;";		
	}
	debug($q);
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();

	$vfile="records/editRecords";vfile($vfile);$this->view->render($data,$vfile);
	
}	/* fxn */


public function view($params){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	$data['id']=$id=isset($params[1])? $params[1]:1;	
	$data['key']=$key=isset($_GET['key'])? $_GET['key']:false;
	$data['value']=$value=isset($_GET['value'])? $_GET['value']:false;
	
	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['columns']=&$dr['field_array'];
	/* 3 */	
	if($key){
		$q="SELECT * FROM {$dbtable} WHERE $key='$value' LIMIT 1;";		
	} else {
		$q="SELECT * FROM {$dbtable} WHERE id=$id LIMIT 1;";		
	}
	
	debug($q);
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();	
	$vfile="records/viewRecords";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


public function filter($params){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	$data['id']=$id=isset($params[1])? $params[1]:1;	
	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['columns']=&$dr['field_array'];
	/* 3 */	
	$q="SELECT * FROM {$dbtable} WHERE id=$id LIMIT 1;";
	debug($q);
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();	
	$vfile="records/viewRecords";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


public function dbtables(){
	$db=&$this->baseModel->db;
	$data['schemas']=$schemas=array(PDBO,PDBG);
	if(isset($_GET['unset'])){ unset($_SESSION['schemas']); exit; }

	if(!isset($_SESSION['schemas'])){
		echo "Init Session Schemas.";
		$i=0;
		foreach($schemas AS $schema){
			$q="SHOW TABLES FROM $schema;";
			$sth=$db->querysoc($q);
			$rows=$sth->fetchAll();	
			$records[$i]=array();
			foreach($rows AS $row){
				$item=$row['Tables_in_'.$schema];
				array_push($records[$i],$item);
			}
			$count[$i]=count($records[$i]);		
			$i++;
		}	// foreach 
		$_SESSION['schemas']['dbo_count']=$count[0];
		$_SESSION['schemas']['dbg_count']=$count[1];

		$_SESSION['schemas']['dbo_tables']=$records[0];
		$_SESSION['schemas']['dbg_tables']=$records[1];
		
	}	// schemas
	
	$data['dbo_count']=$data['db'][0]['count']=$_SESSION['schemas']['dbo_count'];
	$data['dbg_count']=$data['db'][1]['count']=$_SESSION['schemas']['dbg_count'];

	$data['dbo_tables']=$data['db'][0]['tables']=$_SESSION['schemas']['dbo_tables'];
	$data['dbg_tables']=$data['db'][1]['tables']=$_SESSION['schemas']['dbg_tables'];
	
	$vfile="records/dbtablesRecords";
	$this->view->render($data,$vfile);

	
}	/* fxn */


public function truncate($params){	
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:$dbo.".abc";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:$dbo.".abc";
	$q="TRUNCATE $dbtable;"; echo "&exe to execute <br /> ";
	pr($q);if(isset($_GET['exe'])){ $sth=$db->query($q); $msg=($sth)? "Truncate Success":"Truncate Fail"; 
		flashRedirect("records/set/$dbtable",$msg); }
}	/* fxn */

public function add($params){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";

	/* 2 */	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->add($dbtable,$post);
		$id=$db->lastInsertId();
		flashRedirect("records/view/$dbtable/$id","Added successfully.");
		exit;		
	}	/* fxn */
	/* 3 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['columns']=&$dr['field_array'];


	$vfile="records/addRecords";vfile($vfile);$this->view->render($data,$vfile);
	
}	/* fxn */

public function jxadd($params){		/* 20200226 */
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";

	/* NO POST */
	/* 3 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['columns']=&$dr['field_array'];
	$data['num_columns']=count($data['columns']);
	$data['rows']=fetchRows($db,$dbtable,"*","id DESC");

	$vfile="records/jxaddRecords";vfile($vfile);$this->view->render($data,$vfile);
	
}	/* fxn */



public function setup($params=NULL){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";

	/* 1 */
	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;
	$except=isset($_GET['except'])? $_GET['except']:"'id'";


	/* 3 */
	if(isset($_GET['fields'])){
		$field_string="id";
		$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
		$data['columns']=$columns=explode(",",$field_string);			
	} else if(isset($_GET['full'])){
		$except=isset($_GET['except'])? $_GET['except']:"'id'";
		// $except="'id'"
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except);
		$data['columns']=$columns=$dr['field_array'];		
	} else {
		$field_string="id,name";
		$data['columns']=$columns=explode(",",$field_string);					
	}
	$data['num_columns']=count($data['columns']);
	$data['field_str']=$field_str=implode(",",$columns);

	/* 3b */
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['all_columns']=$all_columns=$dr['field_array'];			
	$data['all_field_str']=$all_field_str=implode(", ",$all_columns);

	/* 3c */
	$data['last_id']=lastId($db,$dbtable);

	/* 2 */
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		// pr($posts);
		$q="INSERT INTO $dbtable(";
		foreach($columns AS $col){
			$q.="`".$col."`,";
		}
		$q=rtrim($q,",");$q.=")VALUES(";
		foreach($posts AS $post){
			foreach($columns AS $col){
				$q.="'".$post[$col]."',";
			}
			$q=rtrim($q,",");$q.="),(";
			
		}
		$q=rtrim($q,",(");$q.=";";
		$sth=$db->query($q);
		echo ($sth)? "success":"fail";
		pr($q);
		exit;
		// flashRedirect("records/set/$dbtable","Batch add successful.");
		exit;
		
	}	/* post */

	
	$vfile="records/setupRecords";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */



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
		$field_string="id";
		$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
		$cols=explode(",",$field_string);			
		$columns=array();
		foreach($cols AS $col){	
			$str=$col;
			if(strpos($col,'AS')){
				$len=strlen($col);			
				$num_chars=($len>4)? 3:2;				
				$str=substr($col,strpos($col, 'AS') + $num_chars);		
			} else {
				$str=$col;
			}
			array_push($columns,$str);						
		}	/* foreach */					
		$data['columns']=$columns;
	} else if(isset($_GET['full'])){
		$field_string="*";
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
		$data['columns']=$columns=$dr['field_array'];		
	} else {
		$field_string="id,name";
		$data['columns']=$columns=explode(",",$field_string);					
	}
	$data['num_columns']=count($data['columns']);
	$data['field_str']=$field_str=implode(",",$columns);
	// $except=isset($_GET['except'])
		
	/* 2b */
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['all_columns']=$all_columns=$dr['field_array'];			
	$data['all_field_str']=$all_field_str=implode(", ",$all_columns);

	/* 1 */
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
		$message = ($sth)? "Success":"Failed<br />$q";
		$url=$_SERVER['REDIRECT_QUERY_STRING'];
		$url=trim($url,"url");
		$url=trim($url,"=");
		$url=str_replace("&edit","",$url);
		flashRedirect($url,$message);exit;		
	}	/* post */
	
	/* 3B */
	if(isset($_POST['editor'])){
		$ids = stringify($_POST['rows']);		
		$url = "records/editor/{$dbtable}/".$ids;
		// pr($ids);pr($url);exit;
		redirect($url);		
	}	/* editor */
	
	
	
	/* 4 */
	$data['limit']=$limit=isset($_GET['limit'])? $_GET['limit']:$_SESSION['settings']['records_limit'];
	$order=in_array("name",$columns)? "name":"id";	
	$data['order']=$order=isset($_GET['order'])? $_GET['order']:$order;
	$q="SELECT $field_string FROM $dbtable WHERE $cond ORDER BY $order ";
	$sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$data['pagesPerSet']=$pagesPerSet=isset($_GET['perset'])? $_GET['perset']:10;	/* numpages per set */	
	$offset=($currPage-1)*$limit;
	$url="records/set/$dbtable";	
	$data['pagenav']=pagenav($url,$totalCount,$offset,$limit,$currPage,$pagesPerSet);		
	$limitcond=isset($_GET['all'])? NULL:"LIMIT $limit OFFSET $offset;"; 
	$q.=$limitcond;	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	debug($q);$data['q']=$q;
	
	// pr($data['columns']);
	// pr($data['rows'][0]);
	
	$vfile=(isset($_GET['edit']))? "records/editSetRecords":"records/setRecords";
	
	vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


public function editor($params){
	$idr=$params;array_shift($idr);$data['idr']=$idr;
		
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";

	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	

	/* 2A */
	if(isset($_GET['fields'])){
		$field_string="name";
		$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
		$data['columns']=$columns=explode(",",$field_string);			
	} else if(isset($_GET['full'])){
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
		$data['columns']=$columns=$dr['field_array'];		
	} else {
		$field_string="name";
		$data['columns']=$columns=explode(",",$field_string);					
	}

	$data['num_columns']=count($data['columns']);
	$data['field_str']=$field_str=implode(",",$columns);

	/* 2b */
	$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	$data['all_columns']=$all_columns=$dr['field_array'];			
	$data['all_field_str']=$all_field_str=implode(", ",$all_columns);


	/* 1 */
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
	
	
	$rows=array();
	foreach($idr AS $id){
		$q="SELECT id,$field_str FROM {$dbtable} WHERE id=$id; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		array_push($rows,$row);		
	}	/* foreach */
	$data['rows']=$rows;
	$data['count']=count($rows);
	
	$this->view->render($data,"records/editorRecords");
	
	
}	/* fxn */


public function custom($params=NULL){	
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
	
	/* 1 */
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
		$ids = stringify($_POST['rows']);		
		$url = "records/editor/{$dbtable}/".$ids;
		// pr($ids);pr($url);exit;
		redirect($url);		
	}	/* editor */

	
	/* 4 */
	// $data['limit']=$limit=isset($_GET['limit'])? $_GET['limit']:10;
	$data['limit']=$limit=isset($_GET['limit'])? $_GET['limit']:$_SESSION['settings']['records_limit'];
	$order=in_array("name",$columns)? "name":"id";	
	$data['order']=$order=isset($_GET['order'])? $_GET['order']:$order;
	$q="SELECT * FROM $dbtable WHERE $cond ORDER BY $order ";
	
	if(isset($_POST['query'])){			 
 		$select_str=$_POST['select_str'];
		$qrybody=$_POST['qrybody'];
		$field_str=str_replace("SELECT","",$select_str);
		$data['field_str']=$field_str;
		$data['select_str']=$select_str;		 
		$data['qrybody']=$qrybody;		 
		$cols=explode(",",$field_str);
		$columns=array();
		foreach($cols AS $col){	
			$len=strlen($col);			
			$num_chars=($len>4)? 3:2;
			$str=substr($col,strpos($col, 'AS') + $num_chars);		
			array_push($columns,$str);						
		}	/* foreach */		
		$data['columns']=$columns;
		$data['num_columns']=count($columns);
		$q="SELECT {$field_str} {$qrybody} "; 	// split			
		$q=str_replace("dbo",PDBO,$q);
		$q=str_replace("dbg",PDBG,$q);				
	} else {
		$data['select_str']="id,name";		
		$data['qrybody']=NULL;		
		$data['full_query']=NULL;		
	} /* post query */
	debug($q);
	$sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$data['pagesPerSet']=$pagesPerSet=isset($_GET['perset'])? $_GET['perset']:10;	/* numpages per set */	
	$offset=($currPage-1)*$limit;
	$url="records/custom/$dbtable";	
	$data['pagenav']=pagenav($url,$totalCount,$offset,$limit,$currPage,$pagesPerSet);		
	$limitcond=isset($_GET['all'])? NULL:"LIMIT $limit OFFSET $offset;"; 
	$q.=$limitcond;	

	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	debug($q);$data['q']=$q;

	$vfile=(isset($_GET['edit']))? "records/editSetRecords":"records/setRecords";
	$vfile="records/customRecords";
	
	vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


public function query(){	
	if(isset($_POST['submit'])){
		$query=$_POST['query'];$db=&$this->baseModel->db;
		$sth=$this->baseModel->db->querysoc($query);$rows=$sth->fetchAll();
		pr($query);pr($rows);echo ($sth)? "Success":"Fail";exit;
	}	
	$this->view->render($data=NULL,"records/query");
}	/* fxn */


public function find($params=NULL){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	// $data['field']=$field=isset($params[1])? $params[1]:'name';	
	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	
	// $dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
	// $data['columns']=&$dr['field_array'];

	/* 3 */
	if(isset($_GET['fields'])){
		$field_string="id";
		$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
		$cols=explode(",",$field_string);			
		$columns=array();
		foreach($cols AS $col){	
			$str=$col;
			if(strpos($col,'AS')){
				$len=strlen($col);			
				$num_chars=($len>4)? 3:2;				
				$str=substr($col,strpos($col, 'AS') + $num_chars);		
			} else {
				$str=$col;
			}
			array_push($columns,$str);						
		}	/* foreach */					
		$data['columns']=$columns;
	} else if(isset($_GET['full'])){
		$field_string="*";
		$dr=getDbtableColumnsByArray($db,$schema,$table,$except="'id'");
		$data['columns']=$columns=$dr['field_array'];		
	} else {
		$field_string="id,name";
		$data['columns']=$columns=explode(",",$field_string);					
	}
	$data['num_columns']=count($data['columns']);
	$data['field_str']=$field_str=implode(",",$columns);

	
if(isset($_GET['field'])){
	$field=$_GET['field'];$value=$_GET['value'];	
	$limit=$_SESSION['settings']['records_limit'];
	$limit=10;
	$q="SELECT $field_str FROM {$dbtable} WHERE `$field` LIKE '%".$value."%' LIMIT $limit;";
	debug($q);
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();		
	$data['count']=$sth->rowCount();		
	
}	/* get */
	/* 3 */	

if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$id=$post['id'];
		$q.="UPDATE {$dbtable} SET ";		
		if(($key=array_search('id',$columns))!==false) { unset($columns[$key]); }		
		foreach($columns AS $col){ $q.=" `$col`='".$post[$col]."',"; }
		$q=rtrim($q,",");
		$q.=" WHERE id=$id LIMIT 1;";
	}	
	$sth=$db->query($q);
	$message = ($sth)? "Success":"Failed<br />$q";
	$url=$_SERVER['REDIRECT_QUERY_STRING'];
	$url=trim($url,"url");
	$url=trim($url,"=");
	$url=str_replace("&edit","",$url);
	flashRedirect($url,$message);exit;		
	
}	/* post */

	$vfile=(isset($_GET['edit']))? "records/editFindRecords":"records/findRecords";

	// $vfile="records/findRecords";vfile($vfile);
	
	$this->view->render($data,$vfile);	
}	/* fxn */



public function delete($params){	
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($params[0])? $params[0]:false;
	if(!$dbtable){ pr("No Params - 0-dbtable / 1-id "); exit; }
	$id=isset($params[1])? $params[1]:1;	
	$q="DELETE FROM {$dbtable} WHERE id=$id LIMIT 1; ";	pr("&exe"); pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";				
	}
	
}	/* fxn */


public function xxxcleanColname($str){
	$has_as=(strpos($str,'AS')!==false)? true:false;
	$char=$has_as? "AS":".";
	$str=strstr($str,$char,false);
	$str=ltrim($str,".");			
	if($has_as){ $str=ltrim($str,"AS"); }
	return $str;		
}	/* fxn */


public function abc($params=array('name')){
	require_once(SITE.'functions/stringFxn.php');
	$q="SELECT From abc.contacts WHER limit 1";
	$q=strtolower($q);
	// pr($q);
	// $col="c.name as person";
	// $col="c.name as person";
	// $col="name";
	$col=$params[0];
	// $col="id AS ucid";
	$col=strtolower($col);
	pr($col);
	$col=cleanColname($col);
	
	// pr($col);
	
}


public function complex($params=NULL){	
	require_once(SITE.'functions/stringFxn.php');
	require_once(SITE.'functions/dbtools.php');
	require_once(SITE.'functions/paginationFxn.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	// $data=NULL;
	$data['q']=isset($_POST['q'])? $_POST['q']:false;
	
	if(isset($_POST['q'])){
		$q=$_POST['q'];
		$data['is_empty']=(empty($q))? true:false;			
		
		if(!empty($q)){
			$sth=$db->querysoc($q);
			$data['rows']=$sth->fetchAll();
			$data['count']=$sth->rowCount();
			/* 2 */
			$q=strtolower($q);
			$field_str=betweenString($q,"select","from");
			$field_str=trim($field_str);
			$data['columns']=$columns=explode(",",$field_str);
			$data['num_columns']=count($columns);		
			foreach($columns AS $i=>$col){ $columns[$i]=cleanColname($col); }
			$data['columns']=$columns;
		}				
		
	}	/* query */
	
	
	$vfile="records/complexRecords";
	vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */







}	/* BlankController */
