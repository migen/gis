<?php 
	// pr($_SESSION['q']); 
?>



<h5 class="fp120 screen">

	<span ondblclick="tracehd();" >Sectioning</span>
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'registrars/registration'; ?>" >Registration </a> 


</h5>


<?php 


// pr($_SESSION['q']);
// pr($student);
// pr($data);

?>


<!------------------------------------------------------------------------------------------>

<div class="half" >

<p><form method="POST" >	

<table id="tbl-1" class="gis-table-bordered " >

<tr class="hd bg-blue2" ><th colspan="2" >HD Filter</th></tr>
<tr><th class="bg-gray3" >Name | Surname</th><td>
<input class="pdl05" id="part" autofocus  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />
</td></tr>

<tr><th class="bg-gray3" > ID Number</th><td>
<input class="pdl05" id="codes"  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />
</td></tr>


</table></p>


<?php if($scid): ?>


<form method="POST" >
<table class="fp120 gis-table-bordered table-fx"  >
	<tr><th class="vc150" >SY</th><td class="vc300" ><?php echo $sy.' - '.($sy+1); ?></td></tr>
	<tr><th>Username</th><td><?php echo $student['student_code']; ?></td></tr>
	<tr><th>Password</th><td><?php echo 'pass'; ?></td></tr>
	<tr><th>Student</th><td><?php echo $student['student']; ?></td></tr>
	<tr class="hd" ><th>prevcrid</th><td><?php echo $student['prevcrid']; ?></td></tr>
	<tr><th>Classroom</th><td>
		<a href='<?php echo URL."sectioning/crid/".$student['crid']; ?>' ><?php echo $student['classroom']; ?></a>
	</td></tr>
	<tr><th>Assessed</th><td class="b" ><?php echo number_format($tuition,2); ?></td></tr>
	
	
</table>

<p> <?php // pr ($student); ?> </p>

<?php if($student['role_id'] ==RSTUD): ?>
<table class="fp120 gis-table-bordered table-fx screen"  >

	<tr><th>Active</th><td>
	<select class="full" name="is_active"  >
		<option value="1" <?php echo ($student['is_active'])? 'selected':NULL; ?>  >Active</option>
		<option value="0" <?php echo (!$student['is_active'])? 'selected':NULL; ?>  >Dropped</option>
	</select>
	</td></tr>

	<tr><th>Cleared</th><td>
	<select class="full" name="is_cleared"  >
		<option value="1" <?php echo ($student['is_cleared'])? 'selected':NULL; ?>  >Cleared</option>
		<option value="0" <?php echo (!$student['is_cleared'])? 'selected':NULL; ?>  >NOT Cleared</option>
	</select>
	</td></tr>


	<tr><th class="vc150" >Assign</th><td class="vc300" >
		<select id="crid" name="crid" class="vc200" onchange="getAcid();return false;"  >
			<option value="0">Choose Classroom</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($student['crid']==$sel['id'])? 'selected':NULL; ?>  > 
					<?php echo $sel['name']; ?> 
				</option>	
			<?php endforeach; ?>			
		</select>			
		<input id="acid" class="vc50" name="acid" value="<?php echo $student['acid']; ?>" readonly />
	</td></tr>
		
	<tr><th>Attendance </th><td>
		<select name="attschema_id" class='vc200'>	
			<?php foreach($attschemas AS $sel): ?>			
				<option value="<?php echo $sel['id']; ?>" > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>						
	</td></tr>			

	<tr><td colspan="2" ><input type="submit" name="submit" value="Save"  /></td></tr>		


</table>
<?php endif; ?>
</form>

<?php endif; ?>

</div>

<!------------------------------------------------------------------------------------------>

<div class="hd" id="names" > </div>






<!------------------------------------------------------------------------------------------>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';


$(function(){
	hd();
	$('html').live('click',function(){
		$('#names').hide();
	});


})

function getAcid(){
	var crid = $('#crid').val();
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "clsAdvi";
		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&crid='+crid,				
		async: true,
		success: function(s) { 
			console.log(s);
			$('#acid').val(s.acid);
			
		}		  
    });				

}





function redirContact(ucid){
	var url 		= gurl + '/students/sectioner/' + ucid + '/' + sy;	
	window.location = url;		
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
