<?php 

	// pr($_SESSION['q']); 

?>

<h5>
	Setup Transmutation Table (<?php echo $crstype; ?>)
	| <a href="<?php echo URL.'setup'; ?>" >Setup</a>	
	| <a href="<?php echo URL.'lookups/equivalents?ctype=1'; ?>" >Table</a>	
	| <a class="u" onclick="ilabas('addrows')" >Add</a>			
</h5>

<?php 
	$ratings=array();
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var vurl = gurl+"/legends/equivalents?ctype="+$('#ctype').val()+"&dept="+$('#dept').val();
	window.location = vurl;		
}	/* fxn */
	
</script>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Floor</th>
	<th>Ceiling</th>
	<th>Equiv</th>
	<th>PS<br />
		<input id="ips" class="vc30 center" >
		<br /> <input style="min-width:32px;" type="button" value="All" onclick="populateColumn('ps');" />						
	</th>
	<th>GS<br />
		<input id="igs" class="vc30 center" >
		<br /> <input style="min-width:32px;" type="button" value="All" onclick="populateColumn('gs');" />							
	</th>
	<th>HS<br />
		<input id="ihs" class="vc30 center" >
		<br /> <input style="min-width:32px;" type="button" value="All" onclick="populateColumn('hs');" />							
	</th>
	<th>Manage</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
<tr id="tr<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][floor]" value="<?php echo $rows[$i]['floor']; ?>" 
		tabindex="10" ></td>
	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][ceiling]" value="<?php echo $rows[$i]['ceiling']; ?>" 
		tabindex="20" ></td>

	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][equivalent]" value="<?php echo $rows[$i]['equivalent']; ?>" 
		tabindex="30" ></td>

	<td><input class="vc30 center ps" name="posts[<?php echo $i; ?>][is_ps]" value="<?php echo $rows[$i]['is_ps']; ?>" 
		tabindex="40" ></td>

	<td><input class="vc30 center gs" name="posts[<?php echo $i; ?>][is_gs]" value="<?php echo $rows[$i]['is_gs']; ?>" 
		tabindex="50" ></td>
		
	<td><input class="vc30 center hs" name="posts[<?php echo $i; ?>][is_hs]" value="<?php echo $rows[$i]['is_hs']; ?>" 
		tabindex="60" ></td>
	
	<?php $eid = $rows[$i]['eid']; ?>
	<td><a class="u txt-blue" onclick="deleteEquiv(<?php echo $eid.','.$i; ?>);return false;" >Del</a></td>

	<input name="posts[<?php echo $i; ?>][eid]" value="<?php echo $eid; ?>" type="hidden" />
</tr>
<?php endfor; ?>
</table>


<p>
	<input type="submit" name="save" value="Save" onclick="return confirm('Sure?');"  />
</p>

</form>


<!------------------------------------------------------------------------>


<div class="addrows" >

<form method="POST" >	<!-- form add subjects -->
<div style="width:600px;float:left;"  >
<h5> 
	  Add Rows
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Floor</th>
	<th>Ceiling</th>
	<th>Equiv</th>
	<th>PS</th>
	<th>GS</th>
	<th>HS</th>
</tr>

<tbody>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input id="floor<?php echo $i; ?>" class="vc50" name="posts[<?php echo $i; ?>][floor]" /></td>
	<td><input id="ceiling<?php echo $i; ?>" class="vc50" name="posts[<?php echo $i; ?>][ceiling]" /></td>		
	<td><input id="equiv<?php echo $i; ?>" class="vc50" name="posts[<?php echo $i; ?>][equivalent]" /></td>		
	<td><input id="ps<?php echo $i; ?>" class="vc30" name="posts[<?php echo $i; ?>][is_ps]" /></td>		
	<td><input id="gs<?php echo $i; ?>" class="vc30" name="posts[<?php echo $i; ?>][is_gs]" /></td>		
	<td><input id="hs<?php echo $i; ?>" class="vc30" name="posts[<?php echo $i; ?>][is_hs]" /></td>		
			
</tr>

<?php endfor; ?>			
</tbody></table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.$_SESSION['home']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->

<p><?php $this->shovel('numrows'); ?></p>
</div>

<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="floor" >Floor</option>
	<option value="ceiling" >Ceiling</option>
	<option value="equiv" >Equiv</option>
	<option value="ps" >PS</option>
	<option value="gs" >GS</option>
	<option value="hs" >HS</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


</div>	<!-- addrows -->








<!------------------------------------------------------------------------>

<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	selectFocused();
	nextViaEnter();
	itago('addrows');


})	/* fxn */


function deleteEquiv(eid,i){

	if (confirm('Sure?')){
		var vurl 	= gurl + '/ajax/xratings.php';	
		var task	= "deleteEquiv";
		$('#tr'+i).remove();
		$.ajax({
			url: vurl,type: 'POST',
			async: true,		
			data: 'task='+task+'&eid='+eid,				
		});					
	}


}	/* fxn */

</script>
