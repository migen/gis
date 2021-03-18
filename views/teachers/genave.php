
<?php 


$cr  = $classroom	= $data['classroom'];
$qtr = $qtr = $data['qtr'];
$qqtr		= 'q'.$qtr;



// pr($classroom);
$is_ps	= $classroom['is_ps'];
$is_k12	= $classroom['is_k12'];
$is_hs	= $classroom['is_hs'];

$is_bedk12 	= ($is_k12 && !$is_ps);
// echo ($is_bedk12)? 'yes bedk12' : 'not bedk12';



// ================= DEFINE VARS ====================================

	
// ================= DEBUG ==========================================
// pr($data);
	
$this->shovel('ratings',$ratings);

	
?>



<h5>
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<h2 class='darkgray'> Averages - qtr <?php echo $qtr; ?> </h2>

<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $cr['id']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>

<br />

<form method="POST" >

<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="hd" >CID</th>
	<th class="vc50" >ID Number</th>
	<th class="vc150" >Student</th>
	<?php for($ic=0;$ic<$num_subjects;$ic++): ?>	
		<th class='center vc50'> 
			<?php echo $averages[0][$ic]['subject']; ?> 
			<span class="hd" ><br /><?php echo $averages[0][$ic]['course_id']; ?></span>			 
		</th>
	<?php endfor; ?>
	<th class="vc50" >Gen<br />Ave</th>
	
</tr>


<?php for($is=0;$is<$num_students;$is++): ?> 	<!-- loop thru num_students-->
	
<?php $sum = 0; ?>
<?php $ave = 0; ?>

<tr>
	<td><?php echo $is+1; ?></td>
	<!-- $is = student; 0 = first course;  -->
	<td class="hd" ><?php echo $averages[$is][0]['scid']; ?></td>
	<td class="vc50" ><?php echo $averages[$is][0]['student_code']; ?></td>
	<td class="vc150" ><?php echo $averages[$is][0]['student']; ?></td>
	<?php for($ic=0;$ic<$num_subjects;$ic++): ?> 	<!-- loop thru num_courses -->
		<td class='center vc50' style='vertical-align:middle;' >
			<?php $addgr = $averages[$is][$ic][$qqtr] + $averages[$is][$ic]['bonus_q'.$qtr]; echo number_format($addgr,2); ?>
			<?php $sum += $addgr; ?>
		</td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
	
	<!-- genave -->
	<?php $ave = $sum / $num_subjects; ?>
	<td class="vc50" style='vertical-align:middle;' >
		<input class="vc50 center" type="text" name="data[summary][<?php echo $is; ?>][<?php echo 'ave_q'.$qtr; ?>]"  value="<?php echo number_format($ave,2); ?>"  />
		<?php if(!$cr['is_ps']): ?>
			<br /> <?php $rave = ($is_bedk12)? round($ave) : $ave; $dave = rating($rave,$ratings); ?>
			<input class="vc50 center" type="text" name="data[summary][<?php echo $is; ?>][<?php echo 'ave_dg'.$qtr; ?>]"  value="<?php echo $dave; ?>"  />			
		<?php endif; ?>			
	</td>
		
	<input type="hidden" name="data[summary][<?php echo $is; ?>][scid]" value="<?php echo $averages[$is][0]['scid']; ?>" >	
</tr>
<?php endfor; ?>								<!-- endloop row num_students -->
</table>


<br />

<?php if($cr['is_ps']): ?>
	<input type="hidden" name="is_ps" value="1" >
<?php endif; ?>

<?php if($is_locked): ?>

<?php else: ?>	
	<input type="submit" name="update" value="Finalize" >
	<br />
	<br />
<?php endif; ?>

<?php echo isset($_SERVER['HTTP_REFERER'])? ' <a href="'.$_SERVER['HTTP_REFERER'].'" >Cancel</a>' : ''; ?>				



</form>



<script>

$(function(){
	hd();
})

</script>