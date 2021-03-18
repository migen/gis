<h5 class="screen" >
	Stocks Movements Summary
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'logistics/index'; ?>">Filter</a>	
	| <a href="<?php echo URL.'logistics/move'; ?>">Move / Request Stocks</a>
	<?php if(isset($_GET['submit'])): ?>		
		<?php $_GET['sort']='smv.date';$_GET['order']='DESC';	?>	
		| <a href="<?php echo URL.'logistics/index'.sages($_GET); ?>" >Itemized</a>			
	<?php endif; ?>
	
	
</h5>


<?php if(isset($_GET['submit'])): ?>
	<div class="center clear" >
	<?php $page="Logistics Summary Stocks Movement ($count)"; ?>
	<?php $page.="<br />".date('M d, Y',strtotime($_GET['start']))." -- ".date('M d, Y',strtotime($_GET['end'])); ?>
	<?php $page.="<br />Terminal #".$_GET['src']." -- Terminal #".$_GET['dest']; ?>
	<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
	</div>
<?php endif; ?>


<?php 

	if(isset($_GET['debug'])){ pr($q); }

	
	include_once('incs/smvsummary_filter.php');
	
	if(isset($_GET['submit'])){
		include_once('incs/smv_summary.php');
	}
	
?>



