<?php 


// pr($_SESSION['q']);
$dbg=PDBG;
$dbtable="{$dbg}.01_schedules";
$dbcourses="{$dbg}.01_courses";



?>

<h5>
	College Course Schedule | <?php $this->shovel("homelinks"); ?>
	| <span class="u" onclick="traceshd();" >ID</span>
	
	
</h5>

<?php 
// pr($course);
?>

<table class="gis-table-bordered" >
	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" value="" autofocus />
			<input type="submit" class="vc150" value="Find Course" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" />
		</td>
	</tr>	
</table><br />

<div class="shd" id="names">names</div>

<?php if($crs): ?>


<table class="gis-table-bordered table-altrow" >
<th><?php echo $course['name'].' #'.$course['id']; ?></th>
</table><br />

<table class="gis-table-bordered table-altrow">
<tr>
	<th>#</th>
	<th class="shd" >ID</th>
	<th>Day</th>
	<th>Time</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['sid']; ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php echo $id; ?></td>
	<td><?php echo $rows[$i]['day']; ?></td>
	<td><?php echo $rows[$i]['time']; ?></td>
	<td><button onclick="confirmXdelrow(dbtable,<?php echo $id.','.$i; ?>);" >Drop</button></td>
</tr>
<?php endfor; ?>
</table><br />


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th><select name="post[day_id]" >
	<option value=0>Select One</option>
	<?php foreach($days AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select></th>
<th><select name="post[time_id]" >
	<option value=0>Select One</option>
	<?php foreach($times AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select></th>
<th><input type="submit" name="submit" value="Add" ></th>
<input type="hidden" name="post[course_id]" value="<?php echo $crs; ?>" >
</tr>
</table>
</form>


<?php endif; ?>		<!-- crs -->

<script>

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";
var limits=30;

$(function(){
	shd();
	// alert(dbtable);
	
})

function axnFilter(id){
	var url=gurl+"/unischedules/crs/"+id;
	window.location=url;	
}	/* fxn */


</script>

<script type="text/javascript" src='<?php echo URL."views/js/confirm_xdelrow.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>
