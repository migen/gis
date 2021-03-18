<?php 

	// $_SESSION['q1']=NULL;
	pr($_SESSION['q1']);



?>



<h3>
	Ajax Roles | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'sessions/unsetter/roles'; ?>" >Unset</a>
	
</h3>


<table class="gis-table-bordered" >
<tr>
	<th>ID</th>
	<th>Role</th>
	<th>Price</th>
</tr>
<?php foreach($roles AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['price']; ?></td>
</tr>
<?php endforeach; ?>
</table>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<td><input id="search" name="search"  /></td>
	<td><span class="bordered" onclick="getRolesBySearch();return false;" >Filter</span></td>
	<td></td>

</tr>
</table>

</form>


<div id="results" >results</div>

<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){
	// $("#results").html("sus")

	
})

function xgetContactsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xcontacts.php';	
	var task = "xgetContactsByPart";		
	alert(part);
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].name+' - '+s[i].account+' - '+s[i].code+' #'+s[i].id+' R#'+s[i].role_id+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */

function axnSelected(id){
	alert(id);
	
}


function getRolesBySearch(){
	var search=$('#search').val();
	var vurl=gurl+"/ajax/ajaxok.php";
	var task="xgetRolesBySearch";
		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',
		data: 'task='+task+'&search='+search,async: true,
		success: function(s){
			alert("success");
			// $("#results").append("<br />hahahaha");
			
		}
		
		
	})
	
} 


</script>
