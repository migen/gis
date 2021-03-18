<?php 

// pr($data);
	
	$dbcontacts="{$dbo}.00_contacts";
	$dbclassrooms="{$dbg}.05_classrooms";


?>

<h3>
	MIS Roster Drafter SY<?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>
	| <a href="<?php echo URL.'contacts/ucis/'.$scid; ?>" >UCIS</a>
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



<style>

.divleft{ float:left;width:40%; border:1px solid white; }


</style>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,limits);return false;' />		
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,limits);return false;' />
	</td></tr>
</table></p>

<div id="names" >names</div>

<?php if($scid): ?>

	<form method="POST" >
	<div class="divleft" >
		<table class="gis-table-bordered" >
			<tr><th colspan=2>Student Enrollment Data</th></tr>
			<tr><th>Scid</th><td><?php echo $student['scid']; ?>
			<tr><th>U|P</th><td><?php echo $student['ucid'].' | '.$student['pcid']; ?>
				<input type="hidden" id="scid-0" name="post[scid]" value="<?php echo $student['scid']; ?>" >
			</td></tr>
			<tr><th>Status</th><td>
					<?php echo ($student['is_active']==1)? 'Active':'NOT Active'; ?>
					| <?php echo ($student['is_cleared']==1)? 'Cleared':'NOT Cleared'; ?>
				</td>
			</tr>
			<tr><th>ID No.</th><td><?php echo $student['code']; ?></td></tr>
			<tr><th>Student</th><td><?php echo $student['name']; ?></td></tr>
			<tr><th>Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
			<tr><th>Prevcrid</th><td><input id="prevcrid-0" name="post[prevcrid]" value="<?php echo $student['prevcrid']; ?>" ></td></tr>
			<tr><th>Crid</th><td><input id="crid-0" name="post[crid]" value="<?php echo $student['crid']; ?>" ></td></tr>
			<tr><td colspan=2><input type="submit" name="submit" value="Save"  ></td></tr>
		</table>

	<div class="ht100" >&nbsp;</div>
	</div>
	</form>
<?php endif; ?>	<!-- scid -->

<script>

const dbcontacts = "<?php echo $dbcontacts; ?>";
const dbclassrooms = "<?php echo $dbclassrooms; ?>";
const gurl = "http://<?php echo GURL; ?>";
const sy = "<?php echo $sy; ?>";
const limits='20';


$(function(){
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/rosters/drafter/'+ucid;	
	window.location = url;		
}



function axnFilter(id){
	var url=gurl+"/rosters/drafter/"+id+"/"+sy;
	window.location=url;
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
