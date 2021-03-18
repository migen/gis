<?php

Class InventoryController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}


public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$acl = array(array(RMIS,0),array(RINVIS,0));
	$this->permit($acl);				
	
	parent::beforeFilter();			
}


public function index(){ echo "<h3>Inventory Index</h3>"; }

public function master(){	
	$dbo=PDBO;
	require_once(SITE.'functions/inventory.php');
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$data['employees'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name','WHERE role_id = 10');	
	$data['suppliers']=$_SESSION['suppliers'];
	$today=$_SESSION['today'];
	
	if(isset($_GET['submit']) && isset($_GET['suppid'])){
		$get=$_GET;
		$suppid=$get['suppid'];
		$start=isset($get['start'])? $get['start']:$today;
		$end=isset($get['end'])? $get['end']:$today;
		
		/* 1 */
		$q="SELECT id,id AS suppid,code,name,name AS supplier FROM {$dbo}.`00_contacts` WHERE `id`='$suppid' LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['supp']=$sth->fetch();
		
		
		/* 2-test */
		$q="SELECT id AS prid,barcode,name AS product,cost,price,level FROM {$dbg}.03_products WHERE `suppid`='$suppid' ORDER BY name;";
		
		/* 2 */
		$q="SELECT pr.id AS prid,pr.barcode,pr.name AS product,pr.cost,pr.price,pr.level,dr.dr,
				pr.t1,pr.t2,pr.t3,pr.t4,pr.t5,pr.t6
			FROM {$dbg}.03_products AS pr 
			LEFT JOIN (
				SELECT product_id,sum(rxqty) AS dr FROM {$dbo}.30_po_rx WHERE `rxdate`>='$start' AND `rxdate`<='$end' GROUP BY product_id			
			) AS dr ON pr.id=dr.product_id								
			WHERE pr.`suppid`='$suppid' ORDER BY pr.name;";	
		$qd=$q; /* debugQryString */		
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		$count=count($rows);		
		
		/* 3 sk shrinkages */			
		$q="SELECT sk.prid,sk.sk AS shrinkages FROM {$dbg}.03_products AS pr 
			LEFT JOIN ( SELECT prid,sum(qty) AS sk FROM {$dbg}.30_shrinkages WHERE `date`>='$start' AND `date`<='$end' GROUP BY prid
			) AS sk ON pr.id=sk.prid					
			WHERE pr.`suppid`='$suppid' ORDER BY pr.name;";							
		$qd=$q; /* debugQryString */		
		$sth=$db->querysoc($q);
		$sk=$sth->fetchAll();		
		
		/* 4 sd sold */			
		$q="SELECT sd.product_id AS prid,sd.sd AS sold FROM {$dbg}.03_products AS pr 
			LEFT JOIN ( SELECT pd.product_id,sum(pd.qty) AS sd 
				FROM {$dbo}.`30_pos` AS p
				INNER JOIN {$dbo}.`30_positems` AS pd ON p.id=pd.pos_id				
				WHERE DATE(p.`datetime`)>='$start' AND DATE(p.`datetime`)<='$end' GROUP BY pd.product_id
			) AS sd ON pr.id=sd.product_id					
			WHERE pr.`suppid`='$suppid' ORDER BY pr.name;";										
		$qd=$q; /* debugQryString */		
		$sth=$db->querysoc($q);
		$sd=$sth->fetchAll();
				
		
	}	/* get */

	$data['rows']=&$rows;	
	$data['count']=&$count;
	$data['sk']=&$sk;
	$data['sd']=&$sd;
	// pr($sd);
	$this->view->render($data,'inventory/masterInventory');

}	/* fxn */











}	/* BlankController */
