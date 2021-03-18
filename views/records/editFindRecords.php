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
	<option><?php echo $val; ?></option>
<?php endforeach; ?>
</select><td>
<td><input name="value" ></td>
<td><input type="submit" name="submit" value="Find" ></td>
</tr>

</table>
</form><br />


<?php if(isset($_GET['field'])): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<!-- thead -->
<tr>
<th></th>
<th>#</th>
<?php for($j=0;$j<$num_columns;$j++): ?>
	<th><?php $key=$columns[$j]; echo $key; ?>
		<br /><input class="vc50" type="text" id="i<?php echo $key; ?>" placeholder="All" />
		<button onclick="populateColumn('<?php echo $key; ?>');return false;">All</button>									
	</th>
<?php endfor; ?>
<th></th>
<th></th>
</tr>
<!-- thead -->

<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><a href='<?php echo URL."records/edit/$dbtable/$id"; ?>' >Edit</a></td>
	<td><?php echo $i+1; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><input name="posts[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $rows[$i][$key]; ?>" 
			id="<?php echo $key.$i; ?>" class="<?php echo $key; ?>" ></td>
	<?php endfor; ?>
	<td><a href='<?php echo URL."records/edit/".$dbtable."/$id"; ?>' >Edit</a></td>
	<td><button id="btn-<?php echo $i; ?>" >Save</button></td>
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" readonly >
</tr>
<?php endfor; ?>

</table>

<p><input type="submit" name="submit" value="Save" ></p>
</form>

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
