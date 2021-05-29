<h5>
	SASM Parent Online Portal | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	| <a href="<?php echo URL.'users/reset'; ?>" >Reset</a>

	<?php if($srid==RSTUD): ?>
		| <a href='<?php echo URL."students/unsetter/enrollment"; ?>' >Refresh</a>
	<?php endif; ?>

</h5>


<?php 


// prx($data);

$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$year=$_SESSION['settings']['sy_enrollment'];
$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
$sy_grading=$_SESSION['settings']['sy_grading'];





if($scid){	
	if(isset($_GET['debug'])){ echo "<hr />";pr($data);echo "<hr />"; }
	
} 	/* scid */	




function checkStudlogin(){
	if(isset($_SESSION['user'])){
		$srid=$_SESSION['srid'];
		$studlogin=$_SESSION['settings']['studlogin'];
		if(($srid==RSTUD) && (!$studlogin)){ flashRedirect("lounge/student","Student login not allowed.");  }
		return true;
	}
}	/* fxn */


$allowed=checkStudlogin();




?>

<?php 

if($scid){
	extract($student);
	$numcond=($num>1)? "&num=$num":null;
	$nextLvl=$level_id+1;
	$enrollmentLvl=($_SESSION['settings']['sy_grading']<$_SESSION['settings']['sy_enrollment'])? $nextLvl:$level_id;
	
}	/* scid */

?>

<?php if($scid): ?>

	<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $studcode; ?></td>
		<td><?php echo $studname; ?></td>
	</tr>
	</table>	
	<br />	
<?php endif; ?>

<!-- for admin filter -->
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




<!-- menu -->
<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>
	<tr><td class="vc250 center" ><?php echo $student['classroom']; ?></td></tr>	

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass/$scid"; ?>' >Change Password</a></td></tr>
	<?php $lvlcode=$student['lvlcode']; ?>
	

	
	

	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($currlvl<2): ?>	<!-- dept -->	
			<tr><td>
				<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/4?{$rcget}&tpl=5"; ?>' >PN Report Card</a>
				| <a target="_blank" href='<?php echo URL."frontcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=5"; ?>' >Front</a>		
			</td></tr>	
	<?php elseif($currlvl<14): ?>
			<tr><td><a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy_grading/$qtr?{$rcget}&tpl=$dept_id&deciave=0"; ?>' >Report Card - BED</a></td></tr>
	<?php else: ?>	<!-- dept -->
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>		
		<tr><td>
			<?php 				
				$qtrSem1=($_SESSION['qtr']>1)? 2:1;
				$qtrSem2=($_SESSION['qtr']>3)? 4:3;
				
			?>
			
			
		<?php if($_SESSION['qtr']<3): ?>
			<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtrSem1}/1?{$rcget}&both=$both&deciave=0"; ?>' >SHS Sem1</a> 
		
		<?php endif; ?>
			
			
			<?php if($qtr>2): ?>			
				<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy_grading/{$qtrSem2}/2?{$rcget}&both=$both&deciave=0"; ?>' >SHS Sem2</a>
			<?php endif; ?>	<!-- sem2 -->				
		</td></tr>
		
	<?php endif; ?>		<!-- dept -->

	<tr><td>&nbsp;</td></tr>	
</table>



<!-- mis -->
<?php if($srid==RMIS): ?>	<!-- or admin -->
	<table class="admin accordion gis-table-bordered table-altrow" >
		<tr><th class="accorHeadrow" onclick="accordionTable('admin');" >Admin</th></tr>
		<tr><td class="vc250" ><a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a></th></tr>
		<tr><td>
			<a href='<?php echo URL."students/leveler/$scid/$year"; ?>' >Leveler</a>
			| <a href='<?php echo URL."students/sectioner/$scid/$year"; ?>' >Sectioner</a>		
		</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
<?php endif; ?>



