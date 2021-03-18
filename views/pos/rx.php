<?php 
$tfsize = "tf14";
$itemwidth = "vc200";



?>


<h5 class="screen" >
	<span class="u" onclick="traceshd();" >RX</span> <?php echo ($pos['is_return'])? 'Returned':NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	<span class="" > | <a href="<?php echo URL.'npos/view/'.$pos['id']; ?>" >View</a></span>
	| <span class="u" onclick="ilabas('more');" >More</span>
	
	

<?php if($_SESSION['user']['privilege_id']==0): ?>
	<span class="" > | <a href="<?php echo URL.'pos/edit/'.$pos['id']; ?>" >Edit</a></span>
<?php endif; ?>			
	| <span class="u" onclick="returnAll();" >Return all</span>	
</h5>



<!------ tracelogin ---------------->
<p><?php $this->shovel('hdpdiv'); ?></p>

<?php include_once('incs/find_orno.php'); ?>



<div id="printable" >	<!-- printable -->
<h4><?php echo $_SESSION['settings']['school_name']; ?></h4>


<?php 

$incs = SITE."views/customs/".VCFOLDER."/pos/rx_body.php";
include_once($incs);

?>


</div>	<!-- printable -->

<?php $hdpass = isset($hdpass)? $hdpass:HDPASS;  ?>
<?php  DEFINE('SECRET',$hdpass); ?>


<script>
	var gurl = "http://<?php echo GURL; ?>";
	var hdpass 	= '<?php echo SECRET; ?>';
		
	$(function(){
		hd();
		itago('more');
		$('#hdpdiv').hide();
	})
	
	


</script>
