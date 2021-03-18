<br />

<?php // pr($tblwidth); 

// pr($tsum);

?>

<div class="divborder bordered" style="font-size:<?php echo $font_assess; ?>;" >
<table class="no-gis-table-bordered table-fx  "  >
	<tr><th>ID Number</th><td class="" ><?php echo $tsum['student_code']; ?></td></tr>
	<tr><th>Student <span class="screen" >| <a href="<?php echo URL.'profiles/student/'.$scid; ?>" >Profile</a></span>
		</th><td><?php echo $tsum['student']; ?></td></tr>
	<tr><th>Address</th><td><?php echo $tsum['address']; ?></td></tr>		
	<tr class="shd" ><th>Section</th><td><?php echo $tsum['section']; ?></td></tr>
	<tr><th>Level & Section</th><td><?php echo $tsum['tlabel'];  ?>
		<span class="screen" ><a href="<?php echo URL.'students/sectioner/'.$scid.DS.$sy; ?>" >Change</a></span>
	</td></tr>		
	
	<tr><th>Mode</th><td>
		<select id="pmid0" class="" name="paymode_id" style="border:none;" onchange="scidPaymode(0);" >
			<?php foreach($paymodes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
					<?php echo ($sel['id']==$tsum['paymode_id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
		<input type="hidden" id="scid0" value="<?php echo $tsum['scid']; ?>"/>
		<span class="screen" ><button onclick="location.reload();" >OK</button></span>		
	</td></tr>
	
	<tr><th>Encoder</th><td><?php echo $_SESSION['user']['fullname']; ?></td></tr>		
	
</table>	
</div>


<script>

var scid="<?php echo $scid; ?>";

$(function(){ shd(); })

function xsaveEncoder(encoder){	
	var vurl 	= gurl + '/ajax/xenrollment.php';	
	var task	= "xsaveEncoder";	
	$.ajax({
		url: vurl,type: 'POST',async: true,
		data: 'task='+task+'&encoder='+encoder+'&scid='+scid,		
		success: function() { }		  
    });				
	
	
}


</script>