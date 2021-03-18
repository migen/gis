<h5>
	OR Cancellations
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

	
</h5>

<form id="form" >
<table id="table" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Date</th>
	<th>Void</th>
	<th>Or No.</th>
	<th>Remarks</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo ($rows[$i]['is_void']==1)? 'Y':NULL; ?></td>
	<td><?php echo $rows[$i]['orno']; ?></td>
	<td><?php echo $rows[$i]['remarks']; ?></td>
	<td><a href="<?php echo URL.'invoices/editOrno/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>

<tr>
<td></td>
<td></td>
<td><input class="vc150" id="date" type="date" value="<?php echo $_SESSION['today']; ?>" /></td>
<td><select id="is_void" >
	<option value="0" >Valid</option>
	<option value="1" >Void</option>
</select>
</td>
<td><input class="vc80" id="orno" value="" /></td>
<td><input class="vc200" id="remarks" value="" /></td>
<td><input type="submit" value="Add" onclick="addOrno();return false;"  /></td>
</tr>
</table>
</form>

<!----------------------------------->
<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	// $('html').live('click',function(){ $('#names').hide(); });
	

})



function addOrno(){
	var date = $('#date').val();
	var orno = $('#orno').val();
	var is_void = $('#is_void').val();	
	var remarks = $('#remarks').val();	
	var vurl = gurl+'/ajax/xorno.php';		
	var task = "addOrno";			
	var pdata  = "task="+task+"&date="+date+"&orno="+orno+"&is_void="+is_void+"&remarks="+remarks;
	// alert(pdata);
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: pdata,
	  success:function(){
		$("#form")[0].reset();		
		$('#orno').focus();
		$('#table').append('<tr><td><tr><td>'+date+'</td><td>'+is_void+'</td><td>'+orno+'</td><td></td></tr>');	  
	  } 
	});				

}	/* fxn */







</script>



