<?php 
$tfsize = "tf14";
$itemwidth = "vc200";

// pr($_SESSION['q']);


?>


<h5 class="screen" >
	Modify Sale
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
	

<?php if($_SESSION['user']['privilege_id']==0): ?>
	<span class="" > | <a href="<?php echo URL.'pos/edit/'.$pos['id']; ?>" >Edit</a></span>
<?php endif; ?>	
		
	
</h5>

<!------ tracelogin ------------------------------------>
<p><?php $this->shovel('hdpdiv'); ?></p>

<?php include_once('incs/find_orno.php'); ?>



<div id="printable" >	<!-- printable -->
<h4><?php echo $_SESSION['settings']['school_name']; ?></h4>


<?php 

$incs = SITE."views/customs/".VCFOLDER."/pos/modify_body.php";
include_once($incs);

?>


</div>	<!-- printable -->

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
	
function xdelposdetail(pdid,pos_id){
	var vurl=gurl+'/ajax/xpos.php';
	var task='xdelposdetail';
	var rurl=gurl+'/npos/view/'+pos_id;
	$.ajax({
		url:vurl,type:'POST',
		data:'task='+task+'&pdid='+pdid,
		success:function(){ window.location=rurl; }
	})

}	/* fxn */


</script>
