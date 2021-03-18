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

<div class="forty" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Present</th>
	<th>Attendance</th>
</tr>
<?php for($i=0;$i<$half;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td id='<?php echo "photo-$i"; ?>' >
		<?php if(isset($attd[$i]['timein'])): ?>
			Present
		<?php endif; ?>
	</td>
	<td>
		# <span><?php echo $attd[$i]['pcid']; ?></span><br />
		<a class="" href='<?php echo URL."photos/one/".$attd[$i]['pcid']; ?>' ><?php echo $attd[$i]['contact']; ?></a><br />
		<?php echo $attd[$i]['timein']; ?><br />
		<?php echo $attd[$i]['timeout']; ?>
	</td>

</tr>
<?php endfor; ?>
</table>
</div>


<!------------------------------------------------------------------------->

<div class="forty" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Present</th>
	<th>Attendance</th>
</tr>

<?php for($i=$half;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td id='<?php echo "photo-$i"; ?>' >
		<?php if(isset($attd[$i]['timein'])): ?>
			Present
		<?php endif; ?>
	</td>
	<td>		
		# <span><?php echo $attd[$i]['pcid']; ?></span><br />
		<a class="" href='<?php echo URL."photos/one/".$attd[$i]['pcid']; ?>' ><?php echo $attd[$i]['contact']; ?></a><br />
		<?php echo $attd[$i]['timein']; ?><br />
		<?php echo $attd[$i]['timeout']; ?>
	</td>

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
	var url = gurl+'/registrars/attde/'+date;
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