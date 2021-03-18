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
	var url = gurl+'/students/leveler/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 

if($subject_is_student){ $promlvl=$student['promlvl']; }

// pr($paymodes);
// pr($student);
// pr($tmp_classrooms[3]);

?>

<h3>
	GIS Leveler SY <?php echo $sy.' - '.($sy+1); ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>
	| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>" >Sectioner</a>
	| <a href="<?php echo URL.'enrollment/ledger/'.$scid.DS.$sy; ?>" >Ledger</a>
	
	
	
</h3>

<?php if($subject_is_student): ?>
<table class="gis-table-bordered" >
<tr>
	<td><?php echo $studrow['scid']; ?></td>
	<td><?php echo $studrow['birthdate']; ?></td>
	<td><?php echo $studrow['code']; ?></td>
	<td><?php echo $studrow['name']; ?></td>
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
<tr><th>ID No.</th><td><?php echo $student['code']; ?></td></tr>
<tr><th>Student</th><td><?php echo $student['name']; ?></td></tr>

<?php 
pr($student);
?>

<?php foreach($student AS $key=>$value): ?>
	<?php 
		pr("k: $key");
		pr("v: $value");
		if(($key=='name') || ($key=='code')){ continue; } 
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
	<th>Current SY<?php echo $sy; ?></th>
	<td>
		<select name="student[crid]" >
			<?php foreach($tmp_classrooms AS $sel): ?>
				<option value="<?php echo $sel['crid']; ?>" <?php echo ($sel['lvl']==$promlvl)? 'selected':NULL; ?> >
					<?php echo $sel['level']; debug(' - #'.$sel['crid']); ?>
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

