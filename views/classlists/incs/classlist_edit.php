<style>
</style>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th class="vc30" >#</th>
	<th class="vc30 scid" >Scid</th>
	<th class="vc30" >Male
		<br /><input type="number" min=0 max=1 class="pdl05 vc50" id="imale" /><br />	
		<input type="button" value="All" onclick="populateColumn('male');" >							
	</th>
	<th class="vc100" >Code</th>
	<th class="vc100" >LRN</th>
	<th class="vc30" >Pos
		<br /><input class="pdl05 vc50" id="ipos" /><br />	
		<input type="button" value="All" onclick="populateColumn('pos');" >							
	</th>
	<th class="vc300" >Student</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="vc30" ><?php echo $i+1; ?></td>
	<td class="vc30" ><?php echo $rows[$i]['scid']; ?></td>
	<td><input tabIndex="2" class="male" type="number" min=0 max=1 name="posts[<?php echo $i; ?>][is_male]" value="<?php echo $rows[$i]['is_male']; ?>"  /></td>
	<td><input tabIndex="4" class="full" name="posts[<?php echo $i; ?>][code]" value="<?php echo $rows[$i]['code']; ?>"  /></td>
	<td><input tabIndex="6" class="full" name="posts[<?php echo $i; ?>][lrn]" value="<?php echo $rows[$i]['lrn']; ?>"  /></td>
	<td><input tabIndex="8"  class="vc50 pos" name="posts[<?php echo $i; ?>][position]" value="<?php echo $rows[$i]['position']; ?>"  /></td>
	<td>
		<input tabIndex="10" class="full" name="posts[<?php echo $i; ?>][name]" value="<?php echo $rows[$i]['name']; ?>"  />
		<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>"  />		
	</td>
	
</tr>
<?php endfor; ?>
</table>

<?php if(isset($_GET['edit'])): ?>
	<p><input type="submit" name="submit" value="Submit" /></p>
<?php endif; ?>


</form>


<script>

$(function(){
	nextViaEnter();
	selectFocused();

})


</script>

