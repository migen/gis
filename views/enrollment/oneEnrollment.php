<style>


#content div{ border:1px solid black; min-height:100px; }
.divside{ padding-right:10%; }
.divmain{ width:70%; }



</style>


<h3>
	Enrollment | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('enrollment_notes');" >Notes</span>


</h3>


<div class="left divmain" >

School Year <select id="idbyr" name="seldbyr" onchange="checkDb();" >
	<option><?php echo DBYR; ?></option>
	<option><?php echo (DBYR+1); ?></option>
</select>

<p>
<table class="gis-table-bordered" >
<tr>
	<th>RFID</th>
	<td><input id="rfid" /></td>
	<td><button onclick="axnPage('rfid',1);" >Find</button></td>
</tr>	
<tr>
	<th>Contact</th>
	<td><input id="part" /></td>
	<td><button onclick='axnPage("part",2);' >Filter</button></td>
</tr>		
</table>
</p>


<br />
<br />

<div id="count" ></div>
<table class="gis-table-bordered"  >
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>EPC</th>
	<th></th>
	<th></th>
</tr>
<tbody id="rbox">

</tbody>
</table>


</div>	<!-- left -->




<div class="enrollment_notes right divside" >
	<?php $this->shovel('enrollment_notes'); ?>
</div> <!-- right -->


<?php 
	$limit=isset($_GET['limit'])? $_GET['limit']:$_SESSION['settings']['records_limit'];

?>

<script>
var gurl="http://<?php echo GURL; ?>";
var dbo="<?php echo PDBO; ?>";
var limit="<?php echo $limit; ?>";

$(function(){
	hd();	
	nextViaEnter();		
	// $('html').live('click',function(){ $('#names').hide(); });
	$('#rfid').focus();
	selectFocused();

	
})	/* fxn */

function checkDb(){
	var dbyr=$('select[name="seldbyr"]').val();
	
	var vurl=gurl+"/ajax/xenrollment.php";
	var task="checkDbyr";

	$.ajax({
		url:vurl,dataType:"json",type:"POST",data:"task="+task+"&dbyr="+dbyr,
		success:(function(s){
			alert(s);
			
		})
		
	})


	
}	/* fxn */


function axnSelected(id){
	alert("axn selected id: "+id);
}





function axnPage(input,tasktype){
	var value = $('#'+input).val();	
	var vurl = gurl+'/ajax/xrfid.php';	
	var task="xgetContactsBySwitch";
		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&value='+value+'&limit='+limit+'&tasktype='+tasktype,async: true,
		success: function(s) { 
			var cs = s.length;
			content = '';
			$("#rbox").html("");
			$("#count").html("<h5>Count: "+cs+"</h5>");			
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<tr><td>'+s[i].id+'</td><td>'+s[i].name+'</td><td id="epc-'+i+'" >'+s[i].epc+'</td>';
	content+='<td><a href="'+gurl+'/records/edit/'+dbo+'.contacts/'+s[i].id+'" >Edit</a></td>';
	content+='<td><a href="'+gurl+'/students/sectioner/'+s[i].id+'" >Enroll</a></td>';
	
	content+='<td onclick="assignRfid('+i+','+s[i].id+');" >Assign</td>';
	content+='</tr>';

}
			$('#rbox').append(content).show();
			content = '';

		}		  
    });				
	
}	/* fxn */




function assignRfid(i,scid,reset=false){
	var rfid=(reset)? 0:$('#rfid').val();	
	var vurl = gurl+'/ajax/xrfid.php';	
	var task = "assignRfid";	
	$.ajax({
		url:vurl,type:"POST",
		data:"task="+task+"&value="+rfid+"&scid="+scid,
		success: function() {  
			$('#epc-'+i).text(rfid);			
		}		  
    });				
	
}	/* fxn */




</script>