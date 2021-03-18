<?php 


?>

<h5>
	View College Course | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicourses/edit/'.$crs; ?>" >Edit</a>
	
	
</h5>

<?php

$keys=array();$values=array();
foreach($row AS $k=>$v){ 
	$keys[]=$k;$values[]=$v;		
}
$count=count($keys);


?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Key</th>
	<th>Value</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $key=$keys[$i]; $value=$values[$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $key; ?></td>
	<td><?php echo $value; ?></td>

</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>


