<style>

div{ border:1px solid white; }
div.oneGroup{ float:left; }




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


<h5>
	Tree Setup
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>
	| <a href="<?php echo URL.'cir'; ?>" >CIR</a>
	| <a href="<?php echo URL.'gset'; ?>" >GSET</a>
	| <a href="<?php echo URL.'xhome'; ?>" >xHome</a>
	| <a class="txt-blue u" onclick="expandAccordions();return false;" >Expand</a>
	| <a class="txt-blue u" onclick="collapseAccordions();return false;" >Collapse</a>
	
</h5>

<div class="oneGroup" >


<?php 

	$incs = SITE."views/elements/accor_treeset.php";include_once($incs); 

	// $incs = SITE."views/elements/accor_syncs.php";include_once($incs); 
?>
</div>	<!-- oneGroup -->



<div style="float:left;width:20%" class="hd" id="names" > </div>




<p class="clear ht100" ></p>




<!----------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	hd();
	
	$('html').live('click',function(){ $('#names').hide(); });

	
})
	
		

function accordionTable(cls){ $("."+cls+" td").toggle(); }

function accorHd(){ $(".accordParent table:not(:first)").hide(); }
function expandAccordions(){ $(".accordParent table").show(); $('.accordion tbody').show(); }
function collapseAccordions(){ $(".accordParent table").hide();  $('.accordion tbody').hide(); }
		
		
</script>

