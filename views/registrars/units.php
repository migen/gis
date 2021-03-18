<!-- hyperlinks -->

<script>

var row,viewRow,editRow,newRow,sc,s,le,up,active,cid,j; 
var gurl = 'http://<?php echo GURL; ?>';

function xedit(i){
	row = $("#row"+i);
	sc 	= $("#sc"+i).text();
	s 	= $("#s"+i).text();
	le 	= $("#le"+i).text();
	up 	= $("#up"+i).text();
	active 	= $("#active"+i).text();
	cid = $("#cid"+i).val();
		
	viewRow = '<td>'+i+'</td><td>'+sc+'</td><td>'+s+'</td><td>'+le+'</td><td>'+up+'</td><td>'+active+'</td><td>&nbsp;</td>';
	editRow = '<td>'+i+'</td><td id="sc'+i+'" >'+sc+'</td><td id="s'+i+'" >'+s+'</td><td><input id="le'+i+'" type="text" name="le" value='+le+'></td><td><input id="up'+i+'" type="text" name="up" value='+up+'></td><td><input id="active'+i+'" type="text" name="active" value='+active+'></td><td><input type="button" class="update" id="'+i+'" value="Update" onclick="xupdate(this.id,'+cid+');"><input type="button" value="Cancel" onclick="forgetIt('+i+');"></td>';
		
	row.html(editRow);
	
};


function forgetIt(i){
	row = $("#row"+i);
	sc 	= $("#sc"+i).text();
	s 	= $("#s"+i).text();
	viewRow = '<td>'+i+'</td><td>'+sc+'</td><td>'+s+'</td><td>'+le+'</td><td>'+up+'</td><td>'+active+'</td><td>&nbsp;</td>';	
	row.html(viewRow);
}

function xupdate(i,cid){
	row = $("#row"+i);
	le 	= $("#le"+i).val();
	up 	= $("#up"+i).val();
	active 	= $("#active"+i).val();
	var vurl = gurl + '/registrars/xeditUnit/'+cid;
	newRow = '<td>'+i+'</td><td>'+sc+'</td><td>'+s+'</td><td>'+le+'</td><td>'+up+'</td><td>'+active+'</td><td>&nbsp;</td>';
	  	 
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "level_entry="+le+"&"+"units_previous="+up+"&"+"is_active="+active+"&"+"scid="+cid,	  
	  success: (row.html(newRow)) 				  
   });				
	
	
};


</script>

<?php 

// pr($data);

?>

<h5>
	Units |
	<a href="<?php echo URL; ?>registrars">Home</a> |
	<a href="<?php echo URL.'registrars/editUnits/'.$data['classroom']['crid']; ?>" />Edit All</a>	
</h5>

<!--  =========   CR DETAILS BELOW =====================  -->

<?php $cr = $data['classroom'];  ?>
<div>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
</table>

<!--  =========   UNITS BELOW =====================  -->
<br />
<table class="gis-table-bordered table-fx ">
<!-- ======== row 1 ======= -->
<tr class='bg-blue2'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Level Entry</th>
	<th>Previously <br />Earned <br />Units</th>
	<th class="vc80">1-Active <br />0-Inactive</th>
	<th>Quick Edit</th>
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): 
	// pr($row);
?>
<tr id="row<?php echo $i; ?>">
	<td><?php echo $i; ?></td>
	<td id="sc<?php echo $i; ?>" ><?php echo $row['student_code']; ?></td>
	<td id="s<?php echo $i; ?>" ><?php echo $row['student']; ?></td>
	<td id="le<?php echo $i; ?>" class="colshading" ><?php echo $row['level_entry']; ?></td>
	<td id="up<?php echo $i; ?>" class="colshading" ><?php echo $row['units_previous']; ?></td>
	<td id="active<?php echo $i; ?>" class="colshading" ><?php echo $row['is_active']; ?></td>
	<td class="colshading" >
		<u id="<?php echo $i; ?>" class="darkblue" onclick="xedit(this.id);return false;" >Xedit</u> 		
	</td>
	<input type="hidden" id="cid<?php echo $i; ?>" value="<?php echo $row['scid']; ?>" />
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<script>
	$(function(){
		columnHighlighting();
	
	});
	

</script>

