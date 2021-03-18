<h5>
	Find <?php echo $table; ?> | <?php $this->shovel('homelinks'); ?>
	
	
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>
	
	
</h5>

<?php

// pr($data);


// exit;

?>

<form method="GET" >
<table class="gis-table-bordered" >
<tr><td><select name="field" >
<?php foreach($columns AS $val): ?>
	<option <?php echo (isset($_GET['field'])) && ($_GET['field']==$val) ? 'selected':NULL; ?> ><?php echo $val; ?></option>
<?php endforeach; ?>
</select><td>
<td><input name="value" ></td>
<td><input type="submit" name="submit" value="Find" ></td>
</tr>

</table>
</form><br />


<?php if(isset($_GET['field'])): ?>
<table class="gis-table-bordered" >
<!-- thead -->
<tr>
<th></th>
<th>ID</th>
<?php foreach($columns AS $key): ?>
	<th><?php echo $key; ?></th>
<?php endforeach; ?>
<!-- thead -->

<?php foreach($rows AS $row): ?>
<?php $id=$row['id']; ?>
<tr>
<td><a href='<?php echo URL."records/edit/$dbtable/$id"; ?>' >Edit</a></td>
<td><?php echo $id; ?></td>
	<?php foreach($columns AS $key): ?>
		<td><?php echo $row[$key]; ?></td>
	<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<!-- 

<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<?php foreach($columns AS $k=>$key): ?>
<tr><th><?php echo $key; ?></th>
	<td><?php echo $row[$key]; ?></td></tr>
<?php endforeach; ?>
</table>

-->


<div class="ht50 clear" >&nbsp;</div>
