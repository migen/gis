<script>

$(function(){
	hd();
})

</script>

<?php 

$cr = $classroom = $data['classroom'];
$qtr = $qtr = $data['qtr'];

$is_ps	= $classroom['is_ps'];
$is_k12	= $classroom['is_k12'];
$with_rating = ($is_k12 && !$is_k12);

// ================= DEFINE VARS ====================================
// $characters 		=	 $data['characters'];


// ================= DEBUG ==========================================
// pr($data);
// pr($cr);
// pr($ratings);

// ================= FORMULA/S ==========================================	

$this->shovel('ratings',$ratings);
	
// ================= TRACE ==========================================	
// echo " <br /><button onclick='summary();' > Trace </button><br />	";
	
?>


<h5>
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? ' | <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<h2 class='darkgray'> Average <?php if($qtr < 5): ?>- qtr <?php echo $qtr; ?> <?php endif; ?></h2>


<table class='gis-table-bordered table-fx'>
	<tr><th class='white bg-blue2'>-Class</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr><th class='white bg-blue2'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white bg-blue2'>Section</th><td><?php echo $cr['section']; ?></td></tr>
	<tr><th class='white bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
	
</table>

<p>
<?php if($classroom['is_k12']==1): ?>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '<a class="button" style="font-size:14px;" href="'.$_SERVER['HTTP_REFERER'].'" >Detailed</a>' : ''; ?>			
<?php endif; ?>

</p>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<td>#</td>
	<td class="hd" >CID</td>
	<td>ID Number</td>
	<td>Student</td>
	<td class="center" >Q1</td>
	<td class="center" >Q2</td>
	<td class="center" >Q3</td>
	<td class="center" >Q4</td>
	<td class="center" >Ave</td>	
<tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<?php $fg = 0; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $characters[$i]['scid']; ?></td>
	<td><?php echo $characters[$i]['student_code']; ?></td>
	<td><?php echo $characters[$i]['student']; ?></td>
	<?php for($j=1;$j<5;$j++): ?>
		<td class="center" >
			<?php $x = $characters[$i]['q'.$j]; ?>
			<?php if($j <= $qtr) $fg += $x; ?>
			<?php echo $x; ?>		
			<br /><?php echo rating($x,$ratings); ?>			
		</td>
	<?php endfor; ?>
	<td>
		<input class="vc50 center" type="text" name="data[summary][<?php echo $i; ?>][conduct_q5]" value="<?php $fg /= $qtr; echo number_format($fg,2); ?>" readonly >
		<br /><input class="vc50 center" type="text" name="data[summary][<?php echo $i; ?>][conduct_dg5]" value="<?php $dg = rating($fg,$ratings); echo $dg; ?>" readonly >
		<input type="hidden" name="data[summary][<?php echo $i; ?>][sumid]" value="<?php echo $characters[$i]['sumid']; ?>" readonly >
	</td>		
</tr>

<?php endfor; ?>
</table>

<p class="hd" ><input type="submit" name="submit" value="Tally Final Averages" /></p>

</form>
