<?php 

	$in_rl = in_remarksLevel($cr);
	$user = $_SESSION['user'];
	
$sch=VCFOLDER;	
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles":"profiles/classroom";	


// pr($data);


?>



<h5>
	Classlist (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('hd');" >Details</span>
	| <a href='<?php echo URL."classlists/master/$crid"; ?>' >Masterlist</a>				
	| <a href='<?php echo URL."classlists/custom/$crid"; ?>' >Custom</a>					
	
	<?php if(isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >View</a>
	<?php else: ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy?edit"; ?>' >Edit</a>
	<?php endif; ?>
		| <a href='<?php echo URL."classlists/profiles/$crid/$sy"; ?>' >Bdays</a>
	<?php if(isset($_GET['simple'])): ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Normal</a>			
	<?php else: ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Simple</a>				
	<?php endif; ?>	
	
	<?php if(isset($_GET['split'])): ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Normal</a>		
	<?php else: ?>
		| <a href='<?php echo URL."classlists/classroom/$crid/$sy?split"; ?>' >Split</a>
	<?php endif; ?>	
	
	<?php if(!isset($_GET['edit'])): ?>
		| <a class="u" id="btnExport" >Excel</a> 		
	<?php endif; ?>

	| <a href='<?php echo URL."{$crprofiles_path}/$crid/$sy"; ?>'>Profiling</a>			
	| <a href='<?php echo URL."promotions/sfold/$crid/$sy"; ?>'>Promotions</a>			
	<?php if($in_rl): ?>
		| <a href='<?php echo URL."remarks/classroom/$crid"; ?>'>Remarks</a>	
	<?php endif; ?>

		| <a href='<?php echo URL."photos/classroom/$crid"; ?>'>Photos</a>		
	<?php if($_SESSION['settings']['advsxn_setup']==1): ?>
		| <a href='<?php echo URL."rosters/classroom/$crid"; ?>'>Roster</a>	
	<?php endif; ?>
	
<?php if(($user['role_id'] == RREG) || ($user['role_id'] == RMIS)): ?>	
		| <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>">Roster</a>		
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
		| <a href="<?php echo URL.'registration/one'; ?>">Registration</a>
<?php endif; ?>	
<br />
	  <a href='<?php echo URL."submissions/view/$crid"; ?>'>Submissions</a>			
	| <a href='<?php echo URL."matrix/grades/$crid/$sy"; ?>'>Matrix</a>			
	| <a href='<?php echo URL."spiral/crid/$crid"; ?>'>1) Spiral</a>			
	| <a href='<?php echo URL."summarizers/genave/$crid"; ?>'>2) Summarizer</a>			


<?php 	if($_SESSION['srid']==RMIS): ?>
	| <span class="u " onclick="traceshd();" >CTP</span>
<?php endif; ?>
	
</h5>

<p class="shd" > 
	<table class="gis-table-bordered shd" >
		<tr>
			<th>Account-CTP</th>
			<td><?php echo $cr['account'].'-'.$cr['ctp']; ?></t>
		</tr>
	</table>
</p>

<p>
	* Male=1, Female=0 <br />
	* Pos (Position) @settings.classlist_order  <br />
</p>

<?php  $this->shovel('classroom_details',$cr);  ?>

<?php if(isset($_GET['edit'])): 
	include_once('incs/classlist_edit.php');
else:
	if(isset($_GET['split'])):
		include_once('incs/classlist_split.php');
	elseif(isset($_GET['simple'])):
		include_once('incs/classlist_simple.php');		
	else:
		include_once('incs/classlist_view.php');	
	endif; 
endif; 
?>


<div class="clear ht50" ></div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();
	shd();


})






</script>
