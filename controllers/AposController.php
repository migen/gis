<?php

Class AposController extends Controller{	

	public $table_pos="00_pos";
	public $table_positems="00_positems";
	public $table_buyitems="00_buyitems";
	public $table_products="00_products";
	public $table_types="03_postypes";
	public $table_inventory="00_posinventory";


public function __construct(){
	parent::__construct();			
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$data['axn']=$this->axn();
	$dbo=PDBO;$db=&$this->baseModel->db;
	
	
	

	$data="ABC";$this->view->render($data,"apos/indexApos");
	
}	/* fxn */



public function view($params){
	$data['axn']=$this->axn();
	$dbo=PDBO;$db=&$this->baseModel->db;
	$data['id']=$id=$params[0];
	$table_pos=$this->table_pos;
	$table_positems=$this->table_positems;
	$table_products=$this->table_products;
	$table_types=$this->table_types;
	
	$q="SELECT p.*,t.name AS type FROM {$dbo}.{$table_pos} AS p
		LEFT JOIN {$dbo}.{$table_types} AS t ON p.type_id=t.id
		WHERE p.id=$id LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['pos']=$sth->fetch();
	
	$q="SELECT i.*,pr.name AS product FROM 
		{$dbo}.{$table_positems} AS i
		INNER JOIN {$dbo}.{$table_products} AS pr ON i.product_id=pr.id  		
		WHERE i.pos_id=$id; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['positems']=$sth->fetchAll();
	
	
	$this->view->render($data,"apos/viewApos");
	
	
	
	
}	/* fxn */



public function add(){
	$data['axn']=$this->axn();
	require_once(SITE."functions/arrayFxn.php");
	$dbo=PDBO;$db=&$this->baseModel->db;
	$table_pos=$this->table_pos;
	$table_positems=$this->table_positems;
	$table_products=$this->table_products;
	$table_types=$this->table_types;
	
	$data['today']=$_SESSION['today'];
	if(!isset($_SESSION['apos_products'])){ $_SESSION['apos_products']=fetchRows($db,"{$dbo}.{$table_products}","*"); }
	if(!isset($_SESSION['apos_types'])){ $_SESSION['apos_types']=fetchRows($db,"{$dbo}.{$table_types}","*","id"); }
	$data['products']=$_SESSION['apos_products'];	
	$data['types']=$_SESSION['apos_types'];	
	// $x=fetchRows($db,"{$dbo}.{$table_products}","*");
	
	if(isset($_POST['submit'])){
		$pos=$_POST['pos'];
		$positems=$_POST['positems'];
		/* 1 - pos */
		$db->add("{$dbo}.{$table_pos}",$pos);
		$pos_id=$db->lastInsertId();		
		/* 2 - positems */
		$positems=arrayAddKeyValuePair($positems,"pos_id",$pos_id);
		foreach($positems AS $row){
			$db->add("{$dbo}.{$table_positems}",$row);
		}
		redirect("apos/view/$pos_id");		
		exit;
		
	}	/* post */
	
	
	
	$this->view->render($data,"apos/addApos");
	
	
}	/* fxn */


public function abc(){
	$data['axn']=$this->axn();
	
	$data['pos_id']=5;
	
	$rows=array(
		array('prid'=>11,'price'=>35),
		array('prid'=>12,'price'=>50),
	);
	
	$data['rows']=$rows;
	
	$this->view->render($data,"apos/abcApos");
	
	
}	/* fxn */


public function purge(){
	$data['axn']=$this->axn();
	$db=&$this->baseModel->db;$dbo=PDBO;
	$table_pos=$this->table_pos;
	$table_positems=$this->table_positems;
	$q="TRUNCATE TABLE {$dbo}.{$table_pos}; ";
	$db->query($q);
	pr($q);
	
	$q="TRUNCATE TABLE {$dbo}.{$table_positems}; ";
	$db->query($q);
	pr($q);
	
	$msg="Truncated <br />1) pos <br />2) positems ";
	// flashRedirect("apos",$msg);
	
}	/* fxn */


public function items(){
	$data['axn']=$this->axn();
	$db=&$this->baseModel->db;$dbo=PDBO;
	$table_pos=$this->table_pos;
	$table_positems=$this->table_positems;
	$table_products=$this->table_products;
	
	$q="SELECT i.*,p.*,pr.name AS product
		FROM {$dbo}.{$table_positems} AS i 
		LEFT JOIN {$dbo}.{$table_products} AS pr ON i.product_id=pr.id
		LEFT JOIN {$dbo}.{$table_pos} AS p ON i.pos_id=p.id
		ORDER BY p.id;
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"apos/itemsApos");
	
	
	
}	/* fxn */


public function mir(){
	$data['axn']=$this->axn();
	$db=&$this->baseModel->db;$dbo=PDBO;
	$table_pos=$this->table_pos;
	$table_positems=$this->table_positems;
	$table_buyitems=$this->table_buyitems;
	$table_products=$this->table_products;
	$table_inventory=$this->table_inventory;
	
	/* 1.1 */
	$q="SELECT pr.name AS product,sum(a.qty) AS qty_sold,i.level AS ending_inventory,pr.cost,pr.price
		FROM {$dbo}.{$table_products} AS pr 
		LEFT JOIN {$dbo}.{$table_inventory} AS i ON (pr.id=i.product_id) 
		LEFT JOIN 
			(
				SELECT i.product_id,i.qty
				FROM {$dbo}.{$table_positems} AS i 
				INNER JOIN {$dbo}.{$table_pos} AS p ON i.pos_id=p.id
				WHERE p.type_id=1
			) AS a ON pr.id=a.product_id		
		WHERE i.dbyr=(".(DBYR-1).")  		
		GROUP BY pr.id					
		;";
	// pr($q);
	
	debug("sold: ".$q);		
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();


	/* 2.1 - purchased ok joint table */
	$q="SELECT pr.name AS product,sum(a.qty) AS qty_purchased
		FROM {$dbo}.{$table_products} AS pr 
		LEFT JOIN 
			(
				SELECT i.product_id,i.qty
				FROM {$dbo}.{$table_positems} AS i 
				INNER JOIN {$dbo}.{$table_pos} AS p ON i.pos_id=p.id
				WHERE p.type_id=2
			) AS a ON pr.id=a.product_id
		GROUP BY pr.id	
		;
	";
	/* 2.2 - better i think - NOT joint table OR separate tables */	
	$q1="SELECT pr.name AS product,sum(a.qty) AS qty_purchased
		FROM {$dbo}.{$table_products} AS pr 
		LEFT JOIN 
			(
				SELECT i.product_id,i.qty
				FROM {$dbo}.{$table_buyitems} AS i 
			) AS a ON pr.id=a.product_id
		GROUP BY pr.id	
		;
	";
	debug("purchased: ".$q);		
	$sth=$db->querysoc($q);
	$data['buyrows']=$sth->fetchAll();
	$data['count_buys']=$sth->rowCount();
	
	$data['joint_table']=true;		// 2.1
	// $data['joint_table']=false; 	// 2.2
	
	$this->view->render($data,"apos/mirApos");
	
	
}	/* fxn */





}	/* BlankController */
