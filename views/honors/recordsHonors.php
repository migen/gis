<?php 

	$get = (isset($_GET['get']))? true:false;
	// pr($rows[0]);

?>

<h5>
	Honors Q<?php echo $qtr.' - '.$classroom['classroom']; ?> (<?=$count;?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."honors/records/$crid/$sy/$qtr?sort=honor"; ?>' >Honors</a>
	| <a href='<?php echo URL."honors/records/$crid/$sy/$qtr?sort=honor&get"; ?>' >Sort</a>
	| <a href='<?php echo URL."honors/records/$crid/$sy/$qtr?sort=student&order=ASC"; ?>' >Student</a>
	| <a href='<?php echo URL."honors/process/$crid/$sy/$qtr"; ?>' >Process</a>
	| <a href='<?php echo URL."honors/certificatesByClassroom/$crid/$sy/$qtr"; ?>' >Certificates</a>
	| <a href='<?php echo URL."honors/clsmatrix/$crid"; ?>' >HnrMatrix</a>
	| <a href="#" >Printable</a>
	| <a href="#" >Excel</a>
	
</h5>



<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Student</th>
	<th>Genave<br /><?php echo $_SESSION['settings']['factor_genave']; ?></th>
	<th>Cocurrs<br /><?php echo $_SESSION['settings']['factor_cocurrs']; ?></th>
	<th>Honors</th>
	<th>Rank<br />DB</th>
	<th>Rank</th>
	<th>Tie</th>
</tr>

<?php $rank=1; ?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><input id="genave<?php echo $i; ?>" onchange="tallyHonor(<?php echo $i; ?>);return false;" 
		class="vc50 pdl05" readonly name="post[<?php echo $i; ?>][genave]" value="<?php echo $rows[$i]['ave_q'.$qtr]; ?>"  /></td>		
	<td><input id="cocurr<?php echo $i; ?>" onchange="tallyHonor(<?php echo $i; ?>);return false;" 
		class="vc50 pdl05" name="post[<?php echo $i; ?>][cocurr]" value="<?php echo $rows[$i]['cocurr_q'.$qtr]; ?>"  /></td>	
	<td><input id="honor<?php echo $i; ?>" class="vc50 pdl05" name="post[<?php echo $i; ?>][honor]" 
		value="<?php echo $rows[$i]['honor_q'.$qtr]; ?>"  /></td>	
	<td><?php echo $rows[$i]['honor_rank_q'.$qtr]; ?></td>	
	<?php 
		$j = $i+1;
		$mine = $rows[$i]['honor_q'.$qtr];
		$next = @$rows[$j]['honor_q'.$qtr];
		$tie = ($mine==$next)? true:false;
	?>
	<td><input id="rank<?php echo $i; ?>" class="vc50 pdl05" name="post[<?php echo $i; ?>][rank]" 
		value="<?php echo ($get)? $rank:$rows[$i]['honor_rank_q'.$qtr]; ?>"  /></td>			
	
	<?php 
		$rank = (!$tie)? $rank+1:$rank;							
	
	?>
	<td class="<?php echo ($tie)?'red':NULL; ?>" ><?php echo ($tie)?'Tie':NULL; ?></td>
	<?php if(1==1): ?>
		<td><a href="<?php echo URL.'registrars/editStudentGrades/'.$rows[$i]['scid'].DS.$sy.DS.$qtr; ?>" >Grades</a></td>
		<td><a href="<?php echo URL.'summarizers/student/'.$rows[$i]['scid'].DS.$sy.DS.$qtr; ?>" >Genave</a></td>
		<td><a href="<?php echo URL.'conducts/editOne/'.$rows[$i]['scid'].DS.$sy.DS.$qtr; ?>" >Conduct</a></td>
	<?php endif; ?>
</tr>

	<input type="hidden" name="post[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>"  />
<?php endfor; ?>
</table>


<p><input type="submit" name="submit" value="Update" onclick="return confirm('Sure?');"  /></p>


</form>


<!------------------------------------------------------------------------------->

<script>

var gafactor = "<?php echo $_SESSION['settings']['factor_genave']; ?>";
var ccfactor = "<?php echo $_SESSION['settings']['factor_cocurrs']; ?>";

$(function(){
	nextViaEnter();
	selectFocused();
})

function tallyHonor(i){
	var a = $('#genave'+i).val()*gafactor;
	var b = $('#cocurr'+i).val()*ccfactor;
	var c = a+b;
	$('#honor'+i).val(c.toFixed(2));
	

}	/* fxn */


</script>

