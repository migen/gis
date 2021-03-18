<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';


$(function(){
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	
})

function redirContact(ucid){
	var url = gurl+'/students/datasheet/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 

// pr($data);
// exit;

pr($student);

// foreach($student AS $k=>$v){
	// pr("k: $k | v:$v");
	
// }

// exit;

$promlvl=$student['promlvl'];

?>

<h3>
	SJAM Datasheet | <?php $this->shovel('homelinks'); ?>
	
	
</h3>

<p class="brown" >
	Notes:<br />
	1. Paymode id - Type number only. (1 for yearly, 2 for semestral, 3 for monthly, 4 for quarterly) <br />
	2. Birthdate - follow strict format: 2010-12-25 (i.e. Dec 25, 2010) <br />
	3. Save "Profile" and "Student" separately, double check date are correctly saved before leaving.
	
</p>

<style>

.divleft{ float:left;width:40%; border:1px solid white; }


</style>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<?php if(!isset($params) && ($srid!=RSTUD)){ exit; } ?>
<?php endif; ?>

<form method="POST" >
<div class="divleft" >
<table class="gis-table-bordered" >
<tr><th colspan=2>Profile Master Data</th></tr>
<?php for($i=0;$i<$profiles_count;$i++): ?>
	<?php 
		$key=$profiles_cols[$i];
		$label=ucfirst($key);
		$label=str_replace("_"," ",$label);
	
	?>
	<tr><th><?php echo $label; ?></th><td>
		<?php if(in_array($key,$text_array)): ?>
			<textarea cols=30 rows=5 name="profile[<?php echo $key; ?>]" ><?php echo $profile[$key]; ?></textarea>
		<?php else: ?>
			<input name="profile[<?php echo $key; ?>]" value="<?php echo $profile[$key]; ?>" >
		<?php endif; ?>					
	</td></tr>
<?php endfor; ?>
<tr><td colspan=2>Save &nbsp; <input type="submit" name="submit" value="Profile"  ></td></tr>
</table>

<div class="ht100" >&nbsp;</div>

</div>

<!-- right -->

<div class="divleft" >
<table class="gis-table-bordered" >
<tr><th colspan=2>Student Enrollment Data</th></tr>
<?php foreach($student AS $key=>$value): ?>
	<?php 
		if(($key=='promlvl') || ($key=='prevlevel')){ continue; } 
		$label=ucfirst($key);
		$label=str_replace("_"," ",$label);
	?>
	<tr><th><?php echo $label; ?></th><td>
		<?php if(in_array($key,$text_array)): ?>
			<textarea cols=30 rows=5 name="student[<?php echo $key; ?>]" ><?php echo $value; ?></textarea>
		<?php else: ?>
			<input name="student[<?php echo $key; ?>]" value="<?php echo $value; ?>" >
		<?php endif; ?>					
	</td></tr>
<?php endforeach; ?>
<tr><th>Last SY Level</th><th><?php echo $student['prevlevel']; ?></th></tr>
<tr>
	<th>Current <?php echo $sy; ?> Level</th>
	<td>
		<select name="student[crid]" >
			<?php foreach($tmp_classrooms AS $sel): ?>
				<option value="<?php echo $sel['crid']; ?>" <?php echo ($sel['lvl']==$promlvl)? 'selected':NULL; ?> >
					<?php echo $sel['level']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>
<tr><td colspan=2>Save &nbsp; <input type="submit" name="submit_student" value="Student"  ></td></tr>
</table>

<div class="ht100" >&nbsp;</div>

</div>


</form>


