

<?php 
	// pr($_SESSION['q']);
	// $numt=$_SESSION['settings']['numterminals']; 
	$numt='6';
?>

<br />
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Prid</th>
<th>Code</th>
<th>Product</th>
<?php for($t=1;$t<=$numt;$t++): ?>
	<th>T<?php echo $t; ?><br />
		<input min="0" max="1" type="number" class="vc50" id='<?php echo "it$t"; ?>'  /><br />
		<input type="button" value="All" onclick='populateColumn("t<?php echo $t; ?>");' >									
	</th >
<?php endfor; ?>
<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<?php for($t=1;$t<=$numt;$t++): ?>
		<th><input min="0" max="1" class='<?php echo "t$t"; ?> vc50' value="<?php echo $rows[$i]['in_t'.$t]; ?>"
			 type="number" name="posts[<?php echo $i; ?>][<?php echo "in_t$t"; ?>]"  /></th >
	<?php endfor; ?>
	
	<td><button id="btn<?php echo $i; ?>" onclick="xsaveDisplay(<?php echo $i; ?>);return false;" >Save</button></td>
</tr>

<input type="hidden" name="posts[<?php echo $i; ?>][prid]" value="<?php echo $rows[$i]['prid']; ?>" >
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save"  /></p>

</form>

<script>

$(function(){

})

function xsaveDisplay(i){
	
	$('#btn'+i).hide();
	// var sy = $('input[name="students['+i+'][sy]"]').val();
	var prid = $('input[name="posts['+i+'][prid]"]').val();
	var in_t1 = $('input[name="posts['+i+'][in_t1]"]').val();
	var in_t2 = $('input[name="posts['+i+'][in_t2]"]').val();
	var in_t3 = $('input[name="posts['+i+'][in_t3]"]').val();
	var in_t4 = $('input[name="posts['+i+'][in_t4]"]').val();
	var in_t5 = $('input[name="posts['+i+'][in_t5]"]').val();
	var in_t6 = $('input[name="posts['+i+'][in_t6]"]').val();
	
	var vurl 	= gurl + '/ajax/xinventory.php';	
	var task	= "xsaveDisplay";	
	var pdata = "task="+task+"&prid="+prid+"&in_t1="+in_t1+"&in_t2="+in_t2+"&in_t3="+in_t3+"&in_t4="+in_t4;
	pdata+="&in_t5="+in_t5+"&in_t6="+in_t6;

	$.ajax({ 
		type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				
	


}	/* fxn */


</script>
