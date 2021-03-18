
<?php 

?>

<h5> Attendance Monitor </h5>

<p><button onclick="xgetNextAttendanceLog();return false;" >  Next </button></p>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th>SY</th><td><input type="number" class="pdl05 vc60" value="<?php echo $ssy; ?>"  /></td></tr>
</table>




</form>


<table class="gis-table-bordered table-fx" >

<tr><td>Picture</td><td> 
<img src="data:image/jpeg;base64,base64_encode(<span id='picture' ></span>)" width="150" border="0" />
 </td></tr>
<tr><td>Contact</td><td id="contact" ></td></tr>
<tr><td>Time In</td><td id="timein" ></td></tr>
<tr><td>Time Out</td><td id="timeout" ></td></tr>

</table>
 



<!------------------------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	// alert(gurl);

	
})


function xgetNextAttendanceLog(){


	// var sy			= $('#sy').val();
	// var fullname	= $('#fullname').val();
	// var crid		= $('#crid').val();
	var ecid	= '2121';
	
	var vurl 		= gurl + '/'+home+'/xgetNextAttendanceLog/';	
	// alert(vurl);
	
/* 	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'ecid='+ecid,
		processData:false,				
		async: true,
		success: function(s) { 	
			alert(s.snapshot);
			$('#picture').html(s.snapshot);
			$('#contact').html(s.name);
			
		}		  
    });				

 */

	$.ajax({
		url: vurl,
		dataType:'blob',
		type:'POST',		
		processData:false,				
		success: function(s) { 	
			alert(s.snapshot);
			$('#picture').html(s.snapshot);
			
		}		  
    });				

 
 
 
}





</script>





