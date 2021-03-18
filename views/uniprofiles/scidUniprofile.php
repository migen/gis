<?php 


?>

<h5>
	College Profile | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'contacts/ucid/'.$scid; ?>" >Contact</a>
	
	
</h5>

<?php

$keys=array();$values=array();
$unsets=array("id","contact_id","name");

foreach($row AS $k=>$v){ 
	if(!in_array($k,$unsets)){
		$keys[]=$k;$values[]=$v;		
	}
}
$count=count($keys);
$num_unsets=count($unsets);


?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Key</th>
	<th>Value</th>
</tr>
<tr><td>1</td><td>ID</td><td><?php echo $row['id']; ?></td></tr>
<tr><td>2</td><td>Contact ID</td><td><?php echo $row['contact_id']; ?></td></tr>
<tr><td>3</td><td>Name</td><td><?php echo $row['name']; ?></td></tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $key=$keys[$i]; ?>
<tr>
	<td><?php echo $num_unsets+$i+1; ?></td>
	<td><?php echo $key; ?></td>
	<td><input name="post[<?php echo $key; ?>]" value="<?php echo $values[$i]; ?>" ></td>
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save"  /></p>

</form>



