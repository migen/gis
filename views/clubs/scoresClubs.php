<?php 
$size=isset($_GET['size'])? $_GET['size']:1;
$is_locked=($club['is_finalized_q'.$qtr]==1)? 1:0;

// pr($data);
// pr($rows[0]);


?>

<style>
.tdscore{ font-size:<?php echo $size.'em'; ?>;}
</style>


<h5>
	Club Scores (<?php echo $count; ?>) 
	| Status - <?php echo ($is_locked)? 'Finalized':'Open';  ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('shd');" >SHD</span>
	| <a href="<?php echo URL.'clubs/members/'.$club_id.DS.$sy.DS.$qtr; ?>" >Members</a>	
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Grades</a>		
<form method="GET" style="display:inline;" >
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
	<input type="submit" name="submit" value="Go" >	
</form>			

	
</h5>



<?php include_once('incs/clubDetails.php'); ?>


<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >

<?php if($is_locked): ?>
	<tr>
	<th>#</th>
	<th class="shd" >Scid</th>
	<th class="tdscore" >Classroom</th>
	<th class="tdscore" >Sex</th>
	<th class="tdscore" >ID No.</th>
	<th class="tdscore" >Student</th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[0]['code']); ?>
	<br /><?php echo '('.$clubcriteria[0]['weight'].')'; ?></th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[1]['code']); ?>
	<br /><?php echo '('.$clubcriteria[1]['weight'].')'; ?></th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[2]['code']); ?>
	<br /><?php echo '('.$clubcriteria[2]['weight'].')'; ?></th>
	<th class="tdscore" >Total</th>
	</tr>
<?php else: ?>
	<tr>
	<th>#</th>
	<th class="shd" >Scid</th>
	<th class="tdscore" >Classroom</th>
	<th class="tdscore" >Sex</th>
	<th class="tdscore" >ID No.</th>
	<th class="tdscore" >Student</th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[0]['code']); ?>
	<br /><?php echo '('.$clubcriteria[0]['weight'].')'; ?>
	<br /><a href="<?php echo URL.'clubs/editColumn/'.$club_id.'/1'; ?>" >Edit</a></th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[1]['code']); ?>
	<br /><?php echo '('.$clubcriteria[1]['weight'].')'; ?>
	<br /><a href="<?php echo URL.'clubs/editColumn/'.$club_id.'/2'; ?>" >Edit</a></th>
	<th class="tdscore" ><?php echo ucfirst($clubcriteria[2]['code']); ?>
	<br /><?php echo '('.$clubcriteria[2]['weight'].')'; ?>
	<br /><a href="<?php echo URL.'clubs/editColumn/'.$club_id.'/3'; ?>" >Edit</a></th>
	<th class="tdscore" >Total</th>
	<th class="" ></th>
	</tr>
<?php endif; ?>

<?php if($is_locked): ?>

	<?php for($i=0;$i<$count;$i++): ?>	
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['classroom']; ?></td>
		<td class="tdscore" ><?php echo ($rows[$i]['is_male']==1)? 'B':'G'; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['student_code']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['student']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri1']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri2']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri3']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['total']; ?></td>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['classroom']; ?></td>
		<td class="tdscore" ><?php echo ($rows[$i]['is_male']==1)? 'B':'G'; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['student_code']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['student']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri1']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri2']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['cri3']; ?></td>
		<td class="tdscore" ><?php echo $rows[$i]['total']; ?></td>
		<td><a href="<?php echo URL.'clubs/student/'.$rows[$i]['scid']; ?>" >Edit</a></td>		
	</tr>
	<?php endfor; ?>
<?php endif; ?>
	
	
</table>

<?php if(!$is_locked): ?>
	<p><input type="submit" name="finalize" value="Finalize"  /></p>
<?php endif; ?>
</form>

<div class="ht50 clear" >&nbsp;</div>

<script>

$(function(){
	shd();
	
})

</script>