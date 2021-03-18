<?php 

// echo "with-dg: $with_dg <br />";
// pr($conduct);


// echo "fg: $flrgr ";

$deciconducts  = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];


$this->shovel('ratings',$ratings);

// pr($ratings);

?>

<h5>Edit Student Conduct 
| <?php echo "Q$qtr - "; echo ($is_locked)? 'Locked':'Open'; ?>


</h5>

<!--------------------------------------------------------------------------->

<div class="left half ht1000" >
<form method="POST" >
<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>



<?php for($i=1;$i<=$qtr;$i++): ?>
	<?php if($i==$qtr): ?>
		<tr><th class='bg-blue2'><?php echo "Q$i"; ?></th><td>
			<input onchange="tallyAveConduct();" class="cg pdl05 vc100 " name='<?php echo "q$i"; ?>' value="<?php $cg = number_format($conduct['q'.$i],$deciconducts); echo $cg; ?>" >
			<?php if($with_dg): ?>
				<?php echo $conduct['dg'.$i]; ?>
			<?php endif; ?>
		</td></tr>
	<?php else: ?>
		<tr><th class='bg-blue2'><?php echo "Q$i"; ?></th><td><?php echo $conduct['q'.$i]; ?></td>
			<input class="cg" type="hidden" value="<?php echo $conduct['q'.$i]; ?>" readonly />
		</tr>	
	<?php endif; ?>
<?php endfor; ?>
<tr><th class='bg-blue2'>FG</th><td>
	<input id="cgave" class="pdl05 vc100" name="cgave" value="<?php $dgf = number_format($conduct['q5'],$decifconducts); echo $dgf; ?>"  readonly />
	<?php if($with_dg): ?>
			<?php echo $conduct['dg5']; ?>	
	<?php endif; ?>
</td></tr>

<input type="hidden" name="scid" value="<?php echo $scid; ?>"   />
<input type="hidden" name="gid" value="<?php echo $conduct['gid']; ?>"   />
<input type="hidden" name="sumid" value="<?php echo $conduct['sumid']; ?>"   />

</table>

	<p>
		<input onclick="return confirm('Warning,Cannot Undo!');" type="submit" name="save" value="Save" /> &nbsp; 
		<button><a class="txt-black no-underline" href='<?php echo URL."conducts/records/$course_id/$sy/$qtr"; ?>' > Class Record </a></button>
	</p>


</div>


<!--------------------------------------------------------------------------->

<div class="fifth"  >
<h5>Boys</h5>
<?php foreach($boys AS $row): ?>
<p><a href='<?php echo URL."conducts/edit/$sy/$qtr/$course_id/".$row['scid']; ?>' ><?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>

<div class="fifth"  >
<h5>Girls</h5>
<?php foreach($girls AS $row): ?>
<p><a href='<?php echo URL."conducts/edit/$sy/$qtr/$course_id/".$row['scid']; ?>' ><?php echo $row['student']; ?></a></p>
<?php endforeach; ?>
</div>




<script>

var gurl = 'http://<?php echo GURL; ?>';
var fcgdeci = '<?php echo $decifconducts; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var flrgr 	= '<?php echo $flrgr; ?>';


$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	tallyAveConduct();
	
})


function tallyAveConduct(){
	
	var cgtotal 	= 0;
	var cgave   	= 0;
	var val			= 0;
	
	$('.cg').each(function(){
		val = $(this).val();
		if(val>flrgr) { cgtotal += parseInt(val); } else { cgtotal += parseInt(flrgr); } 	
	})

	cgave = cgtotal / qtr;	
	
	// alert('cgtotal: '+cgtotal+',cgave: '+cgave);
	$('#cgave').val(cgave.toFixed(fcgdeci));

}	/* fxn */


</script>
