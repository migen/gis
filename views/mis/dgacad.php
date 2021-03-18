

<?php

// pr($_SERVER); for home link,used by registrar and teacher
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			

?>

<h5>DG Academics
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>">Setup</a>
	| <a href="<?php echo URL.'mis/dgconductsForm'; ?>"> DG Conducts </a>
</h5>

<?php 
	
	// pr($data);

	
	$this->shovel('ratings',$ratings);
	
	
?>


<p><table class="gis-table-bordered table-fx" >
	<tr><th class='white headrow'>Department</th><td><?php echo $department['name']; ?></td></tr>	
	<tr><th class='white headrow'>Subject</th><td><?php echo $subject['name']; ?></td></tr>	
</table></p>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>

<!------------------------------------------------------------------------------------------->

<form method="POST"  >
<table class="gis-table-bordered table-altrow table-fx"  >

<tr class="headrow" >
	<th>#</th>
	<th>CID</th>
	<th>GID</th>
	<th>Crs#</th>
	<th>Course</th>
	<th>Student</th>
	<th class="center" >Q1</th>
	<th class="center" >Q2</th>
	<th class="center" >Q3</th>
	<th class="center" >Q4</th>
	<th class="center" >FG</th>
</tr>

<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $grades[$i]['scid']; ?></td>
	<td><?php echo $grades[$i]['gid']; ?></td>
	<td><?php echo $grades[$i]['course_id']; ?></td>
	<td><?php echo $grades[$i]['course']; ?></td>
	<td><?php echo $grades[$i]['student']; ?></td>
	<?php for($j=1;$j<5;$j++): ?>
		<td>
			<?php $gr = round($grades[$i]['q'.$j]) + round($grades[$i]['bonus_q'.$j]); ?>
				<input id="<?php echo $i; ?>q<?php echo $j; ?>" class="center vc25" name="grades[<?php echo $i; ?>][q<?php echo $j; ?>]" type="<?php echo 'text'; ?>" value="<?php echo round($grades[$i]['q'.$j]);  ?>"   />
				<input id="<?php echo $i; ?>bq<?php echo $j; ?>" class="center vc25" name="grades[<?php echo $i; ?>][bq<?php echo $j; ?>]" type="<?php echo 'text'; ?>" value="<?php echo round($grades[$i]['bonus_q'.$j]);  ?>"   />						
				 <?php echo $gr; ?> 				
			<br >
			<?php $dg = rating($gr,$ratings);  ?>
			 <?php echo $grades[$i]['dg'.$j]; ?>
			 - <input class="center vc25" name="grades[<?php echo $i; ?>][dg<?php echo $j; ?>]" type="<?php echo 'text'; ?>" value="<?php echo $dg;  ?>"  readonly />
		</td>		
	<?php endfor; ?>	
	<td>
		<?php $fg = round($grades[$i]['q5']); ?>			
			<input id="<?php echo $i; ?>fgrade" class="center vc50" name="grades[<?php echo $i; ?>][final]" value="<?php echo $fg;  ?>"  readonly />	
			- <?php echo $grades[$i]['dg5']; ?>
			<br >
			<?php $dgf = rating($fg,$ratings);  ?>
			<input class="center vc50" name="grades[<?php echo $i; ?>][dgf]" type="<?php echo 'text'; ?>" value="<?php echo $dgf;  ?>"  readonly />	
						
			
	</td>
	

	<td><a id="<?php echo $i; ?>" onclick="refinalize(this.id);return false;" > <button> Tally </button></a></td>

	<td class="hd" ><input class="center vc50" name="grades[<?php echo $i; ?>][gid]" type="<?php echo 'text'; ?>" value="<?php echo $grades[$i]['gid'];  ?>"  readonly /></td>	

	
</tr>
<?php endfor; ?>



</table>

<p>
	<input onclick="return confirm('Are you sure?');"  type="submit" name="tally" value="Update"   />
	<input onclick="return confirm('Are you sure?');"  type="submit" name="submit" value="Rating"   />
</p>
</form>




<!------------------------------------------------------------------------------------------------------------>



<script>

var gurl = 'http://<?php echo GURL; ?>';var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	nextViaEnter();
	
})


function refinalize(i){
	var c = 0;
	var total = 0;
	var q1  = $('#'+i+'q1').val();
	var bq1  = $('#'+i+'bq1').val();
	var tq1  = parseFloat(q1)+parseFloat(bq1);	
	
	var q2  = $('#'+i+'q2').val();
	var bq2  = $('#'+i+'bq2').val();
	var tq2  = parseFloat(q2)+parseFloat(bq2);	

	var q3  = $('#'+i+'q3').val();
	var bq3  = $('#'+i+'bq3').val();
	var tq3  = parseFloat(q3)+parseFloat(bq3);	

	var q4  = $('#'+i+'q4').val();
	var bq4  = $('#'+i+'bq4').val();	
	var tq4  = parseFloat(q4)+parseFloat(bq4);	
		
	if(tq1>50) { c++; total += parseFloat(tq1); } else { $('#'+i+'q1').val(0); }
	if(tq2>50) { c++; total += parseFloat(tq2); } else { $('#'+i+'q2').val(0); }
	if(tq3>50) { c++; total += parseFloat(tq3); } else { $('#'+i+'q3').val(0); }
	if(tq4>50) { c++; total += parseFloat(tq4); } else { $('#'+i+'q4').val(0); }
						
	var fgrade = total / c;
	fgrade = fgrade.toFixed(2);
		
	$('#'+i+'tq1').val(tq1.toFixed(2));
	$('#'+i+'tq2').val(tq2.toFixed(2));
	$('#'+i+'tq3').val(tq3.toFixed(2));
	$('#'+i+'tq4').val(tq4.toFixed(2));
	$('#'+i+'fgrade').val(fgrade);
}



</script>


