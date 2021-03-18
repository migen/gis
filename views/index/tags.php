<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	<a href="<?php echo URL.'reports/balances'; ?>">Balance Sheet</a> 
</h5>


<h5>Tags</h5>

<div style='width:800px;'>

<p>

<?php 
$c = count($data['tags']);

$x = '';
for($i=0;$i<$c;$i++){
	$row = $data['tags'][$i];	
	$x .= $row['name'].' || ';	
}

$x = rtrim($x,' || ');
echo $x;

?>

</p>

</div>