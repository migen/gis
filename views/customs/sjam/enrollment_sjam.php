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
	var url = gurl+'/students/enrollment/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 

if($subject_is_student){ $promlvl=$student['promlvl']; }

?>

<h3>
	SJAM Enrollment | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>
	| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>" >Sectioner</a>
	
	
	
</h3>

<?php if($scid): ?>
<table class="gis-table-bordered" >
<tr>
	<td><?php echo $studrow['scid']; ?></td>
	<td><?php echo $studrow['birthdate']; ?></td>
	<td><?php echo $studrow['code']; ?></td>
	<td><?php echo $studrow['name']; ?></td>
</tr>
</table>
<?php endif; ?>



<p class="brown" >
	Notes:<br />
	1. Paymode id - Type number only. (1 for yearly, 2 for semestral, 3 for monthly, 4 for quarterly) <br />
	
</p>

<style>

.divleft{ float:left;width:40%; border:1px solid white; }


</style>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<?php if(!isset($params) && ($srid!=RSTUD)){ exit; } ?>
<?php endif; ?>

<?php if($subject_is_student): ?>
<form method="POST" >

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
			<input name="student[<?php echo $key; ?>]" value="<?php echo $value; ?>" 
				<?php echo ($key=='name')? 'readonly':NULL; ?> >
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

<?php endif; ?>	<!-- subject_is_student -->

