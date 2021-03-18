<h5 class="screen" >
	Patrons Summary
	| <a href="<?php echo URL.'librarians'; ?>">Librarians</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."librarians/stats"; ?>'>Filter</a>		
	| <a href='<?php echo URL."patrons/student"; ?>'>Student</a>		
	| <a class="u" id="btnExport" >Excel</a> 


</h5>


<?php
 
if(isset($_GET['debug'])) { pr($q); }
 
unset($data['classrooms']); 
unset($data['levels	']); 
// pr($data); 
 
if(isset($_GET['submit'])){
	$incs="incs/stats_table.php";
	include_once($incs);
} else {
	$incs="incs/stats_filter.php";
	include_once($incs);

}

