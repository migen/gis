<?php 

// pr($_SESSION['q']);
$q=$_SESSION['q'];
debug($q);
$note="&qtr=";
debug($note);

?>


<h5>
	<?php echo $row['course']; ?>
	Course Locking 
	
	
</h5>



<table class="gis-table-bordered" >
<tr><th>Crs</th><td><?php echo $crs; ?></td></tr>
<tr><th>Course</th><td><?php echo $row['course']; ?></td></tr>
<tr><th>Teacher</th><td><?php echo $row['teacher']; ?></td></tr>

<?php for($i=1;$i<$qtr;$i++): ?>
	<tr><th>Q<?php echo $i; ?></th><td><?php echo ($row['is_finalized_q'.$i]==1)? 'Locked':'Open'; ?></td></tr>
<?php endfor; ?>
	

<tr><th>Set Q<?php echo $qtr; ?></th>
	<td> 1-Locked / 0-Open <br />
	<input id="is_locked" class="vc50 center" type="number" min=0 max=1 
		value="<?php echo $row['is_finalized_q'.$qtr]; ?>" /> </td></tr>
</table>

<p><input id="submit" onclick="xlockerCourse();return false;" type="submit" value="Save"  /></p>

<script>

var gurl="http://<?php echo GURL; ?>";	
var crs="<?php echo $crs; ?>";	
var qtr="<?php echo $qtr; ?>";	
	
$(function(){

})	
	
function xlockerCourse1(){
	var vurl = gurl + '/ajax/xlocksAdvcrs.php';	
	var task = "xlockerCourse";		
	var is_locked = $('#is_locked').val();		
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'crs='+crs+'&task='+task+'&qtr='+qtr+'&is_locked='+is_locked,				
		success: function() { $('#submit').hide(); }		  
    });				

}	

function xlockerCourse(){
	var vurl = gurl + '/ajax/xlocksAdvcrs.php';	
	var task = "xlockerCourse";		
	var is_locked = $('#is_locked').val();		
	
	$.ajax({
		url: vurl,type: 'POST',data: 'crs='+crs+'&task='+task+'&qtr='+qtr+'&is_locked='+is_locked,				
		success: function() { $('#submit').hide(); }		  
    });				

}	
	

	

</script>
