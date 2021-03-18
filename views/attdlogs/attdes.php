<?php 

$half = $count/2;
// pr($_SESSION['q']);


?>


<h5>
	<?php echo $classroom['name']; ?>
	Attendance Daily Students (<?= $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a class="b" href="<?php echo URL.'advisers/classroomsIndex'; ?>" >CIR</a>
	
	&nbsp;
	&nbsp;
	&nbsp;
	
	<select id="crid"  >
		<?php foreach($classrooms AS $sel): ?>		
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$crid)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
	
	<input class="center vc150" type="date" id="date" value="<?php echo $date; ?>"  />
	<button onclick="gotoSite($('#date').val());" >Go</button>		
	
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<div class="" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>PCID</th>
	<th>IN</th>
	<th>Student</th>
	<th>Time In</th>
	<th>Time Out</th>
	<th><?php echo $_SESSION['month']; ?></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $present = isset($attd[$i]['timein'])? true:false; ?>
<tr class="<?php echo ($present)? 'blue':''; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $attd[$i]['pcid']; ?></td>	
	<td><?php echo ($present)? 'Y':'-'; ?></td>
	<td><a href='<?php echo URL."photos/one/".$attd[$i]['pcid']; ?>' ><?php echo $attd[$i]['contact']; ?></a></td>	
	<td><?php echo $attd[$i]['timein']; ?></td>	
	<td><?php echo $attd[$i]['timeout']; ?></td>	
	<td><a href='<?php echo URL."attdlogs/person/".$_SESSION['year'].DS.$_SESSION['moid'].DS.$attd[$i]['pcid']; ?>' >
		View</a></td>


</tr>
<?php endfor; ?>
</table>
</div>






<!------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';

$(function(){



})	


function gotoSite(date){
	var crid = $('#crid').val();
	var url = gurl+'/attdlogs/attdes/'+crid+'/'+date;
	// alert(url);
	window.location = url;
}


function getPhoto(i){
	var ucid = $('#ucid-'+i).text();
	var vurl = gurl+'/ajax/xphotos.php';	
	var task = "getPhoto";
	// alert(vurl);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&ucid='+ucid,				
		async: true,
		success: function(s) { 			
			// $('#photo-'+i).text("hahah");
			var x = '<img src="data:image/jpeg;base64,base64_encode('+s.photo+');" width="150" border="0" />';
			$('#photo-'+i).text(x);
			console.log(s.photo);
		}		  
    });				
	

}

</script>