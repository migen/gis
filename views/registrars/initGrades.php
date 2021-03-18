<style>
#names{ 
	width:500px;
    position: fixed;
    background-color: white;
    overflow: auto;	
    top: 120px;
    bottom: 20px;

}

</style>


<!------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var sy = '<?php echo $sy; ?>';

$(function(){
	hd();
	nextViaEnter();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	




function xgetStudentsByPartInDB(){
	var part = $('#part').val();
	var vurl = gurl+'/registrars/xgetStudentsByPartInDB';
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'part='+part,				
		async: true,
		success: function(s) { 
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i = 0; i < cs; i++) {			
				content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirEditStudentGrades(this.id);return false;" >'+s[i].code+'</span> - '+s[i].name+'</p>';
			}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}


function closeFilter(){
	$('#names').hide();
}

/* 
	$.ajax({
		url: urla,
		dataType: "json",
		type: 'POST',
		data: 'cid='+cid,				
		async: true,
		success: function() { }		  
    });				

 */

function xgetStudentCrid(scid){
	urla = gurl+'/registrars/xgetStudentCrid/'+scid;
	$.ajax({
		url: urla,
		dataType: "json",
		type: 'POST',
		async: true,
		success: function(s) { $('#crid').val(s.crid); }		  
    });				

}
 
function redirEditStudentGrades(scid){
	
	urla = gurl+'/registrars/xgetStudentCrid/'+scid;
	$.ajax({
		url: urla,
		dataType: "json",
		type: 'POST',
		async: true,
		success: function(s) { 
			var url 		= gurl + '/registrars/editStudentGrades/' + s.crid + '/' + scid + '/' + sy + '/' + '1';	
			window.location = url;					
		}		  
    });				
	
	
	
}


</script>

<!------------------------------------------------------------------------------------------------->


<h5> Initialize Grades - One Student </h5>

<div class="hd" id="names" > </div>

<form method="POST"  >

<table id="tbl-1" class="gis-table-bordered " >

<tr><th class="vc200 bg-gray3" >Student</th><td class="vc500" >
	<select class="full" id="student"  >
		<option value="0" >Choose One</option>
		<?php foreach($students AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th class="bg-gray3" >Name | Surname</th><td>
<input class="pdl05" id="part"  />
<input type="submit" name="auto" value="Filter" onclick="xgetStudentsByPartInDB();return false;" />
</td></tr>

<tr><th class="bg-gray3" >Crid</th><td>
<input class="pdl05" id="crid"  readonly />
</td></tr>


</table>

</form>






<!------------------------------------------------------------------------------------------------->
