<h5>
	Terminals <?php echo $sy; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <span class="blue u" onclick="ilabas('shd');" >New</span>
	| <span class="blue u" onclick="ilabas('xdel');" >Delete</span>
	
	
		
</h5>

<?php

// pr($rows[0]);
// pr($data);

?>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>ID</th>
	<th>Ecid</th>
	<th>ID Number</th>
	<th>Employee</th>
	<th class="center" >Trml</th>
	<th>Axn</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr id="tr<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><input class="vc50 center" id="terminal<?php echo $i; ?>" value="<?php echo $rows[$i]['terminal']; ?>" /></td>
	<td>
		<input type="hidden" name="pkid[<?php echo $i; ?>]" value="<?php echo $rows[$i]['pkid']; ?>" />
		<u id="<?php echo $i; ?>" class="blue" onclick='xSaveTerminal(this.id);return false;' >Save</u> 			
		<span class="xdel" >| <u id="<?php echo $i; ?>" class="blue" onclick='xDelTerminal(this.id);return false;' >Delete</u></span>	
	</td>
</tr>
<?php endfor; ?>
<tr class="shd" >
	<td><?php echo $i+1; ?></td>
	<td></td>
	<td></td>
	<td></td>
	<td><input class="vc100" id="ecid" value=""  /></td>
	<td><input class="vc50" id="terminal" value=""  /></td>
	<td>
		<u id="<?php echo $i; ?>" class="blue" onclick='xAddTerminal();return false;' >Add</u> 					
	</td>	
</tr>

</table>



<!--------------------------------------------------------------------->


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";


$(function(){
	itago('shd');
	itago('xdel');
})

function xDelTerminal(i){
	var pkid = $('input[name="pkid['+i+']"]').val();	
	var vurl 	= gurl + '/ajax/xpurge.php';	
	var task	= "xDelTerminal";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&pkid='+pkid,						
		success: function() { $('#tr'+i).remove(); }		  
	});				
	
};	/* fxn */


function xSaveTerminal(i){
	var pkid = $('input[name="pkid['+i+']"]').val();	
	var terminal = $('#terminal'+i).val();	
	var vurl 	= gurl + '/ajax/xsetup.php';	
	var task	= "xSaveTerminal";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&pkid='+pkid+'&terminal='+terminal+'&sy='+sy,						
		success: function() { location.reload(); }		  
	});				
	
};	/* fxn */


function xAddTerminal(){
	
	var ecid = $('#ecid').val();
	var terminal = $('#terminal').val();
	
	var vurl 	= gurl + '/ajax/xsetup.php';	
	var task	= "xAddTerminal";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&ecid='+ecid+'&terminal='+terminal,						
		success: function() { location.reload(); }		  
	});				

	
};	/* fxn */


</script>


