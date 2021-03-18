<?php

Class TrashController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
}

public function beforeFilter(){
	parent::beforeFilter();			
}




public function assign(){
$dbo=PDBO;
	$dbg = PDBG;
	$dbg = PDBG;

	if(isset($_POST['submit'])){
		$posts = $_POST['posts'];
		$q = "INSERT IGNORE INTO {$dbg}.`products_suppliers`(`product_id`,`suppid`)VALUES ";
		foreach($posts AS $row){
			$q.="('".$row['product_id']."','".$row['suppid']."'),";
		}
		$q = rtrim($q,",");
		$q.=";";
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "trash/assign";
		flashRedirect($url,"Products assigned.");
		exit;
			
	}	/* post */

	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);	
	$data['products']		= $this->model->fetchRows("{$dbg}.03_products",'id,code,name','name');						
	$this->view->render($data,"trash/assign");

}	/* fxn */



public function delAssign($params){
$dbo=PDBO;
	$psid = $params[0];
	$q = "DELETE FROM {$dbg}03_products_suppliers WHERE `id` = '$psid' LIMIT 1; ";
	$this->model->db->query($q);
	flashRedirect('trash/assignments','Assignment deleted.');
}	/* fxn */



public function syncProductsAssignments(){
$dbo=PDBO;
	$dbg = PDBG;
	$dbg = PDBG;
	
	/* 1 */
	$q = " SELECT id AS pid FROM {$dbg}.03_products; ";
	$sth = $this->model->db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'pid');	
	
	/* 2 */
	$q = " SELECT DISTINCT(product_id) AS pid FROM {$dbo}.`03_products_suppliers`;";	
	$sth = $this->model->db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'pid');

	/* 3 */
	$ix = array_diff($ar,$br);	
	// pr($ix); exit;
	
	// 1 - insert summaries - scid,sy
	$q = " INSERT INTO {$dbo}.`03_products_suppliers` (`product_id`) VALUES  ";
	foreach($ix AS $pid){ $q .= " ('$pid'),"; }
	$q = rtrim($q,",");
	$q .= "; ";		
	$this->model->db->query($q);
	$url = 'trash/assignments';
	flashRedirect($url,'Assignments synced.');
	
}	/* fxn */



private function makePO2($suppid,$posts){

	$rows = array();
	foreach($posts AS $post){
		if(isset($post['is_selected'])){
			$rows[] = $post;
		}
	}	
	$data['rows'] = $rows;
	$data['count'] = count($rows);
	
	$data['supplier'] = $this->model->fetchRow(PDBO.".`00_contacts`",$suppid);
	
	
	$this->view->render($data,'products/makePO2');

}	/* fxn */


public function makePO($params){

$products = array();
foreach($params AS $id){
	$row = $this->readProduct($id);
	$products[] = $row;
}

$data['products'] = $products;
pr($data);

}	/* fxn */




public function assignments(){
$dbo=PDBO;
	$data['sy'] = $sy = isset($_GET['sy'])? $_GET['sy']:DBYR;	
	$dbg = VCPREFIX.$sy.US.DBG;

	/* for batch edit */
	if(isset($_POST['po'])){
		$post = $_POST;
		require_once(SITE."functions/inventory.php");
		$db =& $this->model->db;
		$poid = createPO($db,$dbg,$post);
		flashRedirect("products/viewPO/$poid","PO created.");				
		exit;		
	}	/* batch */

	
	if(isset($_POST['update'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$q .= "
				UPDATE {$dbg}.`products_suppliers` SET `cost` = '".$post['cost']."',
					`suppid` = '".$post['suppid']."'
				WHERE `id` = '".$post['psid']."' LIMIT 1;				
			";
			$q .= "UPDATE {$dbo}.`03_products` SET `roqty` = '".$post['roqty']."' WHERE `id` = '".$post['product_id']."' LIMIT 1; ";
			
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "products/assignments";
		flashRedirect($url,"Updated.");		
	}	/* update */

if(isset($_GET['filter'])){
	$data['prodtag_id'] = $prodtag_id = isset($_GET['prodtag_id'])? $_GET['prodtag_id'] : false;
	$data['product_id'] = $product_id = isset($_GET['product_id'])? $_GET['product_id'] : false;
	$data['prodtype_id'] = $prodtype_id = isset($_GET['prodtype_id'])? $_GET['prodtype_id'] : false;
	$data['prodsubtype_id'] = $prodsubtype_id = isset($_GET['prodsubtype_id'])? $_GET['prodsubtype_id'] : false;
	$data['suppid'] = $suppid = isset($_GET['suppid'])? $_GET['suppid'] : false;
		
	$cond="";
	$cond .= ($prodtag_id)? " AND `prodtag_id` = '".$prodtag_id."'":NULL;	
	$cond .= ($product_id)? " AND pr.`id` = '".$product_id."'":NULL;	
	$cond .= ($prodtype_id)? " AND `prodtype_id` = '".$prodtype_id."'":NULL;	
	$cond .= ($prodsubtype_id)? " AND `prodsubtype_id` = '".$prodsubtype_id."'":NULL;	
	$cond .= ($suppid)? " AND ps.`suppid` = '".$suppid."'":NULL;	

	$q = "
		SELECT
			ps.id AS psid,ps.*,
			pr.*,pr.name AS product,
			pg.name AS `group`,
			pt.name AS `prodtype`,
			pc.name AS `prodtag`
		";	
	$q .= "	FROM {$dbo}.`03_products` AS pr 
				LEFT JOIN {$dbg}.`products_suppliers` AS ps ON ps.product_id = pr.id
				LEFT JOIN {$dbo}.`03_prodsubtypes` AS pg ON pr.prodsubtype_id = pg.id
				LEFT JOIN {$dbo}.`03_prodtypes` AS pt ON pg.prodtype_id = pt.id
				LEFT JOIN {$dbo}.`03_prodtags` AS pc ON pt.prodtag_id = pc.id
			WHERE 1=1 $cond
		";

	
	$offset = ($_GET['page']-1)*$_GET['limits'];
	$sort   = (isset($_GET['sort']))?$_GET['sort']:'p.datetime';
	$order  = (isset($_GET['order']))?$_GET['order']:'DESC';
	
	$q .= " ORDER BY $sort $order LIMIT ".$_GET['limits']." OFFSET $offset "; 

	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);


}	/* filter */
	
	

	$where = "WHERE role_id = '".RSUPP."'";							
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);				
	$data['products']	= $this->model->fetchRows("{$dbg}.03_products",'id,code,name','name');						
	$data['prodtags']	= $this->model->fetchRows("{$dbo}.`03_prodtags`",'id,name','id');						
	$data['prodtypes']	= $this->model->fetchRows("{$dbo}.`03_prodtypes`",'id,code,name','name');						
	$data['prodsubtypes']	= $this->model->fetchRows("{$dbo}.`03_prodsubtypes`",'id,code,name','name');						
	$this->view->render($data,"trash/assignments");



}	/* fxn */

















}	/* TrashController */
