
<?php 

// pr($_SESSION['q']);
	
?>

<h5> 
	Academics
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cir'; ?>" >CIR</a>
	| <a href="<?php echo URL.'lir'; ?>" >LIR</a>	
</h5>



<!-- ========================= table =========================  -->

<div style="float:right;width:30%;"  >
	<?php 
		// $incs = SITE.'views/acad/includes/reminder_acad.php';include_once($incs);		
	?>
</div>

<?php 
	$incs = SITE."views/elements/accor_acad.php";
	include_once($incs); 

?>



<div class="ht100" ></div>

<!----------------------------------------------------------------------------------->





<script>

	var gurl  = 'http://<?php echo GURL; ?>';	
	var home  = "academics";
	var sy    = "<?php echo $sy; ?>";
	var qtr   = "<?php echo $qtr; ?>";
	
	$(function(){
		hd();
	
	})
	
	function accorToggle(sxn){ $("#"+sxn).toggle(); }
	

	
</script>

 
