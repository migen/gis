<?php

Class PagesController extends Controller{	

public function __construct(){
	parent::__construct();		
	// $this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function test($params=NULL){
	// echo "Pages";
	reqFxn('paginationFxn');
	$db=$this->baseModel->db;$dbo=PDBO;
	$currPage=isset($params[0])? $params[0]:1;
	$perPage=12;
	$q="SELECT id,name FROM {$dbo}.`00_contacts` WHERE role_id=1 ORDER BY name LIMIT 32; ";
	
	$data['pages']=getPagination($db,$q,$perPage,$currPage);
	
	$this->view->render($data,"pages/indexPages");

	
}	/* fxn */




public function index(){
	reqFxn('paginationFxn');
	$db=$this->baseModel->db;$dbo=PDBO;
	/* given */
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$data['perPage']=$perPage=isset($_GET['perPage'])? $_GET['perPage']:5;
	$perSet=10;	
	
	// $_GET['debug']=true;
	
	$dbtable="{$dbo}.`00_contacts`";
	$cond="c.role_id=1 AND c.is_male=1";		
	$data['name']=$name=isset($_GET['name'])? $_GET['name']:null;
	$data['sex']=$sex=isset($_GET['sex'])? $_GET['sex']:2;
	if($name){ $cond="";$cond.="c.name LIKE '%".$name."%' "; } else { $cond; }
	if($sex<2){
		if($sex==1){ $cond.=" AND c.is_male=1"; } else { $cond.=" AND c.is_male=0"; }  
	} 
		
	
	$data['cond']=$cond;
	$order="c.name";
		
	/* derived */
	$offset=($currPage-1)*$perPage;
	$url="pages";
	/* sql */
	$q="SELECT ctp.ctp,c.id,c.name,c.is_male
			FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id=c.id  
		WHERE $cond ORDER BY $order ";
	$sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	// $data['totalCount']=$totalCount=120;	
	/* derived */
	$data['pagenav']=pagenav($url,$totalCount,$offset,$perPage,$currPage,$perSet);	

	$debug="";
	$debug.="<hr />";
	$debug.="q: ".$q."<br />";	
	$debug.="condition: ".$cond."<br />";	
	$debug.="totalCount: ".$totalCount."<br />";	
	$debug.="curr Page: $currPage <br />";
	debug($debug);

	$q.=" LIMIT $perPage OFFSET $offset";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"pages/indexPages");

}	/* fxn */




public function index1(){
	reqFxn('paginationFxn');
	$db=$this->baseModel->db;$dbo=PDBO;
	/* given */
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$perSet=10;	
	$data['currSet']=$currSet=ceil($currPage/$perSet);
		
	$dbtable="{$dbo}.`00_contacts`";
	$cond="c.role_id=1 AND c.is_male=1";
	$order="c.name";
	$perPage=5;
	/* derived */
	$offset=($currPage-1)*$perPage;
	$url="pages";
	/* sql */
	$q="SELECT c.id,c.name,ctp.ctp 
			FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id=c.id  
		WHERE $cond ORDER BY $order ";
	// $sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	$data['totalCount']=$totalCount=120;	
	/* derived */
	$numpages=ceil($totalCount/$perPage);	
	// $data['pagenav']=pagenav($url,$totalCount,$numpages,$offset,$perPage,$currPage,$currSet,$perSet);	
	$data['pagenav']=pagenav($url,$totalCount,$numpages,$offset,$perPage,$currPage,$currSet,$perSet);	
	// pr("totalCount: ".$totalCount);	

	$debug="";
	$debug.="<hr />";
	$debug.="curr Page: $currPage <br />";
	$debug.="curr Set: $currSet <br />";
	debug($debug);

	$q.=" LIMIT $perPage OFFSET $offset";
	pr($q);$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"pages/indexPages");

}	/* fxn */



public function contacts(){

	$db=$this->baseModel->db;$dbo=PDBO;
	$currPage=isset($_GET['page'])? $_GET['page']:1;
	$dbtable="{$dbo}.`00_contacts`";
	$cond="c.role_id=1 AND c.is_male=1";
	$order="c.name";

	$totalCount=100;
	$perPage=100;

	/* derived */
	$offset=($currPage-1)*$perPage;
	$numpages=ceil($totalCount/$perPage);
	$url="pages/index";
	
	$q="SELECT c.id,c.name,ctp.ctp 
		FROM {$dbo}.`00_contacts` AS c INNER JOIN 
		{$dbo}.`00_ctp` AS ctp ON ctp.contact_id=c.id  
		WHERE $cond ORDER BY $order LIMIT $perPage OFFSET $offset; ";
	// $data['']
	pr($q);
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	
	// $data['pages']=getPagination($db,$dbtable,$cond,$perPage,$currPage);
	$data['pagenav']=null;
	
	$this->view->render($data,"pages/indexPages");
	
	
}	/* fxn */


}	/* BlankController */
