<?php

Class BooklistsController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data=NULL;
	
	
	$this->view->render($data,"booklists/indexBooklists");
	
	
}	/* fxn */

public function table($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$order=isset($_GET['order'])? $_GET['order']:"s.name,b.name";
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT s.name AS subjname,b.*,b.id AS pkid FROM {$dbg}.05_books AS b
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id 
		ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$data['levels']=$_SESSION['levels'];
	
	$this->view->render($data,"booklists/tableBooklists");
	// $this->view->render($data,"booklists/table");
	
}	/* fxn */


public function level($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['num']=$num=isset($_GET['num'])? $_GET['num']:1;
	$data['sy_enrollment']=$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
	$data['is_current']=$is_current=($sy==$sy_enrollment)? true:false;
	
	$order=isset($_GET['order'])? $_GET['order']:"b.semester,b.name";
	$data['db']=$db=&$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT b.*,lb.*,s.name AS subjname,b.id AS book_id,lb.id AS lbid 
		FROM {$dbg}.05_level_books AS lb
		INNER JOIN {$dbg}.05_books AS b ON lb.book_id=b.id
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		WHERE lb.level_id=$lvl AND lb.num=$num		
		ORDER BY $order; ";
	// pr($q);
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	/* data-2 */
	$data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl,"id,code,name");
	$vfile=(isset($_GET['edit']))? "booklists/levelBooklistsEdit":"booklists/levelBooklists";
	vfile($vfile);
	
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function sync($params=NULL){
	$lvl=isset($params[0])? $params[0]:false;
	$sy=$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$num=isset($_GET['num'])? $_GET['num']:1;
	
	if($lvl){

		/* data-1 */
		$q="SELECT *,book_id AS bid FROM {$dbg}.05_level_books 
			WHERE level_id=$lvl AND num=$num;";
		pr($q);
		$sth=$db->querysoc($q);
		$a=$sth->fetchAll();
		$ar=buildArray($a,'bid');	
		
		/* data-2 */
		$q="SELECT summ.scid
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE cr.level_id=$lvl AND c.is_active=1 AND summ.booklist_finalized<>1;";
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		$sr=buildArray($rows,'scid');
		// pr($sr);
		
		$q="INSERT INTO {$dbg}.50_students_books(scid,book_id)VALUES";	
		foreach($sr AS $scid){
			$q1="SELECT book_id AS bid FROM {$dbg}.50_students_books WHERE scid=$scid;";
			$sth=$db->querysoc($q1);
			$b=$sth->fetchAll();
			$br=buildArray($b,'bid');	

			/* 3 */
			$ix=array_diff($ar,$br);		
			foreach($ix AS $bid){ $q.="($scid,$bid),"; }
			
			
		}	/* foreach */
		$q=rtrim($q,",");$q.=";";
		
		pr($q);
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	

		
		
		
		
	
		
	}	/* lvl */
	
	
	
}	/* fxn */



public function syncStudent($params=NULL){
	$scid=isset($params[0])? $params[0]:false;
	$sy=$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	// $num=isset($_GET['num'])? $_GET['num']:1;
	
	if($scid){
		$q="SELECT cr.level_id AS lvl,cr.num
			FROM {$dbo}.00_contacts AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$srow=$sth->fetch();
		$lvl=$srow['lvl'];
		$num=$srow['num'];
			

		/* data-1 */
		$q="SELECT *,book_id AS bid FROM {$dbg}.05_level_books 
			WHERE level_id=$lvl AND num=$num;";
		pr($q);
		$sth=$db->querysoc($q);
		$a=$sth->fetchAll();
		$ar=buildArray($a,'bid');	
		
		/* data-2 */
		$q="SELECT summ.scid
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE cr.level_id=$lvl AND c.is_active=1;";
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		$sr=buildArray($rows,'scid');
		// pr($sr);
		
		$q1="SELECT book_id AS bid FROM {$dbg}.50_students_books WHERE scid=$scid;";
		$sth=$db->querysoc($q1);
		$b=$sth->fetchAll();
		$br=buildArray($b,'bid');	

		/* 3 */
		$ix=array_diff($ar,$br);		
		$q="INSERT INTO {$dbg}.50_students_books(scid,book_id)VALUES";	
		foreach($ix AS $bid){ $q.="($scid,$bid),"; }		
		$q=rtrim($q,",");$q.=";";
		
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
		
		flashRedirect("students/booklist/$scid","Synced");
	
		
	}	/* lvl */
	
	
	
}	/* fxn */


public function edit($params=NULL){
	if(!isset($params)){ pr("Parameter pkid required."); exit; }
	$data['book_id']=$pkid=$params[0];
	$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		
		// 1
		$db->update("{$dbg}.05_books",$post,"id=$pkid");
		// 2
		$lvl=$_POST['level_id'];
		// echo ($lvl)? "added level $lvl ":"no added level";
		if($lvl){
			$q="INSERT INTO {$dbg}.05_level_books(level_id,book_id)VALUES($lvl,$pkid);";
			$db->query($q);
		}
		
		flashRedirect("booklists/edit/$pkid","Saved");
		
	}	/* post */
	
	// 1 - books
	$q="SELECT *,id AS pkid FROM {$dbg}.05_books WHERE id=$pkid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	// 2 - level_books
	$q="
		SELECT lb.id AS pkid,lb.id AS level_book_id,l.name AS level,lb.num
		FROM {$dbg}.05_level_books AS lb
		LEFT JOIN {$dbo}.05_levels AS l ON l.id=lb.level_id
		WHERE lb.book_id=$pkid;		
	";
	$sth=$db->querysoc($q);
	$data['levelBooks']=$sth->fetchAll();
	
	// 3
	$data['subjects']=$_SESSION['subjects'];	
	$data['levels']=$_SESSION['levels'];	
	$this->view->render($data,"booklists/editBook");
	
	
}	/* fxn */

public function levels($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$data['levels']=$_SESSION['levels'];
	$vfile="booklists/levelsBooklists";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function manager($params=NULL){
	$data['buk']=$buk=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=DBYR;
	$db=&$this->baseModel->db;
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['count']=0;



	$q="SELECT lb.*,b.name AS book,b.*,s.name AS subject,l.name AS level,
			b.id AS book_id,lb.id AS level_book_id
		FROM {$dbg}.05_books AS b
		LEFT JOIN {$dbg}.05_level_books AS lb ON b.id=lb.book_id
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		LEFT JOIN {$dbo}.05_levels AS l ON l.id=lb.level_id ";
	
	if($buk){
		$q.="WHERE b.id=$buk; ";
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();		
	}

	if(isset($_GET['book'])){
		$part=$_GET['book'];
		$q.=" WHERE b.code LIKE '%{$part}%' OR b.name LIKE '%{$part}%'; ";
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();		
	}
	
	if(isset($_POST['submit'])){
		$book=$_POST['book'];
		if(strlen($book)<6){ flashRedirect('booklists/manager','Book name should be more than 6 characters.'); }

		$q="INSERT INTO {$dbg}.05_books(`name`)VALUES('$book');";
		// pr($q);		
		$db->query($q);
		flashRedirect("booklists/manager?book=$book","Please edit the details of the book $book you just added.");
	
		
	}	/* post */
	

	$this->view->render($data,'booklists/managerBooklists');
	
	
}	/* fxn */


public function deleteLevelBook($params){
	$data['level_book_id'] = $level_book_id = isset($params[0])? $params[0]:false;
	if(!$level_book_id){ prx('Parameter level book id required.'); }
	
	$db=&$this->baseModel->db;
	$dbo=PDBO;$dbg=PDBG;
	
	$q="SELECT b.name AS book,l.name AS level,b.id AS book_id
		FROM {$dbg}.05_level_books AS lb 
		LEFT JOIN {$dbg}.05_books AS b ON b.id=lb.book_id
		LEFT JOIN {$dbo}.05_levels AS l ON l.id=lb.level_id
		WHERE lb.id=$level_book_id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	extract($row);
		
	$q="DELETE FROM {$dbg}.05_level_books WHERE id=$level_book_id LIMIT 1;";
	$sth=$db->query($q);
	$msg = ($sth)? "Success: $level - $book deleted":"Fail: $level - $book deleted";
	
	flashRedirect("booklists/edit/$book_id",$msg);
	
	
	
}	/* fxn */



public function editLevelBook($params){
	$data['level_book_id'] = $level_book_id = isset($params[0])? $params[0]:false;
	if(!$level_book_id){ prx('Parameter level book id required.'); }
	
	$db=&$this->baseModel->db;
	$dbo=PDBO;$dbg=PDBG;

	// 1
	$q="SELECT b.name AS book,l.name AS level,lb.*,lb.id AS level_book_id,b.id AS book_id
		FROM {$dbg}.05_level_books AS lb 
		LEFT JOIN {$dbg}.05_books AS b ON b.id=lb.book_id
		LEFT JOIN {$dbo}.05_levels AS l ON l.id=lb.level_id
		WHERE lb.id=$level_book_id LIMIT 1;		
	";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
	extract($row);

	// 2
	if(isset($_POST['submit'])){
		$num=$_POST['num'];
		$q="UPDATE {$dbg}.05_level_books SET num=$num WHERE id=$level_book_id LIMIT 1; ";
		$sth=$db->query($q);
		flashRedirect("booklists/edit/$book_id","Level Book edited.");
		
	}


	$this->view->render($data,"booklists/editLevelBook");
	
	
}	/* fxn */



/* enstep-3: booklist */
public function view($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['num']=$num=isset($_GET['num'])? $_GET['num']:1;	
	$data['srid']=$srid=$_SESSION['srid'];
	$data['db']=&$db;
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['controls']=null;


	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 
	
		/* schedule */ 	
		$data['sched']=$sched=getScheduleByModule($db,$sy,$scid,'booklist');
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		
		
	}	/* studacct */

	
	$data['level']=fetchRow($db,"{$dbo}.05_levels","$lvl");
	$q="SELECT cr.name AS crname,l.name AS lvlname 
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.05_levels AS l ON l.id=cr.level_id 
		WHERE cr.level_id=$lvl AND cr.num=$num LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['classroom']=$sth->fetch();
	// prx($data['level']);
	
	$semcond='';
	if($lvl>13){
		$sem=($qtr<2)? 1:2;
		$semcond=" AND (b.semester=0 OR b.semester=$sem) ";
	}

		
	$q="SELECT lb.*,lb.id AS pkid,b.name AS book,b.*,s.name AS subjname
		FROM {$dbg}.05_level_books AS lb 
		INNER JOIN {$dbg}.05_books AS b ON lb.book_id=b.id
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		WHERE lb.level_id=$lvl AND lb.num=$num $semcond ORDER BY b.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	

	$sch=VCFOLDER;$one="booklistView_{$sch}";$two="students/booklistStudentCss";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	
	$this->view->render($data,$vfile,'blank');

	
}	/* fxn */



}	/* BlankController */
