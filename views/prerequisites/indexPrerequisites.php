<h5>
	Prerequisites  
	| <?php $this->shovel('homelinks','College'); ?>
	| <span onclick="traceshd();" class="u" >ID</span>
	| <a href="<?php echo URL.'unisubjects'; ?>" >Subjects</a>
	
</h5>

<?php 

// pr($subjects);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Subject</th>
	<th>Prerequisites</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $id=$rows[$i]['sub']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?><span class="shd" ><?php echo ' #'.$rows[$i]['sub']; ?></span></td>
	<td><?php echo $rows[$i]['prerequisites']; ?></td>
	<td><a href='<?php echo URL."prerequisites/edit/$id"; ?>' >Edit</a></td>

</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>

<script>

$(function(){
	shd();
	
})


</script>
