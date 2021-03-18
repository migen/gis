<style>
div{font-size:0.8em;}

</style>

<?php 

$admin=($_SESSION['user']['privilege_id']==0)? 1:0;


?>

<h5 class="screen" >
	Cash Tally (Accounting)
	| <a href="<?php echo URL.$home; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'cash/report'; ?>">Report</a> 
	| <a class="u txt-blue" onclick="window.print();" >PRINT</a>		

</h5>





<form method="GET" >
<table class="screen gis-table-bordered" >
<tr>

	<th>Ecid</th>
	<td><input class="vc70 center" name="ecid"
		value="<?php echo (isset($ecid))? $ecid:1; ?>" <?php echo ($admin)? NULL:'readonly'; ?> /></td>		
	<th>Date</th>
	<td><input class="pdl05" type="date" id="date" name="date" value="<?php echo $date; ?>"  /></td>
	<td><input type="submit" name="filter" value="Go"  /></td>
</tr>
</table>

</form>

<form method="POST" >

<?php 
	$page = "Daily Cash Tally Report<br />".$date;	
	$inc = SITE.'views/elements/letterhead_logo_datetime.php';
	include($inc); 
	
	
	include_once('incs/cash_tally.php'); 
	include_once('incs/check_part.php'); 
	include_once('incs/deposit_part.php'); 
	include_once('incs/collection_others.php'); 
	include_once('incs/collection_summary.php'); 
	
?>

<div class="clear ht100" ></div>

</form>

<!-------------------------------------------->
<script>

	var gurl  = 'http://<?php echo GURL; ?>';	
	var home  = '<?php echo $home; ?>';


$(function(){
	nextViaEnter();
	selectFocused();

})	/* fxn */


function redirCash(){
	var ecid = $('#ecid').val();
	var udate = $('#date').val();
	var trml = $('#terminal').val();
	var paid = $('#paid').val();
	var url = gurl+'/cash/denominations?date='+udate+'&terminal='+trml+'&ecid='+ecid+'&paid='+paid;
	// alert(url);
	window.location=url;
}	/* fxn */


	
	

</script>