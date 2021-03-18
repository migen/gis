<h5>
	Courses Config <?php echo $level['name']; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="pclass('btn');" >Btn</span>
	| <span onclick="pclass('purgespan');" >Purge</span>



</h5>

<?php 

// pr($subjects[0]);

$headrow="<tr><th colspan=5></th><th>Ctype</th><th>W/S</th><th>Rpt</th><th>Num</th><th>Disp</th><th>InGA</th><th>Wt</th><th>Prnt</th><th>Aggr</th><th>Pos</th><th>Indt</th><th>Sem</th><th class='btn'></th></tr>";

?>


<?php if(isset($_GET['debug'])){ pr($q); } ?>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."courses/config/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>

<form method="POST" >
<?php include_once('incs/level_checkboxes.php'); ?>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>#</th>
	<th>Sub</th>
	<th>Code</th>
	<th>Label</th>
	<th>Ctype
		<br /><input class="pdl05 vc30" id="ictype" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('ctype');" >						
	</th>
	<th>W/S
		<br /><input class="pdl05 vc30" id="iws" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('ws');" >						
	</th>
	<th>Rpts
		<br /><input class="pdl05 vc30" id="irpts" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('rpts');" >						
	</th>	
	<th>Num
		<br /><input class="pdl05 vc30" id="inum" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('num');" >						
	</th>
	<th>Disp
		<br /><input class="pdl05 vc30" id="idisp" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('disp');" >						
	</th>		
	<th>InGA
		<br /><input class="pdl05 vc30" id="iinga" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('inga');" >						
	</th>	
	<th>Wt
		<br /><input class="pdl05 vc50" id="iwt" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('wt');" >							
	</th>
	<th>Sup<br />Sub
		<br /><input class="pdl05 vc50" id="isupsub" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('supsub');" >							
	</th>
	<th>Aggre
		<br /><input class="pdl05 vc30" id="iaggre" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('aggre');" >							
	</th>
	<th>Pos
		<br /><input class="pdl05 vc50" id="ipos" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('pos');" >								
	</th>
	<th>Indent
		<br /><input class="pdl05 vc50" id="iindent" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('indent');" >								
	</th>
	
	<th>Sem
		<br /><input class="pdl05 vc30" id="isem" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('sem');" >								
	</th>
	
	<th class="btn" >Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><input type="checkbox" class="chka" name="posts[<?php echo $i; ?>][is_checked]" value="1" /></td>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][subject_id]" 
		value="<?php echo $subjects[$i]['subject_id']; ?>" readonly /></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][code]" tabindex="1"
		value="<?php echo (isset($subjects[$i]['crscode']))? $subjects[$i]['crscode']: $subjects[$i]['subcode']; ?>" /></td>
	<td><input class="vc250" name="posts[<?php echo $i; ?>][label]" tabindex="3"
		value="<?php echo (isset($subjects[$i]['crslabel']))? $subjects[$i]['crslabel']: $subjects[$i]['sublabel']; ?>" /></td>
	<td class="colshading" ><input class="vc30 ctype" name="posts[<?php echo $i; ?>][crstype_id]" tabindex="4"
		value="<?php echo (isset($subjects[$i]['crsctype']))? $subjects[$i]['crsctype']: $subjects[$i]['subctype']; ?>" /></td>
	<td class="colshading" ><input class="vc30 ws" name="posts[<?php echo $i; ?>][with_scores]" tabindex="6"
		value="<?php echo (isset($subjects[$i]['crsws']))? $subjects[$i]['crsws']: $subjects[$i]['subws']; ?>" /></td>		
	<td class="colshading" ><input class="vc30 rpts" name="posts[<?php echo $i; ?>][on_reports]" tabindex="7"
		value="<?php echo (isset($subjects[$i]['crsrpts']))? $subjects[$i]['crsrpts']: $subjects[$i]['crsrpts']; ?>" /></td>
	<td class="colshading" ><input class="vc30 num" name="posts[<?php echo $i; ?>][is_num]" tabindex="9"
		value="<?php echo (isset($subjects[$i]['crsnum']))? $subjects[$i]['crsnum']: $subjects[$i]['subnum']; ?>" /></td>
	<td class="colshading" ><input class="vc30 idisp" name="posts[<?php echo $i; ?>][is_displayed]" tabindex="13"
		value="<?php echo (isset($subjects[$i]['crsdisp']))? $subjects[$i]['crsdisp']: $subjects[$i]['subdisp']; ?>" /></td>	
	<td class="colshading" ><input class="vc30 inga" name="posts[<?php echo $i; ?>][in_genave]" tabindex="13"
		value="<?php echo (isset($subjects[$i]['crsinga']))? $subjects[$i]['crsinga']: $subjects[$i]['subinga']; ?>" /></td>	
		
	<td class="colshading" ><input class="vc30 wt" name="posts[<?php echo $i; ?>][weight]" tabindex="8"
		value="<?php echo (isset($subjects[$i]['crswt']))? $subjects[$i]['crswt']: $subjects[$i]['subwt']; ?>" /></td>
		
	<td class="colshading" ><input class="vc50 supsub" name="posts[<?php echo $i; ?>][supsubject_id]" tabindex="9"
		value="<?php echo (isset($subjects[$i]['crssupsub']))? $subjects[$i]['crssupsub']: $subjects[$i]['subprid']; ?>" /></td>

	<td class="colshading" ><input class="vc30 aggre" name="posts[<?php echo $i; ?>][is_aggregate]" tabindex="10"
		value="<?php echo (isset($subjects[$i]['crsaggre']))? $subjects[$i]['crsaggre']: $subjects[$i]['subaggre']; ?>" /></td>	

	<td class="colshading" ><input class="vc50 pos" name="posts[<?php echo $i; ?>][position]" tabindex="11"
		value="<?php echo (isset($subjects[$i]['crspos']))? $subjects[$i]['crspos']: $subjects[$i]['subpos']; ?>" /></td>		

	<td class="colshading" ><input class="vc50 indent" name="posts[<?php echo $i; ?>][indent]" tabindex="12"
		value="<?php echo (isset($subjects[$i]['crsindent']))? $subjects[$i]['crsindent']: $subjects[$i]['subindent']; ?>" /></td>		
		
	<td class="colshading" ><input class="vc50 sem" name="posts[<?php echo $i; ?>][semester]" tabindex="13"
		value="<?php echo (isset($subjects[$i]['crssem']))? $subjects[$i]['crssem']: $subjects[$i]['subsem']; ?>" /></td>		
		
	<td class="btn" ><a href="<?php echo URL.'purge/levelCourses?lvl='.$lvl.'&sub='.$subjects[$i]['subject_id']; ?>" 
		class="" onclick="return confirm('Dangerous! Sure?');" >PurgeLC</a></td>
</tr>
<?php endfor; ?>
<?php 
echo $headrow;
?>
</table>

<p class="btn" >
<input type="submit" name="submit" value="Propagate" onclick="return confirm('Sure?');"  />

<button id="purgebtn" onclick="showpurge('purgespan');return false;" >Show Purge</button>

<span class="purgespan" >
	<input type="submit" name="purge" value="Purge Courses" onclick="return confirm('Dangerous!Sure?');"  />
</span>

<hr />
<h4>Create Courses (Enter CSV - Subject IDs)
<a href='<?php echo URL."courses/config/$lvl?subjects"; ?>' >Load Subjects</a>
</h4>
<input name="subs" value="" />
<input type="submit" name="create" value="Create"  />
</p>
</form>

<?php if(isset($_GET['subjects'])): ?>
<table class="gis-table-bordered" >
<tr><th>ID</th><th>Code</th><th></th></tr>
<?php foreach($allsubjects AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<script>

var gurl = "http://<?php echo HOST.'/'.DOMAIN; ?>";
			
$(function(){
	chkAllvar('a');
	hd();
	$(".btn").hide();
	itago('purgespan');
	selectFocused();
	nextViaEnter();
	columnHighlighting();
	
	
})

function showpurge(){
	$('#purgebtn').hide();
	ilabas('purgespan');
}	/* fxn */



</script>


