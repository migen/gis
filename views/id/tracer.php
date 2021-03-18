<h5>
	ID Tracer (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'id/tracer'; ?>">Tracer</a>
	| <a href="<?php echo URL.'setaxis/payments'; ?>">Setup Payments</a>
	| <a class="u" id="btnExport" >Excel</a> 	
		
</h5>


<?php 

if(isset($_POST['submit'])){
	include_once('incs/tracer_table.php');
} else {
	include_once('incs/tracer_filter.php');
}

?>





<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	// itago('clipboard');
	excel();

})




</script>



