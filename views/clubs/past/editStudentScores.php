<h5>
	Club Edit Student Scores
	
	<?php $this->shovel('homelinks'); ?>
<span class="hd" >
	| <a href="<?php echo URL.'clubs/clearStudentScores/'.$scid.DS.$qtr; ?>" >Delete All</a>
	| <a href="<?php echo URL.'clubs/syncStudentScores/'.$scid.DS.$qtr; ?>" >Sync</a>	
</span>
	
</h5>

<?php // pr($record); ?>

<p><?php $this->shovel('hdpdiv'); ?></p>


<p>
<table class="gis-table-bordered table-altrow" >
<tr><th>Student</th><td><?php echo $record['student']; ?></td></tr>
</table>
</p>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Activity</th>
	<th>Score</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
<td>
	<input class="vc50 right" name="posts[<?php echo $i; ?>][score]" value="<?php echo $rows[$i]['score']; ?>" />
	<input type="hidden" name="posts[<?php echo $i; ?>][score_id]" value="<?php echo $rows[$i]['score_id']; ?>" />
</td>

	<td>
		<span class="hd" >
		<a href="<?php echo URL.'clubs/deleteOneStudentScore/'.$rows[$i]['score_id']; ?>" >Del</a></span>
	</td>
</tr>
<?php endfor; ?>

<tr><th colspan=4 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>

</form>


<script>

var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	hd();
	$('#hdpdiv').hide();	
	nextViaEnter();
	selectFocused();
})

</script>
