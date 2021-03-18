

<h5>
	Propagate Subjects to Courses
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>


<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>Dept</th>
	<td>
		<?php foreach($depts AS $sel): ?>
			<input class="" type="radio" name="post[dept_id]" 
				value="<?php echo $sel['id']; ?>"><label><?php echo $sel['code']; ?></label><br>				
		<?php endforeach; ?>		
	</td>
</tr>

</table>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>Select All</th><td><input type="checkbox" id="chkAlla"  /></td></tr>
<tr><th>Ctype</th><td><input type="checkbox" name="post[ctype]" value="1" class="chka" /></td></tr>
<tr><th>Position</th><td><input type="checkbox" name="post[position]" value="1" class="chka" /></td></tr>
<tr><th>Name</th><td><input type="checkbox" name="post[name]" value="1" class="chka" /></td></tr>

<tr><th>Is Numeric</th><td><input type="checkbox" name="post[is_num]" value="1" class="chka" /></td></tr>
<tr><th>Is 3Tier</th><td><input type="checkbox" name="post[is_kpup]" value="1" class="chka" /></td></tr>
<tr><th>With Scores</th><td><input type="checkbox" name="post[with_scores]" value="1" class="chka" /></td></tr>

<tr><th>Weight</th><td><input type="checkbox" name="post[weight]" value="1" class="chka" /></td></tr>
<tr><th>In Genave</th><td><input type="checkbox" name="post[in_genave]" value="1" class="chka" /></td></tr>
<tr><th>Affects Ranking</th><td><input type="checkbox" name="post[affects_ranking]" value="1" class="chka" /></td></tr>
<tr><th>Indent</th><td><input type="checkbox" name="post[indent]" value="1" class="chka" /></td></tr>
<tr><th>Is Active</th><td><input type="checkbox" name="post[is_active]" value="1" class="chka" /></td></tr>
<tr><th>Is Aggregate</th><td><input type="checkbox" name="post[is_aggregate]" value="1" class="chka" /></td></tr>
<tr><th>Is Displayed</th><td><input type="checkbox" name="post[is_displayed]" value="1"  class="chka" /></td></tr>
<tr><th>Is Transmuted</th><td><input type="checkbox" name="post[is_transmuted]" value="1" class="chka" /></td></tr>

<tr><th>Supsubject ID</th><td><input type="checkbox" name="post[parent_id]" value="1" class="chka" /></td></tr>
<tr><th>Semester</th><td><input type="checkbox" name="post[semester]" value="1" class="chka" /></td></tr>
</table>


<p class="hd" >
	<input type="submit" name="submit" value="Submit" onclick="" />
</p>

</form>







<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';
			
$(function(){
	chkAllvar('a');	
	hd();
	$('#hdpdiv').hide();
})




</script>







