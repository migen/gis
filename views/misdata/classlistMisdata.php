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
	MIS Data Classlist SY<?php echo $sy; ?> (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >Simple</a>					
	| <a href='<?php echo URL."schedules/classroom/$crid/$sy"; ?>' >Schedules</a>					
	

	<?php if(!isset($_GET['edit'])): ?>
		| <a class="u" id="btnExport" >Excel</a> 		
	<?php endif; ?>

	| <a href='<?php echo URL."{$crprofiles_path}/$crid/$sy"; ?>'>Profiling</a>			
	| <a href='<?php echo URL."promotions/sfold/$crid/$sy"; ?>'>Promotions</a>			
	
<?php if(($user['role_id'] == RREG) || ($user['role_id'] == RMIS)): ?>	
		| <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>">Roster</a>		
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
		| <a href="<?php echo URL.'registration/one'; ?>">Registration</a>
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



<table id="tblExport" class="table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Ensy</th>
	<th>Scid</th>
	<th>Male</th>
	<th>Actv</th>
	<th class="vc300" >Student</th>
	<th>Login-Pass</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']!=1)? 'red':NULL; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ensy']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['is_male']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['is_active']!=1)?'-NA-':NULL; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>	
	<td><?php echo $rows[$i]['account'].'-'.$rows[$i]['ctp']; ?></td>	
	<td><a href="<?php echo URL.'profiles/scid/'.$rows[$i]['scid']; ?>" >Profile</a></td>	
	<td><a href="<?php echo URL.'students?scid='.$rows[$i]['scid']; ?>" >Portal</a></td>	
	<td><a href="<?php echo URL.'students/links/'.$rows[$i]['scid']; ?>" >Links</a></td>	
	<td><a href="<?php echo URL.'passwords/resets/'.$rows[$i]['scid']; ?>" >Pass</a></td>	
	<td><a href="<?php echo URL.'ensteps/student/'.$rows[$i]['scid']; ?>" >Ensteps</a></td>	
</tr>
<?php endfor; ?>
</table>




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
