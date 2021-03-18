<h5>
	Registrar Lists (<?php echo (isset($count))? $count:0; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."reglists"; ?>' >Filter</a> 
		

</h5>

<?php 

$q=isset($q)? $q:NULL;
if(isset($_GET['debug'])){ pr($q); }



if(!isset($_GET['filter'])){
	// $incs = SITE.'views/mis/incs/contacts_filter.php';
	$incs = 'incs/filter_students.php';
	include_once($incs);

} else {
	// $incs = SITE.'views/mis/incs/contacts_table.php';
	$incs = 'incs/table_students.php';
	include_once($incs);


}


