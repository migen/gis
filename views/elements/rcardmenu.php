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
