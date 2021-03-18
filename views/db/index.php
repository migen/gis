<?php 


// $d = $num_files - 1;
// $dd = $d - 1;
// unset($files[$d]);
// unset($files[$dd]);
// $corrected_num_files = $num_files - 2;

?>



<!------------------------------------------------------------------------------------------------------------>

<h5>
	Files
	| <a href="<?php echo URL.'files/write'; ?>">New</a>
</h5>



<!------------------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="vc200" >File</th>

</tr>

<?php $i=1; ?>
<?php foreach($files AS $row): ?>
<?php 
	$file = rtrim($row,'.php');
?>

<tr>
<td><?php echo $i; ?></td>
<td><a href="<?php echo URL."files/read/".$file; ?>" ><?php echo $file; ?></a></td> <!-- target="_blank" -->
<?php if($_SESSION['user']['role_id']==RMIS): ?>
	<td>	
		<a href="<?php echo URL."files/edit/".$file; ?>" >Edit</a>
		| <a href="<?php echo URL."files/delete/".$file; ?>" onclick="return confirm('Dangerous! Cannot undo!');" >Del</a>
	</td>
<?php endif; ?>

</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>