<?php 

// pr($rows[0]);

?>

<h5>
	Components 
	(<?php echo isset($count)? $count:0; ?>)

	| <a href="<?php echo URL.'mis'; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'components/setup'; ?>">BATCH</a> 	
	| <a href="<?php echo URL.'mis/levels'; ?>">Levels</a> 	
	| <a href='<?php echo URL; ?>mis/addComponents'>Academic</a>
	| <a href='<?php echo URL; ?>mis/addMiscComponents'>Non-Acad </a>
	
</h5>

<p>
<?php 
	$incs = SITE.'views/components/incs/filter_components.php';
	include_once($incs);
	
?>
</p>

<?php 

if(isset($_GET['filter'])){
	$incs = SITE.'views/components/incs/table_components.php';	
	include_once($incs);

}

?>