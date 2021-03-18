<?php 


?>

<h5 class="screen" >
	Foundation
	| <?php $this->shovel('homelinks'); ?>
	
</h5>


<p>
<table class="gis-table-bordered" >
<tr><th colspan=2><a href="<?php echo URL.'foundation/subjects?all'; ?>" >Fdn Subjects </a></th></tr>
<tr><th colspan=2><a href="<?php echo URL.'fdnTypes'; ?>" >Fdn Types</a></th></tr>

</table>






<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	selectFocused();

})

function gotoUrl(){
	var crid=$('#crid').val();
	var url=gurl+"/foundation/crid/"+crid;
	window.location=url;			
	
}	/* fxn */


</script>


