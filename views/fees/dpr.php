<h5>

	Daily Payments Report
	<?php echo (isset($count))? '('.$count.')':NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u txt-blue" onclick="window.print();" >Print</a>

	
</h5>

<table class="gis-table-bordered" >
<tr><th>Date</th>
<td><input id="date" class="pdl05" type="date" value="<?php echo $date; ?>" ></td>
<td><button onclick="redirUrl();" >Go</button></td>
</tr>
</table>
<br />

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<?php 

$incs="incs/payments_table.php";
require_once($incs);

?>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})

function redirUrl(){
	var date = $('#date').val();
	var url = gurl+'/fees/dpr?date='+date;
	window.location=url;
}	/* fxn */


</script>

