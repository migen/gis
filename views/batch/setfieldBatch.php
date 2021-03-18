<style>




</style>


<?php 

	$dbo=PDBO;
	$dbsubjects="{$dbo}.05_subjects";

?>


<h3>

	Batch Setfield (<?php echo $count; ?>) <?php echo $dbtable; ?> | <?php $this->shovel('homelinks'); ?>
	| <a class="u" onclick="pclass('smartboard');" >Smartboard</a>
	| <a href='<?php echo URL."batch/update/$dbsubjects"; ?>' >Update</a>
	

	
</h3>


<div class="" >
	Fields: 
	<?php foreach($table_fields AS $f): ?>
		<?php echo $f.' | '; ?>
	<?php endforeach; ?>
</div>

<div style="float:left;width:60%;" >

<form method="POST" >
	<table class="gis-table-bordered table-altrow table-fx" >
		<tr>
			<th>#</th>
			<?php foreach($field_array AS $fkey): ?>
				<th><?php echo $fkey; ?></th>
			<?php endforeach; ?>
			<th><?php echo ucfirst($field); ?></th>
		</tr>
		<?php for($i=0;$i<$count;$i++): ?>
			<tr>
				<td><?php echo $i+1; ?></td>				
				<?php foreach($field_array AS $fkey): ?>
					<td><?php echo $rows[$i][$fkey]; ?></td>
				<?php endforeach; ?>				
				<td>
					<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" >
					<input type="hidden" name="posts[<?php echo $i; ?>][oldval]" value="<?php echo $rows[$i][$field]; ?>" >
					<input id="value<?php echo $i; ?>" name="posts[<?php echo $i; ?>][newval]" value="<?php echo $rows[$i][$field]; ?>" >
				</td>
			</tr>		
		<?php endfor; ?>
	</table>
	<p><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" ></p>	
</form>
</div>	<!-- main -->

<div class="" style="width:300px;float:left;"  >
	<p class="smartboard" >
	<select id="classbox" class="vc100"  >
		<option value="value" >Value</option>
	</select>
	</p>
	<?php 
		$width=isset($_GET['width'])? $_GET['width']:30;
	?>
	<?php $this->shovel('smartboard',$data=array('width'=>$width)); ?>
</div>	<!-- side / smartboard -->


<div class="clear ht100" ></div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';

$(function(){
	pclass('smartboard');
	nextViaEnter();
	selectFocused();

})



</script>


