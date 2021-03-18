<script>

var gurl = 'http://<?php echo GURL; ?>';
function getSections(val,sel){
	var url = gurl+'/registrars/getSections';
		
	$.ajax({
		url: url,
		dataType: "json",
		type: 'POST',
		data: 'level=' + val,		
		async: true,		
		success: function(s) {
			var cs = (s).length;	
			// alert(cs);
			var options = '<option>Choose one</option>';
			for (var a = 0; a < cs; a++) {
				options += '<option value="' + s[a].id + '">' + s[a].name + '</option>';
			}
			var tdoptions = "<select class='full' name='pr[section_id]' >"+options+"</select>";
			$('#'+sel).html(tdoptions);				
		
		}
	});	



}	// selSection

</script>

<?php 

// ================= DEFINE VARS ====================
$sy = $_SESSION['sy'];


?>

<form method="POST" >
<!--   =====================================================================================   -->


<!--   =====================================================================================   -->




<h4> Promotions </h4>

<table class="gis-table-bordered" >

<?php 

	if(isset($_POST['prs'])){
		pr($_POST);
	}

	$num_levels = 13;
	
?>


<tr>
	<td class="vc200">
		<select class="full" name="pr[level_id]" onchange="getSections(this.value,'spr');" >
			<option>Choose Level</option>
			<?php for($i=0;$i<13;$i++): ?>
				<option value="<?php echo $i+1; ?>" >  <?php echo $levels[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>


<tr>
	<td class="vc200" id='spr' >
		<select class="full" name='pr[section_id]' >
			<option>Select an item</option>
		</select>
	</td>
</tr>

<tr>
	<td>
		<select class="full" name="pr[front]" >
			<option value="_front">Front</option>
			<option value="">Detailed</option>		
		</select>
	</td>
</tr>


<input type="hidden" name="pr[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="prs" value="Get"  />



<!-- =====================================================================================================  -->


<!--   =====================================================================================   -->


<h4> Report Card </h4>

<table class="gis-table-bordered" >

<?php 

	if(isset($_POST['prs'])){
		pr($_POST);
	}

	$num_classrooms = $data['num_classrooms'];
	
?>


<tr>
	<td class="vc200">
		<select class="full" name="rc[crid]"  >
			<option>Choose Section</option>
			<?php for($i=0;$i<$num_classrooms;$i++): ?>
				<option value="<?php echo $i+1; ?>" >  <?php echo $classrooms[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>



<input type="hidden" name="rc[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="rcs" value="Get"  />



</form>

</div>



