<?php 

	// pr($_SESSION['q']);
	// pr($data);
	// pr($ucis);
	// pr($student);
	
	$readonly = ($is_employee)? false:true;			
		
?>



<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */
// var row,viewRow,editRow,newRow,i,cid,code,s,l,sec,active,rmk; 
// var gurl = 'http://<?php echo GURL; ?>';

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	// alert(gurl+' - '+home);
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	

 
function redirContact(ucid){
	var url 		= gurl + '/contacts/statuses/' + ucid;	
	window.location = url;		
}



function xeditStatuses(){

	$('#usbtn').hide();
	var ucid		= $('#ucid').val();	
	var is_active	= $('#active').val();	
	var is_cleared	= $('#cleared').val();	
	var remarks		= $('#remarks').val();	
			
	var vurl 	= gurl + '/ajax/xeditStatuses.php';	
	
	var pdata = 'ucid='+ucid+'&is_active='+is_active+'&is_cleared='+is_cleared+'&remarks='+remarks;
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { }		  
    });				
	



}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

<?php

/* -------------------------------------------------------------------------------------------------------------- */ 

// pr($_SESSION['q']);
// pr($data);

?>




<h5>
	<span ondblclick="tracehd();" >Statuses</span> |
	<a href="<?php echo URL.$home; ?>">Home</a> | 
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> | 	
	<a href="javascript:history.go(0)">Refresh</a>	
</h5>




<?php if($mis || $reg || $guid): ?>
<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table>
<?php endif; ?>

<div class="hd" id="names" > </div>

<?php if(is_null($ucid)){ exit; } ?>



<form method="POST">

<br />

<!-- -found student/s -->


<?php if(isset($data)): ?> 	<!-- if search data is posted -->
<table class="gis-table-bordered table-fx" >

<tr><th>#</th><td><?php echo $student['scid']; ?></td></tr>
<tr><th>ID Number</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th>Level</th><td><?php echo $student['level']; ?></td></tr>
<tr><th>Section</th><td><?php echo $student['classroom']; ?></td></tr>

<tr><th>Active</th><td>
<select id="active" class="full" name="student[is_active]"  >
	<option value="1" <?php echo ($student['is_active'])? 'selected':NULL; ?>  >Enrolled</option>
	<option value="0" <?php echo (!$student['is_active'])? 'selected':NULL; ?>  >Dropped</option>
</select>
</td></tr>

<tr><th>Cleared</th><td>
<select id="cleared" class="full" name="student[is_cleared]"  >
	<option value="1" <?php echo ($student['is_cleared'])? 'selected':NULL; ?>  >Paid</option>
	<option value="0" <?php echo (!$student['is_cleared'])? 'selected':NULL; ?>  >Not fully paid</option>
</select>
</td></tr>

<tr><th>Remarks</th><td><input id="remarks" class="full pdl05" name="student[remarks]" 
	value="<?php echo $student['remarks']; ?>"  /></td></tr>
<input type="hidden" id="ucid" value="<?php echo $student['scid']; ?>"  />
<tr><th>Action</th><td><input type="submit" name="update" value="Update" onclick="xeditStatuses();return true;"  /></td></tr>


</table>
<?php endif; ?>	<!-- if search data is posted -->

</form>

<div class="hd" > <?php pr($student); ?> </div>
