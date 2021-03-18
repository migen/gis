<h3>
	Books | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 
	$str="";
?>

<?php foreach($levels AS $sel): ?>
<?php $str.="<a href='".URL."/booklists/level/".$sel['id']."/$sy' >".$sel['code']."</a> | "; ?>
<?php endforeach; ?>

<?php 
	$str=rtrim($str," | ");
	echo "<p>$str</p>";
?>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>
