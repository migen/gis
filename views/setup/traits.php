<h5>
	Setup Traits

</h5>

<form method="GET" >

<table class="gis-table-bordered" >

<tr><th>Level</th>
<td>
	<select name="lvl" >
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr>
<th>Qry</th>
<td>
	<input type="radio" value="1" name="prq" id="prq"   />Show
	<input type="radio" value="0" name="prq"   />No
</td>
</tr>

<tr>
<th>Exe</th>
<td>
	<input type="radio" value="1" name="exe" id="exe"   />Execute
	<input type="radio" value="0" name="exe"  />No
</td>
</tr>

<tr><td colspan="2" >
<input type="submit" name="submit" value="Go" onclick="return confirm('Sure?');" />
</td></tr>


</table>

</form>



<script>

var gurl="http://<?php echo GURL; ?>";

function redirUrl(){
	var lvl = $('#lvl').val();
	var prq; 
	var exe; 
	if($('#prq').is(':checked')) { prq = '1';  } else { prq='0'; }	
	if($('#exe').is(':checked')) { exe = '1';  } else { exe='0'; }	
	var url=gurl+'/setup/traits/'+lvl+'?prq='+prq+'&exe='+exe;
	
	
}

</script>