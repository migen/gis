<style>
#resack{ border:1px solid white; }
</style>

<h5 class="screen" >
Reservation Acknowledgement	
| <a href="<?php echo URL; ?>" />Home</a>  
<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a> ' : ''; ?>
| <a href='<?php echo URL."profiles/student/$scid/$sy"; ?>' >Profile</a>		
| <a href="<?php echo URL.'assessment/assess/'.$scid.DS.$sy; ?>" />Assessment</a>  
| SY <select onchange="redirSy();" id="sy" >
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>
	<option value="<?php echo (DBYR+1); ?>" <?php echo ($sy==(DBYR+1))? 'selected':NULL; ?> ><?php echo (DBYR+1); ?></option>
</select>	


&nbsp;&nbsp;
<button> <a class="tf24 txt-black no-underline" onclick="window.print();" >PRINT</a></button>




</h5>

<div class="screen" >
<?php 
$d['page']=isset($page)? $page:NULL;$d['new_customer']=NULL;$d['contacts']=array();
$this->shovel('filter_contacts',$d);
?>
</div>

<div class="screen hd" id="names" >Names</div>

<?php if($scid): ?>

<div id="resack" >
<div class="center" ><?php $this->shovel('letterhead_twologos',$d); ?></div>
<?php $incs="incs/resack_content.php"; include_once($incs); ?>
</div>	<!-- resack -->


<?php endif; ?>	<!-- scid -->





<script>

var gurl = "http://<?php echo GURL; ?>";
var scid = "<?php echo $scid; ?>";
var home = "<?php echo $_SESSION['home']; ?>";


$(function(){
	hd();
	nextViaEnter();
	
	
})	/* fxn */

function redirContact(ucid){
	var url = gurl + '/reservations/acknowledgement/'+ucid;	
	window.location = url;		
}


function redirSy(){
	var sy=$('#sy').val();
	var url=gurl+'/reservations/acknowledgement/'+scid+'/'+sy;
	window.location=url;	
}	/* fxn */


</script>
