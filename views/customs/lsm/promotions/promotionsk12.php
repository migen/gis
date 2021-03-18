<?php 


// pr($data);
// pr($boys[0]);
// pr($yis);
// pr($ntc);	pr($ctc);
// echo "currlvl: $currlvl <br />";
// echo "promlvl: $promlvl <br />";
// echo "currcrid: $currcrid <br />";


// pr($prep);


/* deped_ratings */
$ratings = array(
	array('rating'=>'A','grade'=>'90'),
	array('rating'=>'P','grade'=>'85'),
	array('rating'=>'AP','grade'=>'80'),
	array('rating'=>'D','grade'=>'75'),
	array('rating'=>'B','grade'=>'0'),
);




?>

<h5>
	<span class="" >Promotions (<?php echo ($num_boys+$num_girls); ?>) | </span>
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>' >Profiling</a>
	| <a href='<?php echo URL."promotions/sfold/$crid/$sy/$qtr"; ?>' >Old</a>
	&nbsp;&nbsp; 
SY <select onchange="redirSy();" id="sy" >
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>
	<option value="<?php echo (DBYR+1); ?>" <?php echo ($sy==(DBYR+1))? 'selected':NULL; ?> ><?php echo (DBYR+1); ?></option>
</select>	

	
</h5>

<?php if(!$is_locked): ?>
	<h4 class="red" >*Please double check all entries before pressing FINALIZE.</h4>
<?php endif; ?>


<?php if(empty($prep)): ?>
	<a href="<?php echo URL.'promotions/addPrep/'.$classroom['crid'].DS.$_SESSION['sy']; ?>" > Add Promotions Record </a>
<?php exit; ?>
<?php endif; ?>



<p><?php $this->shovel('hdpdiv'); ?></p>




<?php 



$cr 				= $data['classroom'];
$d['is_locked']		= $is_locked;
$d['cr']			= $cr;

/* d for prep */
$d['prep']			= $data['prep'];		 
$d['num_girls'] 	= $num_girls;
$d['num_boys'] 		= $num_boys;

$d['is_locked']		= $is_locked;


/* data for prom */
$data['classrooms']  	  = $classrooms;
$data['ssy'] 	  	  	  = $d['ssy'] 				= $sy;
$data['nsy'] 		  	  = $d['nsy'] 				= $nsy;
$data['prep_locked'] 	  = $d['prep_locked'] 		= $prep['is_finalized'];
$data['ratings']		  = $d['ratings']			= $ratings;

function dated($date,$format='M-d-Y'){
	if(isset($date) && ($date != '0000-00-00')){
		return date($format,strtotime($date));
	} else {
		return null;
	}
}


?>



<!-- ----------------------------  page info / user info ---------------------------- -->
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CRID</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr class="hd" ><th class='white headrow'>Status</th><td>
		<?php if($is_locked): ?>
			<a href="<?php echo URL.'promotions/unlockPromotion/'.$cr['crid']; ?>" >Unlock </a>
		<?php else: ?>				
			<a href="<?php echo URL.'promotions/lockPromotion/'.$cr['crid']; ?>" >Lock </a>
		<?php endif; ?>				
	</td></tr>
	<tr><th class="white headrow" >Class Section</th><td><?php echo $classroom['classroom']; ?></td></tr>
	<tr><th class="white headrow" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Promotions Status</th><td><?php echo ($is_locked)? 'Closed': 'Open'; ?></td></tr>
</table>

<br />


<!-- ----------------------------  data / process ---------------------------- -->

<form method="POST" >
<!-- for redirect controller -->

<?php  

$incs="incs/prom.php";require_once($incs);
$incs="incs/prep.php";require_once($incs);
 

?>


<!-- ====== HIDDEN INPUTS   ======= -->

<?php if((($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG)) && ($is_locked)): ?>
		<br /><input type="submit" name="update" value="Update On" />	
		<input onclick="return confirm('FINAL WARNING! Are you 100% sure?');" type="submit" name="finalize" value="Finalize On" />	
<?php endif; ?>

<?php if(!$is_locked): ?>
	<?php if($_SESSION['qtr']!=4){ echo "<p class='hd' >"; } ?>
			<br /><input type="submit" name="update" value="Update" />	
			<input onclick="return confirm('FINAL WARNING! Are you 100% sure?');" type="submit" name="finalize" value="Finalize" />				
	<?php if($_SESSION['qtr']!=4){ echo "</p>"; } ?>
<?php endif; ?>



</form>

<div class="ht100" ></div>

<!---------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var crid = "<?php echo $crid; ?>";
var hdpass = "<?php echo HDPASS; ?>";

$(function(){
	hd();
	$('#hdpdiv').hide();
	nextViaEnter();
})


function redirSy(){
	var sy=$('#sy').val();
	var url=gurl+'/promotions/k12/'+crid+'/'+sy;
	window.location=url;	
}	/* fxn */


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
