<?php

Class DbController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function onedb(){ }

public function index(){ 
	$data['controller']="DbController";
	require_once(SITE.'views/elements/incs_reflection.php');pr($data);

	$this->view->render($data,"db/indexDb");

}	/* fxn */


public function tools(){
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except="'id','is_cleared'");
	// $data['cols']=$cols=$dr['field_array'];
	// $data['field_str']=$field_str=$dr['field_string'];
	
	$code='<br />require_once(SITE."functions/dbtools.php")';
	$code.="<br />dr=(db,schema,table,except_array)";
	$code.="<br />dr[cols] and dr[field_string]";
	$data['code']=$code;
	
	pr($data);
	
	
}


public function abc(){
$db=&$this->model->db;

// $dbr=PDBG.' '.PDBG.' '.DBO;
$dbr="abc aiphp";

$return_var = NULL;
$output = NULL;

$today=str_replace("-","",$_SESSION['today']);
$command = 'D:\\xampp/mysql/bin/mysqldump -u '.DBUSER.' -h '.DBHOST.' --port='.DBPORT.' -p'.DBPASS.' --databases '.$dbr.' > C:\Users\MakolEngr\Downloads\db'.VCFOLDER.'-'.$today.'.sql"';

pr($command);
// exec($command, $output, $return_var);

echo "Dumped sql";


}	/* fxn */







public function box($params=NULL){
	// $dir = SITE."views".DS."files";	
	$data['moid']=$moid=isset($params[0])? $params[0]:$_SESSION['moid'];

	$data['dir']=$dir=ROOT.DS."gisdata/$moid";
	// echo "DIR - ".$dir." <br />";
	
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	if(isset($_GET['page'])) { unset($_GET['page']); }
	$_SESSION['files_page'] = $page;
	$r = scandir($dir,1);				
	$x = array('.','..');
	$data['files'] = array_diff($r,$x);
	$data['num_files'] = count($data['files']);	
	$this->view->render($data,'db/box');

}	/* fxn */



public function etc($params=NULL){
	$etc=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$data['moid']=$moid=isset($params[0])? $params[0]:$_SESSION['moid'];
	$data['dir']=$dir=ROOT.DS."data/$etc/$moid";	
	
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	if(isset($_GET['page'])) { unset($_GET['page']); }
	$_SESSION['files_page'] = $page;
	$r = scandir($dir,1);				
	$x = array('.','..');
	$data['files'] = array_diff($r,$x);
	$data['num_files'] = count($data['files']);	
	$this->view->render($data,'db/etc');

}	/* fxn */




public function go1(){
$db=&$this->model->db;

$dbr=PDBG.' '.PDBG.' '.DBO;

$return_var = NULL;
$output = NULL;

$today=str_replace("-","",$_SESSION['today']);
$command = 'D:\\xampp/mysql/bin/mysqldump -u '.DBUSER.' -h '.DBHOST.' --port='.DBPORT.' -p'.DBPASS.' --databases '.$dbr.' > C:\Users\MakolEngr\Downloads\db'.VCFOLDER.'-'.$today.'.sql"';

pr($command);
// exec($command, $output, $return_var);

echo "Dumped sql";


}	/* fxn */



public function go(){
$db=&$this->model->db;
// $dbr=PDBG.' '.PDBG.' '.DBO;
$dbr="aiphp";

$return_var = NULL;
$output = NULL;

$today=str_replace("-","",$_SESSION['today']);
// $command = 'D:\\xampp/mysql/bin/mysqldump -u '.DBUSER.' -h '.DBHOST.' --port='.DBPORT.' -p'.DBPASS.' --databases '.$dbr.' > C:\Users\MakolEngr\Downloads\db'.VCFOLDER.'-'.$today.'.sql';

$command = 'mysqldump -u '.DBUSER.' -h '.DBHOST.' --port='.DBPORT.' -p'.DBPASS.' --databases '.$dbr.' > C:\Users\MakolEngr\Downloads\aiphp0920a.sql';


pr($command);
exec($command, $output, $return_var);

echo "Dumped sql";


}	/* fxn */






public function box3($params=NULL){
	$dir = SITE."views".DS."files";	
	$moid=isset($params[0])? $params[0]:$_SESSION['moid'];

	
	echo "SITE - ".SITE." <br />";
	echo "ROOT - ".ROOT." <br />";
	echo "APPDIR - ".APPDIR." <br />";
	echo "DIR - ".$dir." <br />";
	
	$dir=ROOT;
	pr($dir);	
	$data['dir']=$dir="/../../data/$moid";
	pr($dir);

	// $data['dir']=$dir=ROOT.DS.'mysqlbackups/'.$moid;
	$data['dir']=$dir=ROOT.DS.'dbtest';
	echo "DIR - ".$dir." <br />";
	
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	if(isset($_GET['page'])) { unset($_GET['page']); }
	$_SESSION['files_page'] = $page;
	$r 			= scandir($dir,1);				
	$x 			= array('.','..','index.php','edit.php','write.php','delete.php');				
	$data['files'] 			= array_diff($r,$x);
	$data['num_files'] 		= count($data['files']);	
	$this->view->render($data,'db/box');

}	/* fxn */


public function deport(){
	require_once(SITE.'functions/dbFxn.php');
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbo=PDBO;
	$dbsrc=PDBO;
	$dbdest=PDBP;
	$dbyr=DBYR;
	
	// $q="SELECT * FROM {$dbo}.00_archives ";
	$q="UPDATE {$dbo}.00_archives SET is_sub=1 WHERE fkey IS NOT NULL;";
	pr($q);
	$sth=$db->querysoc($q);
	echo ($sth)? "Sub success":"Sub fail"; echo "<hr />";
		
	$q="SELECT * FROM {$dbo}.00_archives ORDER BY `index` ASC;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$rows=&$data['rows'];
	$count=&$data['count'];
	// pr($data);
	$exe=isset($_GET['exe'])? true:false;
	
	foreach($rows AS $row){
		pr($row);
		$dbtbl=$row['name'];
		$is_sub=$row['is_sub'];
		
		/* 1 */
		if($is_sub){
			$tblmaster=$row['master'];
			$tblsub=$row['name'];
			$fkey=$row['fkey'];
			
			$q=updateJoinYear($db,$dbsrc,$tblmaster,$tblsub,$fkey);
			if($exe){
				$sth=$db->query($q);
				echo ($sth)? "Year Success":"Year Fail"; echo "<hr />";				
			} 	/* exe */
			
		}	/* sub */
		
		/* 2 */
		$q=dataCopy($db,$dbsrc,$dbdest,$dbtbl,$dbyr,$keepyears=0);
		if($exe){		
			$sth=$db->query($q);
			echo ($sth)? "Copy Success":"Copy Fail"; echo "<hr />";
		} 	/* exe */

		$q=dataDelete($db,$dbsrc,$dbdest,$dbtbl,$dbyr,$keepyears=0);
		if($exe){		
			$sth=$db->query($q);
			echo ($sth)? "Delete Success":"Delete Fail"; echo "<hr />";
		}	/* exe */
		
	}	/* foreach */	
		
}	/* fxn */


public function struct_diff(){
	require_once(SITE."functions/dbFxn.php");
	$db=&$this->baseModel->db;
	$db1="2016_dbgis_lsm";
	$db2="2017_dbgis_lsm";
	$table1="20_aux";
	$table2="20_aux";
	
	// $sf1=getDbtableColumns($db,$schema,$table);
	$sf1=getDbtableColumns($db,$db1,$table1);
	$sf2=getDbtableColumns($db,$db2,$table2);
	pr($sf1);
	pr($sf2);
	
	
}	/* fxn */

	
public function tables(){
	require_once(SITE."functions/dbFxn.php");
	$db=&$this->baseModel->db;
	$dbx=PDBO;	
	$d=getDbtables($db,$dbx);
	$rows=$d['rows'];
	$count=$d['count'];
	pr($count);
	pr($rows);
	
	
}	/* fxn */


public function diff_tables(){
 
if(isset($_GET['submit'])){
	require_once(SITE."functions/dbFxn.php");
	$db=&$this->baseModel->db;
	$schema1=$_GET['db1'];
	$schema2=$_GET['db2'];
	$d1=getDbtables($db,$schema1);
	$rows1=$d1['rows'];
	$count1=$d1['count'];
	
	$d2=getDbtables($db,$schema2);
	$rows2=$d2['rows'];
	$count2=$d2['count'];
	
	$same_count=($count1==$count2)? true:false;
	$same_count_text=($same_count)? "Same Count":"NOT Same Count";
	if(!$same_count){
		pr("db1: ".$schema1);
		pr("db2: ".$schema2);
		pr("Count 1: ".$count1);
		pr("Count 2: ".$count2);		
		pr($same_count_text);
		echo "<hr />";
		$x=array_diff($rows1,$rows2);	
		pr("Not in db2: ".count($x));pr($x);
		// $y=array_diff($db2,$db1);	
		$y=array_diff($rows2,$rows1);			
		pr("Not in db1: ".count($y));pr($y);
		$z=array_merge($x,$y);
		echo "<hr />";
		pr("Unique tables: ".count($z));pr($z);		
	}	/* !same count */
	
}	/* get */

$data=NULL;
$this->view->render($data,"db/diff_tablesDb");	
	
}	/* fxn */





public function diff(){		
	if(isset($_GET['submit'])){
		require_once(SITE."functions/dbFxn.php");
		$db=&$this->baseModel->db;
		$db1=$_GET['db1'];$table1=$_GET['table1'];
		$db2=$_GET['db2'];$table2=$_GET['table2'];
		$sf1=getDbtableColumns($db,$db1,$table1);
		$sf2=getDbtableColumns($db,$db2,$table2);
		$same=($sf1==$sf2)? true:false;
		if(!$same){
			pr("Struct1: ".$sf1);
			pr("Struct2: ".$sf2);
			pr("NOT same.");			
		} else {
			pr("Same.");									
		}
		// pr($res);		
	}	/* fxn */	
	$data=NULL;
	$this->view->render($data,"db/diffDb");
	
}	/* fxn */
	

public function diff_structs(){
	
	if(isset($_GET['submit'])){
		require_once(SITE."functions/dbFxn.php");
		$db=&$this->baseModel->db;
		$db1=$_GET['db1'];$db2=$_GET['db2'];
		$d1=getDbtables($db,$db1);
		$tables1=$d1['rows'];
		$count1=$d1['count'];
		// pr($tables1);
		foreach($tables1 AS $tbl){
			// pr($tbl);
			$sf1=getDbtableColumns($db,$db1,$tbl);
			$sf2=getDbtableColumns($db,$db2,$tbl);
			$same=($sf1==$sf2)? true:false;
			if(!$same){
				echo "<hr />";
				pr("NOT same - ".$tbl);
				pr("Struct1: ".$sf1);
				pr("Struct2: ".$sf2);
				echo "<hr />";
			} else {
				pr("Same - $tbl.");									
			}			
			
		}	/* foreach */
		
		
	}	/* get */
	
	$data=NULL;
	$this->view->render($data,"db/diff_structsDb");
	
}	/* fxn */


public function trims(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.trims; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
		
}	/* fxn */



public function stack(){
	require_once(SITE."functions/dbFxn.php");
	$sources=array('00_2016','00_2017');
	$tbl_dest="00_2016_17";
	
	$db=&$this->baseModel->db;
	$sch_src=PDBO;
	$sch_dest=PDBO;

	foreach($sources AS $tbl_src){
		$q=stackProcess($db,$tbl_src,$tbl_dest,$sch_src,$sch_dest);
		pr($q);
		if(isset($_GET['exe']))	{
			$sth=$db->query($q);
			$res = ($sth)? "{$tbl_src} migration success":"{$tbl_src} migration fail";
			pr($res);			
		}
		
	}	/* foreach */

	$data=NULL;
	$this->view->render($data,"db/stackDb");
		
}	/* fxn */



public function stacker(){
	
	if(isset($_GET['submit'])){
		require_once(SITE."functions/dbFxn.php");
		// $sources=array('00_2016','00_2017');
		// $tbl_dest="00_2016_17";
		$db=&$this->baseModel->db;
		$db_src=$_GET['db_src'];
		$db_dest=$_GET['db_dest'];
		
		
		$sources_str=trim($_GET['sources_str']);
		$sources=explode(",",$sources_str);
		$tbl_src=$sources[0];
		$tbl_dest=$tbl_src;
		
		$q="SELECT count(id) AS ct FROM {$db_src}.{$tbl_src} LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$count=$row['ct'];
		pr($count);
		
		$limit=300000;
		$iterate=($count>$limit)? true:false;
		if($iterate){
			$times=ceil($count/$limit);				
			for($i=0;$i<$times;$i++){
				$offset=$limit*$i;
				$q=stackProcess($db,$tbl_src,$tbl_dest,$db_src,$db_dest,$limit,$offset);
				pr($q);
				if(isset($_GET['exe']))	{
					$sth=$db->query($q);
					$res = ($sth)? "{$tbl_src} Migration OK - iteration: $i ":"{$tbl_src} Migration NOT ok - iteration: $i ";
					pr($res);			
				}								
			}	/* for */
			
		} else {
			$q=stackProcess($db,$tbl_src,$tbl_dest,$db_src,$db_dest);
			pr($q);
			if(isset($_GET['exe']))	{
				$sth=$db->query($q);
				$res = ($sth)? "{$tbl_src} migration success":"{$tbl_src} migration fail";
				pr($res);			
			}			
			
		}	/* iterate */
		
		/* 2 */
			
		
		
		
	} 	/* get */
	
 
	$data=NULL;
	$this->view->render($data,"db/stackerDb");
	
	
}	/* fxn */


public function ctr(){
	
	if(isset($_GET['submit'])){
		$dbtbl=$_GET['dbtbl'];	
		$db=&$this->baseModel->db;
		$q="SELECT count(id) AS `num` FROM {$dbtbl} LIMIT 1;";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$num=$row['num'];
		pr("{$dbtbl} Row Count: ".number_format($num,0));
		
	}	/* get */
	
	$data=NULL;
	$this->view->render($data,"db/ctrDb");
	
}	/* fxn */


public function stackpart(){
	$db=&$this->baseModel->db;
	$q="
		INSERT INTO dbone_lsm.`50_scores`(year,scid,course_id,activity_id,quarter,score,is_valid) 
			( SELECT year,scid,course_id,activity_id,quarter,score,is_valid FROM 2017_dbgis_lsm.`50_scores` LIMIT 10 OFFSET 5);
	";
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		$txt=($sth)? "Success":"Fail";
		pr($txt);
		
	}
	
	
}	/* fxn */



public function parts(){
	
	$count=567895;	
	$limit=100000;
	$times=ceil($count/$limit);
	echo "count: $count <br />";
	echo "limit: $limit <br />";
	echo "times: $times <br />";
	// $q=""
	for($i=0;$i<$times;$i++){
		$offset=$limit*$i;
		$q=" INSERT SELECT LIMIT $limit OFFSET $offset;";
		pr($q);
		
	}
	
		
	
}	/* fxn */


public function query(){	
	if(isset($_POST['submit'])){
		$db=&$this->baseModel->db;
		$query = $_POST['query'];
		pr($query);
		$sth = $db->query($query);
		echo ($sth)? "Success":"Fail";
		exit;
	}	
	$data = NULL;
	$this->view->render($data,'mis/query');
}	/* fxn */

public function querysoc(){	
	if(isset($_POST['submit'])){
		$query = $_POST['query'];
		pr($query);
		$sth = $this->model->db->querysoc($query);
		$rows = $sth->fetchAll();
		pr($rows);		
		echo ($sth)? "Success":"Fail";
		exit;
	}	
	$data = NULL;
	$this->view->render($data,'mis/query');
}	/* fxn */



public function columns(){
	$data['query']="SELECT GROUP_CONCAT(COLUMN_NAME) AS str_fields
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = 'dbone_lsm' AND TABLE_NAME='contacts' 
	AND COLUMN_NAME NOT IN ('id') ORDER BY ORDINAL_POSITION;";
	
	require_once(SITE."functions/dbFxn.php");	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['table']=$table="contacts";
	$data['dbtable']="{$dbo}.`00_contacts`";
	$data['columns']=getDbtableColumns($db,$dbo,$table);
	$data['column_array']=explode(",",$data['columns']);
	
	$this->view->render($data,"db/columnsDb");
	
}



}	/* DbController */
