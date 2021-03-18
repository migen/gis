
<?php 

// pr($levels);
// pr($_SESSION);


?>




<h5>
	Inventory Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'accounts/levels'; ?>" > Levels </a>	
</h5>

<!-- ========================= table =========================  -->
<?php
	$ssy 	= $_SESSION['sy'];
	$sqtr 	= $_SESSION['qtr'];
?>

<p>
<table class="gis-table-bordered table-fx" >
	<tr>
		<th class="bg-blue2 white" >SY</th><td><input id="sy" class="pdl10 vc80" type="number" value="<?php echo $ssy;  ?>" onchange="syqtr();" /></td>
		<th class="bg-blue2 white" >Qtr</th><td><input id="qtr" class="pdl10 vc50" type="number" value="<?php echo $sqtr;   ?>"  onchange="syqtr();"  /></td>
	</tr>
</table>
</p>






<div class="third" >
<?php $this->shovel('accor_invis'); ?>

</div>

<div class="third" ><?php $incs="incs/invis_sidenote.php";include_once($incs); ?></div>


<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';


$(function(){
	$('.hd').hide();
	nextViaEnter();
	accorHd();
	
	
})

function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }
	

	
</script>