<?php 



?>

<style style="text/css" >


table.attd tr th,table.attd td { size: 24px; color:;}
#names{position:absolute;padding:20px;}



</style>

<?php 

$headfont = 'tf24';
$tblfont = 'tf20';
$titlefont = 'tf28';

$session_timein  = $_SESSION['settings']['timein'];
$session_timeout = $_SESSION['settings']['timeout'];

$casti = isset($contact['timein'])? $contact['timein']:$_SESSION['settings']['timein'];
$casto = isset($contact['timeout'])? $contact['timeout']:$_SESSION['settings']['timeout'];

?>





<script>
var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';
var sy  = '<?php echo $sy; ?>';
var moid  = '<?php echo $moid; ?>';
var casti  = '<?php echo $casti; ?>';
var casto  = '<?php echo $casto; ?>';
			

$(function(){
	hd();
})



function redirContact(ucid){
	var moid			= $('#moid').val();
	var url 		= gurl + '/attdlogs/person/' + sy+'/'+moid+'/'+ucid;	
	window.location = url;		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

<?php 

$half = isset($half)? $half:false;

/* contacts attendance schema timein or out */



?>



<h5 class="screen" >	
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	
	<?php if($_SESSION['settings']['attendance_employees']==1): ?>
		| <a href="<?php echo URL.'registrars/attendanceEmployeesIndex/'; ?>" >Attendance Employees</a>	
	<?php endif; ?>		

	<?php if($user['role_id']==RMIS): ?>
		| <a href="<?php echo URL.'mis/calendar/'.$sy.DS.$moid; ?>" >Calendar</a>
	<?php endif; ?>	
	
		| <a href="<?php echo URL.'attendance/attd'; ?>" >Today</a>
		| <a href="<?php echo URL.'attendance/attendanceHalf/1st/'.$sy.DS.$moid.DS.$ucid.DS.$empl; ?>" >First</a>
		| <a href="<?php echo URL.'attendance/attendanceHalf/2nd/'.$sy.DS.$moid.DS.$ucid.DS.$empl; ?>" >Second</a>
		
</h5>

<!-------------------------------------------------------------------------------------->

<div class="hd" id="names" > </div>

<div class="half" >
<table class="screen tf14 gis-table-bordered table-fx"  >
<tr>
	<td>
		<select id="moid" class="full" >
			<?php foreach($months AS $sel): ?>
				<option value="<?php echo $sel['index']; ?>" <?php echo ($sel['index']==$moid)? 
					'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>			
		</select>
	</td>
	<td>Month</td>
</tr>
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="vc50" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table>


<h2 class="<?php echo $titlefont; ?>" >Attendance</h2>
<p><table class="<?php echo $headfont; ?> vc500 gis-table-bordered table-fx"  >
	<tr><th class="vc150" >Period</th><td class="" ><?php echo $yrmonth; ?></td></tr>
	<tr class="hd"  ><th>Schema</th><td><?php echo $casti.' - '.$casto; ?></td></tr>
	<tr><th>ID Number</th><td><?php echo $contact['code']; ?></td></tr>
	<tr><th>Person</th><td><?php echo $contact['contact']; ?></td></tr>
</table></p>

<table class="<?php echo $tblfont; ?> attd vc600 gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc50" >#</th>
	<th class="vc120" >Date</th>
	<th class="vc120" >Timein</th>
	<th class="vc120" >Timeout</th>
</tr>

<?php for($i=0;$i<$num_attendances;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M-d D',strtotime($attendances[$i]['date'])); ?></td>
	<td><?php echo ($attendances[$i]['timein']); ?></td>
	<td><?php echo $attendances[$i]['timeout']; ?></td>	
</tr>
<?php endfor; ?>
</table>
</div>

<!------------------------------------------------------------------------------------------------------>

<?php if(isset($_SESSION['employees'])): ?>
	<div class="third screen"  >
	  <ol>
		<?php for($i=0;$i<$count_employees;$i++): ?>
			<li><a href='<?php echo URL."attdlogs/person/$sy/$moid/".$_SESSION['employees'][$i]['ecid']; ?>' >
				<?php echo $_SESSION['employees'][$i]['name']; ?></a></li>
		<?php endfor; ?>
	  </ol>
	</div>
<?php endif; ?>
