<div>


<?php 

$cr = $data['classroom'];
$bonuses = $data['bonuses'];
$qtr = $data['qtr'];
$bqqtr = 'bonus_q'.$qtr; 

$bonusgrade = (BGRADE==1)? true : false;
$bonus 		= (BONUS==1)? true : false;
$bonustotal = (BONUSTOTAL==1)? true : false;
	
	
// pr($data);
// pr($bonuses[0]);
	
	

?>



<h5>
	<span ondblclick="tracehd();"  >Credits</span>
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy; ?>" />Attendance</a>	
</h5>

<!------------------------------------------------------------------------------->


<div class='third'>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom</th><td class="vc150" ><?php echo $cr['level'].' - '.$cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Class Size</th><td><?php echo $num_students; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr>
</table>


<!------------------------------------------------------------------------------->

<?php if(($_SESSION['qtr'] == 1) && ($classroom['is_init_grades']==0)): ?>
	<h4> Please ask MIS to setup Sync Grades. </h4>
<?php exit; endif; ?>

<!------------------------------------------------------------------------------->


<br />

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="" >SCID</th>
	<th>ID Number</th>
	<th>Student</th>
	<!-- left to right,iterate thru subjects -->
	<?php foreach($courses AS $row): ?>	
		<th class='center'>
			<?php if(!$is_locked && $bonus): ?>
				<a href="<?php echo URL.'teachers/editCourseBonuses/'.$cr['crid'].DS.$row['course_id'].DS.$sy.DS.$qtr; ?>"> <?php echo $row['course_code']; ?> </a>
			<?php else: ?>
				<?php echo $row['course_code']; ?> 
				<span class="hd" ><?php echo $row['course_id']; ?></span>
			<?php endif; ?>
		</th>
	<?php endforeach; ?>
</tr>

<?php $num_students = $data['num_students']; ?>		

<?php $courses = $data['courses']; ?>

<?php for($is=0;$is<$num_students;$is++): ?> 	<!-- loop thru num_students,top down -->

<?php $nb = count($bonuses[$is]); ?>
<?php if($nb == $num_courses): ?>
<tr>
	<td><?php echo $is+1; ?></td>
	<td class="" ><?php echo $students[$is]['scid']; ?></td>
	<td><?php echo $students[$is]['student_code']; ?></td>
	<td><?php echo $students[$is]['student']; ?>
	</td>
	
	<?php for($ic=0;$ic<$num_courses;$ic++): ?> 	<!-- loop thru num_courses -->
		<td class='center' style='vertical-align:middle;'>
			<?php if($bonusgrade): ?>
				<?php echo number_format($bonuses[$is][$ic]['q'.$qtr],2); ?><br />
			<?php endif; ?>		
			<?php echo number_format($bonuses[$is][$ic][$bqqtr],2); ?>
			<?php if($bonustotal): ?>
			<?php $btotal = $bonuses[$is][$ic]['q'.$qtr] + $bonuses[$is][$ic][$bqqtr]; ?>			
				<span class="b" ><?php echo number_format($btotal,BTDECI); ?></span>
			<?php endif; ?>
		</td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
	<td><a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid'].DS.$sy.DS.$qtr; ?>' >Grades</a></td>
</tr>

<?php else: ?>
<tr><td class="red" colspan="<?php echo $num_courses+5; ?>" > Please check with Registrars / MIS to update 
		<a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid'].DS.$sy.DS.$qtr; ?>' >Grades</a> of 
		<?php echo $students[$is]['student'].' with ID # '.$students[$is]['student_code']; ?> 
	
	</td></tr>
<?php endif; ?>

<?php endfor; ?>								<!-- endloop row num_students -->
</table>

</div>
</div>


<script>

$(function(){
	hd();
})

</script>