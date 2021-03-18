<?php 

// pr($_SESSION['q']);

// pr($classroom);
// pr($data);exit;

?>

<h5>
	<?php echo $classroom['name'].' Roster'; echo (isset($count))? " ($count)":NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>'>Classlist</a>
	| <a href='<?php echo URL."students/sectioner"; ?>'>Sectioner</a>

<?php if($mis || $_SESSION['srid']==RREG): ?>	
	| <a href="<?php echo URL.'rosters/batch/'.$crid; ?>">Batch</a>
<?php endif; ?>

<?php if($mis): ?>	
	| <a href="<?php echo URL.'enrollment/manager/'.$crid.DS.$sy; ?>">Manager</a>	
<?php endif; ?>

	
</h5>

<?php 

$acid = $classroom['acid'];

// pr($rows[0]);
// pr($_SESSION['q']);

?>



<div class="clear" >
<table class='gis-table-bordered table-fx'>
<?php 
	$d['classrooms'] = $classrooms;
	$d['sy']		 = $sy;
	$d['axn']		 = 'classroom';
	// $this->shovel('redirect_classroom',$d); 
?>
	

</table>
</div>

<p>*Summcrid > 0 will not be rostered. Need to be released first.</p>

<?php if($crid): ?>
<table id="roster" class="gis-table-bordered table-fx table-altrow"  >
<tr>
	<th class="vc100" >SCID</th>
	<th class="vc200" >ID Number</th>
	<th class="vc250" >Student</th>
	<th class="vc200" >Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $scid = $rows[$i]['scid']; ?>
<tr id="tr<?php echo $i; ?>" class="<?php echo (!$rows[$i]['is_active'])? 'red':NULL; ?>" >
	<td><?php echo str_pad($rows[$i]['scid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><button id="btn-<?php echo $i; ?>" 
		onclick="releaseRoster(<?php echo $i.','.$scid; ?>);return false;" >Release</button></td>		
</tr>
<?php endfor; ?>
</table>

<p></p>
<form id="form" >
<table class="gis-table-bordered" >
<tr>
	<td class="vc100" >
		<input readonly id="scid" class="pdl05 vc60" value="0" />
		<input type="hidden" id="prevcrid" class="pdl05 vc60" value="0" />		
		<input type="hidden" id="acid" class="pdl05 vc60" value="0" />		
	</td>
	<td class="vc200" ><input class="pdl05 pdl05 vc100" id="codes" readonly /></td>
	<td class="vc250" ><input class="pdl05 vc150" id="part" autofocus />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRosters();return false;" />		
	</td>
	<td class="vc200" >
		<input type="submit" value="Enroll Old" onclick="addRoster();return false;"  />
		<?php if(($_SESSION['settings']['roster_allow_register']==1) || ($_SESSION['srid']==RMIS)): ?>
			<input type="submit" value="Register New" onclick="registerStudent();return false;"  />		
		<?php endif; ?>
		
	</td>
</tr>
</table>
</form>

<p class="brown" >
*Enroll - old student already in the system. Register - Add new student to the database - with Caution!
</p>

<div class="hd" id="names" > </div>


<div class="ht100" >&nbsp;</div>


<?php endif; ?>	<!-- if crid -->







<!-------------------------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var home = "<?php echo 'rosters'; ?>";
var hdpass 	= "<?php echo HDPASS; ?>";
var crid = "<?php echo $crid; ?>";
var acid = "<?php echo $acid; ?>";

$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	

})




</script>


<script type="text/javascript" src='<?php echo URL."views/js/rosters.js"; ?>' ></script>
