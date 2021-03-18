
<?php



/* FXNS */
/* 1 */
function getCutoffArray($dept=NULL){	/* sub=subcrs,min=anycrs */
	$cutarr['1st']=98;$cutarr['2nd']=95;$cutarr['3rd']=87;
	$cutarr['conduct']=90;
	$cutarr['pri']=90;$cutarr['sub']=85;$cutarr['min']=85;		
	return $cutarr;
}	/* fxn */

/* 2 */
function getHonorsStudents($db,$dbg,$crid,$qtr,$fields="c.id",$cond,$order="genave DESC"){	
	$dbo=PDBO;
	$order=(empty($order))? $_SESSION['settings']['classlist_order']:$order;
	$q="SELECT $fields,summ.scid,c.code AS studcode,c.name AS student,
			sx.`honor_q{$qtr}` AS `dbhonor`,sx.`honor_dg{$qtr}` AS `dghonor`
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_summext AS sx ON sx.scid=summ.scid
		WHERE summ.crid='$crid' $cond ORDER BY $order;";
	// pr($q);
	debug($q,"getHonorsStudents");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

/* 3 */
function honorsSubjects($db,$dbg,$crid,$fields="crs.id",$filter=NULL,$sem=0){
$dbo=PDBO;	
$condsem=($sem>0)? "AND (crs.semester=$sem || crs.semester=0 )":NULL;
$q = "SELECT $fields,crs.id AS crs,crs.name AS course
	FROM  {$dbg}.05_classrooms AS cr 	
		LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid=cr.id
		LEFT JOIN  {$dbo}.`00_contacts` AS teac ON crs.tcid=teac.id
	WHERE cr.id='$crid' AND crs.crstype_id='".CTYPEACAD."' AND crs.`is_active`=1 $filter $condsem
	ORDER by crs.`position`,crs.`id`; ";
	debug($q,"honorsSubjects");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

/* 4 */
function getNumberOfCourses($db,$dbg,$crid,$cond=NULL,$sem=0){
	$condsem=($sem>0)? "AND (crs.semester=$sem || crs.semester=0 )":NULL;
	$q=" SELECT COUNT(crs.id) AS num
		FROM  {$dbg}.05_classrooms AS cr 	
			LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid=cr.id
		WHERE cr.id='$crid' AND crs.crstype_id='1' AND crs.`is_active`=1 $cond $condsem ";
	debug($q,"getNumberofCourses");
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row['num'];
}	/* fxn */


/* 5 */
function honorsGrades($db,$dbg,$scid,$qtr,$fields="g.id",$filter=NULL,$sem=0){	
	$dbo=PDBO;
	$condsem=($sem>0)? "AND (crs.semester=$sem || crs.semester=0 )":NULL;
	$q = "SELECT $fields,g.scid,g.`q{$qtr}` AS `grade`,crs.`supsubject_id`,crs.is_primary
		FROM {$dbg}.50_grades AS g LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		WHERE g.scid='$scid' AND crs.crstype_id='".CTYPEACAD."' AND crs.is_active=1 $filter $condsem ORDER by crs.position,crs.id; ";			
	debug($q,"honorsGrades");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

/* 6 */
function evaluateGenave($genave,$cutarr){
	if($genave>=$cutarr['1st']){ $honor=1;
	} elseif($genave>=$cutarr['2nd']){ $honor=2; 
	} elseif($genave>=$cutarr['3rd']){ $honor=3; 
	} else { $honor=0; }
	// pr($genave);
	return $honor;
}	/* fxn */

/* 7 */
function qualifyEachGrade($grarr,$cutarr){	
	if($grarr['grade']<$cutarr['min']){ return false; } 
	return true;
}	/* fxn */

/* 8 */
function qualifyNumpri($grarr,$cutarr){	
	if($grarr['is_primary']==1){ if($grarr['grade']>=$cutarr['pri']){ return true; } }
	return false;
}	/* fxn */


/* 9 */
function evaluateMynumpri($is_qual,$orig_honor,$my_numpri,$numpri){
	if($is_qual){
		if($my_numpri==$numpri){ $honor=1;
		} elseif($my_numpri>5){ $honor=2;
		} elseif($my_numpri>2){ $honor=3; 
		} else { $honor=0; }		
		if(($honor>0) && ($honor<$orig_honor)){ $honor=$orig_honor; }		
	} else { $honor=0; }
	return $honor;
}	/* fxn */

/* --- processes --- */

/* 1 */
$cutarr=getCutoffArray($dept);

/* 2 */
$order=isset($_GET['order'])? $_GET['order']:"genave DESC";
$fields="summ.ave_q{$qtr} AS `genave`,summ.`conduct_q{$qtr}` AS conduct";
$cond=" AND summ.`ave_q{$qtr}`>=".$cutarr['3rd'];
$cond.=" AND summ.`conduct_q{$qtr}`>=".$cutarr['conduct'];
$students=getHonorsStudents($db,$dbg,$crid,$qtr,$fields,$cond);
$count=count($students);


/* 3 */
$fields="crs.id,crs.supsubject_id,crs.is_aggregate,crs.subject_id,crs.code,crs.is_primary";
$courses=honorsSubjects($db,$dbg,$crid,$fields,$filter=NULL,$sem);	
$numcrs=count($courses);

/* 4 */
$numsub=getNumberOfCourses($db,$dbg,$crid,$where="AND crs.supsubject_id>0",$sem);
$numpri=getNumberOfCourses($db,$dbg,$crid,$where="AND crs.supsubject_id<1 AND crs.is_primary=1",$sem);

/* 5 */
$fields="g.id";
for($i=0;$i<$count;$i++){ $grades[$i]=honorsGrades($db,$dbg,$students[$i]['scid'],$qtr,$fields,$filter=NULL,$sem); }	




?>


<h5>
	Std Process Honors - <?php echo $cr['name']; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 	
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	| <span class="u" onclick="pclass('hd');" >Show</span>
	| <a href="<?php echo URL.'honors/report/'.$crid; ?>" >Report</a>
	| <a href="<?php echo URL.'honors/certificatesByClassroom/'.$crid.DS.$sy.DS.$qtr; ?>" >Certificates</a>
	| <a onclick="pclass('id');" >ID</a>
<?php if($lvl>12): ?>	
	<?php if($qtr<3): ?>
		| <a href="<?php echo URL.'honors/process/'.$crid.'?sem=1'; ?>" >Sem1</a>
	<?php else: ?>
		| <a href="<?php echo URL.'honors/process/'.$crid.'?sem=2'; ?>" >Sem2</a>	
	<?php endif; ?>	
<?php endif; ?>	
<?php if($_SESSION['srid']==RMIS): ?>
	| <a href='<?php echo URL."registrars/editStudentGrades"; ?>' >Grades</a>	
	| <a href='<?php echo URL."summarizers/student"; ?>' >Summarizer</a>		
<?php endif; ?>	

<?php if($lvl>13): ?>
	| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.'5?sem=1'; ?>" >Final-Sem1</a>
	| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.'6?sem=2'; ?>" >Final-Sem2</a>
	| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.'7'; ?>" >Final</a>
	| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.$_SESSION['qtr'].'?sem='.$currsem; ?>" >Current</a>
<?php else: ?>
	<?php if($qtr<5): ?>
		| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.'5'; ?>" >Final</a>
	<?php else: ?>
		| <a href="<?php echo URL.'honors/process/'.$crid.DS.$sy.DS.$_SESSION['qtr']; ?>" >Current</a>
	<?php endif; ?>
<?php endif; ?>

	
	
<form method="GET" style="display:inline;" >
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
	<input type="submit" name="submit" value="Go" >	
</form>			
	
</h5>


<form method="POST" >
<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<thead>
<tr>
	<th>#</th>
	<th class="hd id" >Scid</th>
	<th class="hd" >ID No.</th>
	<th><div class="vc200" >Name</div></th>
	<th>Genave</th>
	<th>CDT</th>
	<th>Orig<br />HNR</th>
	<?php $ctpri=0; ?>
	<?php foreach($courses AS $row): ?>
	<th class="center <?php echo ($row['is_primary']==1)? 'bg-lightgreen':NULL; ?>" >
		<?php echo $row['code']; echo "<br />"; echo ($row['supsubject_id']<1)? NULL:'#'.$row['supsubject_id']; ?>
		<?php if($row['is_primary']==1){ $ctpri++; echo '<br />'.$ctpri; } // pr($row['supsubject_id']); ?>
	</th>
	<?php endforeach; ?>
	<th>QLF</th>
	<th>My<br />Num<br />Pri</th>
	<th>Orig<br />HNR</th>
	<th>DB<br />HNR</th>
	<th>Ini<br />HNR<br />Rank</th>
	<th>Honor</th>
	<th class="hd" >DB<br />HNR<br />DG</th>
	<th class="hd" >Student</th>
	<th class="hd" >scid<br />qlfd<br />genave<br />honor<br />honor_dg</th>
</tr>
</thead>
<tbody>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$is_qual=1; 
	$my_numpri=0; 

?>
<tr>
<td><?php echo $i+1; ?></td>
<td class="hd id" ><?php $scid=$students[$i]['scid']; echo $scid; ?></td>
<td class="hd" ><?php echo $students[$i]['studcode']; ?></td>
<td><?php $studname=$students[$i]['student']; echo $studname; ?></td>
<td><?php $genave=number_format($students[$i]['genave'],$decigenave); echo $genave; ?></td>
<td><?php $conduct=number_format($students[$i]['conduct'],$deciconducts); echo $conduct; ?></td>
<?php $honor=0; ?>
<td><?php $honor=evaluateGenave($genave,$cutarr); echo $honor; ?></td>
<?php for($j=0;$j<$numcrs;$j++): ?>	
	<?php 
		$td_qual=1;
		if($is_qual){ 
			$is_qual=qualifyEachGrade($grades[$i][$j],$cutarr);			/* 1 */
			$td_qual=$is_qual;
			$my_numpri=($is_qual)? $my_numpri+=qualifyNumpri($grades[$i][$j],$cutarr):'-'; 	/* 2 */
		}
	?>	
	<td class="colshading <?php echo (!$td_qual)?'red':NULL; ?>" ><?php $grade=number_format($grades[$i][$j]['grade'],$decicard); echo $grade; ?>

	</td>
<?php endfor; ?>
<td><?php echo ($is_qual)? 1:'-'; ?></td>
<td class="<?php echo (!$is_qual)?'red':NULL; ?>" ><?php echo $my_numpri; ?></td>

<td>
<?php 	
	$orig_honor=$honor;
	$honor=evaluateMynumpri($is_qual,$honor,$my_numpri,$numpri);

?>
<?php echo $orig_honor; ?>
</td>

<td><?php $dbhonor=number_format($students[$i]['dbhonor'],$decihonors); echo ($dbhonor)? $dbhonor:'-'; ?></td>
<td>
	<input class="vc50 center" value="<?php echo $honor; ?>"  />
</td>
<td><?php 
		if($is_qual){
			$hbga=getHonorByGenave($genave); 
			$honor_num=$hbga['num'];
			$honor_dg=$hbga['dg'];			
			$honor_genave=$hbga['genave'];			
		} else {
			$honor_num=0;
			$honor_dg='';						
		}
		echo ($is_qual)? $honor_dg:'-'; ?>
	
	<?php 

	?>
	
</td>
<td class="hd" ><?php echo $students[$i]['dghonor']; ?></td>
<td class="hd" ><?php echo $studname; ?></td>
<td class="hd" >
	<input class="vc50 center" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>"  />
	<input class="vc50 center" name="posts[<?php echo $i; ?>][is_qualified]" value="<?php echo $is_qual; ?>"  />	
	<input class="vc50 center" name="posts[<?php echo $i; ?>][is_qualified]" value="<?php echo $honor_genave; ?>"  />	
	<input class="vc50 center" name="posts[<?php echo $i; ?>][honor]" value="<?php echo ($is_qual)? $honor_num:NULL; ?>"  />
	<input class="vc50 center" name="posts[<?php echo $i; ?>][honor_dg]" value="<?php echo ($is_qual)? $honor_dg:NULL; ?>"  />
</td>

</tr>
<?php endfor; ?>
</tbody>

<thead>
<tr>
	<th>#</th>
	<th class="hd id" >Scid</th>
	<th class="hd" >ID No.</th>
	<th><div class="vc200" >Name</div></th>
	<th>Genave</th>
	<th>CDT</th>
	<th>Orig<br />HNR</th>
	<?php $ctpri=0; ?>
	<?php foreach($courses AS $row): ?>
	<th class="center <?php echo ($row['is_primary']==1)? 'bg-lightgreen':NULL; ?>" >
		<?php echo $row['code']; echo "<br />"; echo ($row['supsubject_id']<1)? NULL:'#'.$row['supsubject_id']; ?>
		<?php if($row['is_primary']==1){ $ctpri++; echo '<br />'.$ctpri; } // pr($row['supsubject_id']); ?>
	</th>
	<?php endforeach; ?>
	<th>QLF</th>
	<th>My<br />Num<br />Pri</th>
	<th>Orig<br />HNR</th>
	<th>DB<br />HNR</th>
	<th>Ini<br />HNR<br />Rank</th>
	<th>Honor</th>
	<th class="hd" >DB<br />HNR<br />DG</th>
	<th class="hd" >Student</th>
	<th class="hd" >scid<br />qlfd<br />genave<br />honor<br />honor_dg</th>
</tr>
</thead>
</table>

<p><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  /></p>

</form>


<div class="clear" ></div>

<div style="float:left;width:35%;" >
<p>
<table class="gis-table-bordered" style="font-size:0.8em;" >
<tr><th colspan=2>Legends:</th></tr>
<tr><td>Orig HNR</td><td>Honor based on Genave</td></tr>
<tr><td>CDT</td><td>Conduct</td></tr>
<tr><td>QLF</td><td>Is Qualified (1)</td></tr>
</table>
</p>
</div>

<div class="" style="float:left;width:60%;" >
<p>
<table class="gis-table-bordered table-altrow" style="font-size:0.8em;" >
	<tr><th class="vc500" >PROCESS:</th></tr>
	<tr><td>1: Genave/ Summarizer above 90 (3rd) | above 95 (2nd) | above 98 (1st)</td></tr>
	<tr><td>2: Conduct 90 above. </td></tr>
	<tr><td>3: All grades 85 above.</td></tr>
	<tr><td>
		4: All Primary Subject (is_primary) grade over 90 (1st) <?php echo "Num primary: $numpri"; ?><br />
 		> At least 6 (2nd)<br />
		> At least 3 (3rd)<br />
	</td>
</tr>

</table>
</p>



</div>
<br />
<div class="clear" ><?php include_once("signatures.php"); ?></div>

<div class="ht50 clear" >&nbsp;</div>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();
	hd();
	columnHighlighting();

})

</script>

