<h5>
	Courses Config (<?php echo $count; ?>)
	<a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'loads/cls/'.$crid; ?>" >MIS-Cfg</a>
	<?php endif; ?>
	
</h5>

<table class="gis-table-bordered"  >
<tr><th class="headrow" >Classroom</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
</table>


<br />
<form method="POST"  >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>ID</th>
	<th>Course</th>
	<th>Label</th>
	<th>Ref</th>
	<th>Pos</th>
	<th>Indent</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<input type="hidden" name="crs[<?php echo $i; ?>][course_id]" value="<?php echo $courses[$i]['course_id']; ?>" />
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $courses[$i]['course_id']; ?></td>
	<td><?php echo $courses[$i]['name']; ?></td>
	<td><input class="vc200 pdl05" name="crs[<?php echo $i; ?>][label]" value="<?php echo $courses[$i]['label']; ?>" /></td>
	<td><?php echo $courses[$i]['subject_position']; ?></td>
	<td><input tabindex="<?php echo $i+1; ?>" class="vc50 center" 
		name="crs[<?php echo $i; ?>][position]" value="<?php echo $courses[$i]['position']; ?>" /></td>
	<td><input class="vc50 center" name="crs[<?php echo $i; ?>][indent]" value="<?php echo $courses[$i]['indent']; ?>" /></td>
</tr>
<?php endfor; ?>
</table>



<p>
	<input onclick="return confirm('Are you sure?');" type="submit" name="submit" value="Submit" />
	<button><a class="txt-black no-underline" href='<?php  ?>' >Cancel</a></button>
</p>


<!-------------------------------------------------------------------->

<script>

var gurl 	= 'http://<?php echo GURL; ?>';



$(function(){
	nextViaEnter();
	selectFocused();

})



</script>


