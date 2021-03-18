<?php 
	
	$sq=isset($_SESSION['q'])? $_SESSION['q']:NULL;
	debug($sq);
	// pr($_SESSION['q']);
	// pr($data);
	// pr($ucis);
	

	
?>



<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	











</script>

<!------------------------------------------------------------------------------------------------->

<?php 


?>

<h5 class="screen" >
	Grades Home
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'grades/updateAggregates'; ?>">Update Aggregates</a> 

			
</h5>




<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table>




<div class="hd" id="names" > </div>
