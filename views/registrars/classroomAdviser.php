<script>

$(function(){
	shd();
	
})

</script>

<?php 
	// pr($data);
?>

<h5>
	Classroom Adviser
	| <?php $this->shovel('homelinks'); ?>

</h5>

<table class="gis-table-bordered" >

<tr>
	<th>Classroom</th>
	<td>
		<?php echo $row['crid']; ?>
		| <?php echo $row['classroom']; ?>
	</td>
</tr>
<tr>
	<th>Adviser</th>
	<td>
	<?php 
		if($row['ucid']!=$row['pcid']){
			echo 'UP:'.$row['ucid'].'-'.$row['pcid'];		
		} else {
			echo $row['ucid']; 
		}	
	?>
		
		| <?php echo $row['adviser']; ?>
		<span class="shd" > | <a href="<?php echo URL.'contacts/ucis/'.$row['ucid']; ?>">Edit</a></span>
	</td>
</tr>
<tr>
	<th>ID No. | Code</th>
	<td><?php echo $row['code']; ?></td>
</tr>

<tr>
	<th><span class="u" onclick="traceshd();" >Login Account</span></th>
	<td>
		<?php echo $row['account']; ?>
		<span class="shd" ><?php echo '-'.$row['ctp']; ?></span>
	</td>
</tr>
<tr class="shd" >
	<th>Pwd</th>
	<td><?php echo $row['pass']; ?></td>
</tr>

<tr class="shd" >
	<th>Ctp Ucid</th>
	<td><?php echo $row['ctpucid']; ?></td>
</tr>

<tr class="shd" >
	<th>Prof Pcid</th>
	<td><?php echo $row['profpcid']; ?></td>
</tr>

<tr class="shd" >
	<th>Photo Pcid</th>
	<td><?php echo $row['photopcid']; ?></td>
</tr>

<?php 



?>

</table>
