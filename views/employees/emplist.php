<?php 

// pr($emps[0]);
// pr($_SESSION['q']);

?>


<h5> 
	Employees
	| <a href="<?php echo URL.'mis/employees'; ?>"> Find / Add </a> 
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >

<tr class="headrow" >
<th>#</th>
<th>CID</th>
<th>ID #</th>
<th>I0</th>
<th>Employee</th>
<th>Login<br />Account</th>
<th>Pass</th>
<th>Title</th>
<th class="center" >
	<select id="iats" class='vc100'>	
		<option> Schema </option>
		<?php foreach($attschemas AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
		<?php endforeach; ?>
	</select>				
	<br /><input type="button" value="All" onclick="populateColumn('ats');" >		
</th>
<th class="vc50" > Male
	<br /><select id="imale" class="full"  >
		<option value="1" >Y</option>
		<option value="0" >N</option>
	</select>
	<br /><input type="button" value="All" onclick="populateColumn('male');" >		
</th>							

<th class="vc50" > Active
	<br /><select id="iactive" class="full"  >
		<option value="1" >Y</option>
		<option value="0" >N</option>
	</select>
	<br /><input type="button" value="All" onclick="populateColumn('active');" >		
</th>							

</tr>

<?php for($i=0;$i<$num_emps;$i++): ?>
<?php $active = $emps[$i]['is_active']; ?>
<tr class="<?php echo ($active==1)? NULL:'red'; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $emps[$i]['ecid']; ?></td>
	<td><?php echo $emps[$i]['employee_code']; ?></td>
	<td><?php echo ($emps[$i]['is_active']==1)? '1':'-'; ?></td>
	<td><a href="<?php echo URL.'mis/photo/'.$emps[$i]['ecid']; ?>" ><?php echo $emps[$i]['employee']; ?></a></td>
	<td><?php echo $emps[$i]['account']; ?></td>	
	<td><?php echo $emps[$i]['ctp']; ?></td>	
	<td><?php echo $emps[$i]['title']; ?></td>	
	<td>	
		<select id="ats-<?php echo $i; ?>" class="ats" name="c[<?php echo $i; ?>][attschema_id]" >
			<?php foreach($attschemas AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$emps[$i]['attschema_id'])? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	
	<td>
		<select id="male-<?php echo $i; ?>" class="right pdr05 vc50 male" name="c[<?php echo $i; ?>][is_male]" >
			<option value="1" <?php echo ($emps[$i]['is_male'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$emps[$i]['is_male'])? 'selected':NULL; ?>  >N</option>
		</select>	
	</td>	
	
	<td>
		<select id="active-<?php echo $i; ?>" class="right pdr05 vc50 active" name="c[<?php echo $i; ?>][is_active]" >
			<option value="1" <?php echo ($emps[$i]['is_active'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$emps[$i]['is_active'])? 'selected':NULL; ?>  >N</option>
		</select>	
	</td>	
	
	<td>
		<a href="<?php echo URL.'contacts/ucis/'.$emps[$i]['ecid']; ?>" > Edit </a>
		&nbsp; | <a id="xb-<?php echo $i; ?>" class="txt-blue underline" onclick="xeditAts(<?php echo $emps[$i]['ecid'].','.$i; ?>);" > Update </a>
	
	</td>	
	<input type="hidden" name="c[<?php echo $i; ?>][cid]"  value="<?php echo $emps[$i]['ecid']; ?>"  >
	
</tr>

<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save All"   /></p>
</form>

<!------------------------------------------------------------------------------------------------------------->

<h5>Attendance Schemas Lookup</h5>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow"  ><th>#</th><td>Name</td>
<td>Time In</td><td>Time Out</td>
</tr>

<?php for($i=0;$i<$num_attschemas;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $attschemas[$i]['name']; ?></td>
	<td><?php echo $attschemas[$i]['timein']; ?></td>
	<td><?php echo $attschemas[$i]['timeout']; ?></td>
<?php endfor; ?>
</table>

<!------------------------------------------------------------------------------------------------------------->


<script>
var gurl = 'http://<?php echo GURL; ?>';
$(function(){

	// $('.ats').val('5');

})

function xeditAts(cid,i){
	var ats       = $('#ats-'+i).val();
	var male      = $('#male-'+i).val();
	var active    = $('#active-'+i).val();
	// alert(ats);
	var vurl = gurl + '/registrars/xeditAts';
	
	$.ajax({
		url		 : 	vurl,
		type	 : 'POST',				
		data	 : 'ats='+ats+'&cid='+cid+'&male='+male+'&active='+active,
		success	 : function() { $('#xb-'+i).hide(); }
	})
	
}


</script>




