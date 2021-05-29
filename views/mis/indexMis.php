<style>

div.oneGroup{ float:left; }
th.accorHeadrow{ color:#555; }

/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	
	.accordion{ table-layout:fixed;width:100%; }
	#content{ font-size:1.6em; }
	select{ font-size:1.2em; }
	h3.pagelinks,h5.pagelinks{ font-size:1em; }
	.oneGroup{ float:left;border:1px solid fff;width:50%;  }
	th.accorHeadrow{ color:#222;font-size:2.2em; }
	.accordion td{ font-size:1.6em; }
	.accordion select { font-size:1.6em; }

}


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {

	#content{ font-size:1em; }
	select{ font-size:1.0em; }
	h3.pagelinks,h5.pagelinks{ font-size:1em; }
	.oneGroup{ float:left;width:20%;  }
	
}




</style>

<?php if($_SESSION['ucid']!=1): ?>
<style>

.accordParent table tr td{
	font-size:1.2em;
	
}
	


</style>
<?php endif; ?>	
	
	
	
<?php 

	// pr($_SESSION['q']);
	$user = $_SESSION['user'];

	
?>


<h5 class="pagelinks" >
	MIS <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'links'; ?>" >Links</a>
	| <a href="<?php echo URL.'records/dbtables'; ?>" >Records</a>
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'contacts/ucis'; ?>" >UCIS</a>
	| <a href="<?php echo URL.'settings/all'; ?>" >Settings</a>
	| <a href="<?php echo URL.VCFOLDER; ?>" ><?php echo strtoupper(VCFOLDER); ?></a>
	| <a href="<?php echo URL.'cir'; ?>" >CIR</a>
	| <a href="<?php echo URL.'sessions'; ?>" >Sessions</a>
	| <a class="txt-blue u" onclick="expandAccordions();return false;" >Expand</a>
	| <a class="txt-blue u" onclick="collapseAccordions();return false;" >Collapse</a>
	
</h5>

<div class="oneGroup" >

<?php 
	$sch=VCFOLDER;

	$clinks=SITE."views/customs/".VCFOLDER."/accor_mis_{$sch}.php"; 
	if(is_readable($clinks)){ include_once($clinks); }

	
?>

<?php 

	$incs = SITE."views/elements/accor_misfaves.php";include_once($incs); echo '<br>';
	if((isset($_SESSION['settings']['has_college'])) && ($_SESSION['settings']['has_college']==1)){ 
		$incs = SITE."views/elements/accor_college.php";include_once($incs); }
	if($_SESSION['settings']['has_library']==1){ $incs = SITE."views/elements/accor_library.php";include_once($incs); }
	// $incs = SITE."views/elements/accor_syncs.php";include_once($incs); 
	
?>
</div>	<!-- oneGroup -->


<div class="oneGroup" >
<?php 
	$incs=SITE."views/elements/accor_grading.php";include_once($incs); 		
	$incs=SITE."views/elements/accor_attd.php";include_once($incs); 		
	$incs=SITE."views/elements/accor_enrollment_college.php";include_once($incs);	
	// $incs=SITE."views/elements/accor_enrollment.php";include_once($incs);	
	echo '<br>';
	$incs=SITE."views/elements/accor_contacts.php";include_once($incs);	
	// $incs=SITE."views/elements/accor_stats.php";include_once($incs); 
?>
</div>	<!-- oneGroup -->



<div class="oneGroup" >
	<?php if($_SESSION['settings']['has_hris']==1){ $incs = SITE."views/elements/accor_hris.php";include_once($incs); } ?>
	<?php if($_SESSION['settings']['has_rfid']==1){ $incs = SITE."views/elements/accor_rfid.php";include_once($incs); } ?>
	<?php if($_SESSION['settings']['is_cluster']==1){ $incs = SITE."views/elements/accor_treeset.php";include_once($incs); } ?>
</div>	<!-- oneGroup -->

<div class="oneGroup" >
	<?php // $incs=SITE."views/elements/accor_grades.php";include_once($incs); ?>
	<?php // $incs=SITE."views/elements/accor_gset.php";include_once($incs); ?>
</div>	<!-- oneGroup -->



<div style="float:left;width:20%" class="hd" id="names" > </div>




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
	// $('.stocks').hide();$('.invis').hide();	
	$("table.stocks tr td").hide();	
	$("table.invis tr td").hide();	
	$('html').live('click',function(){ $('#names').hide(); });
	// collapseAccordions();
	
})
	
		
function syqtr(){
		sy  = $('#sy').val();
		qtr = $('#qtr').val();		
	}	
		

function setTssy(tssy){
	var rurl 	= gurl + '/mis/index/'+tssy;		/* redirect url */	
	window.location = rurl;		
}
		


function accordionTable(cls){ $("."+cls+" td").toggle(); }


function expandAccordions(){ $("table.accordion tr td").show();  }
function collapseAccordions(){ $("table.accordion tr td").hide();  }
		
		
</script>

