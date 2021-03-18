<h5>
	Unicomponents  
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >ID</span>
	| <a href="<?php echo URL.'unicomponents/setup'; ?>" >Batch</a>
	
</h5>

<?php 

// pr($subjects);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Subject</th>
	<th>Criteria</th>
	<th class="center" >Weight</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['subject']; ?><span class="shd" ><?php echo ' #'.$rows[$i]['subject_id']; ?></span></td>
	<td><?php echo $rows[$i]['criteria']; ?><span class="shd" ><?php echo ' #'.$rows[$i]['criteria_id']; ?></span></td>	
	<td class="center" ><?php echo $rows[$i]['weight']; ?></td>
	<td><a href="<?php echo URL.'unicomponents/edit/'.$rows[$i]['rid']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>

<script>

$(function(){
	shd();
	
})


</script>
