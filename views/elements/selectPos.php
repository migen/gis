<?php 

function sp1($data){		/* selectProdcategories */
	$rows = $data['selects']['prodsubtypes'];
	foreach($rows as $row){
		echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
	}	
}


function sprods($data){		/* selectProdcategories */
	$rows = $data['selects']['products'];
	foreach($rows as $row){
		echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
	}	
}



?>
