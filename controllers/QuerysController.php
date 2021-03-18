<?php

Class QuerysController extends Controller{	

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
	echo "<h3>Querys or Queries</h3>";

}	/* fxn */


public function updateJoinTerminalsInventory(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

$q = "
UPDATE {$dbo}.`03_products` AS x 
INNER JOIN (
	SELECT 
		pr.id AS prid,pr.name AS product,pr.level,b.sold AS t2sold,c.sold AS t5sold
	FROM {$dbo}.`03_products` AS pr 
		RIGHT JOIN (
			SELECT pd.product_id AS `prodid`,sum(pd.qty) AS sold,p.id AS pos_id
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id		
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			WHERE 1=1  AND p.terminal = '2' 	
			GROUP BY pd.product_id		
		) AS b ON pr.id = b.prodid
		RIGHT JOIN (
			SELECT pd.product_id AS `prodid`,sum(pd.qty) AS sold,p.id AS pos_id
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id		
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			WHERE 1=1  AND p.terminal = '5' 	
			GROUP BY pd.product_id		
		) AS c ON pr.id = c.prodid		
)	AS y ON x.id = y.prid
SET x.t5=((y.t2sold+y.t5sold)*-1),x.level=((y.t2sold+y.t5sold)*-1),x.t2=0
WHERE x.t2<>0 and x.t5=0

";



$q="UPDATE {$dbo}.`03_products` AS x 
SET x.t5=(x.t2+x.t5),x.t2=0
WHERE x.t2<>0;";



pr($q);



}	/* fxn */



public function joinPosTerminals(){

$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

$q=" UPDATE {$dbo}.`30_pos` SET terminal=5 where terminal=2; ";
pr($q);



}	/* fxn */


public function a1(){	/* createInitCrsGrades */
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

$levels=array(4,5,6,7,8,9,10,11,12,13);
$subs=array('30');
$ctype=1;	/* 5 for conduct */

echo "<h3 class='brown' >Not for traits</h3>";

$crsid=lastId($db,"{$dbg}.05_courses");
$crsid++;

/* 2 */
	$cond="";
	foreach($levels AS $lvl){
		$cond.=" cr.level_id='$lvl' OR ";
	}
	$cond=rtrim($cond," OR ");
	$q="SELECT cr.id AS crid,cr.name FROM {$dbg}.05_classrooms AS cr LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id  
		WHERE cr.section_id>2 AND ($cond) ORDER BY cr.level_id,cr.section_id;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();


$crids=buildArray($rows,'crid');
$q="";
foreach($subs AS $sub){
	$q.="INSERT INTO {$dbg}.05_courses(`id`,`crid`,`subject_id`) VALUES ";
	foreach($crids AS $crid){
		$q.="($crsid,'$crid','$sub'),";
		$crsid++;		
	}
	$q=rtrim($q,",");$q.=";";
}

pr($q);


/* 3 crs name code, label tcid */
$q="
	UPDATE {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id		
	SET crs.code=sub.code,crs.label=sub.name,crs.name = concat(cr.`name`,'-',sub.`code`),crs.tcid=cr.acid
	WHERE crs.subject_id = '30';

";
pr($q);




}	/* fxn */





public function club(){	/* derived from a1 */
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

// $levels=array(4,5,6,7,8,9,10,11,12,13);
$levels=array(4);
$subs=array('30');
$ctype=1;	/* 5 for conduct */

echo "<h3 class='brown' >Not for traits</h3>";

$crsid=lastId($db,"{$dbg}.05_courses");
$crsid++;

/* 2 */
	$cond="";
	foreach($levels AS $lvl){
		$cond.=" cr.level_id='$lvl' OR ";
	}
	$cond=rtrim($cond," OR ");
	$q="SELECT cr.id AS crid,cr.name FROM {$dbg}.05_classrooms AS cr LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id  
		WHERE cr.section_id>2 AND ($cond) ORDER BY cr.level_id,cr.section_id;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();


$crids=buildArray($rows,'crid');
$q="";
foreach($subs AS $sub){
	$q.="INSERT INTO {$dbg}.05_courses(`id`,`crid`,`subject_id`) VALUES ";
	foreach($crids AS $crid){
		$q.="($crsid,'$crid','$sub'),";
		$crsid++;		
	}
	$q=rtrim($q,",");$q.=";";
}

pr($q);


/* 3 crs name code, label tcid */
$q="
	UPDATE {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id		
	SET crs.code=sub.code,crs.label=sub.name,crs.name = concat(cr.`name`,'-',sub.`code`),crs.tcid=cr.acid,
		crs.with_scores=0,crs.position=20,crs.is_num=0,crs.in_genave=0
	WHERE crs.subject_id = '30';

";
pr($q);




}	/* fxn */


public function zerofyKpup(){
	$dbg=PDBG;
	$q=" UPDATE {$dbg}.05_courses SET `is_kpup`=0; ";
	pr($q);

}	/* fxn */


















}	/* QuerysController */
