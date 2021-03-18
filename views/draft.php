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
	var url = gurl+'/rosters/draft/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 

// pr($data);


if($subject_is_student){ 
	extract($student);
	// $promcrid=$student['promcrid']; 
	// $promlvl=$student['promlvl']; 
}

// pr($student);

?>

<h3>
	Roster Draft SY<?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>
	| <a href="<?php echo URL.'students/register'; ?>" >Register</a>
	| <a href="<?php echo URL.'students/leveler/'.$scid; ?>" >Leveler</a>
	| <a href="<?php echo URL.'students/enrollment/'.$scid; ?>" >Enrollment</a>
	
	
</h3>

<?php if($scid): ?>
<table class="gis-table-bordered" >
<tr>
	<td><?php echo $student['scid']; ?></td>
	<td><?php echo $student['code']; ?></td>
	<td><?php echo $student['birthdate']; ?></td>
	<td><?php echo $student['name']; ?></td>
</tr>
</table>
<?php endif; ?>


<p class="brown" >
	Notes:<br />
	
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
<tr><th>SY <?php echo ($sy-1); ?></th><th><?php echo $student['prevclassroom']; ?></th></tr>
<tr>
	<th>SY <?php echo $sy; ?></th>
	<td>
		<select name="student[crid]" >
			<?php foreach($curr_classrooms AS $sel): ?>
				<option value="<?php echo $sel['crid']; ?>" <?php echo ($sel['crid']==$currcrid)? 'selected':NULL; ?> >
					<?php echo $sel['classroom'].' #'.$sel['crid']; ?>
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

