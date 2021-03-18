<?php 


	$deciconducts 		= $_SESSION['settings']['deciconducts'];
	$decicard 		= $_SESSION['settings']['decicard'];
	$decifconducts  = $_SESSION['settings']['decifconducts'];
	$dgonly=isset($_GET['dgonly'])? '?dgonly':NULL;
	

?>

<script>

	var gurl = 'http://<?php echo GURL; ?>';
	var rcardgdeci  = '<?php echo $decicard; ?>';
	var fcgdeci 	= '<?php echo $decifconducts; ?>';

	$(function(){	
		hd(); nextViaEnter();		
	});
	


$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	tallyAve();
	
})


function tallyAve(){
	var numtp = '<?php echo $num_grades; ?>';
	
	var tptotal = 0;
	var tpave   = 0;
	
	$('.tp').each(function(){
		tptotal += parseFloat($(this).val());	
	})

	tpave = tptotal / numtp;	
	// alert(tpave);
	$('#tpave').val(tpave.toFixed(rcardgdeci));

}	// fxn
	
	
</script>




<h5>
	Edit Student Traits |
	<?php 	$this->shovel('homelinks',$home); ?>	
	| <a class="" href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	| <a href='<?php echo URL."utils/syncStudentTraits/$course_id/$scid/$sy/$qtr"; ?>' >Sync</a>
<?php if($dgonly): ?>	
	| <a href='<?php echo URL."cav/edit/$course_id/$scid/$sy/$qtr"; ?>' >Numeric</a>
<?php else: ?>	
	| <a href='<?php echo URL."cav/edit/$course_id/$scid/$sy/$qtr?dgonly"; ?>' >DG Only</a>
<?php endif; ?>	
	<?php if($_SESSION['srid']==RTEAC): ?>
		| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr$dgonly"; ?>' >Traits</a>
	<?php else: ?>
		| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr$dgonly"; ?>' >Traits</a>	
		| <a href='<?php echo URL."mis/dgtraits/$sy/$qtr/$is_trait/$crid"; ?>' >DG Traits</a>	
	<?php endif; ?>
		
</h5>


<!---------------------------------------------------------------->
<div class="left half ht1000" >

<h4>Details</h4>
<table class='gis-table-bordered table-fx'>

<tr class="hd" ><th class='bg-blue2'>CrsId</th><td><?php echo $course['id']; ?></td></tr>
<tr class="hd" ><th class='bg-blue2'>Scid</th><td><?php echo $student['scid']; ?></td></tr>
<tr><th class='bg-blue2'>Course</th><td><?php echo $course['name']; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>
<br />
<!---------------------------------------------------------------->


<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr class="headrow" >
	<th class="hd" >GID</th>
	<th class="hd" >Cri</th>
	<th>#</th>
	<th>TP</th>
	<th>Wt</th>
	<th>Grade</th>
	<th>DG</th>
</tr>

<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td class="hd" ><?php echo $grades[$i]['gid']; ?></td>
	<td class="hd" ><?php echo $grades[$i]['criteria_id']; ?></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $grades[$i]['criteria']; ?></td>
	<td><?php echo $criteria[$i]['weight']; ?></td>
	<td><input class="tp vc50 right" type="text" name="grades[<?php echo $i; ?>][grade]" 
		value="<?php echo number_format($grades[$i]['grade'],$deciconducts); ?>" tabindex="2"  /></td>
	<td><input class="tp vc50 center" type="text" name="grades[<?php echo $i; ?>][dg]" 
		value="<?php echo $grades[$i]['dg']; ?>" tabindex="4"  /></td>

	<!------------------------->
	<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"   />

</tr>
<?php endfor; ?>
<?php if($dgonly): ?>
	<th colspan="3" >Final</th>
	<td><input class="tp vc50 right" type="text" name="post[final]" 
		value="<?php echo number_format($grades[0]['final'],$deciconducts); ?>" tabindex="2"  /></td>
	<td><input class="tp vc50 center" type="text" name="post[dgfinal]" 
		value="<?php echo $grades[0]['dgfinal']; ?>" tabindex="4"  /></td>
<?php endif; ?>

<input type="hidden" name="scid" value="<?php echo $scid; ?>"   />

</table>
<?php if(!$is_locked): ?>
	<p>
		<input type="submit" name="save" value="Save" /> &nbsp; 
		<button><a class="txt-black no-underline" href='<?php echo URL."cav/traits/$course_id/$sy/$qtr"; ?>' > Class Record </a></button>
	</p>
<?php endif; ?>
</form>

</div>

<!---------------------------------------------------------------->


<div class="fifth"  >
<h5>Boys</h5>
<?php foreach($boys AS $row): ?>
<p><a href="<?php echo URL.'cav/edit/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr.$dgonly; ?>" >
	<?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

<div class="fifth"  >
<h5>Girls</h5>
<?php foreach($girls AS $row): ?>
<p><a href="<?php echo URL.'cav/edit/'.$course_id.DS.$row['scid'].DS.$sy.DS.$qtr.$dgonly; ?>" >
	<?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

<!-------------------------------------------------------------------->

