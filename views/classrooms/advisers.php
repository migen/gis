<h5>
	Advisers
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" id="btnExport" >Excel</a> 
	
	
</h5>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Level</th>
	<th>Section</th>
	<th class="vc150" >Login</th>
	<th class="vc300" >Adviser</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['login']; ?></td>
	<td><?php echo $rows[$i]['adviser']; ?></td>
</tr>
<?php endfor; ?>
</table>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})






</script>





