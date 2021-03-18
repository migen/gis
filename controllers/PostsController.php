<?php

Class PostsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){	
	$data=NULL;$this->view->render($data,'posts/indexPosts');
}	/* fxn */

public function all(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbo=PDBO;
/* 	
	$q="SELECT p.*,c.name AS category FROM {$dbo}.posts AS p 
	LEFT JOIN {$dbo}.categories AS c ON p.category_id=c.id ORDER BY p.created_at DESC; ";
	$sth=$db->querysoc($q);
	$count=$sth->rowCount();		
	$rows=$sth->fetchAll();
	pr($count);	
	pr($rows);
 */	
 
	$q="SELECT p.*,c.name AS category FROM {$dbo}.posts AS p 
	LEFT JOIN {$dbo}.categories AS c ON p.category_id=c.id ORDER BY p.created_at DESC; ";
	$sth=$db->querysoc($q);
	$count=$sth->rowCount();
	$rows=$sth->fetchAll();
	
	$posts=array();
	foreach($rows AS $row){
		extract($row);
		$post['id']=$id;
		$post['title']=$title;
		$post['category']=$category;
		$post['body']=$body;
		$post['created_at']=$created_at;
		$posts[]=$post;
	}
	
	$posts_arr['data']=$posts;
	echo json_encode($posts_arr);
	
	// pr($count);
	// pr($rows); 
	// $data[]
	// $posts_arr['data']=$rows;
	// $je = json_encode($posts_arr);
	// $je = json_encode($rows);
	// pr($je);
	
 
/*  
	$q="SELECT p.*,c.name AS category FROM {$dbo}.posts AS p 
	LEFT JOIN {$dbo}.categories AS c ON p.category_id=c.id ORDER BY p.created_at DESC; ";
	$sth=$db->prepare($q);
	$sth->execute();
	pr($sth);
	$count=$sth->rowCount();
	pr($count);
	
	$rows=$sth->fetchAll();
	pr($rows); 
*/

	// header("Access-Control-Allow-Origin: * "); 
	// header("Content-Type: application/json");
	

}	/* fxn */


public function view($params=NULL){
	$id=isset($params[0])?$params[0]:1;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT p.*,c.name AS category FROM {$dbo}.posts AS p 
	LEFT JOIN {$dbo}.categories AS c ON c.id=p.category_id WHERE p.id=$id LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	extract($row);
	$post['id']=$id;
	$post['title']=$title;
	$post['body']=$body;
	$post['author']=$author;
	$post['category_id']=$category_id;
	$post['category_name']=$category;
	$post['created_at']=$created_at;
	echo json_encode($post);


}	/* fxn */


public function create(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="INSERT INTO {$dbo}.posts
		SET 
			title=:title,
			body=:body,
			author=:author,
			category_id=:category_id; ";
	$sth=$db->prepare($q);
	
	// clean the data
	$title=htmlspecialchars(strip_tags($title));
	$body=htmlspecialchars(strip_tags($body));
	$author=htmlspecialchars(strip_tags($author));
	$category_id=htmlspecialchars(strip_tags($category_id));
	
	$sth->bindParam(':title',$title);
	$sth->bindParam(':body',$body);
	$sth->bindParam(':author',$author);
	$sth->bindParam(':category_id',$category_id);

	if($sth->execute()){
		return true;
	}
	
	printf("Error: %s. \n", $sth->error());
	return false;
	
	
	



}	/* fxn */




}	/* BlankController */
