<?php 

// pr($_SESSION['q']);
// pr($data);

?>

<h5>
	<span class="hd" >Promotions SF Non-K12 | </span>	
	<span class="hd" >HD</span>
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>' >Profiling</a>
	| <a href='<?php echo URL."promotions/k12/$crid/$sy/$qtr"; ?>' >K12</a>
	
</h5>


<p><?php $this->shovel('hdpdiv'); ?></p>


<?php if(empty($prep)): ?>
	<a href="<?php echo URL.'promotions/addPrep/'.$crid.DS.$sy; ?>" > Add Promotions Record </a>
<?php exit; ?>
<?php endif; ?>

<!----------------------------------------------------------------------------------------------------------------------->


<?php if($is_locked): ?>
	<p><button>REPORT</button></p>
<?php endif; ?>

<!----------------------------------------------------------------------------------------------------------------------->




<?php 

/* =========== DEFINE VARS =========== */

$d['sy']	= $data['sy']	= $sy;
$d['nsy']	= $data['nsy']	= $nsy;
$d['crid']	= $data['crid']	= $crid;


$cr 				= $data['classroom'];
$d['is_locked']		= $is_locked;
$d['cr']			= $cr;


/* =========== for shovel vars =========== */
$d['prep']			= $data['prep'];		/* for preport */ 
$d['num_girls'] 	= $num_girls;
$d['num_boys'] 		= $num_boys;

/* data for prom */
$d['is_locked']		= $is_locked;
$data['classrooms']  	  = $selectsClassrooms;
$data['prep_locked'] 	  = $d['prep_locked'] 		= $prep['is_finalized'];
$data['ratings'] 	  	  = $d['ratings'] 			= $ratings;



/* =========== FUNCTIONS =========== */
function dated($date,$format='M-d-Y'){
	if(isset($date) && ($date != '0000-00-00')){
		return date($format,strtotime($date));
	} else {
		return null;
	}
}


?>

<!-- ========================  filter hd =================================-->


<!-- ----------------------------  page info / user info ---------------------------- -->
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr class="hd" ><th class='white headrow'>Status</th><td>
		<?php if($is_locked): ?>
			<a href="<?php echo URL.'promotions/unlockPromotion/'.$cr['crid']; ?>" >Unlock </a>
		<?php else: ?>				
			<a href="<?php echo URL.'promotions/lockPromotion/'.$cr['crid']; ?>" >Lock </a>
		<?php endif; ?>				
	</td></tr>	
	<tr><th class="white headrow" >Class Section</th><td><?php echo $classroom['classroom']; ?></td></tr>
	<tr><th class="white headrow" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo ($is_locked)? 'Closed': 'Open'; ?></td></tr>
</table>

<br />


<!-- ----------------------------  data / process ---------------------------- -->



<form method="POST" >
<!-- for redirect controller -->
<input type="hidden" name="ctlr" value="<?php echo $home; ?>"  />

<?php  

if(!$is_locked){
	$this->shovel('promOld',$data);  
}
$this->shovel('prepOld',$d);	


?>




<!-- ====== HIDDEN INPUTS   ======= -->


<?php if((($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG)) && ($is_locked)): ?>
		<br /><input type="submit" name="update" value="Update On" />	
		<input onclick="return confirm('FINAL WARNING! Are you 100% sure?');" type="submit" name="finalize" value="Finalize On" />			
<?php endif; ?>



<?php if(!$is_locked): ?>
	<?php if($is_prom): ?>
	<?php if($_SESSION['qtr']!=4){ echo "<p class='hd' >"; } ?>	
		<br /><input type="submit" name="update" value="Update Old" />
		<input type="submit" onclick="return confirm('Are you 100% sure?');" name="finalize" value="Finalize" />
	<?php if($_SESSION['qtr']!=4){ echo "</p>"; } ?>	
	<?php else: ?>
		<br /><input type="submit" name="prep" value="Report" />
	<?php endif; ?>

<?php endif; ?>



</form>

<div class="ht100" ></div>


<!---------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	nextViaEnter();
})


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotionsOld.js"></script>
