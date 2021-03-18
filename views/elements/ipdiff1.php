

<?php 
	// $file = SITE."views/customs/".VCFOLDER."/customs.php";
	// include_once($file);
	// $library_setup
	if(isset($library_setup) && ($library_setup==1)):
	// if($dif)
	
?>


	<h5>
		IP Changed.
	</h5>

	<p>
		1. Get the new ip. cmd > ipconfig<br />
		2. Ask MIS to update <a href="<?php echo URL.'subdepts'; ?>" >Subdepts</a> IP. <br />
		3. Library <a href="<?php echo URL.'librarians/reset'; ?>" >Reset</a>.
	</p>

<?php exit; ?>
<?php endif; ?>	