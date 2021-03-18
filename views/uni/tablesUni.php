<h5>
	UC Tables
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'links'; ?>" >Links</a>

</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Px</th>
	<th>Table</th>
	<th>Fields</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['index']; ?></td>
	<td><?php echo $rows[$i]['table']; ?></td>
	<td class="vc500" ><?php echo $rows[$i]['fields']; ?></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>

<script>

	$(function(){
		
	})

</script>
