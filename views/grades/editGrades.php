<h5>

<?php 
	// echo $row['student'].' | '.$row['course']; 
	$edit=isset($_GET['edit'])? true:false;

	$sqtr = $_SESSION['qtr'];
?>

	Change Grade
	| <a href='<?php echo URL."grades/edit/$crsid/$scid/$gid?edit"; ?>' />Bonus</a>  
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."grades/edit/$crsid/$scid/$gid?qtr=$sqtr"; ?>' />Ave Q<?php echo $_SESSION['qtr']; ?></a>  
	| <a href='<?php echo URL."grades/edit/$crsid/$scid/$gid?qtr=4"; ?>' />Ave Q4</a>  


</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>Scid</th><td><?php echo $row['scid'].' | Gid: '.$row['gid']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>Course</th><td><?php echo $row['course'].' #'.$row['course_id'];  ?></td></tr>
<tr><th></th><td>&nbsp; Grade&nbsp; | &nbsp; DG &nbsp;&nbsp;&nbsp; | Bonus</td></tr>
<?php for($i=1;$i<=4;$i++): ?>
	<tr><th>Q<?php echo $i; ?></th><td>		
		<input type="hidden" id="orig<?php echo $i; ?>" value="<?php echo $row['q'.$i]; ?>" />
		<input type="hidden" id="borig<?php echo $i; ?>" value="<?php echo $row['bonus_q'.$i]; ?>" />
		<?php if($edit): ?>
			<input onchange="getAve();" class="pdr05 right vc50" 
			name="post[q<?php echo $i; ?>]" value="<?php echo $row['q'.$i]; ?>" />				
		<?php else: ?>
			<input onchange="getBonus(<?php echo $i; ?>);return false;" class="pdr05 right vc50" tabIndex=2
				name="post[q<?php echo $i; ?>]" value="<?php echo $row['q'.$i]; ?>" />		
		<?php endif;  ?>

		<input class="pdr05 right vc50" name="post[dg<?php echo $i; ?>]" value="<?php echo $row['dg'.$i]; ?>" />
		<?php if($edit): ?>
			<input class="pdr05 right vc50" name="post[bonus_q<?php echo $i; ?>]" 
				value="<?php echo $row['bonus_q'.$i]; ?>"  />						
		<?php else: ?>
			<input onchange="getGrade(<?php echo $i; ?>);return false;" class="pdr05 right vc50" 
				name="post[bonus_q<?php echo $i; ?>]" value="<?php echo $row['bonus_q'.$i]; ?>" readonly />				
		<?php endif; ?>

	</td></tr>
<?php endfor; ?>
	<input type="hidden" name="post[bonus_q5]" value="<?php echo $row['bonus_q5']; ?>" />
	<input type="hidden" name="post[bonus_q6]" value="<?php echo $row['bonus_q6']; ?>" />

<tr><th>Ave</th><td>
	<input id="ave" class="pdr05 right vc50" name="post[q5]" value="<?php echo $row['q5']; ?>" />
	<input class="pdr05 right vc50" name="post[dg5]" value="<?php echo $row['dg5']; ?>" />
</td></tr>

<?php $hd = ($row['semester']==2)? NULL:'hd'; ?>
<tr class="<?php echo $hd; ?>" ><th>Ave Sem2</th><td>
	<input class="pdr05 right vc50" name="post[q6]" value="<?php echo $row['q6']; ?>" />
	<input class="pdr05 right vc50" name="post[dg6]" value="<?php echo $row['dg6']; ?>" />
</td></tr>

<tr>
<th>Memo (<span id="chars" >160</span>)</th>
<td><textarea name="post[memo]" onkeyup="countChars(this.value);" ></textarea></td>
</tr>

</table>


<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save" />
	<button><a class="txt-black no-underline" href='<?php echo URL."averages/course/$crsid/$sy/$qtr"; ?>' >Averages</a></button>
</p>
</form>


<!-------------------------------------------------------------->
<script>

var sy = "<?php echo $sy; ?>";
var qtr = "<?php echo $qtr; ?>";

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	
})


function getBonus(i){
	var a = $('#orig'+i).val();		
	var b = $('#borig'+i).val();		
	var q = $('input[name="post[q'+i+']"]').val();		
	r=parseFloat(q)-parseFloat(a)+parseFloat(b);
	$('input[name="post[bonus_q'+i+']"]').val(r);
	getAve();
 
}	/* fxn */



function getGrade(i){
	var q = $('#orig'+i).val();		
	var b = $('input[name="post[bonus_q'+i+']"]').val();		
	r=parseFloat(q)+parseFloat(b);
	$('input[name="post[q'+i+']"]').val(r);
	getAve();

}	/* fxn */


function getAve(){
	var q1 = $('input[name="post[q1]"]').val();		
	var q2 = $('input[name="post[q2]"]').val();		
	var q3 = $('input[name="post[q3]"]').val();		
	var q4 = $('input[name="post[q4]"]').val();		
	var total = 0;

	for(var i=1;i<=qtr;i++){
		total += parseFloat(eval('q'+i));	
	}
	var ave = total/qtr;
	$('#ave').val(ave.toFixed(2));
}	/* fxn */



function countChars(txt){
	var len = txt.length;
	var left = parseInt(160)-parseInt(len);
	$('#chars').text(left);
}	/* fxn */






</script>

