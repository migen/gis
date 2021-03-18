<h5>
	Balance Summary
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" id="btnExport" >Excel</a> 

<?php 
	$d['sy']=$sy;$d['repage']="balances/tsum/$lvl";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>


<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."balances/tsum/".$sel['id'].DS.$sy; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Section</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Balance</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo number_format($rows[$i]['balance'],2); ?></td>
</tr>
<?php endfor; ?>
</table>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script>

var gurl = "http://<?php echo GURL; ?>";
var lvl = "<?php echo $lvl; ?>";
var sy = "<?php echo $sy; ?>";


$(function(){
	excel();	
		
})





</script>

