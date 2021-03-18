<?php 
?>

<h5> Reg 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	 | <a href="<?php echo URL.'dashboard/registrar'; ?>"> <?php echo 'Dashboard'; ?></a> 
</h5>





<?php 
	$d['classrooms'] = $classrooms; 
	$d['levels'] = $levels; 
?>

<div class="third" >	<!-- left -->

<div class="accordParent" >	
<button onclick="accorToggle('favorites')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Favorites</p> </button>  	
<table id="favorites" class="gis-table-bordered table-fx" >

<tr><th class="vc250" ><a href="<?php echo URL.'cir'; ?>" >*Class Index Reports (CIR)</a></th></tr>


<tr><td>&nbsp;</td></tr>



</table>
</div>

<?php $this->shovel('accor_registrar',$d); ?>
<?php $this->shovel('accor_regeneral'); ?>


</div>	<!-- left -->

<div class="third" >
	<div id="names" ></div>

</div> <!-- right -->




<div class="ht100" ></div>





<script>

	var gurl  = "http://<?php echo GURL; ?>";		
	$(function(){
		hd();
		$('html').live('click',function(){ $('#names').hide(); });
	})
	
	
	function accorToggle(sxn){ $("#"+sxn).toggle(); }
	function accorHd(){ $(".accordParent table:not(:first)").hide(); }


	
</script>

 


