<style>


.button{
	font: 1em Arial; font-family: Arial,Helmet,Freesans,sans-serif; text-decoration: none;background-color: #EEEEEE;color: #333333;padding: 2px 6px 2px 6px;border-top: 1px solid #CCCCCC;
	border-right: 1px solid #333333;border-bottom: 1px solid #333333;border-left: 1px solid #CCCCCC;
}


</style>



<?php 

$tfsize = "tf14";
$itemwidth = "vc200";

// pr($data);



?>



<h5 class="screen" >
	GIS - Print POS
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
	<span class="" > | <a href="<?php echo URL.'npos/modify/'.$pos_id.DS.$sy; ?>" >Modify</a></span>
	<span class="" > | <a href='<?php echo URL."posrx/id/$pos_id/$sy"; ?>' >Returns</a></span>	

	
	<?php if($has_rx): ?>
		<span class="" > | <a href='<?php echo URL."npos/view/".$pos['rxid']."/$sy"; ?>' >Returned</a></span>			
	<?php elseif($has_rxref): ?>
		<span class="" > | <a href='<?php echo URL."npos/view/".$pos['rxref_posid']."/$sy"; ?>' >Orig OR</a></span>
	<?php else: ?>
		<span class="" > | <a href='<?php echo URL."posrx/id/$pos_id/$sy"; ?>' >Returns</a></span>	
	<?php endif; ?>

<?php if($_SESSION['user']['privilege_id']==0): ?>
	<span class="" > | <a href="<?php echo URL.'pos/edit/'.$pos['id']; ?>" >Edit</a></span>
<?php endif; ?>	
		
	
</h5>

<table class="screen nogis-table-bordered" >
<tr><td class="brown b" >
	Modify - Delete row by cashier. 
	<br /> Returns - Refund to customer. 
</td>
<td class="vc50" ></td>
<td>
<a style="font-size:1.6em;" class="screen button u txt-blue" onclick="window.print();" >Print</a>

</td>

</tr>
</table>


<!------ tracelogin ---------------->
<p><?php // $this->shovel('hdpdiv'); ?></p>

<?php // include_once('incs/find_orno.php'); ?>


<?php 

$incs = "incs/printpos_body.php";
include_once($incs);

?>



<?php $hdpass = isset($hdpass)? $hdpass:HDPASS;  ?>
<?php  DEFINE('SECRET',$hdpass); ?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>

<script>
	var gurl = "http://<?php echo GURL; ?>";
	var hdpass 	= '<?php echo SECRET; ?>';
		
	$(function(){
		hd();
		$('#hdpdiv').hide();
	})
	
	


</script>
