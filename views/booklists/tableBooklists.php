<h3>
	Books | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>

</h3>

<?php 
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbbooks="{$dbg}.05_books";

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
	<th>Subject</th>
	<th>Sem</th>
	<th>Code</th>
	<th>Name</th>
	<th>Company</th>
	<th class="right" >Amount</th>
	<th></th>
</tr>
<?php if($srid==RMIS): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['pkid']; ?></td>
		<td><?php echo $rows[$i]['subjname']; ?></td>
		<td><?php echo $rows[$i]['semester']; ?></td>
		<td><?php echo $rows[$i]['code']; ?></td>
		<td><?php echo $rows[$i]['name']; ?></td>
		<td><?php echo $rows[$i]['company']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
		<td><a href="<?php echo URL.'booklists/edit/'.$rows[$i]['pkid']; ?>" >Edit</a></td>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['id']; ?></td>
		<td><?php echo $rows[$i]['subjname']; ?></td>
		<td><?php echo $rows[$i]['semester']; ?></td>
		<td><?php echo $rows[$i]['code']; ?></td>
		<td><?php echo $rows[$i]['name']; ?></td>
		<td><?php echo $rows[$i]['company']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
		<td></td>
	</tr>
	<?php endfor; ?>
<?php endif; ?>	
</table>

<div class="ht100" ></div>
