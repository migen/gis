
<?php 

// pr($_SESSION['q']);
	
?>

<h5> 
	MIS Transitions
	| Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
</h5>





<!-- ========================= table =========================  -->


<div class="third" >
<?php $incs = SITE."views/elements/accor_transitions.php";include_once($incs); ?>
</div>

<div class="third" >
<?php $incs = "incs/readme_transitions.php";include_once($incs); ?>
</div>



<div class="ht100" ></div>

<!----------------------------------------------------------------------------------->





<script>

	var gurl  = 'http://<?php echo GURL; ?>';	
	var home  = "academics";
	var sy    = "<?php echo $sy; ?>";
	var qtr   = "<?php echo $qtr; ?>";
	
	$(function(){
		hd();
		// alert(gurl+home+sy+qtr);
	
	})
	
	function accorToggle(sxn){ $("#"+sxn).toggle(); }
	

	
</script>

 
