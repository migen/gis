<?php



function averager($db,$dbg,$qtr){
$dbo=PDBO;
$decicard=$_SESSION['settings']['decicard'];
$deciave=$_SESSION['settings']['deciave'];
// $decicard=0;$deciave=2;

$expr = "round(a.q1,$decicard)";
echo "Settings Decicard: $decicard <br />";
echo "Settings Deciave: $deciave <br />";
for($i=2;$i<=$qtr;$i++){ $expr .= "+round(a.q$i,$decicard)"; }		

$q = "UPDATE {$dbg}.50_grades AS a SET a.q5 = round((($expr)/$qtr),$deciave);";
pr($q);
if(isset($_GET['exe'])){ $db->query($q); }

echo "<hr />";

/* sem1 */
$expr = ($qtr%2)? "round(a.q1,$decicard)":"round(a.q1,$decicard)+round(a.q2,$decicard)";
$num = ($qtr%2)? 1:2;
$q="UPDATE {$dbg}.50_grades AS a 
INNER JOIN ( SELECT * FROM {$dbg}.05_courses WHERE `semester`=1 ) AS b ON b.id = a.course_id
SET a.q5=round((($expr)/$num),$deciave); ";
pr($q);
if(isset($_GET['exe'])){ $db->query($q); }

if($qtr>2){

/* sem2 */
$q="UPDATE {$dbg}.50_grades AS a
INNER JOIN ( SELECT * FROM {$dbg}.05_courses WHERE `semester`=2 ) AS b ON b.id = a.course_id
SET a.`q5`=0; ";
pr($q);
if(isset($_GET['exe'])){ $db->query($q); }

/* sem2 */	
$expr = ($qtr%2)? "round(a.q3,$decicard)":"round(a.q3,$decicard)+round(a.q4,$decicard)";	
$num = ($qtr%2)? 1:2;
$q="UPDATE {$dbg}.50_grades AS a
INNER JOIN ( SELECT * FROM {$dbg}.05_courses WHERE `semester`=2) AS b ON b.id = a.course_id
SET a.`q6`=round((($expr)/$num),$deciave); ";
 
}	/* qtr>2 */

pr($q);
if(isset($_GET['exe'])){ $db->query($q); }

$url="advisers/averager?qtr=$qtr&exe";
if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		
				
		
}	/* fxn */


/* 
$deciave=1;
$q="UPDATE {$dbg}.aasumm AS summ SET summ.ave_q7=((round(summ.ave_q5,".$deciave.")+round(summ.ave_q6,".$deciave.")))/2 
	WHERE summ.`scid`='1001' LIMIT 1; ";
 */

function averageCourse($db,$course,$dbg=PDBG){
	$crs=$course['course_id'];$sem=$course['semester'];	
	$card=$_SESSION['settings']['decicard'];$ave=$_SESSION['settings']['deciave'];
	if($sem==2){
		$q="UPDATE {$dbg}.50_grades SET `q6`=round((round(q3,{$card})+round(q4,{$card}))/2,{$ave}) WHERE `course_id`='$crs'; ";						
	} elseif($sem==1){
		$q="UPDATE {$dbg}.50_grades SET `q6`=round((round(q1,{$card})+round(q1,{$card}))/2,{$ave}) WHERE `course_id`='$crs'; ";					
	} else {
		$q="UPDATE {$dbg}.50_grades SET q5=round((round(q1,{$card})+round(q2,{$card})+round(q3,{$card})+round(q4,{$card}))/4,{$ave}) 
			WHERE `course_id`='$crs';";
	}
	$db->query($q);	

}	/* fxn */
