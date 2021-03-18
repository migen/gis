<?php 

	// pr($_SESSION['q']);

	$tables = array(
		array('db'=>DBO,'table'=>'contacts'),
		array('db'=>DBO,'table'=>'roles'),
		array('db'=>DBO,'table'=>'titles'),
		array('db'=>PDBG,'table'=>'levels'),
		array('db'=>PDBG,'table'=>'sections'),
		array('db'=>PDBG,'table'=>'classrooms'),
		array('db'=>PDBG,'table'=>'subjects'),
		array('db'=>PDBG,'table'=>'courses'),
	
	);

?>

<h5>
	FYI
	
</h5>


<div class="third" >
<table class="gis-table-bordered table-fx" >

<tr><th>DB-Table</th><td>
<select id="dbtable" >
	<?php foreach($tables AS $sel): ?>
		<option value="<?php echo $sel['db'].'.'.$sel['table']; ?>" ><?php echo $sel['table']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Operator</th><td>
<select id="task" >
	<option value="equal" >EQUAL</option>
	<option value="like" >LIKE</option>
</select>
</td></tr>
<tr><th>Column</th><td><input class="pdl05" id="column" value="id" ></td></tr>
<tr><th>Value</th><td><input class="pdl05" id="qval" value="" ></td></tr>


</table>


<p><input type="submit" onclick="xfyi();"  /></p>
</div>


<div class="third" >
<table class="gis-table-bordered table-fx" >

<tr><th>DB-Table</th><td>
<select id="dbtable2" >
	<?php foreach($tables AS $sel): ?>
		<option value="<?php echo $sel['db'].'.'.$sel['table']; ?>" ><?php echo $sel['table']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Operator</th><td>
<select id="task2" >
	<option value="like" >LIKE</option>
</select>
</td></tr>
<tr><th>Column</th><td>
<select id="column2" >
	<option value="name" >Name</option>
	<option value="code" >Code</option>
</select>
</td></tr>
<tr><th>Value</th><td><input class="pdl05" id="qval2" value="wille" ></td></tr>

</table>


<p><input type="submit" onclick="xfyiLike();"  /></p>
</div>


<div class="clear" ></div>
<div id="result" ></div>



<script>

var gurl     = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	
})



function xfyi(){

var column 	= $('#column').val();
var qval 	= $('#qval').val();
var task	= $('#task').val();
var dbtable = $('#dbtable').val();

var vurl 	= gurl + '/ajax/xfyi.php';		
$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: 'column='+column+'&qval='+qval+'&task='+task+'&dbtable='+dbtable,						
	success: function(s) { 			
		if(s){ 
			$("#result").html('');			
			var sl = s.length;
			var str;
			for(var x=0;x<sl;x++){
				str = JSON.stringify(s[x], null, 2); 						
				$("#result").append(str);
				$("#result").append('<hr />');								
			}
		} else { alert('No record found!'); } 			
	}		  
});				
	

}	/* fxn */



function xfyiLike(){

var column 	= $('#column2').val();
var qval 	= $('#qval2').val();
var task	= $('#task2').val();
var dbtable = $('#dbtable2').val();

var vurl 	= gurl + '/ajax/xfyi.php';		
$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: 'column='+column+'&qval='+qval+'&task='+task+'&dbtable='+dbtable,						
	success: function(s) { 			
		if(s){ 
			// alert(s.length);
			$("#result").html('');
			
			var sl = s.length;
			var str;
			for(var x=0;x<sl;x++){
				str = JSON.stringify(s[x], null, 2); 						
				$("#result").append(str);
				$("#result").append('<hr />');
								
			}
			
		} else { alert('No record found!'); } 			
	}		  
});				
	

}	/* fxn */




</script>