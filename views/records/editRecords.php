<h5>
	<?php 
		
	?>
	Edit <?php echo $table; ?> | <?php $this->shovel('homelinks'); ?>
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>
	| <a href='<?php echo URL."records/delete/$dbtable/$id"; ?>' onclick="return confirm('Sure?');" >Delete</a>
	
</h5>

<?php

// pr($data);




?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<?php foreach($columns AS $k=>$key): ?>
<tr><th><?php echo $key; ?></th>
	<td><input name="post[<?php echo $key; ?>]" value="<?php echo $row[$key]; ?>" ></td></tr>
<?php endforeach; ?>
<tr><td colspan=2 ><input type="submit" name="submit" value="Save" ></td></tr>
</table>
</form>

<div class="ht50 clear" >&nbsp;</div>
