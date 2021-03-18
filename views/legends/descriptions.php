<?php 

	// pr($_SESSION['q']); 

?>

<h5>
	Setup Descriptive Grades / Ratings (<?php echo $crstype; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'setup'; ?>" >Setup</a>		
	| <a href="<?php echo URL.'lookups/descriptions?ctype=1'; ?>" >Table</a>		
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
	var vurl = gurl+"/legends/descriptions?ctype="+$('#ctype').val()+"&dept="+$('#dept').val();
	window.location = vurl;		
}	/* fxn */
	
</script>



<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Floor</th>
	<th>Ceiling</th>
	<th>Rating</th>
	<th>Description</th>
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
	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][floor]" 
		value="<?php echo $rows[$i]['grade_floor']; ?>" tabindex="10" ></td>
	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][ceiling]" 
		value="<?php echo $rows[$i]['grade_ceiling']; ?>" tabindex="20" ></td>

	<td><input class="vc50 right pdr05" name="posts[<?php echo $i; ?>][rating]" 
		value="<?php echo $rows[$i]['rating']; ?>" tabindex="30" ></td>

	<td><input class="vc200 pdl05" name="posts[<?php echo $i; ?>][description]" 
		value="<?php echo $rows[$i]['description']; ?>" tabindex="40" ></td>
		
	<td><input class="vc30 center ps" name="posts[<?php echo $i; ?>][is_ps]" 
		value="<?php echo $rows[$i]['is_ps']; ?>" tabindex="50" ></td>

	<td><input class="vc30 center gs" name="posts[<?php echo $i; ?>][is_gs]" 
		value="<?php echo $rows[$i]['is_gs']; ?>" tabindex="60" ></td>
		
	<td><input class="vc30 center hs" name="posts[<?php echo $i; ?>][is_hs]" 
		value="<?php echo $rows[$i]['is_hs']; ?>" tabindex="70" ></td>
	
	<?php $did = $rows[$i]['did']; ?>
	<td><a class="u txt-blue" onclick="deleteRating(<?php echo $did.','.$i; ?>);return false;" >Del</a></td>

	<input name="posts[<?php echo $i; ?>][did]" value="<?php echo $did; ?>" type="hidden" />
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
	<th>Rating</th>
	<th>Description</th>
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
	<td><input id="rating<?php echo $i; ?>" class="vc50" name="posts[<?php echo $i; ?>][rating]" /></td>		
	<td><input id="desc<?php echo $i; ?>" class="vc200" name="posts[<?php echo $i; ?>][description]" /></td>		
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
	<option value="rating" >Rating</option>
	<option value="desc" >Description</option>
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


function deleteRating(did,i){

	if (confirm('Sure?')){
		var vurl 	= gurl + '/ajax/xratings.php';	
		var task	= "deleteRating";
		$('#tr'+i).remove();
		$.ajax({
			url: vurl,type: 'POST',
			async: true,		
			data: 'task='+task+'&did='+did,				
		});					
	}


}	/* fxn */

</script>
