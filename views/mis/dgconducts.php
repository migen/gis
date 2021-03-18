

<?php 

// pr($data);
// pr($course);
// pr($ratings);


// pr($conducts[0]);

function getFloorGrade($course,$settings){	
	return $settings['floor_grade'];
}

function getFloorGradeByDept($dept,$settings){
	return $settings['floor_grade']; 
}


$flrgr = getFloorGradeByDept($dept,$_SESSION['settings']);



// pr($_SERVER); for home link,used by registrar and teacher
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			





?>

<h5>
	DG Conducts | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>">Setup</a>
	
</h5>


<?php 


// ================= DEFINE VARS ====================================

$qtr 		= $qtr;
$qqtr 		= 'q'.$qtr;
$kpup		= 1;



// ================= DEBUG ==========================================
// pr($data);
$is_locked = 0;

	
// ================= TRACE ==========================================	

$this->shovel('ratings',$ratings);



?>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>

<!----------------------------------------------------------------------------------------------------------------->


<?php  $this->shovel('offset'); ?>


<form method="POST">	<!-- to update summaries conducts when finalizing,no need for grades since ajax editing -->

<table class="gis-table-bordered table-fx" >
<thead class="frozen" >
<tr class="bg-blue2" >
<th>#</th>
<th>CID</th>
<th>GID</th>
<th>ID Number</th>
<th>Course</th>
<th>Student</th>

<th class="<?php echo ($qtr==1)? 'current' : null; ?>" >
	<?php if($qtr==1): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="1" readonly /><?php else: ?>Q1<?php endif; ?>
</th>
<th class="<?php echo ($qtr==2)? 'current' : null; ?>" >
	<?php if($qtr==2): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="2" readonly /><?php else: ?>Q2<?php endif; ?>
</th>
<th class="<?php echo ($qtr==3)? 'current' : null; ?>" >
	<?php if($qtr==3): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="3" readonly /><?php else: ?>Q3<?php endif; ?>
</th>
<th class="<?php echo ($qtr==4)? 'current' : null; ?>" >
	<?php if($qtr==4): ?>Q &nbsp; <input class="center vc30" type="text" name="data[qtr]" value="4" readonly /><?php else: ?>Q4<?php endif; ?>
</th>

<th>FG-<?php echo $qtr; ?></th>

</tr>
</thead>

<?php for($i=0;$i<$num_conducts;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>

<!------------------------------------------------------------------------------------------------------------------------------------------------>	
<input type="hidden"  name="data[summary][<?php echo $i; ?>][q1]" value="<?php echo $conducts[$i]['q1']; ?>"  />
<input type="hidden"  name="data[summary][<?php echo $i; ?>][q2]" value="<?php echo $conducts[$i]['q2']; ?>"  />
<input type="hidden"  name="data[summary][<?php echo $i; ?>][q3]" value="<?php echo $conducts[$i]['q3']; ?>"  />
<input type="hidden"  name="data[summary][<?php echo $i; ?>][q4]" value="<?php echo $conducts[$i]['q4']; ?>"  />
<!------------------------------------------------------------------------------------------------------------------------------------------------>	
		
	<td class="" ><?php echo $conducts[$i]['scid']; ?></td>
	<td><?php echo $conducts[$i]['gid']; ?></td>
	<td><?php echo $conducts[$i]['student_code']; ?></td>
	<td><?php echo $conducts[$i]['course']; ?></td>
	<td><?php echo $conducts[$i]['student']; ?></td>
	
	<td class="center <?php echo ($qtr==1)? 'current' : null; ?>" >
		<?php if($qtr==1): ?>				
			<input name="data[summary][<?php echo $i; ?>][q1]" class="center vc80" type="text" value="<?php $cg = $conducts[$i]['q1']; echo number_format($cg,2); ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<?php if($kpup): ?> 
				<br >
				<?php $dg = rating($cg,$ratings); echo $dg;  ?>
				<input name="data[summary][<?php echo $i; ?>][dg1]" type="hidden" value="<?php echo $dg;  ?>"  readonly />
			<?php endif; ?>
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />
		<?php else: ?>
			<?php echo $conducts[$i]['q1'];  ?>
			<?php if($kpup): ?><br /><?php echo $conducts[$i]['dg1']; ?><?php endif; ?>
		<?php endif; ?>		
	</td>
	
	<td class="<?php echo ($qtr==2)? 'current' : null; ?>" >
		<?php if($qtr==2): ?>				
			<input name="data[summary][<?php echo $i; ?>][q2]" class="center vc80" type="text" value="<?php $cg = $conducts[$i]['q2']; echo number_format($cg,2); ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<?php if($kpup): ?>
				<br ><input name="data[summary][<?php echo $i; ?>][dg2]" class="center vc80" type="text" value="<?php $dg = rating($cg,$ratings);  echo $dg; ?>" readonly />
			<?php endif; ?>			
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />
		<?php else: ?>
			<?php echo $conducts[$i]['q2']; ?>
			<?php if($kpup): ?><br /><?php echo $conducts[$i]['dg2']; ?><?php endif; ?>			
		<?php endif; ?>		
	</td>

	<?php 
		// pr($conducts);
	?> 
	<td class="<?php echo ($qtr==3)? 'current' : null; ?>" >
		<?php if($qtr==3): ?>				
			<input name="data[summary][<?php echo $i; ?>][q3]" class="center vc80" type="text" value="<?php $cg = $conducts[$i]['q3']; echo number_format($cg,2); ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<?php if($kpup): ?>			
				<br ><input name="data[summary][<?php echo $i; ?>][dg3]" class="center vc80" type="text" value="<?php $dg = rating($cg,$ratings);  echo $dg; ?>"  readonly />
			<?php endif; ?>
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />		
		<?php else: ?> 
			<?php echo $conducts[$i]['q3']; ?>
			<?php if($kpup): ?><br /><?php echo $conducts[$i]['dg3']; ?><?php endif; ?>			
		<?php endif; ?>		
	</td>

	<td class="<?php echo ($qtr==4)? 'current' : null; ?>" >
		<?php if($qtr==4): ?>				
			<input name="data[summary][<?php echo $i; ?>][q4]" class="center vc80" type="text" value="<?php $cg = $conducts[$i]['q4']; echo number_format($cg,2); ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> />
			<?php if($kpup): ?> 
				<br ><input name="data[summary][<?php echo $i; ?>][dg4]" class="center vc80" type="text" value="<?php $dg = rating($cg,$ratings); echo $dg; ?>"  readonly />
			<?php endif; ?>
			<input type="hidden" name="data[summary][<?php echo $i; ?>][gid]" value="<?php echo $conducts[$i]['gid']; ?>"  />		
		<?php else: ?> 
			<?php echo $conducts[$i]['q4']; ?>
			<?php if($kpup): ?><br /><?php echo $conducts[$i]['dg4']; ?><?php endif; ?>			
		<?php endif; ?>		
	</td>	
	
	
<!----------------------------------------------------------------------------------------------------------------->
	
	<td class="center" >
		<?php echo $conducts[$i]['q5']; ?>
		<br /><input type="hidden" class="vc50 center" name="data[summary][<?php echo $i; ?>][final]" value="<?php echo $conducts[$i]['q5']; ?>" readonly />
		<?php if($kpup): ?>
				<?php $dgf = rating($conducts[$i]['q5'],$ratings); echo $dgf; ?>
				<input name="data[summary][<?php echo $i; ?>][dgf]" type="hidden" value="<?php echo $dgf; ?>"  <?php echo ($is_locked)? 'readonly' : null; ?> readonly />
		<?php endif; ?>	
	</td>
		
	
	<input type="hidden" name="data[summary][<?php echo $i; ?>][scid]" value="<?php echo $conducts[$i]['scid']; ?>"  />
	
		
</tr>
<?php endfor; ?>
</table> <br />


<?php if($kpup): ?>
	<input type="hidden" name="is_kpup" value="1" />
<?php endif; ?>

	<input type='hidden' name='data[qqtr]' value="<?php echo $qqtr; ?>">		
	<input type='hidden' name='data[qtr]' value="<?php echo $data['qtr']; ?>">

<?php 


echo " <input type='submit' name='update' value='Update' onclick=\"return confirm('Please Finalize.');\" /> ";	
echo " <input type='submit' name='finalize' value='Finalize' onclick=\"return confirm('You sure?');\" /> ";		


?>

<input type="hidden" name="data[flrgr]" value="<?php echo $flrgr; ?>"  />	
	
</form>


<?php 

// pr($conducts[0]);	
// pr($ratings);

?>


<!--------------------------------------------------------------------------->

<script>
var hdpass = '<?php echo HDPASS; ?>';

	$(function(){	
		$('#hdpdiv').hide();
		hd();
		nextViaEnter();
		selectFocused();
		
	});
</script>
