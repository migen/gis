<h5>
	View <?php echo $table; ?> | <?php $this->shovel('homelinks'); ?>
	
	
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>
	
	
</h5>

<?php

// pr($data);




?>

<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<?php foreach($columns AS $k=>$key): ?>
<tr><th><?php echo $key; ?></th>
	<td><?php echo $row[$key]; ?></td></tr>
<?php endforeach; ?>
</table>

<div class="ht50 clear" >&nbsp;</div>
