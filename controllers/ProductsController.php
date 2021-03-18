<?php

Class ProductsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	if($_SESSION['settings']['has_pos']!=1){ flashRedirect(UNAUTH,'POS module setting not allowed!'); }
	
	$acl = array(array(RMIS,0),array(RINVIS,0),array(RADMIN,0));
	$this->permit($acl);				

}

public function beforeFilter(){
	parent::beforeFilter();			
}




public function add(){
$dbo=PDBO;
	$db=&$this->model->db;
	$dbg=PDBG;
	$dbo=PDBO;

	/* 1 - last product id */
	$dbtable = $dbo.'.03_products';
	$data['last_id'] = $last_id = $this->model->lastID($dbtable);	
	$data['id'] = $last_id;
	
	
	if(isset($_POST['add'])){
		$rows = $_POST['posts'];
	
		/* 2 - products */
		$q = "";
		foreach($rows AS $row){						
		$name = trim($row['name']);
if($name){
  $id = trim($row['id']);
  $q .= " INSERT IGNORE INTO {$dbo}.`03_products` (`id`,`prodsubtype_id`,`uom`,`barcode`,`code`,`name`,`price`,`level`,
		`suppid`,`cost`,`remarks`) VALUES ('$id','".$row['prodsubtype_id']."','".$row['uom']."','".$row['barcode']."',
		'".$row['barcode']."','$name','".$row['price']."','".$row['level']."','".$row['suppid']."','".$row['cost']."','".$row['remarks']."');";	
  $id++;
}
		}	/* foreach */
		// pr($q);exit;
		$db->query($q);		
		$url = isset($_SESSION['url'])? $_SESSION['url']:'products';		
		flashRedirect($url,"Changes saved.");
	}	/* post */

	$data['prodsubtypes']	= $this->model->fetchRows("{$dbo}.`03_prodsubtypes`",'id,code,name','name');			

	
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(PDBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			
	$data['prid'] = lastId($db,"{$dbo}.03_products");
	$data['prefix']=isset($_GET['prefix'])? $_GET['prefix']:strtoupper(VCFOLDER).'-';
	$this->view->render($data,'products/add');

}	/* fxn */



/* start prodtypes - flags - food,drinks,misc */


public function suppliers($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/employees.php");
	$db=&$this->model->db;$dbo=PDBO;

	$data['role_id']= $role_id = isset($params[0])? $params[0]:RSUPP;	
	$data['ssy']	= $ssy 	= $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];
	
	$_SESSION['url']	= "mis/employing/$role_id";		
	$data['current'] = $current = ($sy==$ssy)? true : false;
	
	$dbg  = VCPREFIX.$sy.US.DBG;	

	$order = "c.is_male DESC,c.name";
	$fields=null;
	$filter = null;
	$data['employees'] 	= $employees = employing($db,$dbg,$role_id,$male=2,$order,$fields,$filter);	
	$data['count']		= count($data['employees']);
		
	$data['titles'] = fetchRows($db,"{$dbo}.`00_titles`","id,name","name");
	$data['roles'] = fetchRows($db,"{$dbo}.`00_roles`");
	$vfile="products/suppliers";vfile($vfile);
	$this->view->render($data,$vfile);	

}	/* fxn */



private function readProduct($id){
$dbo=PDBO;
	$dbg = PDBG;
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE id = $id LIMIT 1;";
	$sth = $this->model->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

public function combo($params){
$dbo=PDBO;
/* solo and combo elements */
$id = $params[0];
$dbg = PDBG;
$data['row'] = $row = $this->readProduct($id);


$data['combos'] = $combos = trim($row['combo']);
$data['combor'] = $combor = array_filter(explode(',',$combos));
$rows = array();

foreach($combor AS $cid){
	$row = $this->readProduct($cid);
	$rows[] = $row;
}

$data['rows'] = $rows;

if(isset($_POST['submit'])){
	$post = $_POST;
	// pr($post);
	$q = "UPDATE {$dbo}.`03_products` SET `name` = '".$post['name']."',`combo` = '".$post['combo']."' WHERE `id` = '$id' LIMIT 1; ";
	$this->model->db->query($q);
	$url = "products/combo/$id";
	flashRedirect($url,'Combo edited.');	
	exit;
	
	
}	/* post */




$data['products'] = $this->model->fetchRows("{$dbg}.03_products");
$this->view->render($data,'products/combo');

}	/* fxn */


public function types(){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

	/* for batch edit */
	if(isset($_POST['batch'])){
		$ids = $_POST['rows'];
		$url = 'products/editTypes/';		
		foreach($ids AS $id){
			$url .= $id.'/';
		}		
		redirect($url);		
	}	/* batch */
		
	$data = prodtypes($db);
	$vfile="products/prodtypes";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function editTypes($ids){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	foreach($ids as $id){ $data['rows'][] = prodtype($db,$id,$dbg); }			
	$data['count'] = count($data['rows']);
	
	if(isset($_POST['submit'])){
		$rows = $_POST['posts'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`03_prodtypes` SET  `prodtag_id` = '".$row['prodtag_id']."',`code` = '".$row['code']."',
					`name` = '".$row['name']."' WHERE `id` = '".$row['id']."' LIMIT 1; ";		
		}	/* foreach */
		$this->model->db->query($q);
		$url = "products/types";		
		flashRedirect($url,"Changes saved.");
	}	/* post */
	
	$data['prodtags'] = $this->model->fetchRows("{$dbo}.`03_prodtags`");
	$this->view->render($data,'products/editTypes');

}	/* fxn */


public function subtypes(){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

	/* for batch edit */
	if(isset($_POST['batch'])){
		$ids = $_POST['rows'];
		$url = 'products/editSubtypes/';		
		foreach($ids AS $id){
			$url .= $id.'/';
		}		
		redirect($url);		
	}	/* batch */
		
	$data = prodsubtypes($db);
	$this->view->render($data,'products/prodsubtypes');

}	/* fxn */


public function editSubtypes($ids){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	foreach($ids as $id){ $data['rows'][] = prodsubtype($db,$id,$dbg); }			
	$data['count'] = count($data['rows']);
	
	if(isset($_POST['submit'])){
		$rows = $_POST['posts'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`03_prodsubtypes` SET  `prodtype_id` = '".$row['prodtype_id']."',`code` = '".$row['code']."',
					`name` = '".$row['name']."' WHERE `id` = '".$row['id']."' LIMIT 1; ";		
		}	/* foreach */
		$this->model->db->query($q);
		$url = "products/subtypes";		
		flashRedirect($url,"Changes saved.");
	}	/* post */
	
	$data['prodtypes'] = $this->model->fetchRows("{$dbo}.`03_prodtypes`","id,name","prodtag_id");
	$this->view->render($data,'products/editSubtypes');

}	/* fxn */


public function view($params){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbo=PDBO;
	$prid = $params[0];
	$data['prid'] = $prid;

	$ssy = $_SESSION['sy'];
	$sy = isset($_GET['sy'])? $_GET['sy']:$ssy;
	$dbg = VCPREFIX.$sy.US.DBG;
	$data['numterminals'] = $numterminals = $_SESSION['settings']['numterminals'];
	$data['row'] = read($db,$prid,$dbg);				
	
	$data['rows'] = suppliersByProduct($db,$prid,$dbg);
	$data['count'] = count($data['rows']);

	if(!isset($_SESSION['suppliers'])){ 
		$_SESSION['suppliers'] = fetchRows($db,"{$dbo}.`00_contacts`","id,name","name","WHERE `role_id`='".RSUPP."' "); 	 } 
	$data['suppliers'] = $_SESSION['suppliers'];		
		
	
	$this->view->render($data,'products/view');

}	/* fxn */



public function supplier($params){
	require_once(SITE."functions/products.php");
	$db=&$this->model->db;$dbo=PDBO;
	$suppid = $params[0];
	$data['suppid'] = $suppid;

	$ssy = $_SESSION['sy'];
	$sy = isset($_GET['sy'])? $_GET['sy']:$ssy;
	$dbg = VCPREFIX.$sy.US.DBG;
	$data['row'] = fetchRow($db,"{$dbo}.`00_contacts`",$suppid);				
	
	$data['rows'] = productsBySupplier($db,$suppid,$dbg);
	$data['count'] = count($data['rows']);
	
	$vfile="products/supplier";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function purge($params){
	require_once(SITE."functions/purge.php");
	$db=&$this->model->db;
	$prid=$params[0];
	purgeProduct($db,$prid);
	flashRedirect($url,'Product and its transactions purged.');

}	/* fxn */



public function index(){
	require_once(SITE."functions/inventory.php");
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$data['nt'] = $nt = ($_SESSION['settings']['numterminals']<7)? $_SESSION['settings']['numterminals']:6; /* js constraint */

if(isset($_POST['filter'])){
	$params = $_POST;
	
	$view = $params['view'];
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['supp'])){ $cond .= " AND p.suppid = '".$params['supp']."'"; }				
	if (!empty($params['cat'])){ $cond .= " AND pt.prodtag_id = '".$params['cat']."'"; }				
	if (!empty($params['type'])){ $cond .= " AND ps.prodtype_id = '".$params['type']."'"; }				
	if (!empty($params['gid'])){ $cond .= " AND p.prodsubtype_id = '".$params['gid']."'"; }				
	if (!empty($params['barcode'])){ $cond .= " AND p.barcode LIKE '%".$params['barcode']."%'"; }				
	if (!empty($params['comm'])){ $cond .= " AND p.comm = '".$params['comm']."'"; }				
	if (!empty($params['code'])){ $cond .= " AND p.code LIKE '%".$params['code']."%'"; }				
	if (!empty($params['name'])){ $cond .= " AND p.name LIKE '%".$params['name']."%'"; }				

	$q=" SELECT p.*,p.id AS prid,su.suppid AS multi,sc.name AS supplier,p.suppid AS psuppid,p.cost AS pcost 
	   FROM {$dbo}.`03_products` AS p 
		LEFT JOIN {$dbo}.`03_prodsubtypes` AS ps ON p.prodsubtype_id = ps.id
		LEFT JOIN {$dbo}.`03_prodtypes` AS pt ON ps.prodtype_id = pt.id
		LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.suppid = sc.id
		LEFT JOIN {$dbo}.`03_products_suppliers` AS su ON su.product_id = p.id
	WHERE 1=1 $cond GROUP BY p.id ORDER BY $sort $order $condlimits; ";
	// pr($q);
	debug($q);
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();

	
	if (!empty($params['supp'])){ 
		/* p.suppid must be last not ps.suppid to retain main supp upon updating */
		$q = " SELECT p.*,p.id AS prid,ps.*,ps.product_id AS multi,sc.name AS supplier,p.suppid AS psuppid,p.cost AS pcost 
			FROM {$dbo}.`03_products_suppliers` AS ps 
			INNER JOIN {$dbo}.`03_products` AS p ON ps.product_id = p.id
			INNER JOIN {$dbo}.`00_contacts` AS sc ON p.suppid = sc.id
			WHERE ps.suppid = '".$params['supp']."'; ";
		debug($q);
		$sth = $db->querysoc($q);
		$b = $sth->fetchAll();
		$rows = array_merge($rows,$b);	
	}				
	$data['rows'] = $rows; 		
	$data['count'] = count($rows);


} 	/* filter */

if(isset($_POST['update'])){
	// pr($_POST);
	$q = "";
	$posts = $_POST['posts'];
	foreach($posts AS $post){
		$q.="UPDATE {$dbo}.`03_products` SET 
			`prodsubtype_id` = '".$post['prodsubtype_id']."',		
			`barcode` = '".$post['barcode']."',
			`comm` = '".$post['comm']."',
			`code` = '".$post['code']."',
			`name` = '".$post['name']."',
			`price` = '".$post['price']."',
			`suppid` = '".$post['suppid']."',
			`cost` = '".$post['cost']."',
			`rolevel` = '".$post['rolevel']."',
			`is_decimal` = '".$post['is_decimal']."',
			`roqty` = '".$post['roqty']."',";
		for($i=1;$i<=$nt;$i++){
			$q.=" `t{$i}` = '".$post['t'.$i]."',";
		}
			
		$q.="`level` = '".$post['level']."' WHERE `id` = '".$post['prid']."' LIMIT 1; ";
	}

	$db->query($q);
	$url = "products";
	flashRedirect($url,'Products updated.');
	exit;

}	/* update */

$data['suppliers'] = $_SESSION['suppliers'];		
$data['prodtags'] = $_SESSION['prodtags'];		
$data['prodtypes'] = $_SESSION['prodtypes'];		
$data['prodsubtypes'] = $_SESSION['prodsubtypes'];		
$data['comm'] 	= $_SESSION['comm'];	


$data['sort'] = $sort = isset($sort)? $sort : 'p.name';
$data['order'] = $order = isset($order)? $order : 'ASC';
$data['page'] = $page = isset($page)? $page : '1';
$data['limits'] = $limits = isset($limits)? $limits : '20';

$data['view'] = $view = isset($view)? $view : 'xls';
$this->view->render($data,"products/$view");


}	/* fxn */


public function roster($params=NULL){
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

$data['suppid'] = $suppid = isset($params[0])? $params[0]:false;

if($suppid){
	$q = " SELECT 0 AS psid,id AS prid,name AS product,cost,barcode,price 
		FROM {$dbo}.`03_products` WHERE `suppid` = '$suppid' ORDER BY name;";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	
	$q = " SELECT ps.id AS psid,ps.product_id AS prid,ps.cost,p.name AS product,p.barcode,p.price 
		FROM {$dbo}.`03_products_suppliers` AS ps 
		INNER JOIN {$dbo}.`03_products` AS p ON ps.product_id = p.id
		WHERE ps.suppid = '$suppid' ORDER BY p.name; ";
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$rows = array_merge($a,$b);	
	$data['rows'] = $rows;
	$data['count'] = count($rows);
	
	$data['supplier'] = fetchRow($db,"{$dbo}.`00_contacts`",$suppid);
	// pr($data['supplier']);
	
}	/* if */


if(isset($_POST['add'])){
	$posts = $_POST['posts'];		
	$q = "";
	foreach($posts AS $post){
		$bc = $post['barcode'];
		$empty = (empty($bc))? true:false;
		// pr($bc);
		if(!$empty){
			$bc = preg_replace("([^A-Za-z0-9-/])", "", $bc);
			$qry = "SELECT id AS prid FROM {$dbo}.`03_products` WHERE `barcode` = '$bc' LIMIT 1;";
			$sth = $db->querysoc($qry);
			$row = $sth->fetch();			
			if($row){
			} else {				
				$cost=$post['cost'];
				$price=$post['price'];
				$name=$post['name'];
				$q.="INSERT INTO {$dbo}.`03_products`(`suppid`,`cost`,`price`,`barcode`,`name`) 
					VALUES ('$suppid','$cost','$price','$bc','$name'); ";				
				
			}	
		}		
	}	/* foreach */
			
	$db->query($q);
	$url = "products/roster/$suppid";
	flashRedirect($url,'Assign Roster by Batch processed.');
	
		
	exit;

}	/* add batch */

$this->view->render($data,'products/roster');

}	/* fxn */



public function invis($params){
	$prid=$params[0];
	require_once(SITE.'functions/invis.php');
	$db=&$this->model->db;
	
	
	// processLevelcurrcostVsPocost($db,$prid);		// ok

	
	
}	/* fxn */


public function mgr(){
$db=&$this->model->db;
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$cond="";
unset($_GET['url']);	
if(!empty($_GET['prid'])){ $cond.="AND pr.id='".$_GET['prid']."'"; }
if(!empty($_GET['suppid'])){ $cond.="AND pr.suppid='".$_GET['suppid']."'"; }
$order=(empty($_GET['order']))? "c.name,pr.name":$_GET['order'];
$dir=(empty($_GET['dir']))? "ASC":$_GET['dir'];
if(empty($_GET)){ echo "not set get so exited"; $data=NULL; } else {
	$q="
		SELECT pr.id AS prid,pr.name AS product,pr.*,c.name AS supplier
		FROM {$dbo}.`03_products` AS pr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=pr.suppid
		WHERE 1=1 $cond	ORDER BY $order $dir
	";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);

}	


$this->view->render($data,'products/mgr');

}	/* fxn */
	


}	/* ProductsController */
