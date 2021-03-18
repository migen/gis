<?php 

// pr($_SESSION['q']);

$has_rfid=$_SESSION['settings']['has_rfid'];
$has_rfid=false;
// pr($_SESSION['settings']['has_rfid']);


?>

<h3>
	Students | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'pupils/add'; ?>" >New</a>


</h3>




<p>
<table class="gis-table-bordered" >
<?php if($has_rfid): ?>
	<tr>
		<th>RFID</th>
		<td><input tabIndex=1 id="rfid" /></td>
		<td><button tabIndex=1 onclick="axnPage('rfid',1);" >Find</button></td>
	</tr>	
<?php endif; ?>

<tr>
	<th>Contact</th>
	<td><input tabIndex=1 id="part" /></td>
	<td><button tabIndex=1 onclick='axnPage("part",2);' >Filter</button></td>
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
	<?php if($has_rfid): ?>
		<th>EPC</th>	
	<?php endif; ?>
	<th></th>
	<th></th>
</tr>
<tbody id="rbox">

</tbody>
</table>


<?php 

$limit=isset($_GET['limit'])? $_GET['limit']:$_SESSION['settings']['records_limit'];

?>
<script>
var gurl="http://<?php echo GURL; ?>";
var dbo="<?php echo PDBO; ?>";
var limit="<?php echo $limit; ?>";
var has_rfid="<?php echo $has_rfid; ?>";


$(function(){
	hd();	
	nextViaEnter();		
	// $('html').live('click',function(){ $('#names').hide(); });
	$('#rfid').focus();
	selectFocused();

	
})	/* fxn */

function axnSelected(id){
	alert("axn selected id: "+id);
}


<?php if($has_rfid): ?>
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
		content+='<td><a href="'+gurl+'/records/edit/'+dbo+'.contacts/'+s[i].id+'" >Edit</a></td><td onclick="assignRfid('+i+','+s[i].id+');" >Assign</td>';
		content+='<td onclick="assignRfid('+i+','+s[i].id+',1);" >Reset</td></tr>';

	}
				$('#rbox').append(content).show();
				content = '';

			}		  
		});				
		
	}	/* fxn */


<?php else: ?>
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
		content+='<tr><td>'+s[i].id+'</td><td>'+s[i].name+'</td>';
		content+='<td><a href="'+gurl+'/records/edit/'+dbo+'.contacts/'+s[i].id+'" >Edit</a></td><td onclick="assignRfid('+i+','+s[i].id+');" >Assign</td>';
		content+='<td onclick="assignRfid('+i+','+s[i].id+',1);" >Reset</td></tr>';

	}
				$('#rbox').append(content).show();
				content = '';

			}		  
		});				
		
	}	/* fxn */


<?php endif; ?>




function axnPageOK(input,tasktype){
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
	content+='<td><a href="'+gurl+'/records/edit/'+dbo+'.contacts/'+s[i].id+'" >Edit</a></td><td onclick="assignRfid('+i+','+s[i].id+');" >Assign</td>';
	content+='<td onclick="assignRfid('+i+','+s[i].id+',1);" >Reset</td></tr>';

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