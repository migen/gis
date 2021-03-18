<h5>
	Sold Item POS Finder <span class="underline" onclick="tracehd();" >HD</span>
	| <?php $this->shovel('homelinks'); ?>
	
</h5>


<form method="GET" >

<?php  $incs="incs/filter_finder.php";include_once($incs);  ?>

</form>

<div id="names"></div>

<?php  if(isset($_GET['filter'])){ $incs="incs/table_finder.php";include_once($incs); } ?>

<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
			
$(function(){
	hd();
	$('html').live('click',function(){ $('#names').hide(); });

	
})




function redirLookup(ucid){ $('#prid').val(ucid); }




</script>



<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>



