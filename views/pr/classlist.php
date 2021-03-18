<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>

var gurl   = "http://<?php echo GURL; ?>";
$(function(){
	excel();

})




</script>






<?php 
	// pr($rows[0]); 
	// pr($cr);
?>


<h5 class="screen" >
	<?php echo $cr['name']; ?> (<?php echo $count; ?>) Printable
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>'>Classlist</a>			
	| <span class="u" onclick="pclass('hd');" >Scid</span> 
	| <a class="u" id="btnExport" >Excel</a> 
	
</h5>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
<th class="vc50" >#</th>
<th class="hd" >Scid</th>
<th class="vc100" >ID No</th>
<th class="vc300" >Name</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>




