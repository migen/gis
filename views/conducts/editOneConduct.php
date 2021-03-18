<?php 

	$dbcontacts="{$dbo}.00_contacts";
	


?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID / Name</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>

<div id="names" >names</div>



<?php if($scid): ?>


<!-------------------->

<?php 

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	extract($post);
	
	$q="";
	$q.="UPDATE {$dbg}.50_grades SET q{$qtr}=$conduct,dg{$qtr}='$conduct_dg' WHERE id=$gid LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_summaries SET conduct_q{$qtr}=$conduct,conduct_dg{$qtr}='$conduct_dg' WHERE scid=$scid LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_summext SET skip_q{$qtr}=$skip WHERE scid=$scid LIMIT 1; ";
	$sth=$db->query($q);
	$msg = ($sth)? "Update success":"Update fail";
	
	$url="conducts/editOne/$scid";
	flashRedirect($url,$msg);
	
	
	
}	/* post */

// 2
$q="SELECT sumx.scid AS sumxscid,sumx.skip_q{$qtr} AS skip,
		summ.scid,summ.conduct_q{$qtr} AS summ_conduct,conduct_dg{$qtr} AS summ_conduct_dg,
		summ.crid,cr.name AS classroom,cr.level_id AS lvl
	FROM {$dbg}.05_summaries AS summ 
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
	INNER JOIN {$dbg}.05_summext AS sumx ON summ.scid=sumx.scid 
	WHERE summ.scid=$scid LIMIT 1; ";
debug($q);
$sth=$db->querysoc($q);
$summrow=$sth->fetch();
$lvl=$summrow['lvl'];
$crid=$summrow['crid'];
$student=array_merge($student,$summrow);



extract($student);

?>

<h3>
	STD - One Student's Conduct
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."conducts/records/$crid/$sy/$qtr"; ?>' >Class Conducts</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."rosters/drafter/$scid/$sy"; ?>' >Drafter</a>	
	<?php endif; ?>
		| <a href='<?php echo URL."summarizers/student/$scid/$sy/$qtr"; ?>' >Summarizer</a>	
<?php 
	$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'Qtr':'';
?>		
	| <a href='<?php echo URL."attendance/student{$attdlink}/$scid/$sy/$qtr"; ?>' >Attendance</a>	
<?php if($_SESSION['srid']==RMIS): ?>
	| <a href='<?php echo URL."registrars/editStudentGrades/$scid/$sy"; ?>' >Grades</a>	
	| <a href='<?php echo URL."gtools/msg/$scid/$sy/$qtr"; ?>' >MSG</a>	
<?php endif; ?>	
		
</h3>


<?php


$crid=$student['crid'];

// 2-2 conduct grade
$q="SELECT id AS gid,q{$qtr} AS gr_conduct,dg{$qtr} AS gr_conduct_dg
FROM {$dbg}.50_grades WHERE scid=$scid AND crstype_id=".CTYPECONDUCT." LIMIT 1;";



$q="SELECT g.id AS gid,g.q{$qtr} AS gr_conduct,g.dg{$qtr} AS gr_conduct_dg,crs.name AS course
FROM {$dbg}.05_summaries AS summ
INNER JOIN {$dbg}.50_grades AS g ON summ.scid=g.scid
INNER JOIN {$dbg}.05_courses AS crs  ON g.course_id=crs.id
WHERE crs.crid=$crid AND g.scid=$scid AND g.crstype_id=".CTYPECONDUCT." LIMIT 10;";

$sth=$db->querysoc($q);
$row=$sth->fetch();
extract($row);

$student=array_merge($student,$row);



debug($student);
// pr($student);






?>

<form method="POST" >


	<table class="gis-table-bordered table-altrow table-fx" >
		<tr><th>Scid</th><td><?php echo $student['scid']; ?></td></tr>
		<tr><th>Classroom</th><td><?php echo '#'.$student['crid'].' - '.$student['classroom']; ?></td></tr>
		<tr><th>ID No.</th><td><?php echo $student['studcode']; ?></td></tr>
		<tr><th>Student</th><td><?php echo $student['studname']; ?></td></tr>
		<tr><th>Conduct</th><td><input name="post[conduct]" value="<?php echo $student['gr_conduct']; ?>" ></td></tr>
		<tr><th>Conduct DG</th><td><input name="post[conduct_dg]" value="<?php echo $student['gr_conduct_dg']; ?>" ></td></tr>
		<tr><th>Skip</th><td><input name="post[skip]" value="<?php echo $student['skip']; ?>" ></td></tr>
		<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>
		<input type="hidden" name="post[scid]" value="<?php echo $scid; ?>"  >
		<input type="hidden" name="post[gid]" value="<?php echo $student['gid']; ?>"  >

	</table>
</form>


<?php endif; ?>	<!-- student -->





<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var qtr = "<?php echo $qtr; ?>";
const dbcontacts = "<?php echo $dbcontacts; ?>";


$(function(){
	selectFocused();
	nextViaEnter();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})


function axnFilter(id){
	var url=gurl+"/conducts/editOne/"+id+"/"+sy+"/"+qtr;
	window.location=url;
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
