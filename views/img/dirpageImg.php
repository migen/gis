<?php 



?>



<!------------------------------------------------------------------------------------------------------------>

<h5>
	Photos

	
</h5>



<!------------------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="vc200" >Photo</th>

</tr>

<?php $i=1; ?>
<?php foreach($files AS $row): ?>
<?php 
	$file = rtrim($row,'.jpg');
?>

<tr>
<td><?php echo $i; ?></td>
<td><?php echo $file; ?></td> <!-- target="_blank" -->
<?php if($_SESSION['user']['role_id']==RMIS): ?>
	<td>	
		<a href="<?php echo URL."tmp/images/".$row; ?>" >View</a>		
		| <a href="<?php echo URL."img/getpic/".$row; ?>" >Get</a>		
	</td>
<?php endif; ?>

</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>