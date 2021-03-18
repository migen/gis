<h5>

	Add | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lookups/profile/'.$table; ?>" ><?php echo ucfirst($table); ?></a>



</h5>


<?php 

// pr($data);
$field_array=$dbx['field_array'];
// pr($field_array);


?>

<form method="POST" >
<table class="gis-table-bordered table-atlrow" >
<tr>
<?php foreach($field_array AS $field): ?>
	<th><?php echo $field; ?></th>
<?php endforeach; ?>
</tr>
<?php $count=(isset($_POST['numrows']))? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$count;$i++): ?>

	<tr>
	<?php foreach($field_array AS $field): ?>
	<td><input name="posts[<?php echo $i; ?>][<?php echo $field; ?>]" ></td>
	<?php endforeach;  ?>
	</tr>
<?php endfor; ?>


</table>

<p><input type="submit" name="submit" value="Add" ></p>

</form>

<?php $this->shovel('numrows'); ?>
