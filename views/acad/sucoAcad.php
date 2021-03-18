<h5>
	Subject Coordinator
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>

<?php 
// pr($courses[0]);
?>


<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>ID</th>
	<th>Classroom</th>
	<th>Course<br />Label</th>
	<th>Records</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $courses[$i]['course_id']; ?></td>
	<td><?php echo $courses[$i]['classroom']; ?></td>
	<td><?php echo $courses[$i]['label']; ?></td>
	<td>
		<?php 
			$course_id 	= $courses[$i]['course_id'];
			$crid 		= $courses[$i]['crid'];
			if($courses[$i]['crstype_id']==CTYPEACAD){
				$type = ($courses[$i]['with_scores'])? "scores":"grades";
				$url = "teachers/$type/$course_id/$sy";
			} elseif($courses[$i]['crstype_id']==CTYPECONDUCT){
				$url = "conducts/records/$course_id/$sy";				
			} elseif($courses[$i]['crstype_id']==CTYPETRAIT){
				$url = "cav/traits/$course_id/$sy";				
			}
		
		?>
		<?php for($j=1;$j<5;$j++): ?>
			<a href='<?php echo URL.$url.DS.$j; ?>' >Q<?php echo $j; ?></a> &nbsp;
		<?php endfor; ?>	
	</td>
</tr>
<?php endfor; ?>
</table>

