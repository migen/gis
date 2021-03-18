<h5 class="screen" >
	REPORT CARD
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid; ?>">Matrix</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr?sch=".VCFOLDER; ?>'>School</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr?preschool"; ?>'>Pre-School</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr/$half"; ?>'>Semestral</a>
	
</h5>
