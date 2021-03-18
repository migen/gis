<?php if($srid!=RSTUD): ?>

<?php 


	
?>


<h5 class="screen" >
	REPORT CARD

	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid; ?>">Matrix</a>	
	
<?php if($rcpage==1): ?>	<!-- sircard -->
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr"; ?>' >Std</a>

<?php elseif($rcpage==2): ?>	<!-- rcard -->
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr"; ?>' >Std</a>	

<?php elseif($rcpage==3): ?>	<!-- sirscard -->
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr"; ?>' >Std</a>
		
<?php elseif($rcpage==4): ?>	<!-- srcard -->
	| <a target='blank' href='<?php echo URL."srcards/crid/$crid/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/crid/$crid/$sy/$qtr"; ?>' >Std</a>
<?php endif; ?>	


<?php if($_SESSION['srid']==RMIS): ?>			

	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SRCls</a>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr"; ?>'>Rcard</a>
<?php endif; ?>	
</h5>


<?php endif; ?>