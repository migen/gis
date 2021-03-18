<h3>
	Treeset Classrooms | <?php $this->shovel('homelinks'); ?>

</h3>

<?php
	
	// pr($_SESSION['q']);

	$dbg=PDBG;
	$dbtable="{$dbo}.`05_sections`"; 
	
	$d['dbtable']=&$dbtable;
	$this->shovel('xadd_codename',$d);
	
	
?>




<br />

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
	<th>ID</th>
</tr>
<?php $i=0; ?>
<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['id']; ?></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>


</table>


<script>

var gurl="http://<?php echo GURL; ?>";



</script>


<script type="text/javascript" src='<?php echo URL."views/js/jscrud.js"; ?>' ></script>
