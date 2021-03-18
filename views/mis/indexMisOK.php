	
<?php 

	pr($_SESSION['q']);
	$user = $_SESSION['user'];

	
?>



<h5>
	MIS Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'dashboard/mis/'.$sy; ?>" >Dashboard</a>
	| <a href="<?php echo URL.'locking/controls/'.$sy; ?>" >Locking</a>
	| <a href="<?php echo URL.'dashboard/syncs/'.$sy; ?>" >Syncs</a>
	| <a href="<?php echo URL.'contacts/ucis'; ?>" >UCIS</a>
	| <a href="<?php echo URL.'settings/all'; ?>" >Settings</a>
	| <a href="<?php echo URL.'cir'; ?>" >CIR</a>
	| <a href="<?php echo URL.'gset'; ?>" >GSET</a>
	| <a class="txt-blue u" onclick="expandAccordions();return false;" >Expand</a>
	| <a class="txt-blue u" onclick="collapseAccordions();return false;" >Collapse</a>
	
</h5>


<div class="third" >	<!-- col01 -->
<?php 
	$incs = SITE."views/elements/accor_misfaves.php";include_once($incs);echo "<br />"; 
	if($_SESSION['settings']['has_library']==1){ $incs = SITE."views/elements/accor_library.php";include_once($incs);echo "<br />"; }
	$incs = SITE."views/elements/accor_gisreports.php";include_once($incs);echo "<br />"; 		
	$incs = SITE."views/elements/accor_attd.php";include_once($incs);echo "<br />"; 		
	$incs = SITE."views/elements/accor_syncs.php";include_once($incs);echo "<br />"; 
	
?>


</div> 	<!-- col01 -->

<div class="third" >	<!-- col02 -->
<?php 
	$incs=SITE."views/elements/accor_enrollment.php";include_once($incs);echo "<br />";	
	$incs=SITE."views/elements/accor_contacts.php";include_once($incs);echo "<br />";	
	$incs=SITE."views/elements/accor_stats.php";include_once($incs);echo "<br />"; 
	$incs=SITE."views/elements/accor_misc.php";include_once($incs);echo "<br />"; 
	$incs=SITE."views/elements/accor_purger.php";include_once($incs);echo "<br />"; 
	
?>
</div>	<!-- col02 -->

<?php if($_SESSION['settings']['has_axis']==1): ?>
<div class="third" >	<!-- col03 -->
	<?php $incs=SITE."views/elements/accor_axis.php";include_once($incs);echo "<br />"; ?>
	<?php $incs=SITE."views/elements/accor_invis.php";include_once($incs);echo "<br />"; ?>
	<?php $incs=SITE."views/elements/accor_enrol.php";include_once($incs);echo "<br />"; ?>		

</div>	<!-- col03 -->
<?php endif; ?>	<!-- has_axis -->

<div class="third" >	<!-- col04 -->
	<?php if($_SESSION['settings']['has_hris']==1){ $incs = SITE."views/elements/accor_hris.php";include_once($incs); } ?>
	<?php $incs=SITE."views/elements/accor_syncboard.php";include_once($incs); ?><br />
	<?php $incs=SITE."views/elements/accor_gset.php";include_once($incs); ?><br />
	<?php $incs=SITE."views/elements/accor_grades.php";include_once($incs); ?><br />
</div>	<!-- col04 -->


<div style="float:left;width:20%" class="hd" id="names" > </div>


</div>	<!-- body -->




<p class="clear ht100" ></p>




<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';
var sy  = '<?php echo $sy; ?>';
var qtr = '<?php echo $qtr; ?>';
var ds  = '<?php echo "/"; ?>';
			
$(function(){
	hd();
	// $('#axis').hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})
	
		
function syqtr(){
		sy  = $('#sy').val();
		qtr = $('#qtr').val();		
	}	
		

function setTssy(tssy){
	var rurl 	= gurl + '/mis/index/'+tssy;		/* redirect url */	
	window.location = rurl;		
}
		



function accorHd(){ $(".accordParent table:not(:first)").hide(); }
function expandAccordions(){ $(".accordParent table").show(); }
function collapseAccordions(){ $(".accordParent table").hide(); }
		
		
</script>

