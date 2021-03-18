<?php 
	// pr($_SESSION['q']); 
	
	// pr($data);
	// pr($employee);
		
	
?>



<h5 class="fp120 screen">

	<span class="u" ondblclick="traceshd();" >Emplorer</span>
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		


</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 


// pr($_SESSION['q']);
// pr($student);
// pr($data);

?>


<!------------------------------------------------------------------------------------------>

<div class="half" >

<p>


<table id="tbl-1" class="gis-table-bordered " >

<tr class="hd bg-blue2" ><th colspan="2" >HD Filter</th></tr>
<tr><th class="bg-gray3 vc150" >Name | Surname</th><td>
<input class="pdl05" id="part" autofocus  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />
</td></tr>

<tr><th class="bg-gray3" > ID Number</th><td>
<input class="pdl05" id="codes"  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />
</td></tr>


</table></p>


<?php if(!empty($employee)): ?>

<form method="POST" >
<table class="fp120 gis-table-bordered table-fx"  >
	<tr><th class="vc150" >Username</th><td class="vc300" ><?php echo $employee['employee_code']; ?></td></tr>
	<tr><th>Password</th><td><?php echo $employee['ctp']; ?></td></tr>
	<tr><th>Employee</th><td><?php echo $employee['employee']; ?></td></tr>

<?php if($_SESSION['settings']['has_axis']==1): ?>

<?php endif; ?>	
	
	
</table>

<p> <?php // pr ($employee); ?> </p>

<?php if($employee['role_id']!=RSTUD): ?>
<table class="fp120 gis-table-bordered table-fx screen"  >
	



<!-- hd -->	
	<tr class="hd" >
		<td>School Year</td>
		<td><input type="number" name="sy" class="pdl05" value="<?php echo $employee['sy']; ?>" /></td>
	</tr>

	<tr class="shd" ><td>CTP UCID</td><td><input class="pdl05" value="<?php echo $employee['ctpucid']; ?>" /></td></tr>
	<tr class="shd" ><td>UCID</td><td><input class="pdl05" name="ucid" value="<?php echo $employee['ucid']; ?>" /></td></tr>
	<tr class="shd" ><td>PCID</td><td><input class="pdl05" value="<?php echo $employee['pcid']; ?>" /></td></tr>

	<tr class="shd" ><td>Active (is)</td><td><input class="pdl05" name="is_active" value="<?php echo $employee['is_active']; ?>" /></td></tr>
	<tr class="shd" ><td>Cleared (is)</td><td><input class="pdl05" name="is_cleared" value="<?php echo $employee['is_cleared']; ?>" /></td></tr>
	<tr class="shd" ><td>Male (is)</td><td><input class="pdl05" name="is_male" value="<?php echo $employee['is_male']; ?>" /></td></tr>

	<tr class="shd" ><td>Attd ECID</td><td><input class="pdl05" value="<?php echo $employee['attdecid']; ?>" /></td></tr>
	<tr class="shd" ><td>Empl ECID</td><td><input class="pdl05" value="<?php echo $employee['emplecid']; ?>" /></td></tr>
	<tr class="shd" ><td>Prof ECID</td><td><input class="pdl05" value="<?php echo $employee['profecid']; ?>" /></td></tr>
	<tr class="shd" ><td>Photo ECID</td><td><input class="pdl05" value="<?php echo $employee['photoecid']; ?>" /></td></tr>
	<tr class="hd" ><td colspan="2" ><input onclick="return confirm('Dangerous!Sure?');" type="submit" name="purge" value="DELETE!"  /></td></tr>
<!-- hd -->

		
	<tr><td colspan="2" >
		<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
	</td></tr>		


</table>
<?php endif; ?>	<!-- if student -->
</form>

<?php else: ?>	<!-- if student is empty -->
	<h5>No record found.</h5>
<?php endif; ?>	<!-- if student not empty -->




</div>

<!------------------------------------------------------------------------------------------>

<div class="hd" id="names" > </div>






<!------------------------------------------------------------------------------------------>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
// var hdpass = CryptoJS.MD5("hello");


$(function(){
	hd();
	// shd();
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();
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
	var url 		= gurl + '/mis/employer/' + ucid + '/' + sy;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>