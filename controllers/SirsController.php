<?php

Class SirController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'sir/index');

}	/* fxn */



public function sales($params=NULL){
$dbo=PDBO;
$dbg = PDBG;

$today = date('Y-m-d');
$from = (isset($_GET['from']))? $_GET['from'] : $today;
$to	  = (isset($_GET['to']))? $_GET['to'] : $today;

$q = " 
	SELECT SUM(a.`amount`) AS `subtotal`,a.`prodcategory_id`,a.`prodcategory`
	FROM (
		SELECT 
			pd.`pos_id`,pr.`name` AS `product`,pr.`prodcategory_id`,
			pcat.`name` AS `prodcategory`,pd.`amount`
		FROM {$dbo}.`30_pos` AS `p` 
			LEFT JOIN {$dbo}.`30_positems` AS pd ON pd.`pos_id` = pd.`id`
			LEFT JOIN {$dbo}.`03_products` AS `pr` ON pd.`product_id` = pr.`id` 
			LEFT JOIN {$dbg}.`prodcategories` AS `pcat` ON pr.`prodcategory_id` = pcat.`id` 											
		WHERE 
				p.`datetime` >= '$from'			
			AND	p.`datetime` <= '$to'			
	) AS a 
	GROUP BY a.prodcategory_id					
";

$q = "
	SELECT   
		SUM(pd.amount) AS total
	FROM {$dbo}.`30_pos` AS p
		LEFT JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id = p.id
		LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
		LEFT JOIN {$dbg}.prodcategories AS pcat ON pr.prodcategory_id = pcat.id
	WHERE p.datetime = '$today'	
	GROUP BY pr.prodcategory_id

";

$sth = $this->model->db->querysoc($q);
pr($q);
$data['categories'] =  $sth->fetchAll();
pr($data);

$total = 0;
foreach($data['categories'] AS $row){ $total += $row['subtotal']; }

$data['total'] 	= $total;
$data['today']	= $today;

$this->view->render($data,'posr/sales');


}



public function product($params=NULL){
$data['today'] = $today = $_SESSION['today'];
$data['start'] = $start = (isset($_GET['start']))? $_GET['start']:$_SESSION['today'];
$data['end'] = $end = (isset($_GET['end']))? $_GET['end']:$_SESSION['today'];
$data['product_id'] = $product_id = (isset($params[0]))? $params[0]:1;

$dbg = PDBG;
$dbo=PDBO;



$q = "
	SELECT
		sum(pd.qty) AS sumqty,
		sum(pd.amount) AS sumamount
	FROM {$dbo}.`30_pos` AS p
		INNER JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id = p.id
	WHERE 
			pd.product_id = '$product_id'
		AND	date(p.datetime) >= '$start'
		AND	date(p.datetime) <= '$end'			
";

$sth = $this->model->db->querysoc($q);
$data['row'] = $row = $sth->fetch();


$q = "
	SELECT p.*,pc.name AS prodcategory,p.name AS product FROM {$dbo}.`03_products` AS p
		LEFT JOIN {$dbg}.prodcategories AS pc ON p.prodcategory_id = pc.id
	WHERE p.id = '$product_id' LIMIT 1;
";
$sth = $this->model->db->querysoc($q);
$data['product'] = $sth->fetch();

$this->view->render($data,'sirs/product');

}	/* fxn */



public function productEnum($params=NULL){
$data['today'] = $today = $_SESSION['today'];
$data['start'] = $start = (isset($_GET['start']))? $_GET['start']:$_SESSION['today'];
$data['end'] = $end = (isset($_GET['end']))? $_GET['end']:$_SESSION['today'];
$data['product_id'] = $product_id = (isset($params[0]))? $params[0]:1;
$dbo=PDBO;

$dbg = PDBG;

if(isset($_GET['filter'])){
	// pr($_GET);
	$url = "sirs/productEnum/".$_GET['product_id']."?start=".$_GET['start']."&end=".$_GET['end'];
	// pr($url);
	redirect($url);
	exit;

}	/* get */


$q = "
	SELECT
		pd.*,p.*,c.name AS customer
	FROM {$dbo}.`30_pos` AS p
		INNER JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id = p.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.customer_pcid = c.id
	WHERE 
			pd.product_id = '$product_id'
		AND	date(p.datetime) >= '$start'
		AND	date(p.datetime) <= '$end'			
";

$sth = $this->model->db->querysoc($q);
$data['rows'] = $rows = $sth->fetchAll();
$data['count'] = count($rows);


// pr($rows);

$q = "
	SELECT p.*,pc.name AS prodcategory,p.name AS product FROM {$dbo}.`03_products` AS p
		LEFT JOIN {$dbg}.prodcategories AS pc ON p.prodcategory_id = pc.id
	WHERE p.id = '$product_id' LIMIT 1;
";
$sth = $this->model->db->querysoc($q);
$data['product'] = $sth->fetch();


	// pr($_GET);
	// $get = isset($_GET)? sages($_GET):'';	 
	// pr($get);
	$data['products'] = $this->model->fetchRows("{$dbg}.03_products","id,name","name");

$this->view->render($data,'sirs/productEnum');

}	/* fxn */



// for sales report by product_id
public function byProduct($params=null){	
$dbo=PDBO;

	$dbg = PDBG;
	
	$id = isset($params[1])? $params[1] : false;		
	if(!$id){ redirect('sir'); }	
	$from = isset($params[2])? $params[2] : date('Y').'-01-01';
	$to = isset($params[3])? $params[3] : date('Y-m-d');
	$orderby = isset($params[4])? $params[4] : 'p.datetime';
	

	// all sales between periods
	$q = " 	SELECT c.name AS customer,p.*,pd.* 
				FROM {$dbo}.`30_positems` AS pd 
			LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id = p.customer_pcid
			WHERE pd.product_id = $id AND date(p.datetime) >= '".$from."' AND date(p.datetime) <= '".$to."' 
			ORDER BY $orderby
		";
		
	/* PAGINATION */
	$page = isset($params[0])? $params[0] : 1;								# 1/3
	$perPage = 50; 															# 2/3
	$offset = ($page - 1) * $perPage;										# 3/3
	# pageNav
	$totalCount = $this->model->countAll($q);		
	if(!$totalCount){ 
		$data = "No results found."; 
		$this->view->render($data,'default');
		return false;
	}

	$pagination = new Pagination($page, $perPage, $totalCount);	
	$paramString = $id.'/'.$from.'/'.$to;
	$data['pages'] = $pagination->pageNav('sir','byProduct',$paramString);

	$q .= " LIMIT $perPage OFFSET {$offset} ";		
			
	pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['sales'] = $sth->fetchAll();
	
	/* product details */
	$q = " SELECT id,code,name FROM {$dbo}.`03_products` WHERE id = $id ";
	$sth = $this->model->db->querysoc($q);
	$data['product'] = $sth->fetch();
	$data['from'] = $from;
	$data['to'] = $to;
		
	$this->view->render($data,'sirs/byProduct');
	
	// pr($data);
}	/* fxn */



public function reports(){
$dbo=PDBO;

	$dbg = PDBG;
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$row = $_POST;
		$dateRange = DS.$row['from'].DS.$row['to'];
		$_SESSION['dateRange'] = $dateRange;
		$by = $row['by'];
		$url = '';
		switch($by){
			case 1:
				$url .= 'sales/byProduct/1/'.$row['product']; break;
			case 2:
				$url .= 'sales/byCategory/1/'.$row['category']; break;
			default:
				$url .= 'sales/byCustomer/1/'.$row['customer']; break;		
		}
		$url .= $dateRange;		
		// pr($url);					
		$this->redirect($url);
	}
	
	$data['selectsProducts'] = $this->model->fetchRows("{$dbg}.03_products");
	$data['selectsCategories'] = $this->model->fetchRows("{$dbg}.prodcategories");
	$data['selectsCustomers'] = $this->model->fetchRows(PDBO.".`00_contacts`",'id,name','name',' WHERE (id=parent_id) ');
	$this->view->render($data,'sirs/reports');

}











}	/* SirController */
