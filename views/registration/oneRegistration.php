<style>

#content div { border: 1px solid ; }

.leftdiv,.rightdiv{ float:left;width:35%; }


</style>


<?php 

pr($_SESSION['q']);


?>

<h5>
	Quick Student Registration | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'setup/students/'; ?>">Batch</a> 	

	
</h5>

<h4 id="board" class="brown" >Strictly NO DUPLICATE entries.</h4>


<div class="leftdiv" > 
<table class="gis-table-bordered" >
<tr>
	<th>RFID</th>
	<td><input tabIndex=1 id="rfid" /></td>
	<td><button onclick="axnPage('rfid',1);" >Find</button></td>
</tr>	
<tr>
	<th>Contact</th>
	<td><input tabIndex=1 id="part" /></td>
	<td><button tabIndex=2 onclick='axnPage("part",2);' >Filter</button></td>
</tr>		
</table>
</div>	<!-- leftdiv -->

<div class="rightdiv" >
<h3>Add New <input class="vc100" readonly id="scid" value="<?php echo $scid; ?>" ></h3>
<form id="form" method="POST" >
<table class="gis-table-bordered" >
	<tr><th>Code</th><td><input id="code" ></td></tr>
	<tr><th>Name</th><td><input id="name" ></td></tr>
	<tr><th colspan=2><input type="submit" onclick="registerNew();return false;" value="Register" ></th></tr>
</table>
</form>
</div>	<!-- rightdiv -->

<div class="clear" >&nbsp;</div>

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


<?php 

$limit=isset($_GET['limit'])? $_GET['limit']:$_SESSION['settings']['records_limit'];

?>
<script>
var gurl="http://<?php echo GURL; ?>";
var dbo="<?php echo PDBO; ?>";
var limit="<?php echo $limit; ?>";
var scid="<?php echo $scid; ?>";


$(function(){
	hd();	
	nextViaEnter();		
	// $('html').live('click',function(){ $('#names').hide(); });
	$('#rfid').focus();
	selectFocused();
	// alert(scid);
		

})

function XXXaxnSelected(id){ alert("axn selected id: "+id); }

function axnPage(input,tasktype){
	var value = $('#'+input).val();	
	var vurl = gurl+'/ajax/xrfid.php';	
	var task="xgetContactsBySwitch";
	
	alert(task);
	$.ajax({
		url:vurl,dataType:"json",type:"POST",async:true,
		data:'task='+task+'&value='+value+'&limit='+limit+'&tasktype='+tasktype,
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


function registerNew(){
	var code=$("#code").val();var name=$("#name").val();
	var vurl=gurl+"/ajax/xregistration.php";
	var task="registerContact";
	$.ajax({		
		url:vurl,type:"POST",dataType:"json",async:true,
		data:"task="+task+"&code="+code+"&name="+name+"&scid="+scid,
		success:function(s){
			if(s==1){ 	$("#board").html("<a href='"+gurl+"/profiles/scid/"+scid+"' >Profile Details - "+name+"</a>");			
			} else { alert('Fail. ID already taken.'); }
			$("#form")[0].reset();				
		}		
	})
	
}	/* fxn */

	
</script>

