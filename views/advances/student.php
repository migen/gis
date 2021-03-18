
<h5>Advance Payment for SY <?php echo (DBYR+1); ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| Ledger - 
	<a href='<?php echo URL."ledgers/pay/$scid/$sy"; ?>'>Current</a>			
	<?php $nsy=$sy+1; ?>
	| <a href='<?php echo URL."ledgers/pay/$scid/$nsy"; ?>'>Next</a>			

</h5>

<?php 
	$page="advances/student";
	include_once('incs/filter_codename.php');

?>

<div class="clear" ><br /></div>


<?php 
if($scid){ 
	include_once('incs/advance_pay.php'); 
	echo '<br />';
	include_once('incs/advance_table.php'); 
} 

?>

<div class="twenty" id="names" >names</div>

<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	$('#names').hide();
})


</script>

