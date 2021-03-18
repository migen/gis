<?php

// pr($data);
// pr($_SESSION['q']);

?>


<h5>
	Transfer Student Grades | 
	<?php 	$this->shovel('homelinks','mis'); ?>
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>

	
</h5>

<!---------------------------------------------------------------------------->


<!----------------------------------------------------------------------------> 

<form method="POST"  >

<table class="gis-table-bordered table-fx "  >  
<tr><th class="bg-blue2 white" >SY</th><td><input type="number" class="vc150 pdl05" name="sy" value="<?php echo $_SESSION['sy']; ?>" readonly /></td></tr>	
<tr><th class="bg-blue2 white" >Qtr</th><td><input type="number" class="vc150 pdl05" name="qtr" value="1" readonly  /></td></tr>	
<tr><th class="bg-blue2 white" >SCID</th><td><input type="text" class="vc150 pdl05" name="scid"
ondblclick="xname('dbo','00_contacts',this.value);" placeholder="scid"  /></td></tr>	

<tr>
<th class="bg-blue2 white" >Cls From</th><td>
	<select class='vc150' name="cridf" onchange="xgetClassroomCourses(this.value,'crf');" >	
		<option> Select classroom </option>
		<?php foreach($classrooms as $sel): ?>
			<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
		<?php endforeach; ?>
	</select>				
</td>
</tr>

<tr>
<th class="bg-blue2 white" >Cls To</th><td>
	<select class='vc150' name="cridt" onchange="xgetAcidCourses(this.value,'crt');" >	
		<option> Select classroom </option>
		<?php foreach($classrooms as $sel): ?>
			<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
		<?php endforeach; ?>
	</select>				
</td>
</tr>

<tr><th class="bg-blue2 white" >Adviser</th><td><input id="acid" type="text" class="vc150 pdl05" name="acid" placeholder="adviser" readonly /></td></tr>	


</table>


<!----------------------------------------------------------------------------------------------------------------->

<h4> Subject Courses </h4>
<table class="gis-table-bordered table-fx "  >  
<tr class="headrow" >
	<th>#</th>
	<th>From</th>
	<th>To</th>
	<th>Axn</th>
</tr>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<!----------------------------------------------------------------------------------------------------------------->
<tr id="trow<?php echo $i; ?>"  >
	<th><?php echo $i+1; ?></th>
	<td>
		<select id="crf<?php echo $i; ?>" class='vc150 crf' name="crs[<?php echo $i; ?>][crf]" >	</select>						
	</td>	
	
	<td>
		<select id="crt<?php echo $i; ?>" class='vc150 crt' name="crs[<?php echo $i; ?>][crt]" >	</select>						
	</td>	
	<td class="u" onclick="deltrow(<?php echo $i; ?>);" > Delete </td>
</tr>
<?php endfor; ?>
<!----------------------------------------------------------------------------------------------------------------->
</table>

<p>
	<input type="submit" name="submit" value="Go" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>
</form>

<p><?php $this->shovel('numrows'); ?></p>


<!---------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';

$(function(){
	hd();

	
})


function xgetAcidCourses(crid,cls){

	xgetClassroomAcid(crid);
	xgetClassroomCourses(crid,cls);

}	

function xgetClassroomAcid(crid){
	// var url = gurl+'/mis/xgetClassroomCourses/'+crid;
	var url = gurl+'/mis/xgetClassroomAcid/'+sy;
		
	$.ajax({
		url: url,
		dataType: "json",
		type: 'POST',
		data: 'crid=' + crid,		
		async: true,		
		success: function(s) {
			$("#acid").val(s.acid);			
		}
	});	

}	


function xgetClassroomCourses(crid,cls){
	var url = gurl+'/mis/xgetClassroomCourses/'+sy;
	
	$.ajax({
		url: url,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,		
		async: true,		
		success: function(s) {
			var cs = (s).length;	
			var options = '<option>Choose one</option>';
			for (var a = 0; a < cs; a++) {				
				options += '<option value="' + s[a].id + '">' + s[a].label +' > '+ s[a].name + '</option>';
			}
			// alert(options);
			$('.'+cls).html(options);						
		}

	});	

} 


function deltrow(i){
	$('#trow'+i).remove();
}	




function initClsAdvi(){
	var crid = $("#crid").text();
	// alert(crid);
	
	var vurl 	= gurl + '/registrars/clsAdvi/'+sy;	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid,				
		async: true,
		success: function(s) { 
			$('.advi').val(s.acid);							
		}		  
    });				
	
}	// fxn

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/promotions.js"></script>
