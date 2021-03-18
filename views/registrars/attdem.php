<?php 

$half = $count/2;
// pr($_SESSION['q']);

?>

<h5>
	Attendance Daily Employees 
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

	&nbsp;
	&nbsp;
	&nbsp;
	<input class="center vc150" type="date" id="date" value="<?php echo $date; ?>"  />
	<button onclick="gotoSite($('#date').val());" >Go</button>		
	
</h5>

<div class="" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Pcid</th>
	<th>IN</th>
	<th>Employee</th>
	<th>Time In</th>
	<th>Time Out</th>
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
	var url = gurl+'/registrars/attdem/'+date;
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