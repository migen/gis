<?php 


?>




<h5>
	Accounting Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

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


<?php $this->shovel('accor_axis'); ?>



	


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


	function redirFeeXX(lvl){
		var rurl 	= gurl + '/accounts/fees/'+lvl;		
		window.location = rurl;		
	}
		

	function redirClassXXX(axn,crid){
		var rurl 	= gurl + '/accounts/'+axn+'/'+sy+'/'+crid;		/* redirect url */			
		window.location = rurl;		
	}
	
	function redirAccountsXXX(axn,param){
		var rurl 	= gurl + '/accounts/'+axn+'/'+param+'/'+sy;		/* redirect url */	
		window.location = rurl;		
	}	
		
	function redirStudentXXX(axn,scid){
		var url 		= gurl + '/accounts/'+axn+'/' + scid + '/' + sy;	
		window.location = url;		

	}
	

	
</script>