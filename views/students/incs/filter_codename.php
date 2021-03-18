<?php 

	$srid=$_SESSION['srid'];
	$attd_qtr=$_SESSION['settings']['attd_qtr'];

?>

<p>
<table id="tbl-1" class="gis-table-bordered " >

<tr>
	<th>Module</th>
	<td colspan="2" >		
	<select name="module" class="vc150" >
		<option value="1" >Report Card</option>
		<option value="2" >Profile</option>
		<option value="3" >Photo</option>
		<option value="4" >Edit</option>
<?php if(($srid==RMIS) || ($srid==RREG)): ?>
	<option value="5" >Grades</option>
	<option value="6" >Genave</option>
	<option value="7" >Summary</option>
	<option value="8" >Attendance</option>
	<option value="9" >Links</option>
<?php endif; ?>		
	</select>
	</td>
</tr>


<tr>
	<th> ID No</th>
	<td><input class="pdl05" id="code" value="" /></td>
	<td><input type="submit" name="auto" value="Go" onclick="gotoPage();return false;" /></td>
</tr>

<tr>
	<th>ID No | Name</th>
	<td><input class="pdl05" id="part"   /></td>
	<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" /></td>
</tr>	


</table></p>



<script>
var gurl = "http://<?php echo GURL; ?>";
var attdqtr = "<?php echo $attd_qtr; ?>";
var page = 'rcards/scid';
var limits = '20';
var module;

var attdpage = (attdqtr==1)? "studentQtr":"student";

$(function(){

})

function getPage(){	
	module = $('select[name="module"]').val();	
	switch (module)
	{
	   case "1":
			page = "rcards/scid"; break;
		case "2":
			page = "profiles/student"; break; 
		case "3":
			page = "photos/one"; break; 
		case "4":
			page = "contacts/ucis"; break; 
		case "5":
			page = "grades/student"; break; 
		case "6":
			page = "summarizers/student"; break; 
		case "7":
			page = "summary/edit"; break; 
		case "8":
			page = "attendance/"+attdpage; break;
		case "9":
			page = "students/links"; break;

			
	   default: 
			page = "students/links"; break; 
	}		
	return page;
}



function gotoPage(){
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
	page=getPage();
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/'+page+'/'+s.id;
				window.open(rurl);
			} else {
				alert('No record found.');
			}
			
		}		  
    });				
	
}	




function redirContact(ucid){
	page=getPage();
	var url = gurl+'/'+page+'/'+ucid;	
	window.open(url);		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
