<?php

	require_once(SITE."functions/dbTools.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
	$except="'id','contact_id'";
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except);
	$data['cols']=$cols=$dr['field_array'];
	$data['field_str']=$field_str=$dr['field_string'];
	$data['axn']=$axn=$this->axn();$vfile="menu/{$axn}Menu";
	$this->view->render($data,$vfile);


