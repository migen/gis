<?php 

// pr($data);
// $bs=2015;

$dbo=PDBO;

$task=isset($_POST['task'])? $_POST['task']:NULL;
// switch($_POST['task']){
switch($task){

case "xgetRowsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.`00_roles` WHERE `name` LIKE '%".$part."%' ORDER BY name;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q1'] = $rows;		
	echo json_encode($rows);
	break;

	
default:
	break;






}	/* switch */




?>





<h5>
	Student Ajax | <?php $this->shovel('homelinks'); ?>


	
</h5>

<form method="POST" >
<p>
<table id="tbl-1" class="gis-table-bordered " >

	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick="getRowsByPart(limits);return false;" />		
		</td>
		<td>
			Price: <input id="price" name="price"  /> 		
		</td>
		<td><input type="submit" name="submit" value="Submit" /></td>
	</tr>	
</table></p>



</form>


<div id="names" >names</div>






<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	// $('#names').hide();
	// $('html').live('click',function(){ $('#names').hide(); });
	
})

function axnSelected(price){
	$("#price").val(price);

}


function getRowsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/ajaxok.php';	
	var task = "xgetRowsByPart";	
	$.ajax({
		url: vurl,dataType: "json",type: "POST",
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  // console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnSelected('+s[i].price+');return false;" >'+s[i].name+' Price: '+s[i].price+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */




</script>


