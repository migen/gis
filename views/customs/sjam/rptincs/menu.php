<?php 
$show=(isset($_GET['show']))? true:false;

$both=isset($_GET['both'])? $_GET['both']:0;


$get=sages($_GET);
$get=str_replace("deciave=","",$get);

$session_deciave=$_SESSION['settings']['deciave'];
$url_deciInteger=URL."rcards/crid/$crid$get&deciave=0";
$url_deciave=URL."rcards/crid/$crid$get&deciave=$session_deciave";
$url_decigenave=URL."rcards/crid/$crid$get&deciave=$session_deciave&decigenave=$deciave";



?>

<?php if($srid!=RSTUD): ?>


<?php 

// prx($lvl);
	
?>

<h5 class="screen" >
	REPORT CARD (<?php echo $num_students; ?>) 
	<span class="u" ><?php echo ($show)? '': '&Show'; ?></span>
	| <span class="u" ><?php echo ($show)? '': '&genave (PS)'; ?></span>

	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <span class="u" >&blank</span>
	| <a href="<?php echo URL.'classlists/classroom/'.$crid; ?>">Classlist</a>
	| <a href="<?php echo URL.'matrix/grades/'.$crid; ?>">Matrix</a>	
<?php if($deciave==$_SESSION['settings']['deciave']): ?>
	| <a href="<?php echo $url_deciInteger; ?>">Integer</a>	
<?php else: ?>	
	| <a href="<?php echo $url_deciave; ?>">Deciave</a>	
<?php endif; ?>	

<?php if(isset($_GET['deciave'])): ?>
	| <a href="<?php echo $url_decigenave; ?>">Decigenave</a>	
<?php endif; ?>

	
<?php if($rcpage==1): ?>	<!-- sircard -->
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=5"; ?>' >P1</a>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=0"; ?>'>SR</a>	
	<?php if($both==1): ?>	
		| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	<?php else: ?>
		| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=1"; ?>'>2-Sem</a>
	<?php endif; ?>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr"; ?>' >Std</a>

<?php elseif($rcpage==2): ?>	<!-- rcard -->
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr?tpl=5"; ?>' >P1</a>
	| <a target='blank' href='<?php echo URL."frontcards/crid/".$crid."/$sy/$qtr?tpl=5"; ?>' >Front</a>
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr"; ?>' >Std</a>	

<?php elseif($rcpage==3): ?>	<!-- sirscard -->
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=5"; ?>' >NL</a>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/scid/".$scid."/$sy/$qtr"; ?>' >Std</a>
		
<?php elseif($rcpage==4): ?>	<!-- srcard -->
	| <a target='blank' href='<?php echo URL."srcards/crid/$crid/$sy/$qtr?tpl=1"; ?>' >PS</a>
	| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SR</a>
	| <a target='blank' href='<?php echo URL."rcards/crid/$crid/$sy/$qtr"; ?>' >Std</a>	
<?php endif; ?>	


<?php if($_SESSION['srid']==RMIS): ?>			
	<?php if($both==1): ?>
		| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=0"; ?>'>SRCls</a>
	<?php else: ?>	
		| <a href='<?php echo URL."srcards/crid/$crid/$sy/$qtr/$half?both=1"; ?>'>2-Sem-Cls</a>
	<?php endif; ?>
	| <a href='<?php echo URL."rcards/crid/$crid/$sy/$qtr?tpl=2"; ?>'>Rcard</a>
<?php endif; ?>	


<?php 

$url_qstr=$_SERVER['QUERY_STRING'];
// pr($url_qstr);

// pr($sqtr);

?>

<?php if($classroom['level_id']>13): ?>			

	<?php if(strpos($url_qstr,"srcards/scid/")): ?>			
		<?php if($sem==1): ?>			
			| <a href='<?php echo URL."srcards/scid/$scid/$sy/$sqtr/2?show&both=0&deciave=0"; ?>'>Sem-2</a>
		<?php else:  ?>	
			| <a href='<?php echo URL."srcards/scid/$scid/$sy/2/1?show&both=0&deciave=0"; ?>'>Sem-1</a>
		<?php endif; ?>	
	<?php endif; ?>	
<?php endif; ?>	



<?php if($classroom['level_id']==1): ?>			
	| <a href='<?php echo URL."remarks/classroom/$crid"; ?>'>Remarks</a>
<?php endif; ?>	




</h5>

<?php endif; ?>