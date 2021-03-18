<?php


function sessionizeSupplier($db,$dbg=PDBG){
	$data = array(
		'supplier data 1',
		'supplier data 2',
		'supplier data 3',
	);
	$_SESSION['supplier']	= $data;

}	/* fxn */

