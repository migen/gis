
<?php 

// pr($_SESSION);

?>


<!---------------------------------------------------------------------------------------------------------->

<h5>
	Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/dashboard'; ?>" > Dashboard </a>
</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr><th class="headrow white vc200" > Managers </th></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'hrds/instruments'; ?>" > Instruments </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'hrds/instrutypes'; ?>" > Instrument Types </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'hrds/instrucriteria'; ?>" > Instrument Criteria </a></td></tr>


</table>

<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';	
	
	
</script>