<?php 

	// echo $data['sy']; 
	$crid 	= $data['crid'];
	$sy 	= $data['sy'];
	$qtr 	= $data['qtr'];
	$sem	= $data['sem'];
	$admin	= $data['admin'];

?>

	<a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>'>Matrix</a>
	| <a href='<?php echo URL."submissions/view/$crid/$sy/$qtr"; ?>'>Submissions</a>
	| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$qtr"; ?>'>Summarizer</a>
	| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr"; ?>'>MCR</a>
	| <a href='<?php echo URL."reports/rcr/$crid/$sy/$qtr"; ?>'>RCR</a>
<?php if($admin): ?>	
	| <a href='<?php echo URL."reports/ecr/$crid/$sy/$qtr"; ?>'>ECR</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr/$sem"; ?>'>Cards</a>
<?php endif; ?>