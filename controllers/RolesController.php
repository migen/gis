<?php

Class RolesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'mis/editRoles/'.$ids;
		redirect($url);		
	}

	$data['roles'] 		= $this->model->fetchRows("".PDBO.".`00_roles`","id,name","id");
	$data['num_roles']	= count($data['roles']);
	
	$this->view->render($data,'roles/index');

}	/* fxn */



public function edit($ids){
$dbo=PDBO;
   	if(is_null($ids)){ redirect('mis'); }		
	if(isset($_POST['submit'])){
		$rows = $_POST['roles'];
		foreach($rows as $row){			
			$rp_id 	 = $row['rp_id'];
			$user_id = $row['user_id'];
			
			$q = "
				UPDATE {$dbo}.`00_contacts` AS c
					INNER JOIN {$dbo}.`00_titles` AS p ON p.id = $rp_id
				SET c.role_id = p.role_id,c.privilege_id = p.privilege_id
				WHERE c.id = $user_id
			";
						
			pr($q); exit;			
			$this->model->db->query($q);
			
		} /* foreach */
		$url = 'mis/roles';
		redirect($url);
	}	/* post-submit */
	
	$numrows = count($ids);
	for($i=0;$i<$numrows;$i++){
		$id = $ids[$i];
		$data['roles'][$i] = $this->model->readRole($id);
	}	
	

	$q = " SELECT id,name FROM {$dbo}.`00_titles` ";
	$sth = $this->model->db->querysoc($q);
	$data['selectsRoles'] = $sth->fetchAll();
	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'roles/edit');		
}	/* fxn */




























}	/* BlankController */
