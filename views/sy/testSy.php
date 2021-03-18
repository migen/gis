<?php 

// pr($_SESSION['q']);

$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";

?>

<h3>
	Test SY Registered 
	(<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	

</h3>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>Scid</th>
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Name</th>
	<th></th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?>	
		<input id="scid-<?php echo $i; ?>" type="hidden" class="vc100" value="<?php echo $rows[$i]['scid']; ?>" >
	</td>
	<td><input id="sy-<?php echo $i; ?>"  class="vc100" type="number" value="<?php echo $rows[$i]['sy']; ?>" ></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>
	<button id="btn-<?php echo $i; ?>" onclick="xeditRow(<?php echo $i; ?>);return false;" > Save </button>  
	
	</td>

</tr>
<?php endfor; ?>
</table>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var dbcontacts="<?php echo $dbcontacts; ?>";


$(function(){


})



function xeditRow(i){
	$('#btn-'+i).hide();
	var scid =$('#scid-'+i).val();
	var sy = $('#sy-'+i).val();

	var vurl = gurl+'/ajax/xdata.php';	
	var task="xeditData";
	var pdata = "id="+scid+"&sy="+sy+"&task="+task+"&dbtable="+dbcontacts;
	
	$.ajax({
	  type: 'POST',url: vurl,data: pdata,success:function(){} 
   });				

	
} 


</script>
