<?php 
	

$tplval=1;
if($num_students==1){
	$rcpage=1;
} else {
	$rcpage=3;
}	
	
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
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid; ?>">Matrix</a>

<?php if($rcpage==1): ?>	<!-- sircard -->
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
<?php elseif($rcpage==3): ?>	<!-- sirscard -->
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
<?php endif; ?>	

<?php if($classroom['level_id']<4): ?>			
	<?php if($rcpage==1): ?>			
	| <a target='blank' href='<?php echo URL."grcfp/sifprcard/".$scid."/$sy/$qtr?tpl=1"; ?>' >Front</a>	
	<?php else: ?>
	| <a target='blank' href='<?php echo URL."rcards/fpage/".$crid."/$sy/$qtr?tpl=1"; ?>' >Front</a>	
	<?php endif; ?>
<?php endif; ?>


<?php if($_SESSION['srid']==RMIS): ?>			
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr?tpl=1"; ?>'>Rcard</a>
<?php endif; ?>	
	
</h5>
