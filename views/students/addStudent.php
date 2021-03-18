	<?php 
		// pr($_SESSION['q1']);
	?>

<h3>

	<span class='red' >*Check Filter to Avoid duplicate students</span> 
	| <?php $this->shovel('homelinks'); ?>

</h3>


<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>

<div id="feedback" ></div>

<table class="gis-table-bordered" >
	<tr><th>*ID No.</th><td><input id="code" ></td></tr>
	<tr><th>*Surname, First Middle</th><td><input id="name" ></td></tr>
	<tr><th>Gender</th><td>
		<select id="is_male" >
			<option value="1" >Boy</option>
			<option value="0" >Girl</option>
		</select>
	</td></tr>	
	<tr><td colspan=2 ><button onclick="xaddStudent();" >Add</button></td></tr>
</table>

<script>

var gurl = "http://<?php echo GURL; ?>";
var limits='20';

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})	/* onready */


function xaddStudent(){
	var code=($("#code").val());
	var name=($("#name").val());
	var is_male=($("#is_male").val());
	var url=gurl+"/ajax/xstudents.php";
	var task="xaddStudent";	
	var pdata="task="+task+"&code="+code+"&name="+name+"&is_male="+is_male;		
	// alert(url+", "+pdata);
	$.ajax({
		url:url,type:"POST",data:pdata,
		success:(function(){
			// var form=document.querySelector('#form');
			// var form=$('#form');form.reset();		
			// $('#feedback').html("<h3>"+name+" - student added.</h3>");
			location.reload();
		})		
	})	
	
	
}	/* fxn */

function redirContact(ucid){
	var url = gurl+'/students/add/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/data.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


