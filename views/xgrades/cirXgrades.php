<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';


$sch=VCFOLDER;
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles/":"profiles/classroom/";	

pr($classrooms[2]);

?>

<h5 class="screen" >
	Std Expired CIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>




<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Classlist (Num of Students)</th>
	<th>Courses</th>
	<th class="center" >Traits</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $classrooms[$i]['crid']; ?></td>
	<td><a href='<?php echo URL."xgrades/classlist/".$classrooms[$i]['id']."/$sy"; ?>' >
		<?php echo $classrooms[$i]['classroom']; ?></a>
		 (<?php echo $classrooms[$i]['num_students']; ?>)
	</td>	

<td><a href='<?php echo URL."xgrades/courses/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Courses</a></td>
</tr>

<td>
	<?php for($q=1;$q<5;$q++): ?>
		<a href='<?php echo URL."cav/traits/$crs/$sy/$q"; ?>' >Q<?php echo $q; ?></a>			
	<?php endfor; ?>
</td>

<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	

})


</script>


