<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var scid = "<?php echo $scid; ?>";
var limits='20';


$(function(){
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	
})

function redirContact(ucid){
	var url = gurl+'/students/leveler/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 

if($subject_is_student){ $promlvl=$student['promlvl']; }

// pr($paymodes);
// pr($student);
// pr($tmp_classrooms[11]);

?>

<?php 
extract($student);
// pr($student); 

?>


<h3>
	GIS Leveler SY 
	<select class="f20" onchange="jsredirect(`students/leveler/${scid}/${this.value}`)" >
		<option value="<?php echo DBYR; ?>" 
			<?php echo ($sy==(DBYR))? 'selected':NULL; ?>
		><?php echo DBYR; ?></option>
		<?php if($_SESSION['settings']['sy_enrollment']>DBYR): ?>
			<option value="<?php echo (DBYR+1); ?>" 
				<?php echo ($sy==(DBYR+1))? 'selected':NULL; ?>
			><?php echo (DBYR+1); ?></option>
		
		<?php endif; ?>
	</select>
	
	| <?php $this->shovel('homelinks'); ?>

	
	| <a href="<?php echo URL.'students/register'; ?>" >Register</a>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>
	| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>" >Sectioner</a>
	| <a href="<?php echo URL.'enrollment/ledger/'.$scid.DS.$sy; ?>" >Ledger</a>
	<?php if($srid==RMIS): ?>
		| <a href="<?php echo URL.'rosters/drafter/'.$scid; ?>" >Drafter</a>
	<?php endif; ?>
	
	
	
</h3>

<?php if($subject_is_student): ?>
<table class="gis-table-bordered" >
<tr>
	<td><?php echo $student['scid']; ?></td>
	<td><?php echo $student['code']; ?></td>
	<td><?php echo $student['birthdate']; ?></td>
	<td><?php echo $student['name']; ?></td>
</tr>
</table>
<?php endif; ?>




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
<tr><th class="vc100" >ID No.</th><td class="vc200" ><?php echo $student['code']; ?></td></tr>
<tr><th>Student</th><td><?php echo $student['name']; ?></td></tr>
<tr><th>SY <?php echo $prevsy; ?></th><th><?php echo $student['prevclassroom']; ?></th></tr>
<tr>
	<th>SY <?php echo $sy; ?></th>
	<td>
		<select name="student[crid]" >
			<option value=0>Choose Level</option>
			<?php foreach($tmp_classrooms AS $sel): ?>
				<option value="<?php echo $sel['crid']; ?>" <?php echo ($sel['lvl']==$currlvl)? 'selected':NULL; ?> >
					<?php echo $sel['level']; echo ($sel['num']!=1)? " EC-".$sel['num']:null; debug(' - #'.$sel['crid']); ?>
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

