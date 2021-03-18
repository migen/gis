

<h5>
	Excel
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" id="btnExport" >Excel</a> 
		
	
</h5>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow"  >

<tr>
<th>#</th>
<th class="vc200 left" >Schools</th>
</tr>

<tr><td>1</td><td>Lsm</td></tr>
<tr><td>2</td><td>Sasm</td></tr>
<tr><td>3</td><td>Sjalp</td></tr>
<tr><td>4</td><td>Mipss</td></tr>
<tr><td>5</td><td>Ihmc</td></tr>
<tr><td>6</td><td>Icpsqc</td></tr>


</table>



<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>
