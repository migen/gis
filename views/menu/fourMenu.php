<style>

div{ border:1px solid fff; }

table,table.accordion th,table.accordion td{ color: green;width:40%; }



/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	
	#content{ font-size:1.8em; }
	select{ font-size:1.4em; }
	h3.pagelinks,h5.pagelinks{ font-size:1.8em; }
	.oneGroup{ float:left;border:1px solid fff;width:45%;  }

}


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {

	#content{ font-size:1.2em; }
	select{ font-size:1.0em; }
	h3.pagelinks,h5.pagelinks{ font-size:1.2em; }
	.oneGroup{ float:left;border:0px solid fff;width:20%;  }
	
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
	| <a href="<?php echo '#'; ?>" >Records</a>
	| <a href="<?php echo '#'; ?>" >Records</a>
	| <a href="<?php echo '#'; ?>" >Records</a>
	| <a href="<?php echo '#'; ?>" >Records</a>
	| <a href="<?php echo '#'; ?>" >Records</a>
	| <a class="txt-blue u" onclick="expandAccordions();return false;" >Expand</a>
	| <a class="txt-blue u" onclick="collapseAccordions();return false;" >Collapse</a>
	
</h5>

<div class="oneGroup" >


<?php 

	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abcaxis.php";include($incs); 		
	$incs = SITE."views/elements/accor_invis.php";include($incs); 		
	$incs = SITE."views/elements/accor_abc.php";include($incs); 		

?>
</div>	<!-- oneGroup -->


<div class="oneGroup" >
<?php 
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abc.php";include($incs); 		
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
?>
</div>	<!-- oneGroup -->


<?php if($_SESSION['settings']['has_axis']==1): ?>
<div class="oneGroup" >
<?php 
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abc.php";include($incs); 		
?>	
</div>	<!-- oneGroup -->	
<?php endif; ?>	<!-- has_axis -->

<div class="oneGroup" >
<?php 
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abc.php";include($incs); 		
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
?>
</div>	<!-- oneGroup -->

<div class="oneGroup" >
<?php 
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
	$incs = SITE."views/elements/accor_abc.php";include($incs); 		
	$incs = SITE."views/elements/accor_abcfaves.php";include($incs); 		
?>
</div>	<!-- oneGroup -->

<div style="float:left;width:20%" class="hd" id="names" > </div>




<p class="clear ht100" ></p>




<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
			
$(function(){
	hd();
	$('html').live('click',function(){ $('#names').hide(); });

	
})
	
		


function accordionTable(cls){ $("."+cls+" td").toggle(); }


function expandAccordions(){ $("table.accordion tr td").show();  }
function collapseAccordions(){ $("table.accordion tr td").hide();  }
		
		
</script>

