<?php 
	
	$incs=SITE."views/customs/{$sch}/rptincs/rcard_vars.php";
	require_once($incs);
?>

<h5 class="screen" >
	<?php 
		switch($tplval){
			case 1: echo "Pre School";break;
			case 3: echo "High School";break;
			default: echo "Default";break;
		}
	?> (<?php echo $num_students; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'classlists/classroom/'.$crid.DS.$sy; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid.DS.$sy; ?>">Matrix</a>
<?php 

	$incs=SITE."views/customs/{$sch}/rptincs/tpl_filter.php";
	include_once($incs); 
	
?>


<?php if($classroom['level_id']<4): ?>			
	<?php if($rcpage==1): ?>			
	| <a target='blank' href='<?php echo URL."grcfp/sifprcard/".$scid."/$sy/$qtr?tpl=1"; ?>' >Front</a>	
	<?php else: ?>
	| <a target='blank' href='<?php echo URL."rcards/fpage/".$crid."/$sy/$qtr?tpl=1"; ?>' >Front</a>	
	<?php endif; ?>
<?php endif; ?>


<?php if($_SESSION['srid']==RMIS): ?>			

	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=1"; ?>'>SRCls</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr"; ?>'>Rcard</a>
<?php endif; ?>	

<?php 
	$data['sy']=$sy;$data['repage']="rcards/crid/$crid";
	$incs="sy_selector.php";include_once($incs);
?>	

	
</h5>
