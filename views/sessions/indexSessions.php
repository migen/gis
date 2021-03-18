<h3>
	Sessions (<?php echo $count; ?>) | <?php shovel('homelinks'); ?>
	| <span onclick="pclass('shd');" >Show</span>
	| <a href="<?php echo URL."sessions/unsetter" ?>" >Unsetter</a>
	| <a href="<?php echo URL."records/dbtables" ?>" >Records</a>	
	
	<?php 

	?>
	
</h3>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Session</th>
	<th>Value</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $key=$rows[$i]; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $key; ?></td>
	<td>
		<span onclick="itoggle('val-'+<?php echo $i; ?>);" >Show</span><br />
		<span class="shd" id="val-<?php echo $i; ?>" >
			<?php pr($sessions[$key]); ?>
		</span>
		
		
	</td>
</tr>
<?php endfor; ?>
</table>



<script>

$(function(){
	shd();
	
})


function itoggle(id){ $('#'+id).toggle(); }



</script>
