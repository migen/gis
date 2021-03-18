
<div style="width:30%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >


<tr>
<th>Supplier</th>
<td>
	<select class="vc200" id="suppid" >
		<option value="0" >Choose</option>
		<?php foreach($suppliers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_GET['suppid'])) && ($sel['id']==$_GET['suppid']))? 'selected':NULL; ?> >
			<?php echo $sel['name'].' - '.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>



<tr><td colspan="2" ><input type="submit" onclick="redirUrl();" value="Filter"  /></td></tr>

</table>
</div>


<div class="clear" ></div>

<script>

var gurl="http://<?php echo GURL; ?>";

function redirUrl(){
	var suppid=$('#suppid').val();
	var url=gurl+'/stocks/display/'+suppid;
	window.location=url;
}	/* fxn */


</script>