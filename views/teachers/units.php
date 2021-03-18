<!-- hyperlinks -->


<?php 

// pr($data);

$scid = isset($data['scid'])? $data['scid'] : 0;			


?>

<h5>
	Units |
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'teachers/editUnits/'.$data['classroom']['crid']; ?>" />Edit All</a> 	
	
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
<form method="POST">
<table class="gis-table-bordered table-fx ">
<!-- ======== row 1 ======= -->
<tr class='bg-blue2'>
	<th>#</th>
	<th>ID Number</th>
	<th>Student</th>
	<th>Year <br />Entry</th>
	<th>Level <br />Entry</th>
	<th>Year of <br />Target<br />Graduation <br /></th>
	<th>Units <br />Previously <br />Earned</th>
	<th>Units <br />Current </th>
	<th>Units <br />Total</th>
	<th># Years <br />Earned<br />(Total)</th>
	<th>Edit</th>
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): ?>

<tr id="row<?php echo $i; ?>">
	<td><?php echo $i; ?></td>
	<td id="stc<?php echo $i; ?>" ><?php echo $row['student_code']; ?></td>
	<td id="std<?php echo $i; ?>" ><?php echo $row['student']; ?></td>
	<td id="one<?php echo $i; ?>" class="colshading" ><?php echo $row['year_entry']; ?></td>
	<td id="two<?php echo $i; ?>" class="colshading" ><?php echo $row['level_entry']; ?></td>
	<td id="thr<?php echo $i; ?>" class="colshading" ><?php echo $row['batch']; ?></td>
	<td id="fou<?php echo $i; ?>" class="colshading" ><?php echo $row['units_previous']; ?></td>
	<td id="fiv<?php echo $i; ?>" class="colshading" ><?php echo $row['units_current']; ?></td>
	<td id="six<?php echo $i; ?>" class="colshading" ><?php echo $row['units_total']; ?></td>
	<td id="sev<?php echo $i; ?>" class="colshading" ><?php echo $row['years_earned']; ?></td>
		<input id="cid<?php echo $i; ?>" type="hidden" value="<?php echo $row['scid']; ?>" >
	<td class="colshading" > <u id="<?php echo $i; ?>" onclick="xedit(this.id);return false;" > <button>xedit</button> </u> </td>
</tr>
	

<?php $i++; ?>
<?php endforeach; ?>
</table>


</form>

<script>

var row,viewRow,editRow;
var stc,std,cid,one,two,thr,fou,fiv,six,sev; 
var gurl = 'http://<?php echo GURL; ?>';
function xedit(i){
	row = $("#row"+i);

	stc = $("#stc"+i).text();
	std = $("#std"+i).text();
	
	one = $("#one"+i).text();
	two = $("#two"+i).text();
	thr = $("#thr"+i).text();
	fou = $("#fou"+i).text();
	fiv = $("#fiv"+i).text();
	six = $("#six"+i).text();
	sev = $("#sev"+i).text();
	cid = $("#cid"+i).val();
		
	editRow = '<td>'+i+'</td><td id="stc'+i+'" >'+stc+'</td><td id="std'+i+'" >'+std+'</td><td><input id="one'+i+'" class="vc50" type="text" name="one" value='+one+'></td><td><input id="two'+i+'" class="vc50" type="text" name="two" value='+two+'></td><td><input id="thr'+i+'" class="vc50" type="text" name="thr" value='+thr+'></td><td><input id="fou'+i+'" class="vc50" type="text" name="fou" value='+fou+'></td><td><input id="fiv'+i+'" class="vc50" type="text" name="fiv" value='+fiv+'></td><td><input id="six'+i+'" class="vc50" type="text" name="six" value='+six+'></td><td><input id="sev'+i+'" class="vc50" type="text" name="sev" value='+sev+'></td><td><input type="button" class="update" id="'+i+'" value="Update" onclick="xupdate(this.id,'+cid+');"></td>';
		
	row.html(editRow);
	
};

function xupdate(i,cid){


	row = $("#row"+i);
	stc = $("#stc"+i).text();
	std = $("#std"+i).text();
	
	one = $("#one"+i).val();
	two = $("#two"+i).val();
	thr = $("#thr"+i).val();
	fou = $("#fou"+i).val();
	fiv = $("#fiv"+i).val();
	six = $("#six"+i).val();
	sev = $("#sev"+i).val();
			
	var vurl = gurl + '/teachers/xeditUnit/'+cid;
	newRow = '<td>'+i+'</td><td>'+stc+'</td><td>'+std+'</td><td>'+one+'</td><td>'+two+'</td><td>'+thr+'</td><td>'+fou+'</td><td>'+fiv+'</td><td>'+six+'</td><td>'+sev+'</td><td>&nbsp;</td>';
	  	 
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "year_entry="+one+"&level_entry="+two+"&batch="+thr+"&units_previous="+fou+"&units_current="+fiv+"&units_total="+six+"&years_earned="+sev+"&scid="+cid,	  
	  success: (row.html(newRow)) 				  
   });				
	
	
};




	$(function(){	columnHighlighting();	});


	
	
	

</script>

