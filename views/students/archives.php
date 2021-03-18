<?php

// TC
public function xeditTxn($id){
	$id = array_shift($id);
	$this->Txn->xeditTxn($id); 	
}

// TM
public function xeditTxn($id){
	$data = $_POST;
	return $this->db->update('txns',$data," id = $id ");	
}



