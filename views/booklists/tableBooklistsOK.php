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
	<th>Code</th>
	<th>Name</th>
	<th>Company</th>
	<th class="right" >Amount</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['company']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>
