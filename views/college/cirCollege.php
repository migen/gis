<?php 



?>

<h5 class="screen" >
	Std Class Index Reports (CIR-<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

	
</h5>

<table class="gis-table-bordered" >
<tr><td>Qtr: <input id="qtr" type="number" class="vc50 center" value="<?php echo 4; ?>" /></td>
<td><button onclick="jsredirect('advisers/averager?qtr='+$('#qtr').val());" >Averager</button></td>
</tr>
</table>




<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Classroom (Size)</th>
	<th>ID</th>	
	<th>List</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom'].' ('.$rows[$i]['num_students'].')'; ?></td>	
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><a href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$sy; ?>" >List</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	

})


</script>


