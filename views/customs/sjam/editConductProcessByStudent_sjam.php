
<?php 

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	
	// pr($post);
	
	foreach($post AS $i => $item){
		if($item==''){
			$post[$i]=0;
		}
	}
		
	extract($post);
	

	$q="";
	$q.="UPDATE {$dbg}.50_grades SET q{$qtr}=$conduct,dg{$qtr}='$conduct_dg' WHERE id=$gid LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_summaries SET conduct_q{$qtr}=$conduct,conduct_dg{$qtr}='$conduct_dg' WHERE scid=$scid LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_summext SET skip_q{$qtr}=$skip WHERE scid=$scid LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_attendance SET q{$qtr}_days_present=$present,q{$qtr}_days_tardy=$tardy 
		WHERE scid=$scid LIMIT 1; ";
	$q.="UPDATE {$dbg}.50_offenses_sjam SET q{$qtr}_major_a=$major_a,q{$qtr}_major_b=$major_b,
		q{$qtr}_minor=$minor WHERE scid=$scid LIMIT 1; ";	



	$q.="UPDATE {$dbg}.05_awardees SET `is_conduct_awardee_q{$qtr}` = $is_awardee WHERE `scid`=$scid LIMIT 1;  ";						
		
	// prx($q1);	
		
	$sth=$db->query($q);
	$msg = ($sth)? "Update success":"Update fail";
	
	// pr($post);
	// prx($q);
	
	$url="conducts/editConductProcessByStudent/$scid";
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




?>

<h3>
	SJAM - Adviser's Corner
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' >Records</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."rosters/drafter/$scid/$sy"; ?>' >Drafter</a>	
	<?php endif; ?>
	
	
</h3>


<?php

// prx($data);
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

// echo (empty($row))? "empty":"has something";
// echo '-grade';pr($row);


$student=array_merge($student,$row);


// 3
$q="SELECT q{$qtr}_days_total AS days_total
FROM {$dbg}.05_attendance_months WHERE level_id=$lvl LIMIT 1;";
$sth=$db->querysoc($q);
$row=$sth->fetch();
extract($row);

// echo (empty($row))? "empty":"has something";
// echo '-attmos';pr($row);


// 4
$q="SELECT q{$qtr}_days_present AS present,q{$qtr}_days_tardy AS tardy
	FROM {$dbg}.05_attendance WHERE scid=$scid LIMIT 1;";
debug($q);
$sth=$db->querysoc($q);
$row=$sth->fetch();

// echo (empty($row))? "empty":"has something";
// echo '-attd';pr($row);


$student=array_merge($student,$row);

function getOffense($db,$dbg,$qtr,$scid){
	$q="SELECT 
			q{$qtr}_major_a AS major_a,
			q{$qtr}_major_b AS major_b,
			q{$qtr}_minor AS minor
		FROM {$dbg}.50_offenses_sjam WHERE scid=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
}	/* fxn */

$row=getOffense($db,$dbg,$qtr,$scid);

$row=(empty($row))? []:$row;
// echo (empty($row))? "empty":"has something";
// echo '-offense';pr($row);

if(empty($row)){
	$q="INSERT INTO {$dbg}.50_offenses_sjam(scid)VALUES($scid);";
	$db->query($q);
	$row=getOffense($db,$dbg,$qtr,$scid);	
}


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
		<tr><th>Days Total</th><td><?php echo $days_total; ?></td></tr>
		<tr><th>Conduct</th><td><input name="post[conduct]" value="<?php echo $student['gr_conduct']; ?>" ></td></tr>
		<tr><th>Conduct DG</th><td><input name="post[conduct_dg]" value="<?php echo $student['gr_conduct_dg']; ?>" ></td></tr>
		<tr><th>Present</th><td><input name="post[present]" value="<?php echo $student['present']; ?>" ></td></tr>
		<tr><th>Tardy</th><td><input name="post[tardy]" value="<?php echo $student['tardy']; ?>" ></td></tr>
		<tr><th>Major A</th><td><input name="post[major_a]" value="<?php echo $student['major_a']; ?>" ></td></tr>
		<tr><th>Major B</th><td><input name="post[major_b]" value="<?php echo $student['major_b']; ?>" ></td></tr>
		<tr><th>Minor</th><td><input name="post[minor]" value="<?php echo $student['minor']; ?>" ></td></tr>
		<tr><th>Is Awardee</th><td><input name="post[is_awardee]" value="<?php echo $student['is_awardee']; ?>" ></td></tr>
		<tr><th>Skip</th><td><input name="post[skip]" value="<?php echo $student['skip']; ?>" ></td></tr>
		<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>
		<input type="hidden" name="post[scid]" value="<?php echo $scid; ?>"  >
		<input type="hidden" name="post[gid]" value="<?php echo $student['gid']; ?>"  >

	</table>
</form>


<script>

$(function(){
	selectFocused();
	nextViaEnter();
	
})


</script>
