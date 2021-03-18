<?php 


?>


<h5>
	Contacts Manager <?php echo (isset($count))? '('.$count.')':NULL; ?>
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."mgt/contacts"; ?>' >Filter</a> 
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	

</h5>


<?php 

if(!isset($_POST['filter'])){
	$incs = SITE.'views/mis/includes/contacts_filter.php';
	include_once($incs);

} else {
	$incs = SITE.'views/mis/includes/contacts_table.php';
	include_once($incs);


}


