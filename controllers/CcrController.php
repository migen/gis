<?php

/* college classrooms */
Class CcrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	require_once(SITE.'functions/ccrFxn.php');
	$db=&$this->baseModel->db;
	$dbg=PDBG;
	$d=getCcr($db,$dbg);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];

	$this->view->render($data,'ccr/indexCcr');
}	/* fxn */





public function test($params=NULL){
	$dbo=PDBO;
	
	pr($this->params());
	
	echo "abc test <br />";
	
	
	// $data=$this->baseModel->countAll();
	
}


public function ranks(){
	$data=NULL;
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	$q="SELECT c.name AS student,summ.scid,summ.ave_q1 AS genave
	FROM {$dbg}.05_summaries AS summ INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
	WHERE summ.crid=1 ORDER BY genave DESC LIMIT 20;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	$this->view->render($data,'abc/ranksAbc');
}	/* fxn */



public function ties(){
$dbo=PDBO;
$db=&$this->model->db;$dbg=PDBG;
// $q="SELECT * FROM {$dbg}.ties ORDER BY score DESC; ";

/* 1-ok */
$q1="
SELECT t.*,@rank:=(@rank+1) AS rank 
FROM {$dbg}.ties AS t
INNER JOIN (SELECT @rank:=0) r 
ORDER BY t.score DESC
";

/* 2 */
$q2="
SELECT 
	t.*,
	CASE WHEN @prev=score THEN @rank
	WHEN @prev:=score THE @rank:=@rank+1
FROM {$dbg}.ties AS t
INNER JOIN (SELECT @prev:=NULL,@rank:=0) r 
ORDER BY t.score DESC
";

/* 3 - ok */
$q3="SELECT *,score AS `var`,
	(SELECT COUNT(score)+1 FROM {$dbg}.ties WHERE score<`var`) AS rank
	FROM {$dbg}.ties
	ORDER BY score;";

/* 4 - ok */
$q4="SELECT t.*,t.score AS `var`,
	(SELECT COUNT(score)+1 FROM {$dbg}.ties WHERE score<`var`) AS rank
	FROM {$dbg}.ties AS t
	ORDER BY t.score;";

/* 5-ok */	
$q5="
SELECT t.*,
@prev:=@curr,
@curr:=t.score,
@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
FROM {$dbg}.ties t,(SELECT @prev:=null,@curr:=null,@rank:=0) x
ORDER BY t.score DESC;
";

/* 5-ok */	
$q6="
SELECT t.*,c.name AS person,
@prev:=@curr,
@curr:=t.score,
@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
FROM {$dbg}.ties AS t
INNER JOIN {$dbg}.tiespersons AS c ON t.pid=c.id
INNER JOIN (SELECT @prev:=null,@curr:=null,@rank:=0) AS x
ORDER BY t.score DESC;
";

/* 7-ok */	
$q7="
SELECT t.*,c.name AS person,
@prev:=@curr,
@curr:=t.score,
@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
FROM {$dbg}.tiespersons AS c
INNER JOIN (
	SELECT * FROM {$dbg}.ties ORDER BY score DESC
) AS t ON c.id=t.pid
INNER JOIN (SELECT @prev:=null,@curr:=null,@rank:=0) AS x
;";

/* 8-ok */	
$q8="
SELECT t.*,
@prev:=@curr,
@curr:=t.score,
@rank:=IF(@prev=@curr,@rank,@rank+1) AS `rank`
FROM 
	(SELECT a.*,b.name AS person FROM {$dbg}.ties AS a 
		INNER JOIN {$dbg}.tiespersons AS b ON a.pid=b.id) t,
	(SELECT @prev:=null,@curr:=null,@rank:=0) x
ORDER BY t.score DESC;
";

	
$num=isset($_GET['num'])? $_GET['num']:1;
$data['q']=${'q'.$num};
$sth=$db->querysoc(${'q'.$num});
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$this->view->render($data,'abc/tiesAbc');

}	/* fxn */

public function width(){

$this->view->render(null,"abc/width");

}	/* fxn */


public function carl(){


$this->view->render(NULL,'abc/carl');

}	/* fxn */




}	/* BlankController */
