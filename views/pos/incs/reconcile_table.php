<table class="gis-table-bordered screen" >
<tr><th>Date</th>
<td><input type="date" id="date" value="<?php echo (isset($params['start']))? $params['start']:$today; ?>" /></td>
<td><button onclick="redirReconcile();" >Reconcile</button></td>
</tr>
</table>


<script>
	
function redirReconcile(){
	if (confirm('Sure?')){
		jsredirect('pos/reconcile/'+$('#date').val());
	}		
}	/* fxn */

</script>