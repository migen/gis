<h5 class="screen" >
	Patrons Report
	| <a href="<?php echo URL.'librarians'; ?>">Librarians</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."librarians/patrons"; ?>'>Filter</a>		
	| <a href='<?php echo URL."patrons/student"; ?>'>Student</a>		
	| <a class="u" id="btnExport" >Excel</a> 


</h5>


<?php
 
if(isset($_GET['debug'])) { pr($q); }
 
if(isset($_GET['submit'])){
	$incs="incs/patrons_table.php";
	include_once($incs);
} else {
	$incs="incs/patrons_filter.php";
	include_once($incs);

}

?>

