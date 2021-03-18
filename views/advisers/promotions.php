<?php 


// pr($data);
// pr($boys[0]);
// pr($yis);
// pr($ntc);	pr($ctc);


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
	<span class="hd" >Promotions | </span>
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."$home/promotions0/$crid/$sy/$qtr"; ?>' >Old</a>
	
</h5>

<?php if(!$is_locked): ?>
	<h4 class="red" >Please double check all entries before pressing FINALIZE button,It is FINAL. Cannot make any more changes after. </h4>
<?php endif; ?>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<?php if($is_locked): ?>

<p>
<?php 		
	
	$url = REPORT."SF5.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";
	
?>		
	<button><a class="black no-underline" target="_blank" href="<?php echo $url; ?>"> View Report New </a> </button>	
	
	
</p>


<?php endif; ?>


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
			<a href="<?php echo URL.'promotions/unlockPromotion/'.$cr['crid'].DS.$sy.'/promotions'; ?>" > Unlock </a>
		<?php endif; ?>				
	</td></tr>
	<tr><th class="white headrow" >Class Section</th><td><?php echo $classroom['classroom']; ?></td></tr>
	<tr><th class="white headrow" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Promotions Status</th><td><?php echo ($is_locked)? 'Closed': 'Open'; ?></td></tr>
	<tr><th class='white headrow'>SY</th><td><?php echo $sy .' - ' .$nsy; ?></td></tr>
</table>

<br />


<!-- ----------------------------  data / process ---------------------------- -->

<form method="POST" >
<!-- for redirect controller -->

<?php  

if(!$is_locked){
	$this->shovel('prom',$data); 
}
$this->shovel('prep',$d);			
 

?>


<!-- ====== HIDDEN INPUTS   ======= -->


<?php if(!$is_locked): ?>
		<br /><input type="submit" name="update" value="Update" />	
		<input onclick="return confirm('FINAL WARNING! Are you 100% sure?');" type="submit" name="finalize" value="Finalize" />	
<?php endif; ?>



</form>

hshshshshhshhhhh

<!---------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	nextViaEnter();
})


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
