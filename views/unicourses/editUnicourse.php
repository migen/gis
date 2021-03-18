<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/timepicker/timepicker.css" />

<?php 

$dbcontacts=PDBO.".`00_contacts`";


?>

<h5>
	Edit Course | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'unicourses'; ?>" >Courses</a>
	| <a href="<?php echo URL.'unischedules/upsched'; ?>" >Upsched</a>
	<?php if(!isset($_GET['get'])): ?>
		| <a href="<?php echo URL.'unicourses/edit/'.$crs.'&get'; ?>" >GET</a>
	<?php endif; ?>

</h5>

<?php 
	$getname=$row['crcode'].'-'.$row['subcode'];
?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Subject</th><td><?php echo $row['subject']; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
<tr><th><span class="b" >Teacher ID</span> 
	<input id="id" class="pdl05 vc60" readonly name="post[tcid]" value="<?php echo $row['tcid']; ?>" ></th>
<th><input class="pdl05" id="part" value="<?php echo $row['teacher']; ?>"  /> </th></tr>
<tr><th></th><td colspan= ><input type="submit" class="vc150" value="Teachers" onclick="xgetContactsByPart(limits);return false;" /></td></tr>

<tr><td>W/ Scores <input class="vc50" name="post[with_scores]" value="<?php echo $row['with_scores']; ?>" ></td>
<td>In Genave <input class="vc50" name="post[in_genave]" value="<?php echo $row['in_genave']; ?>" ></td></tr>

<tr><td>Is Numeric <input class="vc50" name="post[is_numeric]" value="<?php echo $row['is_numeric']; ?>" ></td>
<td>Position &nbsp;&nbsp;&nbsp; <input class="vc50" name="post[position]" value="<?php echo $row['position']; ?>" ></td></tr>


<tr><th>Level &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="vc50" name="post[level_id]" type="number" 
value="<?php echo $row['level_id']; ?>" ></th><th>Semester &nbsp;<input class="vc50" name="post[semester]" 
value="<?php echo $row['semester']; ?>" ></th></tr>


<tr><th>Room</th><td><input name="post[room]" value="<?php echo $row['room']; ?>" ></td></tr>
<tr><th>Days</th><td>
	<select class="full" name="post[days]" >
	<option value="" >Select One</option>
	<?php foreach($unidays AS $sel): ?>
		<option value="<?php echo $sel['code']; ?>" <?php echo ($sel['code']==$row['days'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
	</select>
</td></tr>
<tr><th colspan=2>24-hour format</th></tr>
<tr><th>Start <input class="pdl05 timepicker vc100" name="post[time_start]" value="<?php echo $row['time_start']; ?>" ></th>
	<th>End <input class="pdl05 vc100" name="post[time_end]" value="<?php echo $row['time_end']; ?>" ></th></tr>


<tr><th>Schedule | <a href="<?php echo URL.'unischedules/crs/'.$row['id']; ?>" >Edit</a></th>
	<td><?php echo $row['schedule']; ?></td></tr>




<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>


<div class="hd" id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;

$(function(){
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });
	// $('input.timepicker').timepicker({});
	// $(".juice").datepicker({ dateFormat:"yy-mm-dd" });


	
})




function axnFilter(id){
	$("#id").val(id);
	// selectFocused();
	
}	/* fxn */


function redirContact(id){
	$("#id").val(id);

}



</script>


<script type="text/javascript" src='<?php echo URL."public/timepicker/timepicker.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

