<h5>
	Logs - Students SY<?php echo $sy; ?>
	<?php echo (isset($count))? '('.$count.')':NULL; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	| <a href="<?php echo URL.'students/logbooks'; ?>" />Filter</a>  
	| <a class="u" id="btnExport" >Excel</a> 
	
	
</h5>


<?php 


?>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<?php if(isset($count) && ($count==0)){ echo "<h5>No results found. </h5>"; } ?>

<?php if(isset($count) && ($count>0)): ?>


<h4>From <?php echo $_GET['beg'].' To '.$_GET['end']; ?></h4>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th class="" >Ucid</th>
	<th>Type</th>
	<th>Datetime</th>
	<th>Level</th>
	<th>ID No.</th>
	<th>Fullname</th>
	
</tr>


<?php 
// $total=$count;
// $new=$count;
// $old=$count;

?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['logtype']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['usercode']; ?></td>
	<td><?php echo $rows[$i]['fullname']; ?></td>
	
</tr>
<?php endfor; ?>
</table>
<br />


<?php else: ?>
<?php $incs="incs/studlogs_filter.php";include_once($incs); ?>

<?php endif; ?>


<script>

var hdpass 	= "<?php echo HDPASS; ?>";

$(function(){
	hd();
	shd();
	excel();
	$('#hdpdiv').hide();
	

})


</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



