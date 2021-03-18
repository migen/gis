<?php 



?>

<h5>
	Promotions Non-K12 | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."$home/promotions/$crid/$sy/$qtr"; ?>' >New</a>
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<!----------------------------------------------------------------------------------------------------------------------->


<?php if($is_locked): ?>

<p>
<?php 		
	
	$lvl = $classroom['level_id'];
	
	switch($lvl){
		case $lvl >=1 && $lvl <=6:	
	$url = REPORT."prom123.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";		
	$furl = REPORT."fprom123.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";			

			break;
		case $lvl >=7 && $lvl <=9:
	$url = REPORT."prom456.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";		

	$furl = REPORT."fprom456.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";		
	
			break;	
		case $lvl >=10 && $lvl <=13:
	$url = REPORT."promhs.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";		

	$furl = REPORT."fpromhs.rptdesign&level=".$classroom['level_id']."&sxn=".$classroom['section_id']."&sy=".$sy."&dbm={$dbg}&dbg={$dbg}&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false";		
	
			break;				
		default:
			$url = ""; 
			break;							
			
	}
	
		
?>		
	<button><a class="black no-underline" target="_blank" href="<?php echo $furl; ?>"> Front of Report </a> </button>	
	<button><a class="black no-underline" target="_blank" href="<?php echo $url; ?>"> Back of Report </a> </button>	

</p>


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
			<a href="<?php echo URL.'promotions/unlockPromotion/'.$cr['crid'].DS.$sy.'/promotions0'; ?>" > Unlock </a>
		<?php endif; ?>				
	</td></tr>	
	<tr><th class="white headrow" >Class Section</th><td><?php echo $classroom['classroom']; ?></td></tr>
	<tr><th class="white headrow" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo ($is_locked)? 'Closed': 'Open'; ?></td></tr>
	<tr><th class='white headrow'>SY</th><td><?php echo $sy .' - ' .$nsy; ?></td></tr>
</table>

<br />


<!-- ----------------------------  data / process ---------------------------- -->

<form method="POST" >
<!-- for redirect controller -->
<input type="hidden" name="ctlr" value="<?php echo $home; ?>"  />

<?php  

if(!$is_locked){
	$this->shovel('prom0',$data);  
}
$this->shovel('prep0',$d);	


?>


<!-- ====== HIDDEN INPUTS   ======= -->

<?php if(!$is_locked): ?>
	<?php if($is_prom): ?>
		<br /><input type="submit" name="update" value="Update" />
		<input type="submit" onclick="return confirm('Are you 100% sure?');" name="finalize" value="Finalize" />
	
	<?php else: ?>
		<br /><input type="submit" name="prep" value="Report" />
	<?php endif; ?>

<?php endif; ?>



</form>

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

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions0.js"></script>
