<style>

tr.blue th, tr.blue td{ color:blue; }
tr.green th, tr.green td{ color:green; }


</style>



<h5>
	SJAM Parent Online Portal | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	| <a href="<?php echo URL.'users/reset'; ?>" >Reset</a>

	<?php if($srid==RSTUD): ?>
		| <a href='<?php echo URL."students/unsetter/enrollment"; ?>' >Refresh</a>
	<?php endif; ?>

</h5>


<?php 


// $srid=9;
// prx($data);


// $checkBalance=false;
$checkBalance=$_SESSION['settings']['check_balance'];


$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$year=$_SESSION['year'];
$start_b1="2020-06-03";	// ps
$start_b2="2020-06-04";	// hs
$start_b3="2020-06-05";	// shs


$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
$sy_payments=$_SESSION['settings']['sy_payments'];
$sy_grading=$_SESSION['settings']['sy_grading'];


unset($_SESSION['enrollment']);


if($scid){
		
	if(isset($_GET['debug'])){ unset($_SESSION['enrollment']); }	
	
	$student_one=$student;
	
	
	
	if(isset($_SESSION['enrollment']) && $srid==RSTUD){
		$student=$_SESSION['enrollment']['student'];	
		$enrollment=$_SESSION['enrollment'];	
	} else {
		$scid=$scid;
		$sy=DBYR;
		$qtr=$_SESSION['qtr'];
	$incs=SITE."functions/enrollmentFxn.php";require_once($incs);	
		$data_two=getAssessmentDataForClearance($db,$sy,$scid);		
		extract($data_two);			
		$student_two=$student;
		$student=array_merge($student_one,$student_two);				
	$incs=SITE."views/customs/sjam/assessmentIncs_sjam.php";require_once($incs);
		$paymode_id=$student['paymode_id'];
		$allowance=$_SESSION['settings']['balance_cutoff'];			
		$enrollment['period_factor']=$period_factor=getPeriodFactor($qtr,$paymode_id);		
		$prevbal=$student['previous_balance'];
		// $enrollment=getStudentEnrollment($db,$sy,$scid,$student,$qtr,$period_factor,$arp,$payments,$allowance,$prevbal);
		$enrollment=getStudentEnrollment($db,$sy_grading,$scid,$student,$qtr,$period_factor,$arp,$payments,$allowance,$prevbal);
		// prx($enrollment);

		if(DBYR<$sy_enrollment){
			$nextsyClassroomRow=getClassroomByStudent($db,$sy_enrollment,$scid);
			$student=array_merge($nextsyClassroomRow,$student);
			
		}

		
		
		
	
		if($srid==RSTUD){
			$_SESSION['enrollment']=$enrollment;
			$_SESSION['student']=$student;
			// $_SESSION['message']="sessionize-enrollment";			
		}	
	}	// session-condition

	$has_honors=hasHonors($db,$scid,$sy_grading,$qtr);	
	$is_conductee=isConductee($db,$scid,$sy_grading,$qtr);	
	$student['has_honors']=$has_honors;	
	$student['is_conductee']=$is_conductee;	
	
	
	if(isset($_GET['debug'])){ echo "<hr />";pr($enrollment);echo "<hr />"; }
	
} 	/* scid */	


function checkSchedule($schedule){
	$today=$_SESSION['today'];
	return ($today>=$schedule)? true:false;	
}	/* fxn */

function getBatch($lvl){
	switch($lvl){
		case $lvl>9: return 'b3';break; 
		case $lvl>6: return 'b2';break; 
		default: return 'b1';break;		
	}	
}	/* fxn */



function checkStudlogin(){
	if(isset($_SESSION['user'])){
		$srid=$_SESSION['srid'];
		$studlogin=$_SESSION['settings']['studlogin'];
		if(($srid==RSTUD) && (!$studlogin)){ flashRedirect("lounge/student","Student login not allowed.");  }
		return true;
	}
}	/* fxn */


$allowed=checkStudlogin();


function checkRcardScheduleSjam($db,$scid){
	$sy=DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$ret=checkEnsy($db,$sy,$scid);
	$new_student=$ret['new_student'];
	if($new_student){ return false; }
	
	// schedule for old student
	$q="SELECT summ.crid,rs.is_open
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=summ.crid
		WHERE summ.scid=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	
	$allowed = ($row['is_open'])? true:false;
	return $allowed;
		
	
}	/* fxn */


function fxnSchedule($srid,$student,$allowed,$start_b1,$start_b2,$start_b3){
	if($srid==RSTUD){
		if($allowed){
			$batch=getBatch($student['level_id']);
			$schedule=${"start_".$batch};	
			$in_sched=checkSchedule($schedule);
			if(!$in_sched){ flashRedirect("lounge/student","Too early."); }
		}	
	}	/* student */
}

function fxnEC($srid,$student){
	if($srid==RSTUD){
		$classroom=$student['classroom'];
		$word = "-EC";
		$mystring = $classroom;
		 if(strpos($mystring, $word) !== false){
			flashRedirect("lounge/student","EC Student check with the school.");
		} 	
	}	/* rstud */
		
}	/* EC */


function hasHonors($db,$scid,$sy=DBYR,$qtr=false){
	$qtr=($qtr)? $qtr:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbo=PDBO;
	$q="SELECT c.id,c.code,c.name AS student,summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS honor 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_summext AS sx ON c.id=sx.scid
	WHERE summ.scid='$scid' AND sx.honor_q{$qtr} > 0 ;";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */

function isConductee($db,$scid,$sy=DBYR,$qtr=false){
	$qtr=($qtr)? $qtr:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbo=PDBO;
	$q="SELECT c.id,c.code,c.name AS student,summ.ave_q{$qtr} AS genave,aw.is_conduct_awardee_q{$qtr} AS is_conductee
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_awardees AS aw ON c.id=aw.scid
	WHERE summ.scid='$scid' AND aw.is_conduct_awardee_q{$qtr} > 0 ;";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function checkForErrorBalance($enrollment){
	
	
	
	if($enrollment['error_minbal']){
		echo "<tr class='red' ><th>".$enrollment['error_minbal']."</th></tr>";
	}
	
	if($enrollment['error_prevbal']){
		echo "<tr class='red' ><th>".$enrollment['error_prevbal']."</th></tr>";
	}
	
	if($enrollment['error_otherbal']){
		echo "<tr class='red' ><th>".$enrollment['error_otherbal']."</th></tr>";
	}
	
}	/* fxn */


?>

<?php if($scid): ?>
<?php 


fxnSchedule($srid,$student,$allowed,$start_b1,$start_b2,$start_b3);


extract($student);

$numcond=($num>1)? "&num=$num":null;
$nextLvl=$level_id+1;
$enrollmentLvl=($_SESSION['settings']['sy_grading']<$_SESSION['settings']['sy_enrollment'])? $nextLvl:$level_id;




// prx($enrollment);

		// pr($crid);

		$allowedByRcardSchedule = checkRcardScheduleSjam($db,$scid);
		
		// echo "<hr>";echo ($allowedByRcardSchedule)? "allowedByRcardSchedule":"NOT allowedByRcardSchedule";echo "<hr>";
		



?>

	<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $studcode; ?></td>
		<td><?php echo $studname; ?></td>
	</tr>
	</table>	
	<br />	
<?php endif; ?>
<?php if(!$user_is_student): ?>
	<script>
		var gurl = "http://<?php echo GURL; ?>";
		var sy = "<?php echo $sy; ?>";
		var limits='20';

		$(function(){
			$('#names').hide();
			
			
		})

		function redirContact(ucid){
			var url = gurl+'/students?scid='+ucid;	
			window.location=url;		
		}

	</script>	


	<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
		<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
		<div id="names" >names</div>
		<?php if(!isset($_GET['scid']) && ($srid!=RSTUD)){ exit; } ?>
<?php else:  ?>	<!-- user_is_student -->

	<script>
		var flash_message = "<?php echo $flash_message; ?>";
		
		$(function(){
			if(flash_message){ alert(flash_message); }
			
		})


	</script>	
<?php endif; ?>	<!-- user_is_student -->


<table class="one accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('one');" >Enrollment</th></tr>	

	<?php if(DBYR<$sy_enrollment): ?>
		<tr>
			<td class="center" >			
				<a class="no-underline" href='<?php echo URL."students/encrid/$scid/$sy_enrollment"; ?>' >
				<?php echo $student['nextclassroom']; ?></a>
				<?php echo ' - SY'.$sy_enrollment; ?>
			</td>
		</tr>			
	<?php endif; ?>		


	<tr><th class="bg-blue2" >Tuition & Books</th></tr>
	<tr><td class="vc250">
		<a href='<?php echo URL."students/tuitions/$scid/".$sy_payments; ?>' >Tuitions</a>		
		| <a href='<?php echo URL."students/feespolicies"; ?>' >Policies</a>		
	</td></tr>	
	<tr><td>
		<a href='<?php echo URL."students/booklist/$scid/".$sy_payments; ?>' >Booklist</a>
	</td></tr>		
	<tr><td>&nbsp;</td></tr>

	<tr><th class="bg-blue2" >Enrollment Steps</th></tr>

	<tr><td class="">
		1) <a href='<?php echo URL."students/datasheet/$scid"; ?>' >Datasheet</a>		
	</td></tr>	
	<tr><td>2) <a href='<?php echo URL."students/paymode/$scid/".$sy_payments; ?>' >Mode of Payment</a>
	</td></tr>
	<tr><td>
		3) <a href='<?php echo URL."students/assessment/$scid/".$sy_payments; ?>' >Assessment Fees</a>
	</td></tr>	
	<tr><td>4) Payment > Thank you.</td></tr>
	
	
	<tr><td>&nbsp;</td></tr>
	

</table>
<br>


<table class="studhome accordion gis-table-bordered table-altrow" >

	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>
	<tr><td class="vc250 center" >
		<a class='no-underline' href='<?php echo URL."students/encrid/$scid/".DBYR; ?>' >
		<?php echo $student['classroom']; ?></a>
		<?php if(DBYR<$sy_enrollment): ?>
			<?php echo ' - SY'.DBYR; ?>

		<?php endif; ?>		
	</td></tr>	

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass/$scid"; ?>' >Change Password</a></td></tr>
	<?php $lvlcode=$student['lvlcode']; ?>	
	
	

	<tr><td>
		<a href='<?php echo URL."students/payments/$scid"; ?>' >View Payments</a>
	</td></tr>	




<?php if($hasRcard): ?>	
<?php if($allowedByRcardSchedule): ?>	
	<?php if($has_honors): ?>
		<tr><td>
			<a href='<?php echo URL."certificates/studentHonors/$scid/$sy_grading/$qtr"; ?>' >
				Certificate - Academic Award</a>
		</td></tr>		
	<?php endif; ?>

	<?php if($is_conductee): ?>
		<tr><td>
			<a href='<?php echo URL."certificates/studentConductee/$scid/$sy_grading/$qtr"; ?>' >
				Certificate - Conduct Award</a>		</td></tr>		
	<?php endif; ?>
<?php endif; ?>
	
	<?php if(($user_is_student) AND ($student['sy_registered']<$sy)): ?>	
	<?php else: ?>
	<?php endif; ?>

<?php if($srid!=RAXIS): ?>
	
<?php if($scid): ?>

<?php if($checkBalance): ?>	
	<?php if($allowedByRcardSchedule): ?>	

	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($currlvl<2): ?>		
		<?php if($enrollment['can_view_rcard']): ?>
			<tr><td>
				<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/4?{$rcget}&tpl=5"; ?>' >PN Report Card</a>
				| <a target="_blank" href='<?php echo URL."frontcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=5"; ?>' >Front</a>		
			</td></tr>	
		<?php else: ?>
			<?php checkForErrorBalance($enrollment); ?>
		<?php endif; ?>			
	<?php elseif($currlvl<14): ?>		
		<?php if($enrollment['can_view_rcard']): ?>
			<tr><td><a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=$dept_id"; ?>' >Report Card - BED</a></td></tr>
		<?php else: ?>		
			<?php checkForErrorBalance($enrollment); ?>				
		<?php endif; ?>	
	<?php else: ?>
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>

		
		<?php if($enrollment['can_view_rcard']): ?>
			<tr><td>
				<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtr}/1?{$rcget}&both=$both"; ?>' >SHS Sem1</a>
				<?php if($qtr>2): ?>			
					| <a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtr}/2?{$rcget}&both=$both"; ?>' >SHS Sem2</a>
				<?php endif; ?>
			</td></tr>
		<?php else: ?>
			<?php checkForErrorBalance($enrollment); ?>
			<?php if($qtr>3 && $enrollment['total_balance']>0): ?>
				<tr class="red" ><th>Total balance: <?php echo number_format($enrollment['total_balance'],2); ?></th></tr>			
			<?php endif; ?>									
		<?php endif; ?>	
		
		
	<?php endif; ?>	
	
	<?php else: ?>	<!-- allowedByRcardSchedule -->
		<tr><th>Rcard Schedule Closed</th></tr>

		<?php if($enrollment['can_view_rcard']): ?>
		<?php else: ?>
			<?php checkForErrorBalance($enrollment); ?>
			<?php if($qtr>3 && $enrollment['total_balance']>0): ?>
				<tr class="red" ><th>Total balance: <?php echo number_format($enrollment['total_balance'],2); ?></th></tr>			
			<?php endif; ?>												
		<?php endif; ?>				
	
	<?php endif; ?>		<!-- allowedByRcardSchedule -->
	<?php endif; ?>		<!-- hasRcard  -->
	
<?php endif; ?>		<!-- if($srid!=RAXIS ) -->

	

<?php else: ?>

	<?php if(!$user_is_student): ?>
		<tr><td><a href='<?php echo URL."students/enrollment/$scid/".$sy_enrollment; ?>' >Enrollment</a></td></tr>
		<tr><td><a href='<?php echo URL."students/sectioner/$scid/".$sy_enrollment; ?>' >Sectioner</a></td></tr>
	<?php endif; ?>	
	
		
<?php endif; ?>	<!-- checkBalance -->
<?php endif; ?>	<!-- scid -->



	<tr><td>&nbsp;</td></tr>
	
</table>

<div class="ht100" ></div>


<?php if($srid==RMIS): ?>	<!-- or admin -->
	<table class="admin accordion gis-table-bordered table-altrow" >
		<tr><th class="accorHeadrow" onclick="accordionTable('admin');" >Admin</th></tr>
		<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></th></tr>
		<tr><td>
			<a href='<?php echo URL."enrollment/payables/$scid/$year"; ?>' >Payables</a>
			| <a href='<?php echo URL."students/clearance/$scid/$year"; ?>' >Clearance</a>
		</td></tr>
		<tr><td>
			<a href='<?php echo URL."students/leveler/$scid/$sy_enrollment"; ?>' >Leveler</a>
			| <a href='<?php echo URL."students/sectioner/$scid/$sy_enrollment"; ?>' >Sectioner</a>		
		</td></tr>
		<tr><td>
			<a href='<?php echo URL."students/enrollment/$scid/$year"; ?>' >Enrollment</a>		
			| <a href='<?php echo URL."enrollment/ledger/$scid/$year"; ?>' >Ledger</a>
		</td></tr>
		<tr><td><a href='<?php echo URL."students/tuitions/$enrollmentLvl/".$sy_enrollment; ?>' target="_blank" >View Tuition Fees</a></td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
<?php endif; ?>


