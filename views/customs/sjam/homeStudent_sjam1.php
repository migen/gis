<h5>
	SJAM Parent Online Portal | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	| <a href="<?php echo URL.'users/reset'; ?>" >Reset</a>

</h5>


<?php 

if($scid){
		
	if(isset($_GET['debug'])){ unset($_SESSION['accounts']); }
	
	$student_one=$student;
	if(isset($_SESSION['accounts']) && $srid==RSTUD){
		$student=$_SESSION['accounts']['student'];	
		$accounts=$_SESSION['accounts'];	
	} else {
		$scid=$scid;
		$sy=DBYR;
		$qtr=$_SESSION['qtr'];
		$incs=SITE."functions/enrollmentFxn.php";require_once($incs);
			$data_two=getAssessmentDataForClearance($db,$sy,$scid);
			extract($data_two);			
			$student_two=$student;
			// echo "stud-2";pr($student_two);echo "<hr />";pr("xxxx-222333");
			$student=array_merge($student_one,$student_two);				
		$incs=SITE."views/customs/sjam/assessmentIncs_sjam.php";require_once($incs);
			$paymode_id=$student['paymode_id'];
			$allowance=$_SESSION['settings']['balance_cutoff'];
			$accounts['period_factor']=$period_factor=getPeriodFactor($qtr,$paymode_id);
			// $isEmployeeChild=isEmployeeChild($db,$scid,$sy=DBYR);
		$prevbal=$student['previous_balance'];
		$accounts=getStudentAccounts($db,$sy,$scid,$student,$qtr,$period_factor,$arp,$payments,$allowance,$prevbal);
		if($srid==RSTUD){
			$_SESSION['accounts']=$accounts;
			$_SESSION['student']=$student;
			$_SESSION['message']="sessionize-accounts";			
		}	
	}
	
	/* debug */
	if(isset($_GET['debug'])){ echo "<hr />";pr($accounts);echo "<hr />"; }

	
} 	/* scid */	


// pr($accounts);

// ------------------------------------------------------------------

$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$year=$_SESSION['year'];
$start_b1="2020-06-03";	// ps
$start_b2="2020-06-04";	// hs
$start_b3="2020-06-05";	// shs


$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
$sy_grading=$_SESSION['settings']['sy_grading'];


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



?>

<?php if($scid): ?>
<?php 


fxnSchedule($srid,$student,$allowed,$start_b1,$start_b2,$start_b3);


extract($student);

$numcond=($num>1)? "&num=$num":null;
$nextLvl=$level_id+1;
$enrollmentLvl=($_SESSION['settings']['sy_grading']<$_SESSION['settings']['sy_enrollment'])? $nextLvl:$level_id;



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


<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass/$scid"; ?>' >Change Password</a></td></tr>
	<tr><td><a href='<?php echo URL."students/paymode/$scid/".$sy_enrollment; ?>' >Mode of Payment</a></td></tr>
	<?php $lvlcode=$student['lvlcode']; ?>
	
	<tr><td>
		<a href='<?php echo URL."students/tuitions/$scid/".$sy_enrollment; ?>' >Tuitions</a>
		| <a href='<?php echo URL."students/feespolicies"; ?>' >Policies</a>		
	</td></tr>
	
	<tr><td>
		<a href='<?php echo URL."students/assessment/$scid/".$sy_enrollment; ?>' >Assessment Fees</a>
	</td></tr>	
	<tr><td>
		<a href='<?php echo URL."students/payments/$scid"; ?>' >View Payments</a>
	</td></tr>	

	<tr><td>
		<a href='<?php echo URL."students/booklist/$scid"; ?>' >Booklist</a>
	</td></tr>	

	<tr><td>
		<a href='<?php echo URL."students/datasheet/$scid"; ?>' >Datasheet</a>
	</td></tr>	
	
	<?php if(($user_is_student) AND ($student['sy_registered']<$sy)): ?>	
	<?php else: ?>
	<?php endif; ?>
	
<?php if($scid): ?>

	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($currlvl<2): ?>
		<tr><td>
			<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/4?{$rcget}&tpl=5"; ?>' >PN Report Card</a>
			| <a target="_blank" href='<?php echo URL."frontcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=5"; ?>' >Front</a>		
		</td></tr>	
	<?php elseif($currlvl<14): ?>
		<?php if($accounts['can_view_rcard']): ?>
			<tr><td><a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=$dept_id&deciave=0"; ?>' >Report Card - BED</a></td></tr>
		<?php else: ?>
			<tr><th><?php echo $accounts['denied_message']; ?></th></tr>
		<?php endif; ?>	
	<?php else: ?>
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>
		<tr><td>
			<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtr}/1?{$rcget}&both=$both&deciave=0"; ?>' >SHS Sem1</a>
			<?php if($qtr>2): ?>			
				| <a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtr}/2?{$rcget}&both=$both&deciave=0"; ?>' >SHS Sem2</a>
			<?php endif; ?>
		</td></tr>
	<?php endif; ?>	
	<?php if($srid==RSTUD): ?>
		<tr><td><a href='<?php echo URL."students/unsetter/accounts"; ?>' >Reset Accounts</a></td></tr>			
	<?php endif; ?>
<?php else: ?>
	<tr><td><a href='<?php echo URL."students/enrollment/$scid"; ?>' >Enrollment</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/sectioner/$scid"; ?>' >Sectioner</a>
		<?php endif; ?>	
	</td></tr>
	
	
	
<?php endif; ?>	<!-- scid -->
	<tr><td>&nbsp;</td></tr>
	
</table>


<?php if($srid==RMIS): ?>	<!-- or admin -->
	<table class="admin accordion gis-table-bordered table-altrow" >
		<tr><th class="accorHeadrow" onclick="accordionTable('admin');" >Admin</th></tr>
		<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></th></tr>
		<tr><td>
			<a href='<?php echo URL."enrollment/payables/$scid/$year"; ?>' >Payables</a>
			| <a href='<?php echo URL."students/clearance/$scid/$year"; ?>' >Clearance</a>
		</td></tr>
		<tr><td>
			<a href='<?php echo URL."students/leveler/$scid/$year"; ?>' >Leveler</a>
			| <a href='<?php echo URL."students/sectioner/$scid/$year"; ?>' >Sectioner</a>		
		</td></tr>
		<tr><td>
			<a href='<?php echo URL."students/enrollment/$scid/$year"; ?>' >Enrollment</a>		
			| <a href='<?php echo URL."enrollment/ledger/$scid/$year"; ?>' >Ledger</a>
		</td></tr>
		<tr><td><a href='<?php echo URL."students/tuitions/$enrollmentLvl/".$sy_enrollment; ?>' target="_blank" >View Tuition Fees</a></td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
<?php endif; ?>


