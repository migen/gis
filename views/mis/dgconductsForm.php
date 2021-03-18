<h5>
DG Conducts Form
	| <a href="<?php echo URL.'mis'; ?>" > Home </a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/dgacadForm'; ?>" > DG Academics </a>

</h5>

<?php  $this->shovel('offset'); ?>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >

<tr>
	<th class="bg-blue2" >DEPT</th>
	<td><select class="full" name="dept" onchange="xgetCountConductsByDept(this.value);"  >
		<option>Choose One</option>
		<option value="1">PS</option>
		<option value="2">GS</option>
		<option value="3">HS</option>
	</select></td>
</tr>

<tr>
	<th class="bg-blue2" >SY</th>
	<td><input class="pdl05" name="sy" value="<?php echo $sy; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >Qtr</th>
	<td><input class="pdl05" name="qtr" value="<?php echo $qtr; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >LIMIT</th>
	<td><input class="pdl05" type="number" name="limit" value="<?php echo 100; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >OFFSET</th>
	<td><input class="pdl05" name="offset" value="0" ></td>
</tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Submit"   /></td></tr>

</table>
</form>


<!------------------------------------------------------------------->


<script>


var gurl = 'http://<?php echo GURL; ?>';

function xgetCountConductsByDept(dept){
	
	var vurl 	= gurl + '/mis/xgetCountConductsByDept/'+dept;		// redirect url
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		async: true,
		success: function(s) { 	
			alert(s.count+' records.');		
		}		  
    });				
	

}





</script>


