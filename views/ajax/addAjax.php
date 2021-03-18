<?php 


// $_SESSION['q']="qqq";
// Session::set('q',"qqq");
pr($_SESSION['q']);

?>

<h3>

	Ajax Add DATA | <?php shovel('homelinks'); ?>


</h3>

<form id="form" method="POST" >
<table class="gis-table-bordered" >
	<tr><th>Code</th><td><input id="code"  ></td></tr>
	<tr><th>Name</th><td><input id="name"  ></td></tr>
	<tr><th colspan=2><button onclick="xsaveData();return false;" >JS Add</button></th></tr>
</table>

<table class="gis-table-bordered" >
<tr><th>ID</th><th>Code</th><th>Name</th></tr>
<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['code']; ?></td>
	<td><?php echo $row['name']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<div class="hd" id="names" > </div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var dbtable = "<?php echo $dbtable; ?>";


$(function(){
	hd();
	// alert('hi');
	$('html').live('click',function(){ $('#names').hide(); });
	// selectFocused();
	
	
})

function xsaveData(){
	var url=gurl+"/ajax/xdata.php";
	var task="xsaveData";
	var code=$("#code").val();var name=$("#name").val();	
	var pdata="task="+task+"&code="+code+"&name="+name+"&dbtable="+dbtable;
		
	$.ajax({
		url:url,type:"POST",data:pdata,
		success:(function(){
			var form=document.querySelector('#form');
			form.reset();
		
		})		
	})	
	
}	/* fxn */



</script>
<script type="text/javascript" src='<?php echo URL."views/js/data.js"; ?>' ></script>

