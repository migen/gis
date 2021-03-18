<h3>
	
	

</h3>


<?php 
$incs="filter_sectioning.php";include_once($incs);

if(isset($_GET['submit'])){
	// pr($data);
	// echo "shovel-tableset";
	$d['num_columns']=&$num_columns;
	$d['columns']=$columns;
	$d['rows']=&$rows;
	$d['count']=&$count;
	$this->shovel('tableset',$d);
	
}	/* fxn */


?>

