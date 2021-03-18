<?php 


// pr($data);




?>

<h5>
	Methods
	- <?php echo $class; ?>
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo '| <a href="'.URL.'tools" >Tools</a>'; ?>					
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	
</h5>

<div class="half" >
<table class="gis-table-bordered table-fx" >

<tr class="headrow row-white" >
	<th class="vc30" >#</th>
	<th class="vc200" >Method</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$method=$rows[$i];
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.$controller_name.'/'.$method; ?>" ><?php echo $method; ?></a></td>
</tr>
<?php endfor; ?>
</table>
</div>
