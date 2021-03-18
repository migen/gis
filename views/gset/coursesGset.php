<?php 

// pr($classrooms);
$srid = $_SESSION['srid'];

?>

<h5> 
<?php echo $level['name']; ?> Courses (BRID: <?php echo $brid; ?>)
Branch ID: <?php $d['branches']=$branches;$d['brid']=$brid;$this->shovel('selector_branches',$d); ?>			
<span class="screen" >	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'subjects'; ?>">Subjects</a>
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href='<?php echo URL."gset/courses/$lid/$sy?detailed"; ?>'>Detailed</a>
	| <a href='<?php echo URL."gset"; ?>'>GSET</a>
<?php if($srid==RMIS): ?>	
	| <a href='<?php echo URL."courses/config/$lid"; ?>'>Configure</a>
	| <a href='<?php echo URL."data/teachers"; ?>'>*Loads</a>
	| <a href='<?php echo URL."gset/crs/4"; ?>'>Assign</a>
	| <a href='<?php echo URL."courses/teachers"; ?>'>Assg-code</a>
<?php endif; ?>	
</span>
	| <a href='<?php echo URL."gset/renameCourses"; ?>' >Rename-Courses</a>	
	| <?php $this->shovel('links_gset'); ?>
	

</h5>


<p><?php $this->shovel('hdpdiv'); ?></p>


<p>
	<?php foreach($levels AS $row): ?>
		<a href='<?php echo URL."gset/courses/".$row['id']; ?>' ><?php echo $row['code']; ?></a> &nbsp;&nbsp;   
	<?php endforeach; ?>
</p>


<table class="gis-table-bordered" >
<tr class="headrow" >
	<th class="" ></th>
	<?php for($i=0;$i<$numrows;$i++): ?>
		<?php $crid = $classrooms[$i]['crid']; ?>
		<th>
			Sxng - <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>" ><?php echo $classrooms[$i]['crlabel']; ?></a> (<?= $crid; ?>)<br />
			<?php if($srid==RMIS): ?>
				<a href='<?php echo URL."classrooms/courses/".$classrooms[$i]['crid']; ?>' >Config</a>
			<?php endif; ?>
		</th>
	<?php endfor; ?>
</tr>

<tr>
	<td>LSC</td>
	<?php for($i=0;$i<$numrows;$i++): ?>
		<?php $count[$i] = count($courses[$i]);; ?>
		<td>
			Sem-Crs#-Label-Sub#<br />
			<?php // pr($classrooms[$i]); ?>
			
			<?php // pr($courses[$i]);  ?>
			<?php for($j=0;$j<$count[$i];$j++): ?>
				<?php echo $courses[$i][$j]['semester'].'-'; ?>
				<span class="<?php echo (!$courses[$i][$j]['is_active'])? 'red':NULL; ?>" ><?php echo $courses[$i][$j]['course_id'].'-'; ?>
				<?php if($srid==RMIS): ?>
					<a href='<?php echo URL."courses/edit/".$courses[$i][$j]['course_id']; ?>' ><?php echo $courses[$i][$j]['label']; ?></a>
				<?php else: ?>
					<?php echo $courses[$i][$j]['label']; ?>				
				<?php endif; ?>				
				<?php echo '('.$courses[$i][$j]['subject_id'].')<br />'; ?>
				</span>
			<?php endfor; ?>
		</td>
	<?php endfor; ?>
</tr>



</table>

<br />

<?php if($_SESSION['srid']!=RMIS) exit; ?>
<div class="clear" ></div>

<div class="third" >
<form method="POST" >
<h5 onclick="tracepass();" >Batch Create</h5>
<table class="hd gis-table-bordered" >
	<tr><td>Classroom ID's</td><td><input class="pdl05" name="classroom_string" /></td></tr>
	<tr><td>Subject ID's</td><td><input class="pdl05" name="subject_string" /></td></tr>
	<tr><td colspan="2" ><input onclick="return confirm('Proceed?');" type="submit" name="create" value="Create"  /></td></tr>
</table>
</form>

<!--------------delete--------------->
<form method="POST" >
<div class="hd" >
<h5>*Dangerous Batch DELETE</h5>
<table class="hd gis-table-bordered" >
	<tr><td>Course ID's</td><td><input class="pdl05" name="courses_string" /></td></tr>
	<tr><td colspan="2" ><input onclick="return confirm('DANGEROUS! Proceed?');" type="submit" name="delete" value="DELETE"  /></td></tr>
</table>
</form>
</div>
</div>

<div class="third" >
	<h5>Single Create</h5>
		<p class="red" >*Pending</p>
	<span class="hd" >
		<?php for($s=0;$s<$numsub;$s++): ?>
			<a href='<?php echo URL."mis/createCourses/$lid/".$subjects[$s]['id']."/$sy"; ?>' >
				<?php echo '#'.$subjects[$s]['id'].'-'.$subjects[$s]['code'].'-'.$subjects[$s]['name']; ?></a><br />
		<?php endfor; ?>
	</span>
</div>


<div class="third" >	<!-- allclassrooms -->
	<table class="gis-table-bordered table-altrow table-fx" >
	<?php foreach($allClassrooms AS $ac): ?>
		<tr><td><?php echo '#'.$ac['id'].'-'.$ac['code'].'-'.$ac['name']; ?></td></tr>
	<?php endforeach; ?>
	</table>
	<div class="ht100" >&nbsp;</div>
</div>	<!-- allclassrooms -->



<!------------------------------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';

	$(function(){ 
		// hd(); 
		$('#hdpdiv').hide();
	})
</script>
