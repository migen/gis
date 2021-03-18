<?php 

$dbo=PDBO;
$dbg=PDBG;

$dbcriteria="{$dbo}.05_criteria";


?>

<h3>
	Components Scripts | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" >SHD</span>
	| Criteria - 
		<a href='<?php echo URL."batch/setfield/$dbcriteria"; ?>' >Setfield</a>
		| <a href='<?php echo URL."batch/update/$dbcriteria"; ?>' >Update</a>
	| <a href='<?php echo URL."components/roots"; ?>' >Roots</a>
		
	
</h3>


<p> &active=2 | &crstype | &order_cri </p>

<?php 

	// pr($data);
?>
<div class="left half" >

<?php 
	pr($scripts);
?>

</div>


<div class="third left" >
<h5>Criteria</h5>
<p class="shd" ><?php echo $query['criteria']; ?></p>
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>ID</th>
	<th>Code</th>
	<th>Criteria</th>
	<th>Pos</th>
	<th>Actv</th>
</tr>
<?php foreach($cri_rows AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['position']; ?></td>
	<td><?php echo $row['is_active']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- subjtypes -->

<h5>Subjtypes</h5>
<p class="shd" ><?php echo $query['subjtypes']; ?></p>
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Pos</th>
</tr>
<?php foreach($st_rows AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['position']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>	<!-- right -->


<script>



</script>
